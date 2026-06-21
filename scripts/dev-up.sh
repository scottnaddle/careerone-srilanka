#!/usr/bin/env bash
# =============================================================
# dev-up.sh — Bring up local dev environment (idempotent)
# =============================================================
# 1. Copy .env.local.example → .env (if not exists)
# 2. Generate APP_KEY (if empty)
# 3. Start docker services (MySQL/Redis/Mailpit)
# 4. Wait for MySQL ready
# 5. composer install (if vendor/ missing)
# 6. Run migrations + seed
# 7. npm install + build (if needed)
# 8. Start php artisan serve in background
# 9. Print connection info
# =============================================================
set -e

cd "$(dirname "$0")/.."
ROOT="$(pwd)"

# Colors
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log() { echo -e "${GREEN}[dev-up]${NC} $*"; }
warn() { echo -e "${YELLOW}[dev-up]${NC} $*"; }
err() { echo -e "${RED}[dev-up]${NC} $*"; }

# ----------------------------------------
# 1. .env
# ----------------------------------------
if [ ! -f .env ]; then
  log "Creating .env from .env.local.example"
  cp .env.local.example .env
else
  warn ".env already exists, skipping copy"
fi

# ----------------------------------------
# 2. APP_KEY
# ----------------------------------------
if ! grep -q "^APP_KEY=base64:" .env; then
  log "Generating APP_KEY"
  KEY=$(php -r "echo 'base64:'.base64_encode(random_bytes(32));")
  sed -i.bak "s|^APP_KEY=.*|APP_KEY=$KEY|" .env && rm -f .env.bak
else
  warn "APP_KEY already set"
fi

# ----------------------------------------
# 3. Docker services
# ----------------------------------------
log "Starting docker services (MySQL/Redis/Mailpit)..."
docker compose up -d

# ----------------------------------------
# 4. Wait for MySQL
# ----------------------------------------
log "Waiting for MySQL to be ready..."
for i in {1..30}; do
  if docker exec careerone-mysql mysqladmin ping -h localhost -u root -prootpass >/dev/null 2>&1; then
    log "MySQL is ready"
    break
  fi
  [ $i -eq 30 ] && { err "MySQL not ready after 30s"; exit 1; }
  sleep 1
done

# ----------------------------------------
# 5. composer install
# ----------------------------------------
if [ ! -d vendor ]; then
  log "Running composer install..."
  composer install --no-interaction --prefer-dist
else
  warn "vendor/ exists, skipping composer install"
fi

# ----------------------------------------
# 6. Migrations + seed
# ----------------------------------------
if [ ! -f storage/app/.migrated ] || [ "$1" = "--fresh" ]; then
  log "Running migrations + seed (this may take a while)..."
  php artisan migrate:fresh --seed --force
  touch storage/app/.migrated
else
  warn "Already migrated (use --fresh to redo)"
  # Run only new migrations
  php artisan migrate --force || true
fi

# ----------------------------------------
# 7. Storage link
# ----------------------------------------
if [ ! -L public/storage ]; then
  log "Creating storage symlink"
  php artisan storage:link
fi

# ----------------------------------------
# 8. Clear caches
# ----------------------------------------
log "Clearing caches..."
php artisan config:clear
php artisan view:clear
php artisan route:clear

# ----------------------------------------
# 9. npm (optional)
# ----------------------------------------
if [ -f package.json ]; then
  if [ ! -d node_modules ]; then
    log "Running npm install..."
    npm install --silent
  fi
  log "Building frontend assets..."
  npm run build 2>/dev/null || warn "npm build skipped/failed (dev mode is fine)"
fi

# ----------------------------------------
# 10. Start server in background
# ----------------------------------------
if lsof -i :18000 >/dev/null 2>&1; then
  warn "Port 18000 already in use, skipping serve"
else
  log "Starting php artisan serve on :18000 (background)"
  nohup php artisan serve --host=0.0.0.0 --port=18000 > storage/logs/serve.log 2>&1 &
  echo $! > storage/app/.serve.pid
  sleep 2
  log "Server PID: $(cat storage/app/.serve.pid)"
fi

# ----------------------------------------
# 11. Print info
# ----------------------------------------
cat <<'EOF'

============================================================
 CareerOne — Local Dev Ready
============================================================
 App      : http://localhost:18000
 Admin    : http://localhost:18000/admin
 Mailpit  : http://localhost:18025  (catch all outgoing mail)
 MySQL    : localhost:13306  (user: careerone / pass: careerone_pass)
 Redis    : localhost:16379

 Test accounts (from seeders):
   Admin     : admin@videabiz.com     / Videa@2024  (super admin)
   Admin     : admin@tvec.com         / tvec2024    (TVEC admin)
   Trainee   : trainee_user1@gmail.com / Videa@2024
   CGO       : cgouser1@gmail.com     / Videa@2024
   Company   : (see CompanyRecruiterSeeder, default password Videa@2024)
   SchoolKid : (seeded if SchoolKidSeeder enabled)

 Stop with: bash scripts/dev-down.sh
 Reset DB : bash scripts/dev-reset.sh
 Logs     : tail -f storage/logs/serve.log
============================================================
EOF

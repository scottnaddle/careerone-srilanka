#!/usr/bin/env bash
# =============================================================
# dev-down.sh — Stop local dev environment
# =============================================================
set -e

cd "$(dirname "$0")/.."
ROOT="$(pwd)"

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log() { echo -e "${GREEN}[dev-down]${NC} $*"; }
warn() { echo -e "${YELLOW}[dev-down]${NC} $*"; }

# Stop artisan serve
if [ -f storage/app/.serve.pid ]; then
  PID=$(cat storage/app/.serve.pid)
  if ps -p $PID >/dev/null 2>&1; then
    log "Stopping php artisan serve (PID $PID)"
    kill $PID 2>/dev/null || true
  fi
  rm -f storage/app/.serve.pid
fi

# Stop docker services (but keep volumes for next start)
log "Stopping docker services..."
docker compose stop

echo
log "Done. Data volumes preserved (use dev-reset.sh to wipe DB)."

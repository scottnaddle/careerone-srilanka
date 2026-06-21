#!/usr/bin/env bash
# =============================================================
# dev-reset.sh — Destroy all data and start fresh
# =============================================================
set -e

cd "$(dirname "$0")/.."

GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m'

log() { echo -e "${GREEN}[dev-reset]${NC} $*"; }
warn() { echo -e "${YELLOW}[dev-reset]${NC} $*"; }
err() { echo -e "${RED}[dev-reset]${NC} $*"; }

if [ "$1" != "--yes" ]; then
  warn "This will DELETE all local DB data + docker volumes."
  read -p "Continue? (yes/no) " -r
  [ "$REPLY" = "yes" ] || { err "Aborted"; exit 1; }
fi

log "Stopping services..."
docker compose down -v --remove-orphans

log "Removing storage markers..."
rm -f storage/app/.migrated storage/app/.serve.pid

log "Restarting..."
bash scripts/dev-up.sh --fresh

log "Reset complete"

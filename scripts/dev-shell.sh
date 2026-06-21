#!/usr/bin/env bash
# =============================================================
# dev-shell.sh — Open shell inside a service container
# =============================================================
set -e
cd "$(dirname "$0")/.."

case "${1:-mysql}" in
  mysql)   docker exec -it careerone-mysql mysql -u careerone -pcareerone_pass careerone ;;
  redis)   docker exec -it careerone-redis redis-cli ;;
  app)     docker exec -it -w /var/www/html $(docker compose ps -q app 2>/dev/null || echo careerone-mysql) sh ;;
  *)       echo "Usage: $0 {mysql|redis|app}"; exit 1 ;;
esac

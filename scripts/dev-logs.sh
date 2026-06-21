#!/usr/bin/env bash
# =============================================================
# dev-logs.sh — Tail logs from docker services
# =============================================================
set -e
cd "$(dirname "$0")/.."

case "${1:-all}" in
  mysql)    docker logs -f careerone-mysql ;;
  redis)    docker logs -f careerone-redis ;;
  mailpit)  docker logs -f careerone-mailpit ;;
  app)      tail -f storage/logs/serve.log 2>/dev/null || echo "No serve.log (server not running)";;
  laravel)  tail -f storage/logs/laravel.log ;;
  all|*)
    echo "Tailing all services (Ctrl+C to exit)..."
    docker compose logs -f --tail=50
    ;;
esac

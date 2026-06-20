#!/bin/bash
# CareerOne 로컬 개발 서버 시작 스크립트

export PATH="/opt/homebrew/opt/postgresql@16/bin:$PATH"
PHP="/opt/homebrew/opt/php@8.2/bin/php"
PROJECT="$(cd "$(dirname "$0")" && pwd)"

echo "=== CareerOne 로컬 환경 시작 ==="

# 1. PostgreSQL 시작
echo "[1/3] PostgreSQL 시작..."
brew services start postgresql@16 2>/dev/null
sleep 1
pg_isready -h 127.0.0.1 > /dev/null 2>&1 && echo "  ✓ PostgreSQL 실행 중 (port 5432)" || echo "  ✗ PostgreSQL 시작 실패"

# 2. 기존 서버 종료
lsof -ti:8000 | xargs kill -9 2>/dev/null

# 3. Laravel 서버 시작
echo "[2/3] Laravel 서버 시작..."
cd "$PROJECT"
$PHP -S 127.0.0.1:8000 -t public/ server.php > /tmp/careerone-serve.log 2>&1 &
sleep 2

if lsof -ti:8000 > /dev/null 2>&1; then
  echo "  ✓ 서버 실행 중: http://127.0.0.1:8000"
else
  echo "  ✗ 서버 시작 실패. 로그 확인: cat /tmp/careerone-serve.log"
  exit 1
fi

echo "[3/3] 브라우저 열기..."
open http://127.0.0.1:8000/

echo ""
echo "=== 주요 URL ==="
echo "  홈페이지:       http://127.0.0.1:8000/"
echo "  Trainee 로그인: http://127.0.0.1:8000/trainee/auth/signin"
echo "  Company 로그인: http://127.0.0.1:8000/company/auth/signin"
echo "  CGO 로그인:     http://127.0.0.1:8000/cgo/auth/signin"
echo "  Admin 패널:     http://127.0.0.1:8000/admin/auth/login"
echo ""
echo "서버 중지: kill \$(lsof -ti:8000)"
echo "서버 로그: tail -f /tmp/careerone-serve.log"

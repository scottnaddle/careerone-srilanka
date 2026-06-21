-- MySQL init script for CareerOne local dev
-- Runs once on first container startup (when mysql_data volume is empty)

-- Make sure DB exists with proper charset
ALTER DATABASE careerone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Grant privileges (idempotent)
GRANT ALL PRIVILEGES ON careerone.* TO 'careerone'@'%';
FLUSH PRIVILEGES;

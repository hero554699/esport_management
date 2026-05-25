#!/bin/bash
set -e

echo "🚀 Starting EsportsTrack..."

# Wait for database
echo "⏳ Waiting for database..."
for i in {1..30}; do
    if php -r "new PDO('pgsql:host=' . getenv('DB_HOST') . ';port=' . getenv('DB_PORT'), getenv('DB_USERNAME'), getenv('DB_PASSWORD'));" 2>/dev/null; then
        echo "✅ Database ready!"
        break
    fi
    echo "Attempt $i/30..."
    sleep 2
done

# Always run migrations
echo "📦 Running migrations..."
php artisan migrate --force

# Only seed on first run (checks if users table is empty)
IS_FIRST_RUN=false
if ! php artisan tinker --execute="exit((\App\Models\User::count() > 0) ? 0 : 1);" 2>/dev/null; then
    IS_FIRST_RUN=true
    echo "📍 First run detected"
fi

if [ "$IS_FIRST_RUN" = "true" ]; then
    echo "🌱 Seeding database..."
    php artisan db:seed --force
fi

# Storage link
echo "🔗 Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Clear and cache
echo "🧹 Caching configuration..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# PandaScore sync in background
echo "🔄 Syncing PandaScore data..."
php artisan pandascore:sync --type=all > /dev/null 2>&1 &

echo "✅ Application ready!"
echo "🌐 Starting Apache on port 10000..."
exec apache2-foreground
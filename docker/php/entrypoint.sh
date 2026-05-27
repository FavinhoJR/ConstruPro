#!/bin/sh
set -e

cd /var/www/html

if [ ! -f vendor/autoload.php ]; then
    composer install --no-interaction --prefer-dist
fi

if [ ! -d node_modules ] || [ ! -f public/build/manifest.json ]; then
    npm install
    npm run build
fi

exec php-fpm

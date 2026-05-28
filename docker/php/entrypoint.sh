#!/bin/sh
set -e

cd /var/www/html

PORT="${PORT:-10000}"

cat > /etc/nginx/http.d/default.conf <<NGINX
server {
    listen ${PORT};
    server_name _;
    root /var/www/html/public;
    index index.php;

    client_max_body_size 20M;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX

mkdir -p storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R ug+rw storage bootstrap/cache || true

if [ -z "${APP_KEY:-}" ]; then
    export APP_KEY="$(php artisan key:generate --show --no-ansi)"
fi

php artisan optimize:clear

if [ -n "${DB_URL:-}" ] || [ -n "${DATABASE_URL:-}" ] || [ -n "${DB_HOST:-}" ]; then
    php artisan migrate --force

    if [ "${RUN_DEMO_SEEDERS:-true}" = "true" ]; then
        php artisan db:seed --force
    fi
fi

php artisan storage:link || true
php artisan optimize

php-fpm -D
exec nginx -g "daemon off;"

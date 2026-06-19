#!/bin/sh
set -e

# Render передаёт порт в переменной окружения PORT.
PORT="${PORT:-80}"

echo "[entrypoint] starting Apache on port ${PORT}"

cat > /etc/apache2/ports.conf <<EOF
Listen ${PORT}
<IfModule ssl_module>
    Listen 443
</IfModule>
<IfModule mod_gnutls.c>
    Listen 443
</IfModule>
EOF

sed -ri "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/" /etc/apache2/sites-available/*.conf

exec docker-php-entrypoint apache2-foreground

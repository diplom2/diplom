FROM php:8.2-apache

# 1. Устанавливаем нужные расширения для MySQL и SQLite
RUN apt-get update && apt-get install -y default-mysql-client libsqlite3-dev && \
    docker-php-ext-install pdo_mysql pdo_sqlite && \
    rm -rf /var/lib/apt/lists/*

# 2. Копируем файлы проекта
COPY . /var/www/html/

# 3. Если проект завершён в папке cms/, перемещаем его в корень
RUN if [ -d /var/www/html/cms ]; then \
      sh -c 'cd /var/www/html && mv cms/* . 2>/dev/null || true && mv cms/.[!.]* . 2>/dev/null || true && rm -rf cms'; \
    fi

# 4. Создаем папки и даем права (чтобы не было ошибки Logger.php)
RUN mkdir -p /var/www/html/storage/logs /var/www/html/public/uploads /var/www/html/uploads && \
    chmod -R 777 /var/www/html/storage && \
    chmod -R 777 /var/www/html/public/uploads && \
    chmod -R 777 /var/www/html/uploads

# 5. Включаем модуль Apache Rewrite (часто нужен для PHP сайтов)
RUN a2enmod rewrite

# 5. Устанавливаем рабочую директорию для Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/*.conf
RUN sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 6. Устанавливаем .htaccess для корректной маршрутизации
RUN cat <<'EOF' >/etc/apache2/conf-available/rewrite.conf
<Directory /var/www/html/public>
  Options -MultiViews
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteRule ^ index.php [QSA,L]
</Directory>
EOF
RUN a2enconf rewrite

# 7. Копируем и разрешаем запуск кастомного entrypoint, который использует PORT от Render
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
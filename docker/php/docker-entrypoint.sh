#!/bin/bash
set -e

cd /var/www/html

# Instalar Composer se não estiver instalado
if ! command -v composer &> /dev/null; then
    echo "Installing Composer..."
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
    chmod +x /usr/local/bin/composer
fi

# Instalar dependências PHP se vendor não existir
if [ ! -d "vendor" ] || [ ! -f "vendor/autoload.php" ]; then
    echo "Installing PHP dependencies..."
    composer install --no-dev --optimize-autoloader --no-progress
fi

# Gere a chave se não existir
if [ ! -f "storage/app/key_generated" ]; then
    echo "Generating application key..."
    php artisan key:generate --force
    touch storage/app/key_generated
fi

# Settings permissions
echo "Setting permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Starting PHP-FPM
echo "Starting PHP-FPM..."
exec php-fpm

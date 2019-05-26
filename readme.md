## install

1. run `docker-compose up -d` (run `docker-compose down` to stop)
2. connect to php container `docker-compose exec php-fpm bash`
3. run in container `composer install`
4. run migrations `php artisan migrate`

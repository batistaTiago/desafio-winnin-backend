#/bin/sh
docker-compose build;
docker-compose up -d;

docker-compose exec php bash -c "composer install";

docker-compose exec php bash -c "service cron reload";
docker-compose exec php bash -c "service cron start";

docker-compose exec php bash -c "php artisan config:clear && ./vendor/bin/phpunit ./tests --testdox"
docker-compose exec php bash -c "php artisan config:clear && php artisan migrate:fresh"


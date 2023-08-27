# running
- docker-compose up -d
# using (inside php container)
php bin/console import var/import/data.csv --to mysql

php bin/console import var/import/data.csv --to postgres

php bin/console import var/import/data.csv --to redis


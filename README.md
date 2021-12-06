# Working time tracker (Wott)

Wott is web app written in PHP to track and store
working hour.

## Dependencies

To use this app in the best conditions, please use :

- Php >= 7.4
- MySQL or MariaDB

Or

- Docker >= 18.0

## Composer Libraries

- "symfony/dotenv": "^5.3"
- "nikic/fast-route": "^1.3"
- "symfony/http-foundation": "^5.3"
- "friendsofphp/php-cs-fixer": "^3.2"
- "phpunit/phpunit": "^9.5"

## Installation

1- Install depencies with Composer:

```bash
composer install
```

2- If you want to use docker, launch the server:

```bash
composer install
php database\init_db.php
docker-compose up -d
```

3- Edit the .env and the init_db.php files if needed and launch the script to setup the db.

```bash
php database\init_db.php
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

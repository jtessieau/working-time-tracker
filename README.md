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

```bash
composer install
php database\init_db.php
docker-compose up -d
```

## License

[MIT](https://choosealicense.com/licenses/mit/)

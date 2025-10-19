# Development with Docker (PHP 8.1)

This project ships a minimal `docker-compose.yml` and PHP 8.1 Dockerfile to run a local dev environment that is compatible with Laravel 8 and avoids PHP 8.4 deprecation noise.

Requirements: Docker and Docker Compose installed.

Start the development stack:

```bash
docker compose up --build
```

This will:
- Build a PHP 8.1 container with composer
- Start a MySQL 8 container with database `Form_Permintaan`
- Run `composer install`, migrate and seed, and start `php artisan serve` on port 8000

Visit http://localhost:8000 after the containers are up.

# Currency exchange

Task 

## Requirements

php: ^8.1

NodeJS: ^18.0

## Installation
Backend setup

Create a new 'currancy' database and fill in the credentials in the .env file

```bash
cd api
cp .env.example .env
composer install
php artisan migrate
php artisan db:seed
php artisan serve --port 8000
```
Configure email in .env

Frontend setup

```bash
cd ../app
cp .env.dev.exmaple .env.dev.local
npm install
npm run dev
```

## Usage
To update currencies use the following command
```php
# updates exchange rates in the database
php artisan currency:update-rates
```

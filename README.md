# Eloquent relationships example

## Setup

1. Clone this repo into your `html` folder
2. Run `composer install` to install the project dependencies
3. Run `php artisan key:generate`
4. Make a copy of `.env.example` called `.env` and update the database credentials to connect to a new empty database
5. Run `php artisan migrate:fresh --seed` to run the migrations and seeders
6. Run `php artisan serve --host=0.0.0.0` to run the app

# Prex demo Laravel Project

The following project attempts to solve the exercise for an API that interacts with the Giphy service.

## Installation

Clone the repository and install all dependencies by issuing:

`composer install`


This project uses Laravel sail. This means that Dockerfiles are included as a dependency under `vendor/laravel/sail/runtimes/8.x/Dockerfile`.


After installation, just run:

`./vendor/bin/sail up -d`


Run all necessary DB migrations:

```
./vendor/bin/sail artisan migrate:install
./vendor/bin/sail artisan migrate
```

An example Postman collection with the needed environment configuration is included in the repository.
Please configure your own `GIPHY_API_KEY` environment variable using the included .env file. It is not included for security purposes.

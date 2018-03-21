# Martynas Bakanas Task

- Front - Vue
- Back - Laravel

## Start

- DB_DATABASE @ .env
- DB_USERNAME @ .env
- DB_PASSWORD @ .env
- php artisan migrate @ command line

## Addons/Packages

- Hierarchical lists package for Laravel - https://github.com/lazychaser/laravel-nestedset
- Fonts Awesome v4.7.0 - npm install font-awesome
- Notification Styles - https://github.com/codrops/NotificationStyles

## URL

- /populate - Creates 20 root categories, each of which has 30 sub categories, which in turn also has 30 sub categories

## Tests

- Insert categories - ./vendor/bin/phpunit
- Iterative method: ./vendor/bin/phpunit --filter testIterativeGet ./tests/Feature/CategoryLoad.php 
- Using package functions: ./vendor/bin/phpunit --filter testPackageGet ./tests/Feature/CategoryLoad.php

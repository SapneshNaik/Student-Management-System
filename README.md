# Student-Management-System

## Setup 

`$ php artisan migrate
`

`$ php artisan passport:install
`

`$ php artisan sms:setup_system
`

`$ php artisan sms:super_admin
`

## Development Steps:

1. Laravel IDE Helper plugin for PhpStorm (https://github.com/bar********ryvdh/laravel-ide-helper)
2. Laravel Passport for authentication (https://medium.com/@flicher/laravel-rest-api-passport-authentication-for-ionic-app-3934713bcdf7)
3. php artisan migrate
4. php artisan passport:install
5. php artisan make:middleware Cors
   php artisan make:model -a app/Models/Admin --api
   
   https://stackoverflow.com/questions/34748097/phpstorm-exclude-vendor-from-search-but-keep-intellisense



## Tech Stack:

Laravel 6,
Vue.js 2

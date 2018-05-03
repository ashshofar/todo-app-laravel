## Todo APP

Req: 

- PHP 7.1 (don't use PHP 7.2)
- Composer
- MySQL

Install
- Clone
- Run Composer Install
- cp .env.exampe .env
- change .env 
    DB_DATABASE 
    DB_USERNAME 
    DB_PASSWORD
    CACHE_DRIVER=array
- run php artisan vendor:publish
- run php artisan jwt:generate 
- run php artisan migrate --seed

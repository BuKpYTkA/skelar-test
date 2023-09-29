# Installation
## Basic

Copy .env file:
````bash 
cp .env.example .env
````

Install composer dependencies:
````bash 
composer install
````

Setup database credential in your <code>.env</code> file and run the migrations
````bash 
php artisan migrate
````

Generate app key:
````bash 
php artisan key:generate
````

To be able to use local storage you have to run:
````bash 
php artisan storage:link
````

<b>Important:</b><br>
This application uses <code>spatie/laravel-medialibrary</code> library.
You have to set up correct <code>APP_URL</code> to be able to use local storage. 
By default, it's <code>http://127.0.0.1:8000</code>

Create demo data:
````bash
php artisan db:seed --class=DemoSeeder
````

By default, this application uses sqlite database for testing. If you want to keep it this way, run:
````bash
touch database/database.sqlite
````

Install npm dependencies:
````bash
npm i
````

Compile assets:
````bash
npm run dev
````

Start local server:
````bash
php artisan serve
````

<hr>

## Docker

If this is your first time launching the application you should use:
````bash
make set_up
````

Otherwise:
````bash
make up
````

Your application will be available on <code>http://127.0.0.1:8090</code>

To open application bash run:
````bash
make app_bash
````

<b>Use your local <code>npm</code></b> to be able to use <code>npm run dev</code> command.<br>

After you installed the project, your database credentials will be 
#### Username: root
#### Password: root
#### Port: 3307

# Tests

Run tests:
````bash
php artisan test
````

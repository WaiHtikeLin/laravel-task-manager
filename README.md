## Laravel Task Manager

Basic Task Manager App written using laravel framework (v8.x). It's mostly emphasized in backend (But I used tailwind for authentication because I installed laravel breeze for simple authentication). You can use any frontend framework if you want to.

### Steps to use the app 

1. Clone the repository.

2. Install dependencies using composer

```
composer install
```

If you don't have composer, go to https://getcomposer.org/download/ and can follow the instructions.

3. Create New Mysql Database

4. Copy .env.example to .env file

5. Edit .env file to match the database and other env values.

6. Generate unique key for the app
```
php artisan key:generate
```

7. Migrate the database
 ```
php artisan migrate
```

8. Start the development server
 ```
php artisan serve
```

References
<br>
Element drag and drop - https://www.w3schools.com/html/html5_draganddrop.asp

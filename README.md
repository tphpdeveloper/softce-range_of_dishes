# Work with module range_of_dishes

**1.**
```php
//write to composer.json
"require": {
    ...
    "softce/range_of_dishes" : "dev-master"
}

"autoload": {
    ... ,

    "psr-4": {
        ... ,

        "Softce\\Rangeofdishes\\" : "vendor/softce/range_of_dishes/src"
    }
}
```


**2.**
```php
//in console write

composer update softce/range_of_dishes
```


**3.**
```php
//in service provider config/app

'providers' => [
    ... ,
    Softce\Rangeofdishes\Providers\RangeofdishesServiceProvider::class,
]


// in console 
php artisan config:cache
```

**4.**
```php
//To display, you need to write the following code on the page

...

```

# For delete module

```php
//delete next row

1.
//in app.php
Softce\Rangeofdishes\Providers\RangeofdishesServiceProvider::class,

2.
//in composer.json
"Softce\\Rangeofdishes\\": "vendor/softce/range_of_dishes/src"

3.
//in console
composer remove softce/range_of_dishes

4.
// delete -> bootstrap/config/cache.php

5.
//in console
php artisan config:cache
```


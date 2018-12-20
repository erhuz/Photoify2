# Photoify

## Hand-in project @ Yrgo Göteborg
An Instagram-like application where users can upload, like and comment on eachothers images.

## Built with
* Laravel

## Dependencies
* php-sqlite3
* doctrine/dbal

## Setup
1. Clone the project
```
$ git clone https://github.com/erhuz/Photoify.git
```
2. Move inside the Photoify directory
```
$ cd Photoify
```
3. Install composer dependencies
```
$ composer install
```
4. Rename `.env.example` to `.env`
```
$ mv .env.example .env
```
5. Generate application key
```
$ php artisan key:generate
```
6. Start the application server
```
$ php artisan serve
```


## License
[The MIT License](https://github.com/erhuz/Photoify/blob/master/LICENSE)

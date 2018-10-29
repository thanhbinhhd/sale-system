# Selling System PHP Framework
This System build with Laravel 5.7 + VueJs 2.0

## Basic Features

- Manage product + category
- Statistical tables
- Categorize articles
- Label classification
- ベトナム語　＋　日本語 
- Markdown Editor
- and more...

## Server Requirements

- PHP >= 7.1.13
- Node >= 6.x
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MySql 5.7+

#### How to install Project

#### 1.Step 1
Clone this project

```terminal
https://github.com/thanhbinhhd/sale-system.git
```
#### 2.Step 2
Install required package
```terminal
composer install
npm install
```

#### 3.Step 3
Create or clone .env for config driver, database for this project.

```terminal
cp .env.example .env
```
##### set your local db
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE= --database_name
DB_USERNAME=--user_name
DB_PASSWORD=--user_password
``` 

#### 4.Step4
First run laravel project
```terminal
php artisan system:install
php artisan serve
npm run dev
```
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

#### 4.Step 4 setup default data and create super admin
```
php artisan system:install
php artisan system:admin
```

#### 5. Step 5 setup your mail host: `example with gmail`
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=****@gmail.com
MAIL_PASSWORD=******
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=******@gmail.com
MAIL_FROM_NAME=ASTEAM_K60
```

#### 6. Step 6 setup your google client `example with localhost sites`
```
GG_CLIENT_ID=********
GG_CLIENT_SECRET=*******
GG_REDIRECT_URL=http://localhost:8000/user/oauth/google/callback
```

#### 7. Step 7 Update your config and run with default port 8000. You can custom port by option `--port=port_number`
```terminal
php artisan config:cache
php artisan ser
npm run dev
```

#### 8. Step 8 open web app
> Your web app default serve in `http://localhost:8000`

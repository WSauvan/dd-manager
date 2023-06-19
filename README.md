**This document is for internal use only. It is confidential and the property of Webqam. It may not be reproduced or
transmitted in whole or in part without the prior written consent of Webqam. / Ce document est à usage interne
uniquement. Il est confidentiel et la propriété de Webqam. Il ne peut être reproduit ou transmis en tout ou partie sans
l'accord préalable et écrit de Webqam.**

# Laravel Readme boilerplate

<p align="center">Place your customer logo here</p>

You are working on a Laravel project, please follow instructions (More information: https://laravel.com/docs/:laravel-doc-version:) :

## Summary

[[_TOC_]]

## About

This project using Laravel :laravel-doc-version: (:app-name:) is an application for (:app-description:)

Gitlab repository : [:repository-url:](:repository-url:)

## Server Requirements

* PHP >= :php-version:
* Nginx orApache server
* MariaDB, MySQL or MongoDB database
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP Extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
* Composer
* Git

## Installation

### Main Structure

* Project input : `/public`
* Configuration files : `/config`
* Resources files (assets) : `/resources`
* Core files : `/app`

For more detailed information about structure of a laravel root directory : https://laravel.com/docs/:laravel-doc-version:/structure

### Commands to use on installation

* `cp .env.example .env` copy the default configuration file
* `chmod -R 777 ./storage/` give writing rights for storage directory
* Fill .env file with your database credentials, APP_URL (with https if it's active)

| local                                       | pre-prod, staging or prod                                                             |
|---------------------------------------------|---------------------------------------------------------------------------------------|
| `composer install` install php dependencies | `composer install --no-dev --no-progress -a` install php dependencies and exclude dev |
| `npm install` install npm dependencies      | Launched with gitlab CI job                                                           |   

```bash
php artisan key:generate # generate app key, answer 'yes'
php artisan config:clear # clear config cache
php artisan storage:link # create symbolic link for uploads
php artisan vendor:publish --tag=public # publish public assets to public folder
php artisan vendor:publish --provider="Backpack\CRUD\BackpackServiceProvider" --tag=minimum # publish public assets needed for Backpack BO
```

## Development

### Laravel development server

If you have PHP installed locally and you would like to use PHP's built-in development server to serve your application,
you may use the serve Artisan command.

```bash
php artisan serve --host[=HOST] --port[=PORT]
```

Without option, this command will start a development server at http://localhost:8000.

### Docker

This project comes with a Docker environment. For further information, please refer to
its [readme](.cloud/docker/README.md) file.

In short, create and fill the `.env` file then build the Docker image:

```bash
cd .cloud/docker
cp .env.example .env
make up-expose
```

### Front

You should use [nvm](https://github.com/nvm-sh/nvm) in order to synchronize to the project Node/NPM versions, stored in [.nvmrc](.nvmrc) file with the following command:

```bash
nvm use
```

| local                              | pre-prod, staging or prod                                                    |
|------------------------------------|------------------------------------------------------------------------------|
| `npm run dev` compile assets files | `npm run prod` compile assets files, minify files, can launch custom actions |
| `npm run watch` watch assets files | do not watch anything in environment different of local                      |

* `npm install -g stylelint` install css linter, to improve the style quality code
* `stylelint "path/to/your/css/**/*.scss"` launch stylelint for all your scss files

### Unit tests

Run the command `vendor/bin/phpunit` to launch tests.

They are located in /tests folder

### Linter

[GrumPHP](https://github.com/phpro/grumphp) and [Prettier](https://prettier.io/) are set in git hook to check code
style (each commit).

To fix some JS / CSS code style mistake this command can help you : `pretty-quick --staged`  
It's try to reformat staged code.  
PHPStorm Plugin : [Prettier](https://plugins.jetbrains.com/plugin/10456-prettier)

To fix some PHP code style mistake this command can help you : `./vendor/bin/phpcbf {you file or your directory}`  
PHPStorm Plugin : [Prettier](https://plugins.jetbrains.com/plugin/10456-prettier)
You can enable Code Sniffer in PHPStorm ([Doc](https://www.jetbrains.com/help/phpstorm/using-php-code-sniffer.html)) and
set code style to [PHPStorm formater](https://laraveldaily.com/how-to-configure-phpstorm-for-psr-2/)

## Variables to replace
* `:app-name:`
* `:app-description:`
* `:laravel-doc-version:`, eg: 8.x
* `:php-version:`, eg: 7.2.5
* `:repository-url:`, eg: https://gitlab.webqam.fr/... 


## Observations

> The original location of this document is : https://gitlab.webqam.fr/webqam/boilerplates/readme/blob/master/Laravel.md 

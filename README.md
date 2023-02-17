﻿# ArnaudMichant

## Installation
### Project Dependencies
To install all dependencies, run command : 
`composer install`

### Create database
to create the database for the site use command : 
`php .\bin\console doctrine:database:create`

### Create database schema
to create the database schema use command : 
`php .\bin\console doctrine:schema:create`

### Create the first admin user :
`php .\bin\console createuser`
Input user email and choose a password

## Running

Depending on your installation, use symfony client to run the website `symfony serve` or any other webserver

## Requirements 
php 8.1 is required


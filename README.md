# BileMo API REST 

this porject is created as part of a PHP / Symfony application developer training, the objectif is to create an API REST using symfony 4 and Complies with HTTP specifications and level 1,2,3 rules in Richardson's model.

# The quality of the code
<a href="https://codeclimate.com/github/samirdev2019/bileMo-API-REST/maintainability"><img src="https://api.codeclimate.com/v1/badges/ca14c014041769a1d21a/maintainability" /></a>

# Installation:
____________________
#### 1- clone or download the project 
`` git@github.com:samirdev2019/bileMo-API-REST.git``
#### 2- download & install dependencies 
``` $ composer install ```
#### 3- database configuration
in the .env enter the username, password and the name of database
`` DATABASE_URL=mysql://username:password@127.0.0.1:3306/databaseName ``

#### 4- create database
`` $ php bin/console doctrine:database:create ``
#### 5- create a schema 
``` $ php bin/console doctrine:schema:update --force ```

#### 6- load fixtures

``` $ php bin/console doctrine:fixtures:load ```
#### 7-  Generate the SSH keys:
``$ mkdir -p config/jwt``
``$ openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096``
``$ openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout``
### Usage
_________
#### 1- run server 
`` $ php -S localhost:8000 -t public ``
#### 2- demo
 Users registred:</h>

<p>username : orange</p>
<p>password : password </p>

#### 3- see the API documentation 
for some raison of configuration it's preferable to use localhost in the place of 127.0.0.1  
for more information about how to use the bileMo API, you can consult the documentation taping the URL
http://localhost:8000/api/doc in your browser
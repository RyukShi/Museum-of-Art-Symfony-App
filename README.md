# Museum-of-Art-Symfony-App

Symfony Application to visualize data from The Metropolitan Museum of Art

## Install Application

`git clone https://github.com/RyukShi/Museum-of-Art-Symfony-App.git`  
`composer i`

## Run Application

for Symfony CLI only  
`symfony serve OR symfony server:start`

## Create database

requirements : uncomment options **pdo_pgsql** and **pgsql** in **php.ini** to connect to postgresql server

`php bin/console doctrine:database:create`  
`php bin/console doctrine:migrations:migrate` or `php bin/console d:m:m`

## Load Fixtures

`php bin/console doctrine:fixtures:load` use option : `--append` to append data to database

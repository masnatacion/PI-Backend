  

# PI-Backend exam (PHP-Laravel)

  
A company requires a system to have basic information about their employees at any time containing files that are important for the enrollment process. As part of the PI Department you were selected to develop this project.


## Requirements

  
- Composer
- PHP 7.3
- MYSQL 5.7
- NGINX or Apache
- Postman
- Docker ( optional )

 

## Run with docker

  
Download docker
[https://docs.docker.com/engine/install/](https://docs.docker.com/engine/install/)

Open terminal

> cd your-project-folder
> 
> docker-compose up
> 

Open other terminal or tap

> docker-compose exec php composer install
> 
> docker-compose exec php php artisan migrate
> 
> docker-compose exec php php artisan db:seed

The project runs in 
> http://localhost:8080

If you want to change default port go to docker-compose.yml

## Run without docker

Make a copy of .env.example to .env and change environment variables
  
Open terminal

> cd your-project-folder
> 
> composer install
> 
> php artisan migrate
> 
> php artisan db:seed

## Postman

You can found the postman file in the root path ( api.postman_collection.json )
We create 2 environment variables **base_url** and **token**.  The **base_url** is http://localhost:8080 and **token** is the access token generated after login

## Users for testing
Administrator user:

username: admin

password: admin



Employee user:

username:ee

password:ee

## Cron job

if you want to run the email log open a new terminal

> cd your-project-folder
> php artisan log:email

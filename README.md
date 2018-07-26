# Project Title

Docker-based Drupal Intallation 

## Getting Started

This repository conssists of Dockerized  Drupal website. Running Drupal 8.5, Apache 2.4, MySql 5.7 and PHP 7. 
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Prerequisites

What things you need to install the software and how to install them

```
Git 
Docker 
Composer
```

### Installing

A step by step series of examples that tell you how to get a development env running

Download the repository

```
$ git clone git@github.com:hunde/drupal_docker.git 
```

Change your Directory to the newly downloaded repository

```
cd DrupalDocker
```
###### Edit Key Configuration files (.env)

```
DB_NAME=Database Name
DB_USER=Database username
DB_PASSWORD=Database password for $DB_USER
DB_ROOT_PASSWORD=Mysql Root Password
DB_HOST=HostNamae 
DB_DRIVER=mysql
MYSQL_VERSION=5.7 (Mysql Version/ Recommended to leave it with 5.7)
HOST_MYSQL_PORT= Docker container Mapping port for mysql
HOST_APACHE_PORT= Docker container Mapping port for apache
MYSQL_NAME=mysqldb //Yur database container name
WEB_NAME=web // your Web container name 
CONFI_DIRECTORY=/path/to/drupal/config
CONFI_DIRECTORY=/path/to/drupal/config
```


## Running containers

Our development environment will consists of two containers. One running apache+php and another one for mysql. 

```
$ docker-compose up --build -d
```

### Drush

Drush is installed on the webserver container. In order run drush comman use:

```
docker exec -it web drush Command 
```

### Drupal Project Installation 

The next step is to get drupal project to be part of your repository. For fresh drupal installation please run the script provided. This repo is being shipped with Drupal 8.5.5 under docroot directory. 

```
bash InstallDrupal.sh //this will remove the existing Drupal installation and pull a new 8.5.5 release 
#Please refer https://www.drupal.org/node/3060/release ton install diffrent version of drupal and change the 
#URL on InstallDrupal.sh file to point to the version you want to install.
```
Or 

To dockerize an exixsting project please download the project to this directory and rename it to docroot. 
It is remmended to restart the web container after anychange to a volumen directory. 

❗During installation if an error "Can't unlink already-existing object" occured. Please try removing the docroot directory as a root user (sudo rm -rf docroot/) and rerun this script.  

 ** Also if an existing Project is docorized please make sure drush is part of the project or run :

```
cd docroot/ && composer require 'drush/drush'
```
### Vendor Directory 

Vendor directory is ignored in our repository. So, please run composer install to get Drupal dependecies


```
cd docroot/ && composer install 
```


### Now go to the URL below to intall Drupal on your container


From now on we use a normal Drupal Intallation, 

```
Open: http://localhost:HOST_APACHE_PORT (The port number you configured on .env file)
```

During installation on database configuratuion open the advanced setting to change the database host to MYSQL_NAME configured on .env file 


## Authors

* **Hunde Keba** - *Initial work* - [Hundek](https://github.com/hunde)



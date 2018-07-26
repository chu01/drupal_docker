# Project Title

Docker-based Drupal Installation 

## Getting Started

This repository consists of Dockerized  Drupal website. Running Drupal 8.5, Apache 2.4, MySql 5.7 and PHP 7. 
These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. 

### Prerequisites


```
Git  [How to install git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
Docker [How to install docker](https://docs.docker.com/install/#reporting-security-issues)
Composer [How to install composer](https://getcomposer.org/doc/00-intro.md)
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

Our development environment will consist of two containers. One running apache+php and another one for mysql. 

```
$ docker-compose up --build -d
```

### Drush

Drush is installed on the webserver container. In order run drush command, use:

```
docker exec -it web drush Command 
```

### Drupal Project Installation 

The next step is to get drupal project to be part of your repository. For fresh drupal installation please run the script provided. This repo is being shipped with Drupal 8.5.5 under docroot directory. 

```
bash InstallDrupal.sh //this will remove the existing Drupal installation and pull a new 8.5.5 release 
#Please refer https://www.drupal.org/node/3060/release ton install different version of drupal and change the 
#URL on InstallDrupal.sh file to point to the version you want to install.
```
Or 

To dockerize an existing project please download the project to this directory and rename it to docroot. 
It is recommended to restart the web container after any change to a volume directory. 

❗During installation if an error "Can't unlink already-existing object" occured. Please try removing the docroot directory as a root user (sudo rm -rf docroot/) and rerun this script.  

 ** Also if an existing Project is dockerize please make sure drush is part of the project or run :

```
cd docroot/ && composer require 'drush/drush'
```
### Vendor Directory 

Vendor directory is ignored in our repository. So, please run composer install to get Drupal dependencies


```
cd docroot/ && composer install 
```


### Now go to the URL below to install Drupal on your container


From now on we use a normal Drupal Installation, 

```
Open: http://localhost:HOST_APACHE_PORT (The port number you configured on .env file)
```

During installation on database configuration open advanced setting to change the database host to MYSQL_NAME configured on .env file 

### Optional: Import existing mysql Database dump

Copy database dump to db-backups directory under the repo 

```
cp mysqlDump.sql /path/to/repo/db-backups
```

Now content under our db-backups directory will be available under /var/mysql/backups on the container. 

Login to our mysql container 

```
docker exec -it DbContainerName bash 
```

Import the database backup under /var/mysql/backups to the database we create

```
mysql -u username -p database_name < file.sql
```

Exit the container by typing 'exit'

## Authors

* **Hunde Keba** - *Initial work* - [Hundek](https://github.com/hunde)



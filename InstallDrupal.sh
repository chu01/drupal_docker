#!/bin/bas
#Instll Drupal 
# https://www.drupal.org/node/3060/release
#ENV DRUPAL_VERSION 8.5.5
curl -fSL "https://ftp.drupal.org/files/projects/drupal-8.5.5.tar.gz" -o drupal.tar.gz \
	&& tar -xz --strip-components=1 -f drupal.tar.gz -C docroot/ \
	&& rm drupal.tar.gz 
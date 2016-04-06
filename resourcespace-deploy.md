### Deploy example of Resource Space

```
#!/bin/bash
apt-get update
apt-get install -y apache2 php5 php5-gd php5-mysql php5-curl php5-dev subversion imagemagick

debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'
apt-get -y install mysql-server
mysql -u root -proot -e 'create database resourcespace;'

rm /var/www/html/index.html
svn co http://svn.resourcespace.org/svn/rs/trunk/ /var/www/html

wget https://raw.githubusercontent.com/AtzeDeVries/cursus-sd/master/resources/resourcespace.sql -O /tmp/resourcespace.sql

mysql -u root -proot resourcespace < /tmp/resourcespace.sql

wget https://raw.githubusercontent.com/AtzeDeVries/cursus-sd/master/resources/config.php -O /var/www/html/include/config.php

sed -i 's/floating-ip/145.136.242.xx/g' /var/www/html/include/config.php

mkdir -p /var/www/html/filestore
chmod 777 /var/www/html/filestore

```

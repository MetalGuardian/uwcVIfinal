#!/usr/bin/env bash
sudo su
export DEBIAN_FRONTEND=noninteractive

apt-get update -y

apt-get install -y -q git php5-cli php5-mysql php5-curl php5-intl php5-json curl nginx php5-fpm mysql-server php5-gd
# mysql
# apt-get install -y -q git mysql-client mysql-server
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# update configs
cp /vagrant/www.conf /etc/php5/fpm/pool.d/
cp /vagrant/default /etc/nginx/sites-available/
cp /vagrant/custom.ini /etc/php5/mods-available/ && cd /etc/php5/fpm/conf.d/ && ln -s ../../mods-available/custom.ini ./20-custom.ini

# restart services
service nginx restart
service php5-fpm restart

SQL="CREATE DATABASE IF NOT EXISTS uwc DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;"
mysql --user=root --password= -e "$SQL"

cd /vagrant/src && composer install
cd /vagrant/src/backend/www && ln -s ../../frontend/www/uploads/ ./

# add cron email command
echo "* * * * * vagrant /vagrant/src/yiic email" >> /etc/crontab

## SERO Rest API

Could also be called "the server part" of SERO.

- Uses Laravel PHP Framework.
- Uses https://github.com/Zizaco/entrust for roles and permissions.

### Requirements
- Setup server:
```
sudo apt-get install apache2 php5 libapache2-mod-php5 php5-cli php5-mysql mysql-client mysql-server libapache2-mod-auth-mysql php5-mysqlnd
sudo a2enmod rewrite
sudo a2enmod ssl
sudo a2ensite default-ssl
sudo a2enmod auth_mysql
sudo php5enmod mcrypt 
sudo apt-get install phpmyadmin
sudo service apache2 restart
```
- Change timezone:
```
sudo dpkg-reconfigure tzdata   -> follow on screen instructions
sudo service cron stop
sudo service cron start
date   -> shows current time
more /etc/timezone   -> shows current timezone
```
- Setup git:
```
sudo apt-get install git-core
git config --global user.email "jostein.skaar@gmail.com" && git config --global user.name "Jostein Skaar"
git config --global core.autocrlf true
git config --global push.default simple   -> New behaviour for Git 2.0
```
- Download Composer (in api directory): `curl -sS https://getcomposer.org/installer | php`
- Install/update project dependencies: `php composer.phar update`
- Make sure web server has write access to api/app/storage: 
```
cd app
sudo chown -R www-data:www-data storage
cd storage
find . -type d -exec sudo chmod 775 {} \; && find . -type f -exec sudo chmod 664 {} \;
sudo chown ubuntu:ubuntu .gitignore cache/.gitignore logs/.gitignore meta/.gitignore sessions/.gitignore views/.gitignore
```
- Set environment:
-- Goto api/bootstrap and follow instuctions in environment-dummy.php
- Open/close for https: Edit /etc/apache2/ports.conf and change between `Listen 443` and `Listen 127.0.0.1:443` (remember `sudo service apache2 restart`)


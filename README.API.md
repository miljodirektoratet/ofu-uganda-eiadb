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
- Set memory limit for php: `sudo sed -i 'sudo sed -i 's/memory_limit = .*/memory_limit = 256M/' /etc/php5/apache2/php.ini`
- Set upload sizes in /etc/php5/apache2/php.ini: 
-- upload_max_filesize = 100M
-- post_max_size = 100M
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
- Make sure web server has write access to api/storage: 
```
sudo chown -R www-data:www-data storage
cd storage
find . -type d -exec sudo chmod 775 {} \; && find . -type f -exec sudo chmod 664 {} \;
sudo chown ubuntu:ubuntu .gitignore cache/.gitignore logs/.gitignore meta/.gitignore sessions/.gitignore views/.gitignore
```
- Set environment:
-- See .env file
- Open/close for https: Edit /etc/apache2/ports.conf and change between `Listen 443` and `Listen 127.0.0.1:443` (remember `sudo service apache2 restart`)

- /etc/apache2/sites-available/default-ssl.conf:
```
DocumentRoot /home/ubuntu/sero/api/public
<Directory /home/ubuntu/sero/api/public>
    Options FollowSymlinks
    AllowOverride all
    Require all granted
</Directory>
```

- Other stuff:
-- "/dev/xvda1 should be checked for errors": https://nathanpfry.com/fix-dev-xvda1-should-be-checked-for-errors-on-amazon-ec2-ubuntu-instances/



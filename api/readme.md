## SERO Rest API

Could also be called "the server part" of SERO.

- Uses Laravel PHP Framework.
- Uses https://github.com/Zizaco/entrust for roles and permissions.

### Requirements
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


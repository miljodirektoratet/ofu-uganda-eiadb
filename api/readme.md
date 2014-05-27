## SERO Rest API

Could also be called "the server part" of SERO.

Uses Laravel PHP Framework.
Uses https://github.com/Zizaco/entrust for roles and permissions.

### Requirements
- Download Composer (in api directory): `curl -sS https://getcomposer.org/installer | php`
- Install/update project dependencies `php composer.phar update`
- Make sure web server has write access to api/app/storage: `sudo chmod -R 777 app/storage & sudo chmod -R 755 app/storage` 

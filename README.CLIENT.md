## SERO Client Web App

Located under api/public/client.

Uses AngularJS.

### Build

##### When it is a simple build. This is how to build version
- On developers machine: 
- - grunt publish (creates for instance version v4.16.0)
- On server:
- - cd sero
- - git fetch
- - git checkout v4.16.0 (or whatever version was created)

##### When we also have changes like db in Laravel.
- Same steps as over.
- Use artisan to handle db changes.


### Requirements

### Requirements (should only be needed for dev)
- Install Node.js: `sudo apt-get install node npm`
- Install grunt-cli globally: `sudo npm install -g grunt-cli`
- Install bower globally: `sudo npm install -g bower`
- Install/update dependencies: `sudo npm install`

### hosts
192.168.10.10 uganda.app
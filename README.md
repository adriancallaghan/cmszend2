
Introduction
============
Based on ZF2 Skeleton and the Album tutorial, this ZF2 application extends this further by migrating fully to Doctrine2 and adding comments for Albums as an association.

There is provision for Dynamic Modules & layouts, seperating the various layers.

The default module has routing setup with a top bar navigation, along with a GUI to demonstrate an AJAX RESTful service.

A RESTful service is in place, that is contained within its own module to serve the Albums and comments objects as Create, Update, Delete and List to the default application.

A CMS module is in place that uses identity persistance and Zend Auth to authenticate the users, the login forms and validation are all handled.

The CMS users can be created and managed, the CMS also has independent Navigation from the default route, along with CRUD services for the albums & comments services.

Twitter bootstrap has been intergrated into the CMS, so Flash Messages and form validation are all displaying within a bootstrap enviroment.


HOSTING STRUCTURE
-----------------
* Folder structure is /NAMEOFNEWPROJECT/public/ 
* Public is the Document-root for the server.
* Public should not be present prior to cloning from GIT, but setup in the host file



INITIAL SETUP
-------------
```bash
cd ../NAMEOFNEWPROJECT
git clone https://github.com/adriancallaghan/cmszend2.git NAMEOFNEWPROJECT  (will clone the project into the new project)
cd NAMEOFNEWPROJECT
mv config/autoload/examplelocal.php config/autoload/local.php
nano config/autoload/local.php (set database credientials)
php composer.phar self-update
php composer.phar install
./vendor/bin/doctrine-module orm:schema-tool:create
git remote rm origin
git init
git add *
git commit -m "first commit"
git remote add origin https://github.com/NEW-GIT-REPO-LOCATION.git
git push -u origin master
```

UPDATE USING GIT/COMPOSER & DOCTRINE2
-------------------------------------
```bash
git pull
php composer.phar install
./vendor/bin/doctrine-module orm:schema-tool:create./vendor/bin/doctrine-module orm:validate-schema
```

UPDATE DB IF NECESSARY (Caution it can cause the db to flush)
-------------------------------------------------------------
```bash
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

Admin
-----
You need to add a username, active (true) boolean and (md5) password combination into the cmsuser table in order to be able to login to the cms.
The password can be easily md5'd on the cmd line with something like 
```bash
php -r 'echo md5("SOME PASS");'
```



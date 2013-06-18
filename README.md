
Introduction
------------
Based on ZF2 Skeleton, this Skeleton has Pagination, Dual Navigation, Zend Auth, Doctrine2, Flash Messages, REST, Dynamic Modules/layouts, and a secure CMS



HOSTING STRUCTURE
-----------------
Folder structure is /NAMEOFNEWPROJECT/public/ 
Public is the Document-root for the server.
Public should not be present prior to cloning from GIT, but setup in the host file



INITIAL SETUP
-------------
cd ../NAMEOFNEWPROJECT
git clone https://github.com/adriancallaghan/cmszend2.git NAMEOFNEWPROJECT  (will clone the project into the new project)
cd NAMEOFNEWPROJECT
mv config/autoload/examplelocal.php config/autoload/local.php
nano config/autoload/local.php (set database credientials)
php composer.phar self-update
php composer.phar install
./vendor/bin/doctrine-module orm:schema-tool:create



UPDATE USING GIT/COMPOSER & DOCTRINE2
-------------------------------------
git pull
php composer.phar install
./vendor/bin/doctrine-module orm:schema-tool:create./vendor/bin/doctrine-module orm:validate-schema


UPDATE DB IF NECESSARY (Caution it can cause the db to flush)
-------------------------------------------------------------
./vendor/bin/doctrine-module orm:schema-tool:update --force


Admin
-----
You need to add a username and (md5) password combination into the cmsuser table in order to be able to login to the cms.
The password can be easily md5'd on the cmd line with something like php -r 'echo md5("SOME PASS");'




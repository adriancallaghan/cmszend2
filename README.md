
Introduction
------------
Based on ZF2 Skeleton, this Skeleton has Pagination, Dual Navigation, Zend Auth, Doctrine2, Flash Messages, REST, Dynamic Modules/layouts, and a secure CMS


QUICK START
-----------
git clone https://github.com/adriancallaghan/cmszend2.git
php composer.phar self-update
php composer.phar install
./vendor/bin/doctrine-module orm:schema-tool:create




Installation of code dependancies using composer and git
--------------------------------------------------------
git clone
php composer.phar self-update
php composer.phar install



Installation DB
---------------
./vendor/bin/doctrine-module orm:schema-tool:create 




Updates of code dependancies using composer and git
---------------------------------------------------
git pull
php composer.phar install



Check DB version
----------------
./vendor/bin/doctrine-module orm:schema-tool:create./vendor/bin/doctrine-module orm:validate-schema


Update DB (Caution it flushes the db)
-------------------------------------
./vendor/bin/doctrine-module orm:schema-tool:update --force


Admin
-----
You need to add a username and (md5) password combination into the cms_user table in order to be able to login to the cms




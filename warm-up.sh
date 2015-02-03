#! /bin/bash

cp parameters.yml.dist ./app/config/

#cd www
rm -fR ./app/logs/*
rm -fR ./app/cache/*

php composer.phar self-update
php composer.phar update -o
#php composer.phar install --optimize-autoloader
#php app/console assets:install --symlink
php app/console cache:clear --env=prod --no-debug
php app/console assetic:dump --env=prod --no-debug

# Note: As of Ubuntu 14.04 coreutils 8.21~8.23 a 3+ years old bug
# makes ACL usage ineffective : http://debbugs.gnu.org/cgi/bugreport.cgi?bug=8527

sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs
sudo setfacl -dR -m u:www-data:rwX -m u:`whoami`:rwX app/cache app/logs


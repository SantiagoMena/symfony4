#!/bin/bash
composer install
mkdir -p cache my_project/app/logs
touch logs/prod.log
touch logs/dev.log
chgrp -R www-data .
chmod -R g+w cache logs
source /etc/apache2/envvars
tail -F /var/log/apache2/* logs/prod.log logs/dev.log &
exec apache2 -D FOREGROUND
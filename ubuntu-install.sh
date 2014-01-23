#!/bin/bash
apt-get install apache2 mysql-server php5 ruby1.9.3 ruby1.9.3-dev build-essential
a2enmod mod_proxy
a2enmod proxy_http
a2enmod proxy_ajp
service apache2 restart

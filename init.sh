#!/bin/bash

apt update
apt install -y git unzip
docker-php-ext-install pdo pdo_mysql
php ./composer.phar install && ./yii migrate --interactive=0 && ./yii import "project_data.jsonl" && ./yii serve 0.0.0.0:8081
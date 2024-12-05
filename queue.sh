#!/usr/bin/env bash

php artisan queue:restart
php artisan queue:work --tries=3

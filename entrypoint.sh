#!/usr/bin/env sh

chmod -R 777 /var/www/html/database
set -e

exec "$@"

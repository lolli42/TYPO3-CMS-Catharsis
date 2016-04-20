#!/bin/bash

set -e

DIR=$(realpath $(dirname "$0"))
USER=$(whoami)
PHP_VERSION=$(phpenv version-name)
ROOT=$(realpath "$DIR/../../../../../..")
FPMPORT=9000
SERVER="/tmp/php.sock"

function tpl {
    sed \
        -e "s|{DIR}|$DIR|g" \
        -e "s|{USER}|$USER|g" \
        -e "s|{PHP_VERSION}|$PHP_VERSION|g" \
        -e "s|{ROOT}|$ROOT|g" \
        -e "s|{FPMPORT}|$FPMPORT|g" \
        -e "s|{SERVER}|$SERVER|g" \
        < $1 > $2
}

# Create some working directories
mkdir "$DIR/nginx"
mkdir "$DIR/nginx/sites-enabled"
mkdir "$DIR/var"


PHP_FPM_BIN="$HOME/.phpenv/versions/$PHP_VERSION/sbin/php-fpm"
PHP_FPM_CONF="$DIR/nginx/php-fpm.conf"

# Build the php-fpm.conf.
tpl "$DIR/php-fpm.tpl.conf" "$PHP_FPM_CONF"

# Start php-fpm
"$PHP_FPM_BIN" --fpm-config "$PHP_FPM_CONF"

# Build the default nginx config files.
tpl "$DIR/nginx.tpl.conf" "$DIR/nginx/nginx.conf"
tpl "$DIR/fastcgi.tpl.conf" "$DIR/nginx/fastcgi.conf"
tpl "$DIR/default-site.tpl.conf" "$DIR/nginx/sites-enabled/default-site.conf"

# Start nginx
nginx -c "$DIR/nginx/nginx.conf"
#!/bin/bash
set -e

SITE_CONF=/etc/apache2/sites-available/000-default.conf
PATH_ROOT=/var/www/html
STR_TEST_ENV=testing

if [ -n "$SERVER_NAME" ]; then
	sed -i 's#$SERVER_NAME#'$SERVER_NAME'#g' $SITE_CONF
else
	sed -i 's#$SERVER_NAME#localhost#g' $SITE_CONF
fi

if [ -n "$DOCUMENT_ROOT" ]; then
	NEW_PATH="${PATH_ROOT}/${DOCUMENT_ROOT}"
	sed -i 's#$DOCUMENT_ROOT#'$NEW_PATH'#g' $SITE_CONF
else
	sed -i 's#$DOCUMENT_ROOT#'$PATH_ROOT'#g' $SITE_CONF
fi

cd $PATH_ROOT

if [ -f "$PATH_ROOT/composer.json" ]; then
	if [ ! -d "$PATH_ROOT/vendor" ];then
	    composer update
		composer install
	fi
fi

if [ ! -f "$PATH_ROOT/.env" ]; then
    if [ -f "$PATH_ROOT/.env.example" ]; then
        cp .env.example .env
        php artisan key:generate
    fi
fi

if [ -f "$PATH_ROOT/.env" ]; then
    if [ "$APP_ENV" != "$STR_TEST_ENV" ]; then
        php artisan migrate
        php artisan db:seed
    fi
    chown www-data.www-data -R bootstrap/ storage/
fi

exec "$@"

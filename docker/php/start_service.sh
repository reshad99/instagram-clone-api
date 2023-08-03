#!/usr/bin/env bash

#set -e

# Run our defined exec if args empty
if [ -z "$1" ]; then
    role=${CONTAINER_ROLE:-app}

    if [ "$role" = "main_app" ]; then
        echo "Caching configuration..."
        php /var/www/html/artisan cache:clear 
        php /var/www/html/artisan config:clear
        php /var/www/html/artisan route:clear 
        php /var/www/html/artisan view:clear
        php /var/www/html/artisan config:cache
        php /var/www/html/artisan event:cache 
        php /var/www/html/artisan route:cache
        php /var/www/html/artisan view:cache --verbose --no-interaction &

    elif [ "$role" = "queue" ]; then

        echo "Running the queue..."
        exec php /var/www/html/artisan queue:work -vv --no-interaction --tries=3 --sleep=5 --timeout=300 --delay=10

    elif [ "$role" = "cron" ]; then

        echo "Running the cron..."
        while true
        do
            echo "Run schedule..."
            php /var/www/html/artisan schedule:run --verbose --no-interaction &
            sleep 60
        done

    else
        echo "Could not match the container role \"$role\""
        exit 1
    fi

    exec "$@"
else
    exec "$@"
fi

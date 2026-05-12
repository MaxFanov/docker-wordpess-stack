#!/bin/sh

until wp db check; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 1
done

if wp core is-installed; then
  echo "WordPress is installed. Checking Redis..."
  
  if ! wp plugin is-active redis-cache; then
    wp plugin install redis-cache --activate
  fi

  wp redis enable
fi
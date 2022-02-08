#!/bin/sh

docker run \
  -ti \
  --rm \
  --volume "$SSH_AUTH_SOCK:/ssh-auth.sock" \
  --volume "${COMPOSER_HOME:-$HOME/.composer}:/tmp" \
  --volume "$PWD:/app" \
  --env SSH_AUTH_SOCK=/ssh-auth.sock \
  --env COMPOSER_HOME \
  --env COMPOSER_CACHE_DIR \
  --user "$(id -u):$(id -g)" \
   composer:2.1 "$@"
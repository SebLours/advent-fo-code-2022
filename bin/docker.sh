#!/bin/bash
docker run --rm --name=adventofcode_php -ti -e DOCKER_USER=$UID -v "$PWD":/app -w /app thecodingmachine/php:8.1-v4-cli bash
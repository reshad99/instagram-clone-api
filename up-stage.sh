#!/bin/bash

docker compose -f docker-compose-stage.yml up -d "$@"

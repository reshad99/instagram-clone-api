#!/bin/bash

docker compose -f docker-compose-stage.yml down -v --remove-orphans

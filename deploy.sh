#!/bin/bash

git pull origin master
docker compose restart php

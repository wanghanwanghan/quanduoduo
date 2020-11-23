#!/bin/bash

git pull

rm -f ./Log/*

composer update

php easyswoole restart produce

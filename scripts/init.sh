#!/usr/bin/bash
echo 'script executing ...'  

if [[ -d "migrations/" ]]
then
    echo "This file exists on your filesystem."
fi

if find toto/ -maxdepth 0 -empty | read v; then echo "Empty dir"; fi
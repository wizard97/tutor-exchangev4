#!/bin/bash
# Remove old pictures
if [ "$#" -ne 4 ]; then
    echo "Run with ./migrate.sh <user> <password> <old db> <new db>"
    exit
fi
rm -rf ../storage/app/images/*
php ../artisan migrate:refresh
php users_tutors.php $1 $2 $3 $4
php reviews.php $1 $2 $3 $4
php saved_tutors.php $1 $2 $3 $4
php tutor_contacts.php $1 $2 $3 $4
php profile_pic.php $1 $2 $3 $4
echo "All Done!"

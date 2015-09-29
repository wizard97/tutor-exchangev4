#!/bin/bash
php ../artisan migrate:refresh
php users_tutors.php
php reviews.php
php saved_tutor.php
php tutor_contacts.php
php profile_pic.php
echo "All Done!"

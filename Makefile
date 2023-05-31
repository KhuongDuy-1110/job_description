up:
	- ./vendor/bin/sail up
down:
	- ./vendor/bin/sail down
php:
	- ./vendor/bin/sail exec laravel.test bash
tinker:
	- ./vendor/bin/sail exec laravel.test php artisan tinker
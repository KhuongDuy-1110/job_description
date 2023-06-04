up:
	- ./vendor/bin/sail up
down:
	- ./vendor/bin/sail down
php:
	- ./vendor/bin/sail exec laravel bash
tinker:
	- ./vendor/bin/sail exec laravel php artisan tinker
swagger:
	- ./vendor/bin/sail exec laravel php artisan l5-swagger:generate
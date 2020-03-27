## Student Management Installlation and Set up

 1. **Download the source code from the github repository.**
	 - src/frontend : frontend code
	 -  src/backend: backend code
	 - src/docs: project related docs
2. **Backend Deployment:**
	- Install XAMPP server and change document root  to `/src/backend/public`
	- Install Composer.
	- Create database in mysql (php-myadmin)
	- set the databse name, server url and password in `/src/backend/.env`
	- **In `src/backend` run :**
		- `chmod -R 777 storage`
		- `chmod -R 777 bootstrap/cache` 
		-  `composer install --optimize-autoloader --no-dev`
		- `php artisan migrate`
		- `php artisan passport:install`
		- `php artisan sms:setup`
		- `php artisan super:admin` and set super admin details.
		- `php artisan route:cache` and `php artisan config:cache`

3. **Frontend deployment:**
	- Install `node.js` and `npm` 
	- **In `src/frontend` run:**
		- `npm install`
		- `npm run build`
	- Install a web server (XAMPP)  and point its docuent root to `/src/frontend/dist` .

		

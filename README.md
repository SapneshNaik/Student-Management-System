![SMS logo](https://kerneldev.com/wp-content/uploads/2017/11/v240-62Artboard-1.png) 

# Student Management System

The web app has 4 types of users, namely, Admin, Student, Staff, and Parent. And each user can have a set of roles (Ex. Admin Desk, Exam Staff), and these roles, in turn, grant the user a set of permissions. So each permission is mapped one action (for example, create admin, view students, create roles, etc.). So based upon the user's permission, the front-end dashboard is dynamically populated. The same check present on the backend as well so that the user only has access to the operations which he has permissions to access. Apart from this there is also functionalities to create/list/view and update Student, Admins, Staff and Parents.

## Demo Video (Click below image to view):

[![Watch the video](https://img.youtube.com/vi/q5hc4QWdJdM/maxresdefault.jpg)](https://youtu.be/q5hc4QWdJdM)

 
## Installlation and Set up:

 1. **Download the source code from the github repository.**
	 - src/frontend : frontend code
	 - src/backend: backend code
	 - src/docs: project related docs
2. **Backend Deployment:**
	- Install Composer.
	- Create database in mysql (php-myadmin)
	- set the databse name, server url and password in `/src/backend/.env`
	- **In `src/backend` run :**
	
		- `composer install`
		- `chmod -R 777 storage`
		- `chmod -R 777 bootstrap/cache` 
		-  `composer install --optimize-autoloader --no-dev`
		- `php artisan migrate`
		- `php artisan passport:install`
		- `php artisan sms:setup`
		- `php artisan super:admin` and set super admin details.
		- `php artisan route:cache` and `php artisan config:cache`
	- Change your web server's document root  to `/src/backend/public`


3. **Frontend deployment:**
	- Install `node.js` and `npm` 
	- **In `src/frontend` run:**
		- `npm install`
		- `npm run build`
	- Change your web server's document root  to `/src/frontend/dist`

		

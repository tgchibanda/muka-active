# Muka Active Website
E-commerce application built with Laravel, Vue.js, Tailwind.css and Alpine.js. <br>


## Installation 
Make sure you have environment setup properly. You will need MySQL, PHP8.1, Node.js and composer.

### Install Laravel Website + API
1. Download the project (or clone using GIT)
2. Copy `.env.example` into `.env` and configure database credentials
3. Navigate to the project's root directory using terminal
4. Run `composer install`
5. Set the encryption key by executing `php artisan key:generate --ansi`
6. Run migrations `php artisan migrate --seed`
7. Start local server by executing `php artisan serve`
8. Open new terminal and navigate to the project root directory
9. Run `npm install`
10. Run `npm run dev` to start vite server for Laravel frontend

### Install Vue.js Admin Panel
1. Navigate to `backend` folder
2. Run `npm install`
3. Copy `backend/.env.example` into `backend/.env`
4. Make sure `VITE_API_BASE_URL` key in `backend/.env` is set to your Laravel API host (Default: http://localhost:8000)
5. Run `npm run dev`


### Laravel Deployment on hostinger
1. Create domain eg example.com and Setup subdomain eg admin.example.com. Complete SSL certificates
2. SSH and go to domains/example.com and delete public_html rm -rf public_html (On new ssh, you might see the broken public_html, just remove it too)
3. Run git clone and add example.com at the end. Then cd into the example.com. Run the below code
```
composer install
```
if you get errors, download composer. This might be because the global composer being used is old. Run the code below.
```
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                        php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
                        php composer-setup.php
                        php -r "unlink('composer-setup.php');"
```
4. Install with the local composer
```
php composer.phar install
```
5. Copy and create your .env file using 
```
cp .env.example .env
```
6. Create a symbolic link for public_html 
```
ln -s public public_html
```
7. Generate secret app key and migrations
```
php artisan key:generate --ansi
php artisan migrate --seed
```
8. Generate build files on local dev machine to get vite files
```
npm run build
```
9. Remove /public/build from .gitignore and commit your changes to remote server.
10. Pull changes into production
```
git pull origin main
```
if you had made some changes first run
```
git reset --hard HEAD
```

### VueJs Deployment on hostinger
1. Create a .env.production file in the backend on your local machine and put the url of your server eg https://example.com
2. In the backend folder on local, run. 
```
npm run build
```
This will create a dist folder
3. Go to your production server and create folder admin in public_html. Add the dist files from local into admin
4. Create an apache file in the admin folder and name it .htaccess then paste the below
```
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.html
```
5. Run 
```
php artisan storage:link
```
6. On you local, search filesystems.php under the config of the laravel application add visibility on disks array like below
```
'visibility' => 'public'
```
then comit to git hub and pull to production server
7. Configure stripe. Just copy them from local .env file. Change webhook key for the production server. Generate this with new domain in stripe account.
8. For email logo to show, slot name should be exactly like the production app name in the .env

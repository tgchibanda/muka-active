1. Clone project
2. Get into the folder
3. run composer install
4. rename .env.example for both front and backend then run npm install for both folders as well
5. create the mysql db
6. run php artisan key:generate
7. run php artisan storage:link
8. run php artisan migrate
9. run php artisan serve
10. got to the backend folder and run npm install
11. run npm run dev



<b>Deployment</b>

Create domain eg example.com
Setup subdomain eg admin.example.com
Setup ssl ceertificate as they affect your URL configs
Delete public_html rm -rf public_html
When you ssh into the user, you might still have a symbolic link for public_html, run rm -rf public_html again then navigate to domains
do a git clone in there and in front of the git link, write an extra line of the name of the domain eg example.com
cd example.com
then composer install if it does not work do the following
                        1. Download composer by pasting the below in your ssh terminal under example.com
                        php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
                        php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
                        php composer-setup.php
                        php -r "unlink('composer-setup.php');" 
                        2. 
install with the local composer php composer.phar install as the global composer was pointing to an old version
configure your .env file eg cp .env.example .env
create a symbolic link by ln -s public public_html
php artisan key:generate --ansi
php artisan migrate --seed
go to your local folder and run npm run build to get vite files
remove /public/build from .gitignore
commit your changes to remote server

then run git pull origin main
if you had some changes before just do git reset --hard HEAD first

Now Deploy VueJs
create a .env.production file in the backend on your local machine and put the url of your server eg https://example.com
In the backend folder on local, run npm run build. This will create a dist folder
go to your production server and create the folder in the public_html that has been created name it admin
add the files that are in the dist folder into admin
When you click reload on the server, it will look for the folders but we want to direct it to the index.html
create the apache file in the admin folder on the production server and name it .htaccess
paste the below
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule . index.html
run php artisan storage:link on production for our storage folder to be accessible in public
then go on you local and search for filesystems.php under the config file of laravel application
add visibility on disks array like below
    'visibility' => 'public'
then comit to git hub and pull to production server
Configure stripe. Just copy them from local .env file
Change webhook key for the production server.

For email logo to show, slot name should be exactly like the production app name in the .env


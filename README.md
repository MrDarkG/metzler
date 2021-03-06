<p align="center">
	<a href="https://www.metzler-vater.com" target="_blank">
		<img src="https://www.metzler-vater.com/typo3conf/ext/sineos_layout/Resources/Public/Svg/logo-mv-group.svg" width="400">
	</a>
</p>



## About project

This is project for [metzler-vater.com](https://metzler-vater.com/). Project's perfect Workable inviroments are  :

- Php v7.4.16.
- PhpMyAdmin v5.1.0.
- Npm v6.14.11.
- Composer

## User Packages/frameworks

- Laravel v8.37.0.
- Vue.js v3.
- Jquery v3.5.1.
- Bootstrap v4.6.0

## Installation

To download This project simply run this command :
```
$ git clone https://github.com/MrDarkG/metzler.git
```
After that you need to install required packages:
```
$ cd metzler
$ composer update
$ composer install
$ npm install
$ npm run watch
```
After that we need to make **.env** file we can simply copy soure from .env.example. and we need to change following variables:
```
$ DB_DATABASE=your_database_name
$ DB_USERNAME=database_username #for most of phpmyadmin servers default is root
$ DB_PASSWORD=users_password #for mots of phpmyadmin's its blank
$ DB_PORT=users_password #for mots of phpmyadmin's default port is 3306. so update it if you have changed port manually
```
Then we need to generate App_key
```
$ php artisan key:generate
```
Then we need to migrate migrations and seed our database for required starting data like admin user, posts roles etc.
```
$ php artisan migrate
$ php artisan db:seed
```
Finally you can run server with command:
```
$ php artisan serve
```
with default parameters applications url will be [127.0.0.1:8000](http://127.0.0.1:8000)

For Authentification as Administrator use:
```
Email: admin@mail.com
Password: roottoor
```
Registration route is disabled so you guest cant register by their own
## Email verification
email verification middleware is included so if you want full futures you must change configuration of smtp. open **.env** file and update following information
```
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=
MAIL_FROM_ADDRESS=
```
with your smtp provider information
After That Forget password functions will also work perfectly.

## Privilegies and roles

On this application only **admin** can:

- [x] **Add User**
- [x] **Edit User**
- [x] **Delete User**
- [x] **Write Post**
- [x] **Edit Post**
- [x] **Delete Post**

Writer :
- [ ] **Add User**
- [ ] **Edit User**
- [ ] **Delete User**
- [x] **Write Post**
- [x] **Edit Post**
- [x] **Delete Post**




User can have only one role at a time

**Note:** When admin deletes user evrthing about user is deleting to:
- **Posts from that user**
- **Pictures of that post**
- **Avatar picture of that user**


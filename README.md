The backend API for teamio system.

## Software Requirements

* php 5.4, 
* mysql 5.5,
* enable mod_rewirte in apache2.4
* Suggested testing tool: Postman in Chrome Browser.

** LAMP installation, setting up .htaccess refers to Digital Ocean
** Creating Virtual Directory in Apache2 search internet.
** Grant your_user www_data group access

## Requests
You will need a http header:
X-Requested-With
 having value:
XMLHttpRequest

for Post Request, you need key:value pairs in "form-data"

## Development Manual
0. Setup: find under `lib` folder, copy `mysql_template.php` to `mysql.php`, modify the database name, username and password accordingly.

1. add a handler under `/handlers/` folder

2. add queries into `/lib/queries.php`

3. add in the route in `/index.php`

4. test things you added

5. add in the `API Usage` in `README.md`

6. pull, commit, push

## OAuth 2.0
This is an uncompleted feature, please refer to [http://bshaffer.github.io/oauth2-server-php-docs/](http://bshaffer.github.io/oauth2-server-php-docs/)

## API Usage

`GET /user/$user_id/image/` gets a list of images with associated properties of a given user based on $user_id

`POST /user/$user_id/image/` requires the following fields:

 * pictures[]
 * friend_names[]
 * descriptions[]
 
`GET /user/$user_id/image/$img_id` gets information of image $img_id of $user_id

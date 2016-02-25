The backend API for CMS system.

php 5.4, 
mysql 5.5,
enable mod_rewirte in apache2.4,

Suggested testing tool: Postman in Chrome Browser.

You will need a http header:
X-Requested-With
 having value:
XMLHttpRequest

for Post Request, you need key:value pairs in "form-data"


to start this, find under lib folder, copy mysql_template.php to mysql.php
, modify the database name, username and password accordingly.


`GET /user/$user_id/image/` gets a list of images with associated properties of a given user based on $user_id

`POST /user/$user_id/image/` requires the following fields:

 * pictures[]
 * friend_names[]
 * descriptions[]
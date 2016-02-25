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
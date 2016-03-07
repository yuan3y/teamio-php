The backend API for teamio system.

## Software Requirements

* php 5.4, 
* mysql 5.5,
* enable mod_rewirte in apache2.4
* Suggested testing tool: Postman in Chrome Browser.

 - LAMP installation, setting up .htaccess refers to Digital Ocean
 - Creating Virtual Directory in Apache2 search internet.
 - Grant your_user www_data group access

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

* Sample Data:
```javascript
[
  {
    "id": "1",
    "friend_name": "Samuel",
    "description": "He reads minds.",
    "filename": "06c0153d.jpg"
  },
  {
    "id": "2",
    "friend_name": "Yuan Yiyang",
    "description": "He codes.",
    "filename": "ee6a9fdc.jpg"
  }
]
```


`POST /user/$user_id/image/` requires the following fields:

 * pictures[]
 * friend_names[]
 * descriptions[]

This will get back the inserted data:
```javascript
{
  "id": "2",
  "friend_name": "Yuan Yiyang",
  "description": "He codes.",
  "filename": "ee6a9fdc.jpg"
}
```

`PUT /user/$user_id/image/$image_id` requires the following fields:

* picture
* friend_name
* description
 
Please note that these fields are singular.
This will get back the updated data:
```javascript
{
  "id": "2",
  "friend_name": "Yuan Yiyang",
  "description": "He codes.",
  "filename": "ee6a9fdc.jpg"
}
```

`DELETE /user/$user_id/image/$image_id` removes a specific image.
The result
success:
```javascript
{
  "success": true,
  "row_count": 1
}
```
failure:
```javascript
{
  "success": false,
  "row_count": 0
}
```

`GET /user/$user_id/image/$img_id` gets information of image $img_id of $user_id

This will get the image data:
```javascript
{
  "id": "2",
  "friend_name": "Yuan Yiyang",
  "description": "He codes.",
  "filename": "ee6a9fdc.jpg"
}
```


`GET /user/` retrieves a list of all user_id

`POST /user/` creates a new user (form field: userInfo)

`GET /user/$id` gets info of the user

`POST /user/$id` update

`GET /record/` aggregated record of all users

`GET /record/user/$user_id` gets all record of user $user_id

`GET /game/match_name/user/$id` generates a new game, with id, then an array of matches, each contains 1 name, 4 images.

`GET /game/match_image/user/$id` generates a new game, with id, then an array of matches, each contains 1 image, 4 names.

`POST /game/$game_id` records game result score (form field: result)

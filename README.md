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


`GET /user/` retrieves a list of all user (id and email)

```javascript
[
  {
    "id": "1",
    "email": "user1@example.com"
  },
  {
    "id": "2",
    "email": "user2@example.com"
  },
  {
    "id": "3",
    "email": "user3@example.com"
  },
  {
    "id": "4",
    "email": "user4@example.com"
  }
]
```


`GET /user/$id` gets info of the user

```javascript
{
  "id": "1",
  "email": "user1@example.com",
  "name": "Tan Ah Kau",
  "birthday": "1965-01-01"
}
```

`POST /user/` creates a new user, with following fields:

* email
* name
* birthday (in format of yyyy-mm-dd)

```javascript
{
  "id": "1",
  "email": "user1@example.com",
  "name": "Tan Ah Kau",
  "birthday": "1965-01-01"
}
```

`PUT /user/$id` update

```javascript
{
  "id": "1",
  "email": "user1@example.com",
  "name": "Tan Ah Kau",
  "birthday": "1965-01-01"
}
```

`GET /record/` aggregated record of all users

```javascript
[
  {
    "type": "FIND_NAME",
    "win_games": "8",
    "total_games": "10",
    "win_ratio": "0.8000"
  },
  {
    "type": "FIND_FACE",
    "win_games": "6",
    "total_games": "10",
    "win_ratio": "0.6000"
  }
]
```

`GET /user/$user_id/record/` gets all record of user $user_id

```javascript
[
  {
    "type": "FIND_NAME",
    "win_games": "7",
    "total_games": "10",
    "win_ratio": "0.7000"
  },
  {
    "type": "FIND_FACE",
    "win_games": "6",
    "total_games": "10",
    "win_ratio": "0.6000"
  }
]
```

`PUT /user/$user_id/record/$record_id` update number of games won by user for a particular game, with field:

* win : number of game won

```javascript
{
  "success": true,
  "row_count": 1
}
```

```javascript
{
  "success": false,
  "row_count": 0
}
```


`GET /game/match_name/user/$id` generates a new game, with id, then an array of matches, each contains 1 name, 4 images.

`GET /game/match_image/user/$id` generates a new game, with id, then an array of matches, each contains 1 image, 4 names.

`POST /game/$game_id` records game result score (form field: result)

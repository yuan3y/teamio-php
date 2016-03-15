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

[`GET /user/$user_id/image/`](http://php-teamio.rhcloud.com/user/1/image/) gets a list of images with associated properties of a given user based on $user_id

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

[`GET /user/$user_id/image/$img_id`](http://php-teamio.rhcloud.com/user/1/image/1) gets information of image $img_id of $user_id

This will get the image data:
```javascript
{
  "id": "2",
  "friend_name": "Yuan Yiyang",
  "description": "He codes.",
  "filename": "ee6a9fdc.jpg"
}
```


[`GET /user/`](http://php-teamio.rhcloud.com/user/) retrieves a list of all user (id and email)

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


[`GET /user/$id`](http://php-teamio.rhcloud.com/user/1/) gets info of the user

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

[`GET /record/`](http://php-teamio.rhcloud.com/record/) aggregated record of all users

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

[`GET /user/$user_id/record/`](http://php-teamio.rhcloud.com/user/1/record/) gets all record of user $user_id

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

[`GET /game/find_name/user/$id`](http://php-teamio.rhcloud.com/game/find_name/user/1) generates a new game, with id, then an array of matches, each contains 1 name, 4 photos.
You can update the game record by PUT /user/$user_id/record/$game_id after the game.

```javascript
{
  "game_id": "2",
  "matches": [
    {
      "name": "Samuel",
      "description": "He reads minds.",
      "photo": [
        "\/uploads\/1317cd0d.jpg",
        "\/uploads\/06c0153d.jpg",
        "\/uploads\/4cf92575.jpg",
        "\/uploads\/d82631e5.jpg"
      ],
      "correct": 2
    },
    {
      "name": "Eug\u00e8ne Gavrilin",
      "description": "He shoots.",
      "photo": [
        "\/uploads\/362f6162.jpg",
        "\/uploads\/e4a4401b.jpg",
        "\/uploads\/d82631e5.jpg",
        "\/uploads\/1317cd0d.jpg"
      ],
      "correct": 3
    }, ...
    }
  ]
}
```

[`GET /game/find_image/user/$id`](http://php-teamio.rhcloud.com/game/find_image/user/1) generates a new game, with id, then an array of matches, each contains 1 photo, 4 names.

```javascript
{
  "game_id": "3",
  "matches": [
    {
      "photo": "\/uploads\/e4a4401b.jpg",
      "description": "He plays chess.",
      "name": [
        "Benjamen Lim",
        "Agrim Singh",
        "Zhu Liang",
        "Yuan Yiyang"
      ],
      "correct": 1
    },
    {
      "photo": "\/uploads\/1317cd0d.jpg",
      "description": "Geek",
      "name": [
        "Eug\u00e8ne Gavrilin",
        "Jenni",
        "Emily Li",
        "Zhu Liang"
      ],
      "correct": 4
    }, ...
  ]
}
```

[`GET /user/$user_id/diary/`](http://php-teamio.rhcloud.com/user/1/diary/) list all diaries from the user of user_id. The default behaviour is order by descending published date (newest at top).

```javascript
[
  {
    "id": "2",
    "user_id": "1",
    "title": "Second Post",
    "body": "Just another post to test out some features.\n\nLine break and *asterisks* to show Markdown integration.",
    "published": "2012-08-18 16:39:03"
  },
  {
    "id": "1",
    "user_id": "1",
    "title": "First Post",
    "body": "This is the first post for Teamio. Hello, world?",
    "published": "2012-08-18 16:28:10"
  }
]
```

`POST /user/$user_id/diary/` create a new diary for the user, with the following fields:
* title : string
* body : string
* published : datetime string YYYY-MM-DD HH:MM:SS

response is the created post if success.
```javascript
{
  "id": "7",
  "user_id": "1",
  "title": "More Fun",
  "body": "More fun More fun More fun",
  "published": "2016-03-16 01:01:01"
}
```

[`GET /user/$user_id/diary/$diary_id`](http://php-teamio.rhcloud.com/user/1/diary/1) get the particular diary of the user.
```javascript
{
  "id": "1",
  "user_id": "1",
  "title": "First Post",
  "body": "This is the first post for Teamio. Hello, world?",
  "published": "2012-08-18 16:28:10"
}
```

`PUT /user/$user_id/diary/$diary_id` update diary. fields refers to post.
* title : string
* body : string
* published : datetime string YYYY-MM-DD HH:MM:SS (any or all of these) 

success: the updated result
```javascript
{
  "id": "5",
  "user_id": "1",
  "title": "Something like that",
  "body": "Nobody but you",
  "published": "2016-03-16 00:59:31"
}
```
user_id or diary_id error:
```javascript
{
  "error": "wrong user id or diary id"
}
```
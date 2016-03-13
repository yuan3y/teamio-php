<?php

//function log_operation($operation_type) {
//    $query = MySQL::getInstance()->prepare("UPDATE operations SET count=count+1 WHERE type = :operation_type");
//    $query->bindValue(':operation_type', $operation_type, PDO::PARAM_STR);
//    $query->execute();
//}

function get_diaries($user_id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM diaries WHERE user_id=:user_id ORDER BY published DESC");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_users()
{
    $query = MySQL::getInstance()->prepare("SELECT id, email FROM users");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_user_by_email($email)
{
    $query = MySQL::getInstance()->prepare("SELECT id, email FROM users WHERE email=:email");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function get_user_by_id($id)
{
    $query = MySQL::getInstance()->prepare("SELECT id, email, name, birthday FROM users WHERE id=:id");
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function new_user($email, $name, $birthday)
{
    $query = MySQL::getInstance()->prepare("INSERT INTO users (email, name, birthday) VALUES (:email, :name, :birthday)");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':birthday', $birthday, PDO::PARAM_STR);
    $query->execute();
    return get_user_by_id(MySQL::getInstance()->lastInsertId());
}

function update_user($id, $email, $name, $birthday)
{
    $query = MySQL::getInstance()->prepare("UPDATE users SET email = :email, name=:name, birthday=:birthday  WHERE id = :id");
    $query->bindValue(':email', $email, PDO::PARAM_STR);
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':birthday', $birthday, PDO::PARAM_STR);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return get_user_by_id($id);
}


function get_images($user_id)
{
    $query = MySQL::getInstance()->prepare("SELECT id, friend_name, description, filename FROM images WHERE user_id=:user_id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetchall(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($result); ++$i) {
        $result[$i]['filename'] = UPLOADS_PATH . $result[$i]['filename'];
    }
    return $result;
}

function get_image_by_user_id_and_filename($user_id, $filename)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM images WHERE user_id=:user_id AND filename=:filename");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':filename', $filename, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (key_exists('filename', $result)) $result['filename'] = UPLOADS_PATH . $result['filename'];
    return $result;
}

function get_image_by_user_id_and_img_id($user_id, $img_id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM images WHERE user_id=:user_id AND id=:img_id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':img_id', $img_id, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (key_exists('filename', $result)) $result['filename'] = UPLOADS_PATH . $result['filename'];
    return $result;
}

function delete_image($user_id, $img_id)
{
    $query = MySQL::getInstance()->prepare("DELETE FROM images WHERE user_id=:user_id AND id=:img_id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':img_id', $img_id, PDO::PARAM_INT);
    $query->execute();
    return array("success" => ($query->rowCount() > 0), "row_count" => $query->rowCount());
}

function insert_image($user_id, $friend_name, $description = '', $filename)
{
    $query = MySQL::getInstance()->prepare("INSERT INTO images (user_id, friend_name, description, filename) VALUES (:user_id, :friend_name, :description, :filename)");
    $query->bindValue('user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue('friend_name', $friend_name, PDO::PARAM_STR);
    $query->bindValue('description', $description, PDO::PARAM_STR);
    $query->bindValue('filename', $filename, PDO::PARAM_STR);
    $query->execute();
    return get_image_by_user_id_and_filename($user_id, $filename);
}

function update_image($user_id, $img_id, $friend_name, $description = '', $filename)
{
    $query = MySQL::getInstance()->prepare("UPDATE images SET friend_name=:friend_name, description=:description, filename=:filename WHERE user_id=:user_id AND id=:img_id");
    $query->bindValue('user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue('friend_name', $friend_name, PDO::PARAM_STR);
    $query->bindValue('description', $description, PDO::PARAM_STR);
    $query->bindValue('filename', $filename, PDO::PARAM_STR);
    $query->bindValue('img_id', $img_id, PDO::PARAM_INT);
    $query->execute();
    return get_image_by_user_id_and_filename($user_id, $filename);
}

function get_diary_by_user_and_id($user_id, $id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM diaries WHERE user_id=:user_id AND id=:id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}


function update_diary($id, $title, $body, $published, $user_id)
{
    $old_diary = get_diary_by_user_and_id($user_id, $id);
    if (is_null($old_diary)) return null;
    if (!$title) $title = $old_diary['title'];
    if (!$body) $body = $old_diary['body'];
    $query = MySQL::getInstance()->prepare("UPDATE diaries SET title = :title, body=:body, published=:published WHERE id = :id AND user_id=:user_id");
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':body', $body, PDO::PARAM_STR);
    $query->bindValue(':published', $published, PDO::PARAM_STR);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return get_diary_by_user_and_id($user_id, $id);
}


function delete_diary_by_user_and_id($user_id, $id)
{
    $query = MySQL::getInstance()->prepare("DELETE FROM diaries WHERE user_id=:user_id AND id=:id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return array("success" => ($query->rowCount() > 0), "row_count" => $query->rowCount());
}

function new_diary($title, $body, $published, $user_id)
{
    $query = MySQL::getInstance()->prepare("INSERT INTO diaries (title, body, published, user_id) VALUES (:title, :body, :published, :user_id)");
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':body', $body, PDO::PARAM_STR);
    $query->bindValue(':published', $published, PDO::PARAM_STR);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return get_diary_by_user_and_id($user_id, MySQL::getInstance()->lastInsertId());
}


function get_record_by_user($user_id)
{
    $query = MySQL::getInstance()->prepare("SELECT type, SUM(win) AS win_games, sum(total) AS total_games, SUM(win)/sum(total) AS win_ratio FROM records WHERE user_id=:user_id AND win IS NOT NULL GROUP BY type");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function update_record($user_id, $id, $win)
{
    $query = MySQL::getInstance()->prepare("UPDATE records SET win=:win WHERE id=:id AND user_id=:user_id");
    $query->bindValue(':win', $win, PDO::PARAM_INT);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return array("success" => ($query->rowCount() > 0), "row_count" => $query->rowCount());
}

function get_record_by_user_and_id($user_id, $id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM records WHERE user_id=:user_id AND id=:id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_aggregated_record()
{
    $query = MySQL::getInstance()->prepare("SELECT type, SUM(win) AS win_games, sum(total) AS total_games, SUM(win)/sum(total) AS win_ratio FROM records WHERE win IS NOT NULL GROUP BY type");
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function generate_random_games($user_id,$number_of_games=10)
{
    $query = MySQL::getInstance()->prepare("SELECT id, friend_name, description, filename
FROM images
WHERE user_id=:user_id
ORDER BY RAND()
LIMIT :number_of_games
");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':number_of_games', $number_of_games, PDO::PARAM_INT);
    $query->execute();

    $images = $query->fetchAll(PDO::FETCH_ASSOC);
    $result=[];
    $record_query = MySQL::getInstance()->prepare("INSERT INTO records (user_id, type, total) VALUES (:user_id, :type, :total)");
    $record_query ->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $record_query ->bindValue(':type', "FIND_NAME", PDO::PARAM_STR);
    $record_query ->bindValue(':total', 10, PDO::PARAM_INT);
    $record_query -> execute();
    $game_id=MySQL::getInstance()->lastInsertId();
    $result["game_id"]=$game_id;
    $matches=[];
    foreach ($images as $value) {
        $choice_images = get_three_random_images($value['id'],$user_id);
        $choice_images[]=array('filename'=>$value['filename']);
        shuffle($choice_images);

        $correct_answer = get_correct_answer($choice_images, $value['filename']);
        $photo =[];
        foreach ($choice_images as $c) {
            $photo[]=$c['filename'];
        }
        $matches[]= array("name"=>$value['friend_name'],"description"=>$value['description'],"photo"=>$photo,"correct"=>$correct_answer);
        // $choice_images represents the 4 images that are the choices
        // $correct_answer represents the index of the current answer amongst the above 4 choices
        // We now need to construct the json from these
        // I cant seem to get the syntax right

        /*
         * {
	"game_id": 123,
	"matches": [{
		"name": "TanOne",
		"photo": ["https:\/\/serveraddress\/images\/image1.jpg",
		"https:\/\/serveraddress\/images\/image2.jpg",
		"https:\/\/serveraddress\/images\/image3.jpg",
		"https:\/\/serveraddress\/images\/image4.jpg"],
		"correct": 0
	},
	{
		"name": "TanTwo",
		"photo": ["https:\/\/serveraddress\/images\/image4.jpg",
		"https:\/\/serveraddress\/images\/image5.jpg",
		"https:\/\/serveraddress\/images\/image6.jpg",
		"https:\/\/serveraddress\/images\/image7.jpg"],
		"correct": 3
	}]
}
         * */
    }
    $result["matches"]=$matches;
    return $result;
}

function get_three_random_images($exclude_image_id, $user_id) {
    $query = MySQL::getInstance()->prepare("SELECT filename
FROM images
WHERE id<>:id AND user_id=:user_id
ORDER BY RAND()
LIMIT 3
");
    $query->bindValue(':id', $exclude_image_id, PDO::PARAM_INT);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();

    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_correct_answer($choice_images, $correct_file_name) {
    $index = 1;
    foreach ($choice_images as $image) {
        if ($image['filename'] == $correct_file_name) {
            return $index;
        } else {
            $index = $index + 1;
        }
    }
}

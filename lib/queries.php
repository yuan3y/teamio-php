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

function get_diary_by_user_and_id($user_id,$id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM diaries WHERE user_id=:user_id AND id=:id");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}


function update_diary($id, $title, $body, $published, $user_id)
{
    $old_diary=get_diary_by_user_and_id($user_id,$id);
    if (is_null($old_diary)) return null;
    if (!$title) $title=$old_diary['title'];
    if (!$body) $body=$old_diary['body'];
    $query = MySQL::getInstance()->prepare("UPDATE diaries SET title = :title, body=:body, published=:published WHERE id = :id AND user_id=:user_id");
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':body', $body, PDO::PARAM_STR);
    $query->bindValue(':published', $published, PDO::PARAM_STR);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    $query->execute();
    return get_diary_by_user_and_id($user_id,$id);
}


function delete_diary_by_user_and_id($user_id,$id)
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
    $query = MySQL::getInstance()->prepare("SELECT type, SUM(win) as win_games, sum(total) as total_games, SUM(win)/sum(total) as win_ratio FROM records where user_id=:user_id and win is not null GROUP BY type");
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function update_record($user_id, $id, $win)
{
    $query = MySQL::getInstance()->prepare("UPDATE records SET win=:win WHERE id=:id AND $user_id=:user_id");
    $query->bindValue(':win', $win, PDO::PARAM_INT);
    $query->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $query->bindValue(':id', $id, PDO::PARAM_INT);
    return array("success" => ($query->rowCount() > 0), "row_count" => $query->rowCount());
}
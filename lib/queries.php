<?php

//function log_operation($operation_type) {
//    $query = MySQL::getInstance()->prepare("UPDATE operations SET count=count+1 WHERE type = :operation_type");
//    $query->bindValue(':operation_type', $operation_type, PDO::PARAM_STR);
//    $query->execute();
//}

function get_diaries()
{
    $query = MySQL::getInstance()->query("SELECT * FROM diaries ORDER BY published DESC");
//    return $query->fetchAll();
//    $query = MySQL::getInstance()->prepare("SELECT * FROM diaries ORDER BY published DESC");
//    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function get_diary_by_slug($slug)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM diaries WHERE slug=:slug");
    $query->bindValue(':slug', $slug, PDO::PARAM_STR);
    $query->execute();
    return $query->fetch(PDO::FETCH_ASSOC);
}

function delete_diary_by_slug($slug)
{
    $query = MySQL::getInstance()->prepare("DELETE FROM diaries WHERE slug=:slug");
    $query->bindValue(':slug', $slug, PDO::PARAM_STR);
    $query->execute();
    return;
}

function get_diary_comments($diary_id)
{
    $query = MySQL::getInstance()->prepare("SELECT * FROM comments WHERE diary_id=:diary_id ORDER BY posted ASC");
    $query->bindValue(':diary_id', $diary_id, PDO::PARAM_INT);
    $query->execute();
    return $query->fetchAll(PDO::FETCH_ASSOC);
}

function save_comment($diary_id, $name, $body)
{
    $query = MySQL::getInstance()->prepare("INSERT INTO comments (diary_id, name, body) VALUES (:diary_id, :name, :body)");
    $query->bindValue(':diary_id', $diary_id, PDO::PARAM_INT);
    $query->bindValue(':name', $name, PDO::PARAM_STR);
    $query->bindValue(':body', $body, PDO::PARAM_STR);
    $query->execute();
}

function new_diary($title, $body, $published, $slug = '')
{
    if ($slug == '')
        $slug = _slugify($title);
    else $slug = _slugify($slug);
    $pre_query = MySQL::getInstance()->prepare("SELECT COUNT(*) FROM diaries WHERE `slug` LIKE :slug");
    $pre_query->bindValue(':slug', $slug . '%');
    $pre_query->execute();
    $n_slug = (int)($pre_query->fetchColumn());
    if ($n_slug > 0) $slug = $slug . (string)($n_slug + 1);
    $query = MySQL::getInstance()->prepare("INSERT INTO diaries (title, body, slug, published) VALUES (:title, :body, :slug, :published)");
    $query->bindValue(':title', $title, PDO::PARAM_STR);
    $query->bindValue(':body', $body, PDO::PARAM_STR);
    $query->bindValue(':slug', $slug, PDO::PARAM_STR);
    $query->bindValue(':published', $published, PDO::PARAM_STR);
    $query->execute();

}
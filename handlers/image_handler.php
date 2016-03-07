<?php

class imageHandler
{
    function get($user_id, $img_id)
    {
        $this->get_xhr($user_id, $img_id);
    }

    function get_xhr($user_id, $img_id)
    {
        $images = get_image_by_user_id_and_img_id($user_id, $img_id);
        _response($images);
    }

    function put($user_id, $img_id)
    {
        $this->put_xhr($user_id, $img_id);
    }

    function put_xhr($user_id, $img_id)
    {
        $params = _parsePut();
        $images = get_image_by_user_id_and_img_id($user_id, $img_id);
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $extensions = array(IMAGETYPE_PNG => ".png", IMAGETYPE_JPEG => ".jpg", IMAGETYPE_GIF => ".gif");
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . UPLOADS_PATH;
        $result = array();
        if (key_exists("picture", $_FILES) && $_FILES["picture"]["error"] == UPLOAD_ERR_OK && in_array(exif_imagetype($_FILES['picture']['tmp_name']), $allowedTypes)) {
            #http://stackoverflow.com/questions/6755192/uploaded-file-type-check-by-php
            $name = hash_file('CRC32', $_FILES["picture"]["tmp_name"], FALSE) . $extensions[exif_imagetype($_FILES['picture']['tmp_name'])];
            move_uploaded_file($_FILES["picture"]["tmp_name"], $uploads_dir.$name);
        } else {
            $name = $images['filename'];
        }
        $result[] = update_image($user_id, $img_id, $params['friend_name'], $params['description'], $name);
        _response($result);
    }

    function delete($user_id, $img_id)
    {
        $this->delete_xhr($user_id, $img_id);
    }

    function delete_xhr($user_id, $img_id)
    {
        $result = delete_image($user_id, $img_id);
        _response($result);
    }
}
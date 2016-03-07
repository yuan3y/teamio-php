<?php

class imagesHandler
{
    function get($user_id)
    {
        $this->get_xhr($user_id);
    }

    function post($user_id)
    {
        $this->post_xhr($user_id);
    }

    function get_xhr($user_id)
    {
        $images = get_images($user_id);
        _response($images);
    }

    function post_xhr($user_id)
    {
        $params = _set_default();
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF);
        $extensions = array(IMAGETYPE_PNG => ".png", IMAGETYPE_JPEG => ".jpg", IMAGETYPE_GIF => ".gif");
        $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . UPLOADS_PATH;
        $result = array();
        foreach ($_FILES["pictures"]["error"] as $key => $error) {
            #http://php.net/manual/en/function.move-uploaded-file.php
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["pictures"]["tmp_name"][$key];
                $detectedType = exif_imagetype($_FILES['pictures']['tmp_name'][$key]);
                $error = !in_array($detectedType, $allowedTypes);
                #http://stackoverflow.com/questions/6755192/uploaded-file-type-check-by-php
                if ($error) continue;
                $name = hash_file('CRC32', $tmp_name, FALSE) . $extensions[$detectedType];
                move_uploaded_file($tmp_name, $uploads_dir . $name);
                $result[] = insert_image($user_id, $params['friend_names'][$key], $params['descriptions'][$key], $name);
            }
        }
        _response($result);
    }
}
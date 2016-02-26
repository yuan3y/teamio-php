<?php

class imageHandler
{
    function get($user_id, $img_id){
        $this->get_xhr($user_id,$img_id);
    }

    function get_xhr($user_id, $img_id)
    {
        $images = get_image_by_user_id_and_img_id($user_id, $img_id);
        _response($images);
    }
}
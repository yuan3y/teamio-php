<?php

class diariesHandler
{
    function get($user_id)
    {
        $diaries = get_diaries($user_id);
        include($_SERVER["DOCUMENT_ROOT"] . "/views/diaries.php");
    }

    function get_xhr($user_id)
    {
        $diaries = get_diaries();
//        include( $_SERVER["DOCUMENT_ROOT"] . "/views/diaries.php");
        _response($diaries);
    }

    function post_xhr($user_id)
    {
//        echo json_encode($_POST);
        $params = _set_default('title', 'slug', 'body', 'published');
        new_diary($params['title'], $params['body'], $params['published'], $params['slug'], $user_id);
    }
}
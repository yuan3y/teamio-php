<?php

class diariesHandler
{
    function get($user_id)
    {
        $this->get_xhr($user_id);
    }

    function get_xhr($user_id)
    {
        $diaries = get_diaries($user_id);
        _response($diaries);
    }

    function post($user_id){
        $this->post_xhr($user_id);
    }

    function post_xhr($user_id)
    {
        $params = _set_default('title', 'slug', 'body', 'published');
        new_diary($params['title'], $params['body'], $params['published'], $user_id);
    }
}
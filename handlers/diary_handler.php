<?php

class diaryHandler
{
    function get($user_id,$id)
    {
        $this->get_xhr($user_id,$id);
    }

    function get_xhr($user_id,$id)
    {
        $diary = get_diary_by_user_and_id($user_id,$id);
        _response($diary);
    }

    function put_xhr($user_id,$id)
    {
        $params = _parsePut();
        $diary = get_diary_by_user_and_id($user_id,$id);
        if (!($diary)) {
            _response(array("error"=>"wrong user id or diary id"));
            return;
        }
        if (key_exists('title',$params)) $diary['title'] = $params['title'];
        if (key_exists('body',$params)) $diary['body'] = $params['body'];
        if (key_exists('published',$params)) $diary['published'] = $params['published'];
        _response(update_diary($id,$diary['title'],$diary['body'],$diary['published'],$user_id));
    }

    function delete_xhr($user_id,$id)
    {
        delete_diary_by_user_and_id($user_id,$id);
    }
}
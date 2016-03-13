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

    function delete_xhr($user_id,$id)
    {
        delete_diary_by_user_and_id($user_id,$id);
    }
}
<?php

class RecordHandler
{
    function get($user_id,$id)
    {
        $this->get_xhr($user_id,$id);
    }

    function get_xhr($user_id,$id)
    {
        $record = get_record_by_user_and_id($user_id,$id);
        _response($record);
    }

    function put($user_id,$id)
    {
        $this->put_xhr($user_id,$id);
    }

    function put_xhr($user_id,$id)
    {
        $params = _parsePut();
        _response(update_record($user_id,$id,$params['win']));
    }

    function post($user_id,$id)
    {
        $this->post_xhr($user_id,$id);
    }

    function post_xhr($user_id,$id)
    {
        $params = _set_default();
        _response(update_record($user_id,$id,$params['win']));
    }
}
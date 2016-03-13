<?php

class RecordsHandler
{
    function get($user_id)
    {
        $this->get_xhr($user_id);
    }

    function get_xhr($user_id)
    {
        $records = get_record_by_user($user_id);
        _response($records);
    }
}
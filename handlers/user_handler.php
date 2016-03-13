<?php

class userHandler
{
    function get($id)
    {
        $this->get_xhr($id);
    }

    function get_xhr($id)
    {
        $users = get_user_by_id($id);
        _response($users);
    }

    function put($id)
    {
        $this->put_xhr($id);
    }

    function put_xhr($id)
    {
        $params = _parsePut();
        update_user($id, $params['email'], $params['name'], $params['birthday']);
    }
}
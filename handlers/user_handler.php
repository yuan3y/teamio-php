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
        $params = _set_default();
        $params = array_merge(get_user_by_id($id), $params);
        _response(update_user($id, $params['email'], $params['name'], $params['birthday'], $params['password'], $params['gender'], $params['type']));
    }

    function post($id)
    {
        $this->put($id);
    }

    function post_xhr($id)
    {
        $this->put_xhr($id);
    }
}
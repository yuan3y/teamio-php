<?php

class usersHandler
{
    function get()
    {
        $this->get_xhr();
    }

    function get_xhr()
    {
        $users = get_users();
        _response($users);
    }

    function post()
    {
        $this->post_xhr();
    }

    function post_xhr()
    {
        $params = _set_default();
        _response(new_user($params['email'], $params['name'], $params['birthday'], $params['password'], $params['gender'], $params['type']));
    }
}
<?php

class verifyHandler
{
    function post()
    {
        $this->post_xhr();
    }

    function post_xhr()
    {
        $params = _set_default('email','password');
        _response(verify_email_password($params['email'], $params['password']));
    }
}
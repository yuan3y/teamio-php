<?php

class GameHandler
{
    function get($type,$user_id)
    {
        $this->get_xhr($type,$user_id);
    }

    function get_xhr($type,$user_id)
    {
        $games = generate_random_games($user_id);
        _response($games);
    }

}
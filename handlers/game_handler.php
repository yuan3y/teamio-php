<?php

class GameHandler
{
    function get($type, $user_id)
    {
        $this->get_xhr($type, $user_id);
    }

    function get_xhr($type, $user_id)
    {
        $images = generate_random_games($user_id);
        $game_id = new_game($user_id, $type);
        $game = gen_game($user_id, $game_id, $images, $type);
        _response($game);
    }

}
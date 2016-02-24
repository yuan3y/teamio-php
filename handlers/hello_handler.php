<?php

class HelloHandler
{
    function get()
    {
        echo "Hello, world";
    }

    function get_xhr()
    {
        _response("Hello, world, xhr");
    }
}

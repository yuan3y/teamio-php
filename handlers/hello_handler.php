<?php

class HelloHandler
{
    function get()
    {
        echo (new Parsedown)->text(file_get_contents('README.md'));
    }

    function get_xhr()
    {
        _response("Hello, world, xhr");
    }
}

<?php

foreach (glob("handlers/*_handler.php") as $filename) {
    require $filename;
}
require("lib/markdown.php");
require("lib/mysql.php");
require("lib/queries.php");
require("lib/toro.php");
require("lib/base.php");

ToroHook::add("404", function () {
    echo "Not found";
});

Toro::serve(array(
    "/diary/" => "diariesHandler",
    "/diary/:alpha" => "diaryHandler",
    "/diary/:alpha/comment" => "CommentHandler",
    "/hello/" => "HelloHandler",
    "/" => "HelloHandler",
    "/user/:number/image/" => "ImagesHandler",
    /* Naming Convention
     * To make our life easier, we'll use only singular terms in URL,
     * For Handlers' names, use singular or plural corresponding to the usage
     * Happy coding :) */
));

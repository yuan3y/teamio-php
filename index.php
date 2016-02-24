<?php

foreach (glob("handlers/*_handler.php") as $filename) {
    require $filename;
}
//require("handlers/diary_handler.php");
//require("handlers/diaries_handler.php");
//require("handlers/comment_handler.php");
//require("handlers/hello_handler.php");
require("lib/markdown.php");
require("lib/mysql.php");
require("lib/queries.php");
require("lib/toro.php");
require("lib/base.php");

ToroHook::add("404", function () {
    echo "Not found";
});

Toro::serve(array(
    "/diaries/" => "diariesHandler",
    "/diary/:alpha" => "diaryHandler",
    "/diary/:alpha/comment" => "CommentHandler",
    "/hello/" => "HelloHandler",
    "/" => "HelloHandler",
));

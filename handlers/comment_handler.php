<?php

class CommentHandler
{
    function post($slug)
    {
        $diary = get_diary_by_slug($slug);
        if (isset($_POST['name']) && isset($_POST['body']) &&
            strlen(trim($_POST['name'])) > 0 && strlen(trim($_POST['body'])) > 0
        ) {
            save_comment($diary['id'], trim($_POST['name']), trim($_POST['body']));
        }
        header("Location: /diary/$slug");
    }
}
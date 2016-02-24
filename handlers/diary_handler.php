<?php

class diaryHandler
{
    function get($slug)
    {
        $diary = get_diary_by_slug($slug);
        $comments = get_diary_comments($diary['id']);
        include($_SERVER["DOCUMENT_ROOT"] . "/views/diary.php");
    }

    function get_xhr($slug)
    {
        $diary = get_diary_by_slug($slug);
        $comments = get_diary_comments($diary['id']);
        _response($diary);
    }

    function delete_xhr($slug)
    {
        delete_diary_by_slug($slug);
    }
}
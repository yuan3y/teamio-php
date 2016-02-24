<h1>cms</h1>
<? include("_diary.php"); ?>

<h3>Comments (<?php echo count($comments); ?>)</h3>
<?php
foreach ($comments as $comment) {
    include("_comment.php");
}
?>

<h4>Add Comment</h4>
<form method="post" action="/diary/<?php echo $diary['slug']; ?>/comment">
    <strong>Name:</strong><br/>
    <input type="text" name="name"/><br/>
    <strong>Message:</strong><br/>
    <textarea name="body"></textarea><br/>
    <input type="submit"/>
</form>
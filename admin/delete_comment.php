<?php

require_once('../admin_header.php');
if(!$session->is_logged_in()){
    redirect("login.php");
}


if(!$session->is_logged_in()){
    redirect("login.php");
}
$sp = urlencode($_GET['id']);
$pp = urlencode($_GET['post']);
print_r($_GET);

$comment = new Comment();
$comment->id =$sp;
if($comment->remove()){
    $session->message("Comment Deleted Succesfully");
    redirect("comments.php?page=$pp");
}else{
    $session->message("Comment Not Deleted");
    redirect("comments.php");
}




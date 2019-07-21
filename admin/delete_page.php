<?php
require_once("../admin_header.php");
if(!$session->is_logged_in()){
    redirect("login.php");
}
	$sp = urlencode($_GET['page']);
	$post->id =  $sp;
	if($post->remove()){
		$session->message("Page Deleted Successfully");
		redirect("content.php");
	}else{
		$session->message("Page Not Deleted");
		redirect("content.php");
	}
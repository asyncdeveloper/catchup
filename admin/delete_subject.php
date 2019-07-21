<?php

require_once('../admin_header.php');                                            

$subjectx->find_selected_subject();
if(!$session->is_logged_in()){
    redirect("login.php");
}
	
	$ss = urlencode($sel_subject['id']);
	$subjectx->subject_id =  $ss;
	if($subjectx->remove()){
		$session->message("Subject Deleted Successfully");
		redirect("content.php");
	}else{
		$session->message("Subject Not Deleted");
		redirect("content.php");
	}	

   ?>	


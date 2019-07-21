<?php
  
require_once('../admin_header.php');

  
if(!$session->is_logged_in()){
    redirect("login.php");
}
  $session->logout();
  redirect("index.php");  


<?php
require_once('../includes/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');
try{
	$response = FroalaEditor_Image::delete($_POST['src']);
	echo stripslashes(json_encode('Success'));
}catch(Exception $e){
	http_response_code(404);
}


 
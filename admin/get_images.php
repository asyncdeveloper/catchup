<?php
require_once('../includes/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');
$b = dirname($_SERVER['PHP_SELF']);
 try{
	$response = FroalaEditor_Image::getList("$b/uploads/");
	echo stripslashes(json_encode($response));
}catch(Exception $e){
	http_response_code(404);
}

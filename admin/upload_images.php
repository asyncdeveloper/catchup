<?php
$b = dirname($_SERVER['PHP_SELF']);

require_once('../includes/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');

// Get filename.h
$temp = explode(".", $_FILES["file"]["name"]);

// Get extension.
$extension = end($temp);

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES["file"]["tmp_name"]);

    // Generate new random name.
    $name = sha1(microtime()) . "." . $extension;

    // Save file in the uploads folder.
    move_uploaded_file($_FILES["file"]["tmp_name"], getcwd() . "/uploads/" . $name);

    // Generate response.
    $response = new StdClass;   
	$response->link = "https://catchupng.000webhostapp.com$b/uploads/" . $name;
	echo stripslashes(json_encode($response));
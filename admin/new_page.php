<?php

require_once('../admin_header.php');


if(!$session->is_logged_in()){
    redirect("login.php");
}
if (isset($_POST['submit'])){
  // Grab the data from the POST
	$author = 	 $database->mysql_prep($_POST['author']);
    $page_name = $database->mysql_prep($_POST['page_name']);
    $subject  = $database->mysql_prep($_POST['subject']);
    $visible  = $database->mysql_prep($_POST['visible']);
	$content  = $_POST['content'];
    $date_created =date('Y-m-d H:i:s',time());
	//Set Values
	$post->author = $author;
	$post->page_name = $page_name;
    $post->subject_id = $subject;
	$post->visible = $visible;
    $post->content = $content;
    $post->date_created =$date_created;


    if($post->save()){
		$session->message("Page Created Successfully");
		redirect("content.php");
	}else{
		$session->message("Page Not Created");
		redirect("content.php");
	}
}
  
?>

<body>

<link rel="stylesheet" href="../js/froala_editor_2.4.2/css/froala_style.min.css" type="text/css" />
<link rel="stylesheet" href="../js/froala_editor_2.4.2/css/froala_editor.pkgd.min.css" type="text/css" />
<link rel="stylesheet" href="<?php echo $b ;?>/css/signup-form.css" type="text/css" />
	<div class="container">
		<div class="signup-form-container">
			 <!-- form start -->
			<div id="signup">
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" role="form" id="register-form" autocomplete="off" >
				<div class="form-header">
					<h3 class="form-title"><span class="glyphicon glyphicon-plus"></span> Add Page</h3>
								  

							  
				</div>
						  
				<div class="form-body">
					
					<div class="form-group">
					   <div class="input-group">
					   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					   <input name="author" type="text" required="required" class="form-control" placeholder="Author">
					   </div>
					   
					</div>												
					
					<div class="form-group">
					   <div class="input-group">
					   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					   <input name="page_name" required="required" type="text" class="form-control" placeholder="Page Name">
					   </div>
					   
					</div>
					
					<div class="form-group">
					   <div class="input-group">
							<div class="input-group-addon"><span>Subject</span></div>
							   <select name="subject" class="form-control">
								   <?php $subjectx->get_all_subject_name() ?>
							   </select>
					   </div> 
					</div>
											
					
					<div class="radio">
						<div class="input-group-addon"><span>Visible</span>
						<label class="checkbox-inline">
							<input type="radio" name="visible" id="radio" value="1" checked>Yes
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="visible" id="radio" value="0" > No
						</label>
						</div>
						
                                                <div class="form-group">						
						<center><label for="name">Text Area</label></center>
						<textarea  required="required" name="content" class="form-control" autocomplete="off" >
						
						</textarea>
					
				    </div>
								
										  
					</div>
					<div class="form-footer">
						<center>
							<button name="submit" id="submit" type="submit" class="btn btn-info" id="btn-signup">
							<span class="glyphicon glyphicon-log-in"></span> Add New Page !
							</button>
						</center>	
					</div>
						 
				</div>
					

					

				</form>
				
			</div>
			
		</div>
		
	    <div class="alert alert-info">
			<a href="index.php" target="_blank">Go to Homepage.</a>
	    </div>

	</div>

    <script src="../js/froala_editor_2.4.2/js/froala_editor.pkgd.min.js" > </script>
    <script src="../js/froala_editor_2.4.2/js/plugins/image.min.js" > </script>
    <script src="../js/froala_editor_2.4.2/js/plugins/image_manager.min.js" > </script>
    <script>

        $(function() {
            $('textarea').froalaEditor({
              height: 400,
               //Image Manager
                imageManagerLoadURL: 'get_images.php',

                //Delete Image Manager
                imageManagerDeleteURL: 'delete_images.php',

                // Set the image upload URL.
                imageUploadURL: 'upload_images.php'

            });

        });
    </script>
</body>	
 <?php
require_once('../footer.php');	
?>
<?php
require_once('../admin_header.php');
require_once('../includes/wysiwyg-editor-php-sdk-master/lib/FroalaEditor.php');

if(!$session->is_logged_in()){
    redirect("login.php");
}
$post-> find_selected_page();
$sp = urlencode($sel_page['id']);

$cur_vis = urlencode($sel_page['visible']);


 if(isset($_POST['submit'])){
     // Grab the data from the POST
  
	$page_id	= 	$sp;//selected page id
    $author		= 	$_POST['author'];
    $page 		= 	$_POST['page_name'];
    $subject    =   $_POST['subject'];	
    $visible  	=   $_POST['visible'];
	$content	=   $_POST['content'];
		
	//Set Values
	$post->id = $page_id;
	$post->author = $author;
	$post->page_name = $page;
    $post->subject_id = $subject;
	$post->visible = $visible;
    $post->content = $content;
   
   	
    if($post->save()){		
		$session->message("Page Updated Successfully");
		redirect("content.php");
	}else{
		$session->message("Page Not Updated");
		redirect("content.php");
	}  
   	
}

?>


<body>

<link rel="stylesheet" href="../js/froala_editor_2.4.2/css/froala_style.min.css" type="text/css" />
<link rel="stylesheet" href="../js/froala_editor_2.4.2/css/froala_editor.pkgd.min.css" type="text/css" />

<link rel="stylesheet" href="<?php echo $b ;?>/css/signup-form.css" type="text/css" />
	<div class="container">
        <div class="row">
             <div class="signup-form-container col lg-6">
			 <!-- form start -->
			<div id="signup">
				<form method="post" action="<?php echo htmlentities("edit_page.php?page=$sp"); ?>" role="form" id="register-form" autocomplete="off" >
				<div class="form-header">
					<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-plus"></span>
					Edit Page :  <?php echo $sel_page['page_name']; ?>
					</h3>

					<div class="pull-right">
						 <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
					</div>

				</div>

				<div class="form-body">

					<div class="form-group">
					   <div class="input-group">
					   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					   <input name="author" type="text" value="<?php  echo $sel_page['author'];?>" class="form-control" placeholder="Author">
					   </div>

					</div>

					<div class="form-group">
					   <div class="input-group">
					   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					   <input name="page_name" type="text" value="<?php  echo $sel_page['page_name'];?>" class="form-control" placeholder="Page Name">
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
							<input type="radio" name="visible" id="radio" value="1"
								<?php if($cur_vis == 1)echo " checked" ?>
							/>Yes
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="visible" id="radio" value="0"
								<?php if($cur_vis == 0)echo " checked" ?>
							/> No
						</label>
						
						
						</div>

						
						
						 <div class="form-group">
               
						<textarea  name="content" class="form-control contents" autocomplete="off"  cols="30" rows="10">						
							<?php 	 echo htmlentities($sel_page['content']) ;   ?>"
						</textarea>

							
						</div>

						
					</div>


						<div class="form-footer">
						<center>
							<a href="<?php echo "edit_page.php?page=$sp" ; ?>">
							<button name="submit" id="submit" type="submit" class="btn btn-info" id="btn-signup">
							<span class="glyphicon glyphicon-log-in"></span> Edit Page !
							</button>
						</center>
					</div>

				</div>

				</form>


				<div class="form-footer">
					<center>
						<a href="<?php echo "delete_page.php?page=$sp" ; ?>"><button name="delete" type="submit" class="btn btn-info" id="btn-signup">
						<span class="glyphicon glyphicon-log-in"></span>Delete Page
						</button></a>
					
					
					
						<a href="content.php">
						<button name="cancel" type="submit" class="btn btn-info" id="btn-signup">
						<span class="glyphicon glyphicon-log-in"></span>Cancel
						</button></a>
					
					</center>

				</div>


			</div>
           
			</div>


           

        </div>
		
		
		<div class="alert alert-info">
		
			<a href="index.php">Go to Homepage.</a>

		</div>
		
    </div>

</div>


 
 <script src="../js/froala_editor_2.4.2/js/froala_editor.pkgd.min.js" > </script>
 <script src="../js/froala_editor_2.4.2/js/plugins/image.min.js" > </script>
 <script src="../js/froala_editor_2.4.2/js/plugins/image_manager.min.js" > </script>
 <script>

  $(function() {
    $('textarea').froalaEditor({
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
require_once(LIB_PATH.DS.'footer.php');
?>


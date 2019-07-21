<?php
require_once('../admin_header.php');

if(!$session->is_logged_in()){
    redirect("login.php");
}



if (isset($_POST['submit'])){
  // Grab the data from the POST
    $subject = $_POST['subject_name'];
    $visible  =  $_POST['visible'];
    $position =  $_POST['position'];
    $subjectx->subject_name = $subject;
    $subjectx->visible = $visible;
    $subjectx->position = $position;
    if($subjectx->save()){		
		$session->message("Subject Created Successfully");
		redirect("content.php");
	}else{
		$session->message("Subject Not Created");
		redirect("content.php");
	}
}
  
?>  
<body>
	<link rel="stylesheet" href="<?php echo $b ;?>/css/signup-form.css" type="text/css" />
	<div class="container">
		<div class="signup-form-container">
			 <!-- form start -->
			<div id="signup">
				<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" role="form" id="register-form" autocomplete="off" >
				<div class="form-header">
					<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-plus"></span> Add Subject</h3>
								  
					<div class="pull-right">
						 <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
					</div>
							  
				</div>
						  
				<div class="form-body">
					<div class="form-group">
					   <div class="input-group">
					   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
					   <input name="subject_name" type="text" class="form-control"  placeholder="Subject Name">
					   </div>
					   
					</div>
											
					<div class="form-group">
					   <div class="input-group">
							<div class="input-group-addon"><span>Position</span></div>
							   <select name="position" class="form-control  span">">
								   <?php $subjectx->get_position(null) ?>
							   </select>
					   
					   
					   </div> 
					</div>
					
					
					<div class="radio">
						<label for="name">   Visible </label>   					
						
						<label class="checkbox-inline">
							<input type="radio" name="visible" id="radio" value="1" checked>Yes
						</label>
						<label class="checkbox-inline">
							<input type="radio" name="visible" id="radio" value="0" > No
						</label>		
										  
					</div>
							   
					<div class="form-footer">
					
						<button name="submit" id="submit" type="submit" class="btn btn-info" id="btn-signup">
						<span class="glyphicon glyphicon-log-in"></span> Add New Subject !
						</button>
						<button type="button" class="btn btn-info" id="btn-signup">Cancel
						</button>
						
					
					</div>
						 
				</div>
					
				</form>
				
			</div>
			
		</div>
		
	    <div class="alert alert-info">
			<a href="index.php" target="_blank">Go to Homepage.</a>
	    </div>

	</div>
 <?php
require_once('../footer.php');	
?> 
						  
					
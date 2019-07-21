<?php

require_once('../admin_header.php');


if(!$session->is_logged_in()){
    redirect("login.php");
}

$subjectx->find_selected_subject();
if(intval($_GET['subj']) == 0  || $sel_subject['id']== "") {
	redirect("content.php");
}

$cur_pos = urlencode($sel_subject['position']);
$cur_vis = urlencode($sel_subject['visible']);
$ss = urlencode($sel_subject['id']);	
if (isset($_POST['submit'])){
  // Grab the data from the POST
    $subject = $_POST['subject_name'];
    $visible  =  $_POST['visible'];
    $position =  $_POST['position'];
    $subjectx->subject_id = $_GET['subj'];
    $subjectx->subject_name = $subject;
    $subjectx->visible = $visible;
    $subjectx->position = $position;
	
   if($subjectx->save()){
		$session->message("Subject Updated Successfully");
		redirect("content.php");
	}else{
		$session->message("Subject Not Updated");
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
		
				<form method="post" action="<?php echo htmlentities("edit_subject.php?subj=$ss"); ?> " role="form" id="register-form" autocomplete="off">
						<div class="form-header">
							<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> 
								Edit Subject : <?php echo $sel_subject['subject_name']; ?>
								
							</h3>  
										  
							<div class="pull-right">
								 <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
							</div>
							  
						</div>
						  
					<div class="form-body">
					 
								<div class="form-group">
								   <div class="input-group">
								   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
								   <input name="subject_name" type="text" class="form-control" value="<?php  echo $sel_subject['subject_name'];?>" placeholder="Subject Name">
								   </div>
								   
								</div>
										
								<div class="form-group">
								   <div class="input-group">
										<div class="input-group-addon"><span>Position</span></div>
										   <select name="position" class="form-control">
											   <?php 
											   $subjectx->get_position($cur_pos);

											   ?>
										   </select>
								   </div> 
								</div>
							
								<div class="radio">
									<label for="name">   Visible </label>   					
									
									<label class="checkbox-inline">
										<input type="radio" name="visible" id="radio" value="1" 
										<?php if($cur_vis == 1)echo " checked" ?>	/> Yes
									</label>
									<label class="checkbox-inline">
										<input type="radio" name="visible" id="radio" value="0" 
										<?php if($cur_vis == 0)echo " checked" ?> /> No
									</label>		
													  
								</div>

								<div class="form-footer">
                                    <center>
									<button name="submit" type="submit" class="btn btn-info" id="btn-signup">
									<span class="glyphicon glyphicon-log-in"></span> Edit Subject
									</button>
                                    </center>
								</div>
								
					</div>	
					
				</form>	
				
				
				<div class="form-footer">
                    <center>
					<a href="<?php echo "delete_subject.php?subj=$ss" ; ?>"><button name="cancel" type="submit" class="btn btn-info" id="btn-signup">
					<span class="glyphicon glyphicon-log-in"></span>Delete Subject
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
	         
    
<?php
require_once(LIB_PATH.DS.'footer.php');	
?>
							  
					
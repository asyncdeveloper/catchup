<?php
require_once('../admin_header.php');


$username_error;
$email_error;
$number_error;
$password_error;
$network_error;
if (isset($_POST['submit'])){
    
    // Grab the data from the POST
    $username = $database->mysql_prep($_POST['username']);
    $email  =   $database->mysql_prep($_POST['email']);
    $number =   $database->mysql_prep($_POST['number']);
    $password = $database->mysql_prep($_POST['password']);
    $cpassword= $database->mysql_prep($_POST['cpassword']);
    $network =  $database->mysql_prep($_POST['radio']);   	
    $user = new User();
	//Validate Data
    if($user->validate_username($username))	 $user->username  = $username;
	if($user->validate_email($email)) 		$user->email 	 = $email;
	if($user->validate_number($number)) 	$user->number	 = $number;
	if($user->validate_password($password,$cpassword))  $user->password  = sha1($password);
	if($user->validate_radio($network))   $user->network   = $network;
	//If no error that is we can register user
	
	if (!isset($username_error) && !isset($email_error) && !isset($number_error) && !isset($password_error) &&!isset($network_error)){
	    //If no errors insert
        $user->save();
        echo "Registration Succesfull";
        redirect("login.php");
	}

}    
    

?>
    <body>	
    
	<link rel="stylesheet" href="../../css/signup-form.css" type="text/css" />
	<div class="container">
		<div class="signup-form-container">
			 <!-- form start -->
			 <div id="signup">
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" role="form" id="register-form" autocomplete="off" >
			<div class="form-header">
					<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Sign Up</h3>
							  
				<div class="pull-right">
					 <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
				</div>
						  
			</div>
					  
			<div class="form-body">
         
				<div class="form-group">
                   <div class="input-group">
                   <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                   <input name="username" type="text" class="form-control" value="<?php if(isset($username)) echo htmlentities($username)?>" placeholder="Username">
                   </div>
                   <span class="help-block" id="error"> * <?php  if (isset($username_error) && ($username_error!= 1)) echo $username_error;  ?></span>
				</div>
                        
				<div class="form-group">
                   <div class="input-group">
                   <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                   <input name="email" id="email" type="text" class="form-control" value="<?php if(isset($email)) echo htmlentities($email) ?>" placeholder="Email">
                   </div> 
                   <span class="help-block" id="error"> * <?php if (isset($email_error)&&($email_error!= 1)) echo htmlentities($email_error);   ?></span>                     
				</div>
				<div class="form-group">
                   <div class="input-group">
                   <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                   <input  name="number" id="number" type="text" class="form-control"  placeholder="Phone Number"  value="<?php if(isset($number)) echo  htmlentities($number) ?>">
                   </div> 
                   <span class="help-block" id="error">  <?php if (isset($number_error)  &&  ($number_error!= 1)) echo htmlentities($number_error); ?> </span>                     
				</div>
				<div class="radio">
					<label for="name"><b>Kindly Select Your Network Provider </b> </label> <br />					
					<?php
		
						$choices = array('AIRTEL','ETISALAT','GLO', 'MTN');
							foreach ($choices as $choice) {
								echo "<label class=\"checkbox-inline\">";
								echo "<input type='radio'  id='radio' name=\"radio\" value='$choice' checked> $choice";
								echo "</label>";
							}
					
					?>
					
					 <span class="help-block" id="error"> * <?php if (isset($network_error) && ($network_error!= 1)) echo $network_error;   ?></span>                     
				</div>


				<div class="row">
                        
					<div class="form-group col-lg-6">
                        <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="password" id="password" type="password" class="form-control" placeholder="Password" value="<?php if(isset($password)) echo  htmlentities($password) ?>">
                        </div>  
                        <span class="help-block" id="error">* <?php if(isset($password_error) && ($password_error!= 1)) echo  htmlentities($password_error)  ?></span>                    
					</div>
                            
                   <div class="form-group col-lg-6">
                        <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="cpassword" type="password" class="form-control" placeholder="Retype Password" value="">
                        </div>  
                        <span class="help-block" id="error"></span>                    
                   </div>
                            
				</div>
               
				<div class="form-footer">
				
					<button name="submit" id="submit" type="submit" class="btn btn-info" id="btn-signup">
					<span class="glyphicon glyphicon-log-in"></span> Sign Me Up !
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
require_once(LIB_PATH.DS.'footer.php');
 ?>


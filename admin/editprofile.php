<?php
require_once('../admin_header.php');

if(!$session->is_logged_in()){
    redirect("index.php");
}
	$email_error;
	$number_error;
	$password_error;    
	$cpassword_error;
	$network_error;
if (isset($_POST['submit'])){
    // Grab the data from the POST
	$email  =   mysqli_real_escape_string($dbc, trim($_POST['email']));
	$number =   mysqli_real_escape_string($dbc, trim($_POST['number']));
	$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
    $cpassword= mysqli_real_escape_string($dbc, trim($_POST['cpassword']));
	$network =  mysqli_real_escape_string($dbc, trim($_POST['radio']));
		if(empty($email)){
			if(!preg_match('/^[a-zA-Z0-9][a-zA-Z0-9\._\-&!?=#]*@/',$email)){
				$email_error = "Invalid email format";
			}
		}	
		//check if numbersyntax is valid or not
		if (!preg_match('/^\d{11}/',$number)) {
			$number_error = "Invalid Number";
		}	
		if(strlen($password) < 6){
			$password_error = "Password must be at least 6 characters";
		}		
		if ($password !== $cpassword){ 
			$cpassword_error = "Passwords do not Match";
		}
		if (empty($network)){ 
			$network_error = "You must choose a service provider";
		}
			//check for email address availablity
		if(!$email_error){
			$query = "SELECT * FROM catchup_user WHERE email = '$email'";
			$data = mysqli_query($dbc, $query);
			if (!mysqli_num_rows($data) == 0) {
			  // An account already exists for this email, so display an error message
				$email_error = "An account already exists for this email";
				$email = "";
			}
		}
		//check for phone number availablity
		if(!$number_error){
			$query = "SELECT * FROM catchup_user WHERE number = '$number'";
			$data = mysqli_query($dbc, $query);
			if (!mysqli_num_rows($data) == 0) {
				// An account already exists for this username, so display an error message
				$number_error = "An account already exists for this number";
				$number = "";
			}
		}	
		if (!isset($email_error)){
			$query = "UPDATE catchup_user SET email = '$email' WHERE user_id = '" . $_SESSION['user_id'] . "'" ;    
			mysqli_query($dbc, $query);
			echo '<h4><p>Your Email address has been successfully updated. </p><h4>';
		} 
		if (!isset($number_error)){
			$query = "UPDATE catchup_user SET number = '$number' WHERE user_id = '" . $_SESSION['user_id'] . "'" ;    
			mysqli_query($dbc, $query);
			echo '<h4><p>Your Phone number has been successfully updated. </p><h4>';
		} 
		if (!isset($network_error)){
			$query = "UPDATE catchup_user SET network ='$network' WHERE user_id = '" . $_SESSION['user_id'] . "'" ;    
			mysqli_query($dbc, $query);
			echo '<h4><p>Your network provider has been successfully updated. </p><h4>';
		} 
		if (!isset($password_error) && !isset($cpassword_error)){
			$query = "UPDATE catchup_user SET password= '$cpassword' WHERE user_id = '" . $_SESSION['user_id'] . "'" ;    
			mysqli_query($dbc, $query);
			echo '<h4><p>Your account has been successfully updated. </p><h4>';			
		}
	} 	

?>

<link rel="stylesheet" href="/PhpProject/public/css/signup-form.css" type="text/css" />
<div class="container">
		<div class="update-form-container">
			 <!-- form start -->
			 <div id="update">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form" id="register-form" autocomplete="off">
			<div class="form-header">
					<h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Update Profile</h3>							  
			</div>
					  
			<div class="form-body">
                 
				<div class="form-group">
                   <div class="input-group">
                   <div class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></div>
                   <input name="email" id="email" type="text" class="form-control" value="<?php if(isset($email)) echo $email ?>" placeholder="Email">
                   </div> 
                   <span class="help-block" id="error"> <?php if (isset($email_error)) echo $email_error ?></span>                     
				</div>
				
				<div class="form-group">
                   <div class="input-group">
                   <div class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></div>
                   <input  name="number" id="number" type="text" class="form-control"  placeholder="Phone Number" >
                   </div> 
                   <span class="help-block" id="error"><?php if (isset($number_error)) echo $number_error ?></span>                     
				</div>
				<div class="radio">
					<label for="name"><b>Kindly Select Your Network Provider </b> </label> <br />					
										
					<label class="checkbox-inline">
						<input type="radio" name="radio" id="radio" value="airtel" > AIRTEL
					</label>
					<label class="checkbox-inline">
						<input type="radio" name="radio" id="radio" value="etisalat" > ETISALAT
					</label>
					<label class="checkbox-inline">
						<input type="radio" name="radio" id="radio" value="glo" > GLO
					</label>
					<label class="checkbox-inline">
						<input type="radio" name="radio" id="radio" value="mtn" > MTN
					</label>		
					 <span class="help-block" id="error"> <?php if(isset($network_error)) echo $network_error ?> </span>                     
				</div>


				<div class="row">
                        
					<div class="form-group col-lg-6">
                        <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="password" id="password" type="password" class="form-control" placeholder="Password">
                        </div>  
                        <span class="help-block" id="error"><?php if (isset($password_error)) echo $password_error ?></span>                    
					</div>
                            
                   <div class="form-group col-lg-6">
                        <div class="input-group">
                        <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                        <input name="cpassword" type="password" class="form-control" placeholder="Retype Password">
                        </div>  
                        <span class="help-block" id="error"><?php if (isset($cpassword_error)) echo $cpassword_error ?></span>                    
                   </div>
                            
				</div>
               
				<div class="form-footer">
					<button name="submit" type="submit" class="btn btn-info" id="btn-signup">
					<span class="glyphicon glyphicon-log-in"></span> Update Profile!
					</button>
				</div>
			         
			</div>
				
        </form>
		</div>
			</div>
		
       	
</div>

<?php
require_once (LIB_PATH.DS."footer.php") ;
?>

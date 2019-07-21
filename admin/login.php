<?php
require_once('../admin_header.php');

if($session->is_logged_in()){
    redirect("index.php");
}
if (isset($_POST['submit'])){
    // Grab the user-entered log-in data
    $username = $_POST['username'];
    $password = $_POST['password'];
    $found_user = User::authenticate($username,$password);

    //If User was found
    if($found_user){
        $session->login($found_user);
        redirect("index.php");
    }else{
        $message = "Username/Password Incorrect";
    }
}else{
    $username="";
    $password="";
}


?>
    <html>

   <link rel="stylesheet" href="<?php echo $b ;?>/css/signup-form.css" type="text/css" />
    <div class="container">
        <div class="signup-form-container">
            <div id="signup">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form" id="register-form" autocomplete="off">
                    <div class="form-header">
                        <h3 class="form-title"><i class="fa fa-user"></i><span class="glyphicon glyphicon-user"></span> Log In</h3>

                        <div class="pull-right">
                            <h3 class="form-title"><span class="glyphicon glyphicon-pencil"></span></h3>
                        </div>

                    </div>

                    <div class="form-body">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
                                <input name="username" type="text"  maxlength="40" class="form-control" value="<?php if(isset($username))echo htmlspecialchars($username);  ?>"  placeholder="Username">
                            </div>
                            <span class="help-block" id="error"> </span>

                            <div class="input-group">
                                <div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
                                <input name="password" maxlength="40"  id="password" type="password" class="form-control" placeholder="Password"  value="<?php if(isset($password))echo htmlspecialchars($password); ?>" >
                            </div>
                        </div>
                        <span class="help-block" id="error"> <?php if(isset($message)) echo output_message($message); ?> </span>
                    </div>

            </div>
            <div class="form-footer">
                <button name="submit" type="submit" class="btn btn-info" id="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> Sign In!
                </button>
            </div>

        </div>

        </form>
    </div>

    <html>
<?php
require_once('../footer.php');
?>
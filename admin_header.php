<?php

require_once('includes/initialize.php');
require_once('includes/session.php');
require_once('includes/user.php');


$b = "http://catchup.tk/";


ob_start();
?>

<!DOCTYPE html>
<head>
    <title>Catch-Up</title>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/
		html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/
		respond.min.js"></script>
    <![endif]-->
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://use.fontawesome.com/fc7e71436b.js"></script>
    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <link rel="stylesheet" type="text/css" href="<?php echo $b; ?>css/style.css" />

</head>

    <header id="masthead" class="site-header" role="banner">
		<div class="backdrop">
		<div id="header">

            <div class="navbar navbar-inverse">
                 <div class="container">
                <div class="navbar-header ">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                            </button>
					<a class="navbar-brand" id="sitename" href="#">Catch Up</a>
                </div>

                        <div class="collapse navbar-collapse" id="mynavbar-content">
                                <ul class="nav navbar-nav navbar-right text-center">

                                 <li class="active "><a href="<?php echo $b; ?>admin/" >Home</a></li>
                                        <li><a href="topstories.php">Top Stories</a></li>
                        <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  data-toggle="tab" >
                                                                                Top Leagues
                                                <b class="caret"></b>
                                        </a>
                            <ul class="dropdown-menu">

                                        <?php
                                           $sql= "SELECT * FROM subjects WHERE visible=1 ORDER BY position LIMIT 5";
                                           $subject_set= $database->query($sql);
                                                while($subject = $database->fetch_array($subject_set)){
                                                  echo "<li><a href=\"index.php?subj=".urlencode($subject["id"])."\"> {$subject["subject_name"]} </a></li>";
                                                }
                                          ?>
                            </ul>
				</li>
					
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  data-toggle="tab"> Categories
                                            <b class="caret"></b>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <?php
                                            $sql= "SELECT * FROM subjects WHERE visible=1 ORDER BY position ";
                                            $subject_set= $database->query($sql);
                                            while($subject = $database->fetch_array($subject_set)){
                                                echo "<li><a  href=$b/category/{$subject['id']}/{$subject['friendly_url']} \"> {$subject['subject_name']} </a></li>";
                                            }
                                            ?>
                                        </ul>
                                    </li>

	<li><a href="<?php echo $b ; ?>">Visit Main Site</a></li>

                                    <?php
                                    echo '<ul class="nav navbar-nav navbar-right" id="logout">';
                                    if($session->is_logged_in()){
                                        echo '<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  data-toggle="tab" ><span class="glyphicon glyphicon-user"></span>
                        My Profile
                                        <b class="caret"></b>
                        </a>					
                                <ul class="dropdown-menu">
                                <li><a href="editprofile.php"> Edit-Profile</a></li>
                                <li><a href="logout.php" toggle="tab"> Log-Out(' . $session->username . ')</a></li>
                           </ul>	</li>';
                                    }
                                    else{
                                        echo '<li><a href="login.php"><span class="glyphicon glyphicon-log-in "></span> Log In</a></li>';
                                        echo '<li><a href="signup.php"><span class="glyphicon glyphicon-user "></span> Sign Up</a></li>';
                                    }
                                    echo '</ul>';

                                    ?>
                                </ul>


</div>
                 </div>
	</div>
	</div>
</div>
</header>
<?php
require_once('includes/initialize.php');
$b = "https://catchup.tk";
$a = "https://catchupng.000webhostapp.com/";
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

    <link rel="stylesheet" type="text/css" href="<?php echo $a; ?>css/style.css" />

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
                                <span class="icon-bar"></span>`
                            </button> 
					              <a class="navbar-brand" id="sitename" href="#">Catch Up</a>
                         </div>

                        <div class="collapse navbar-collapse" id="mynavbar-content">
                                <ul class="nav navbar-nav navbar-right text-center">
                                     <li class="active "><a href="<?php echo $b; ?>" >Home</a></li>                                   
    									 <li><a href="<?php echo $b; ?>/topstories.php">Top Stories</a></li>
                                     <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"  data-toggle="tab"> Top Leagues
                                                <b class="caret"></b>
                                        </a>					
                                           <ul class="dropdown-menu">
                                                <?php
                                                $sql= "SELECT * FROM subjects WHERE visible=1 ORDER BY position LIMIT 5";
                                                  $subject_set= $database->query($sql);
                                                        while($subject = $database->fetch_array($subject_set)){
                                                            echo "<li><a href=$b/category/{$subject['id']}/{$subject['friendly_url']} \"> {$subject['subject_name']} </a></li>";
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


									 <li>

										<form method="post" action="<?php echo $b; ?>/search.php" class="navbar-form navbar-left" role="search">
											<div class="form-group">
											<input type="text" name="search" class="form-control" placeholder="Search">
											</div>
                                            <button name="submit" type="submit" class="btn btn-info">
                                                <span class="glyphicon glyphicon-log-in"></span> Search
                                            </button>
										</form>
										

									</li>

									
									
                                </ul>

               
</div>
                 </div>

                </div>

            </div>

        </div>
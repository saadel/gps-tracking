<?php
require_once('classes/session.php');
require_once ('process/users.php');

$session = new Session();

if($session->is_loggedin())
{
    header('Location: suivi.php');
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Signup - GPS Tracking</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.jpg" />
    <!--[if IE]><link rel="shortcut icon" type="image/x-icon" href="favicon.ico" /><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->

	  <div id="login-page">
	  	<div class="container">
	  	
		      <form class="form-login" action="process/register.php" method="post">
		        <h2 class="form-login-heading">sign in now</h2>
		        <div class="login-wrap">
                <?php 
                        if ($session->message()) {
                            echo '<div class="alert alert-info">
                                    <button type="button" class="close" data-dismiss="alert">
                                    &times;</button>';
                            echo $session->message(); 
                            echo "</div>";    
                        }
                     ?> 
                    <input type="text" name="firstname" class="form-control" placeholder="Prenom" autofocus required>
                    <br>
                    <input type="text" name="lastname" class="form-control" placeholder="Nom" autofocus required>
                    <br>
                    <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                    <br>
                    <input type="text" name="societe" class="form-control" placeholder="Nom de la société" autofocus required>
                    <br>
		            <input type="text" name="username" class="form-control" placeholder="User ID" autofocus required>
		            <br>
		            <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <br>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Reenter Password" required>
		            <br>
                    <button class="btn btn-theme btn-block" href="index.php" type="submit">
                    <i class="fa fa-lock"></i> SIGN UP</button>
		            <hr>
		            <div class="registration">
		                Déjà inscrit?<br/>
		                <a class="" href="login.php">
		                    Se connecter
		                </a>
		            </div>
		
		        </div>
		      </form>	  	
	  	
	  	</div>
	  </div>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>

    <!--BACKSTRETCH-->
    <!-- You can use an image of whatever size. This script will stretch to fit in any screen size.-->
    <script type="text/javascript" src="assets/js/jquery.backstretch.min.js"></script>
    <script>
        $.backstretch("assets/img/Satellite-image.jpg", {speed: 500});
    </script>


  </body>
</html>

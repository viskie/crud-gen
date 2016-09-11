<?php 
	include_once('library/config/Config.php');
	include_once('library/commonManager.php');
	include_once('library/commonFunctions.php'); 
	include_once('library/applicationManager.php'); 
	$applnObject = new applicationManager();
	$app_title = $applnObject->getAppTitle(); 
	$notification = "";	
	if((isset($_POST['wl-username'])) && (trim($_POST['wl-password']) != ""))
	{	
		include_once('library/loginManager.php');
		$loginObject = new loginManager();
		$inpUsername = $_POST['wl-username'];
		$inpPassword = $_POST['wl-password'];	
		if($loginObject->checkLogin($inpUsername,$inpPassword))
		{			
			$loginObject->setUserDetails($inpUsername);
			callheader("home.php");			
			exit;
		}
		else
		{
			$_SESSION['notification'] = "Username or Password Incorrect";
		}
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $app_title;?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />        
        <meta name="author" content="pixelcave" />
        <meta name="robots" content="nofollow" />
        <!-- Favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico" />        
        <!-- TurboAdmin main style -->
        <link type="text/css" rel="stylesheet" href="css/style.css" />        
        <!-- Uniform jquery plugin style, for styling form elements -->
        <link type="text/css" rel="stylesheet" href="css/jquery.uniform.css" />
       	<script src="js/jquery-1.5.2.min.js"></script>
        <!-- Uniform, jquery plugin for styling form elements -->
        <script src="js/jquery.uniform.js"></script>
        <!-- Custom javascript code for TurboAdmin's login page -->
		<script>
            $(function(){
                
                /* Initialize Uniform, form styling */
                $("select").uniform();
                $("input:checkbox").uniform();
                $("input:radio").uniform();
                $("input:file").uniform();

                // Hide the login form and show the reminder form
                $('#a-reminder').click(function(){
                    $('#wl-form').slideUp( 300, function(){
                        $('#wr-form').slideDown( 300, function(){
                            $('#a-reminder').hide( 1, function(){
                                $('#a-login').show();
                                $('#wr-email').focus();
                            });
                        });
                    });
                });

                // Hide the reminder form and show the login form
                $('#a-login').click(function(){
                    $('#wr-form').slideUp( 300, function(){
                        $('#wl-form').slideDown( 300, function(){
                            $('#a-login').hide( 1, function(){
                                $('#a-reminder').show();
                            });
                        });
                    });
                });

            });
        </script>
		<!-- END Javascript code -->
    </head>

    <body>        
        <!-- Login Outer -->
        <div id="login-container-outer" class="radius">
            <!-- Login Container -->
            <div id="login-container" class="radius">
                <!-- Login Header -->
                 <div id="login-header" class="radius-top" style="text-align:center">

                    <!-- Login Logo -->
                    <a href="index.php">
                        <img src="img/vishak_logo.png"  width="50%" alt="login logo" />
                    </a>
                    
                </div>
                <!-- END Login Header -->

                <!-- Login Content -->
                <div id="login-content">
                	<span style="color:#9C0;font-weight:bold;font-size:13px;">
					<? if(isset($_SESSION['notification1'])){
							echo $_SESSION['notification1'];
							$_SESSION['notification1'] = "";
						}
					?></span>
                    <span style="margin-left: 91px;color: #E95E5E;font-weight: bold;font-size: 13px;"><? if(isset($_SESSION['notification'])){
							echo $_SESSION['notification'];
							$_SESSION['notification'] = "";
						} ?></span>
                    <form action="index.php" method="post" id="wl-form" name="wl-form">
                        <label for="wl-username">Username</label>
                        <input type="text" id="wl-username" name="wl-username" value="" />
                        <label for="wl-password">Password</label>
                        <input type="password" id="wl-password" name="wl-password" value="" />
                        <label for="wl-remember">Remember me</label>
                        <input type="checkbox" id="wl-remember" name="wl-remember" />
                        <input type="submit" value="Enter" id="wl-btn" name="wl-btn" class="fright" /><br>                         
                    </form>

                    <form action="javascript: void(0)" method="post" id="wr-form" name="wr-form" class="dis-none">
                        <label for="wr-email">Enter your email</label>
                        <input type="text" id="wr-email" name="wr-email" />
                        <p class="tright">
                            <input type="submit" value="Send the password" id="wr-btn" name="wr-btn" />
                        </p>
                    </form>

                </div>
                <!-- END Login Content -->

                <!-- Login Extra -->
                <div id="login-extra" class="radius-bottom" >
					 Came here first time ? <a href="index.php" style="margin-right:15px;">Register</a>
                    <a id="a-login" href="javascript: void(0)" class="afooter-link dis-none">Suddenly remembered?</a>
                </div>
                <!-- END Login Extra -->

            </div>
            <!-- END Login Container -->

        </div>
        <!-- END Login Outer -->
        
        
        
    </body>

</html>

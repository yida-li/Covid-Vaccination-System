<?php
	require_once 'database.php';
	session_start();

    if(isset($_SESSION["UserSession"]))
    {
        header("Location: home.php");
        die();
    }
	
?>
	<!DOCTYPE HTML>
	<html>

	<head>
     
         <link rel="stylesheet" href="css/bootstrap.min.css" />
        <link rel="stylesheet" href="css/bootstrap-theme.min.css" />
        
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
	</head>

	<body>
        
        
		<div class="container" >
			<?php include 'header.php' ?>
				<!-- container -->
				<!-- content -->
				<div class="content">
					<div class="col-md-4"></div>

					<div class="col-md-4">
						<form class="form-signin" method="post">
							<h2 class="form-signin-heading">Please sign in</h2>
							<label for="inputEmail" class="sr-only">Email address</label>
							<input name="username" type="text" id="inputEmail" class="form-control" placeholder="Username" required="" autofocus="">
                            
							<label for="inputPassword" class="sr-only">Password</label>
							<input name="password" type="password" id="inputPassword" class="form-control" placeholder="Password" required="">
							</br>
							<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
						</form>
						</br>
						<?php
                        //Login authentication
						if(isset($_POST["username"]) && isset($_POST["password"]))
						{
                            //get login information from form using post request
							$username = $_POST["username"];
							$password = $_POST["password"];

                            //get the password from the database to compare to the input data
							$STH = $DBH->query("SELECT username, password FROM users WHERE username='$username'");

							$STH->setFetchMode(PDO::FETCH_ASSOC);
							$row = $STH->fetch();

                            //if the password matches , login to the website
							if(count($row) > 0 && $password==$row["password"])
							{
                                //start a session
								$_SESSION["UserSession"] = $row["username"];
                                //redirect to the main page
								header("Location: home.php");
								die();
							}
							else
							{
					?>
								<div id="alertdiv" class="alert alert-danger fade in">
									<a class="close" data-dismiss="alert">×</a> 
									<strong><span>Login Failed</span></strong>
								</div>	
					<?php
							}
						}

						#this closes the connection (database)
						$DBH = null;
					?>
					</div>
					<div class="col-md-4"></div>
				</div>
				<!-- top-grids -->
				<!-- content -->
				<?php include 'footer.php' ?>
					<!-- container -->
		</div>
	</body>

	</html>
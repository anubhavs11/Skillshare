<!DOCTYPE html>
<html lang="en">
<head>
	<title>Welcome to Skillshare | Best place to share your skills with other students</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	<?php
	include 'pdo.php';
	$error="";
  if(isset($_POST['username'])&&isset($_POST['fullname'])&&isset($_POST['email'])&&isset($_POST['password'])){
    $username=1;
    $email=1;
    foreach($db->query("SELECT username FROM users") as $row){
        if($row['username']==$_POST['username']){
          $username=0;
          break;
        }
    }
    foreach($db->query("SELECT email FROM users") as $row){
        if($row['email']==$_POST['email']){
          $email=0;
          break;
        }
    }
    if($username==0){
      $error="Username already exist";
    }
    else if(!preg_match("/([a-zA-Z0-9])/",$_POST['username'])){
      $error="Username should not contain any special characters";
    }
    else if(strlen($_POST['username'])<5){
      $error="Username must have at least 6 characters ";
    }
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
      $error = "Invalid email address";
    }
    else if($email==0){
      $error="Email Address already exist";
    }
    else if(strlen($_POST['password'])<5){
      $error="password must have at least 6 characters ";
    }
    else{
$stmt=$db->prepare("INSERT INTO users(username,fullname,email,password)
VALUES (:username,:fullname,:email,:password)");
$stmt->bindParam(':username',$_POST['username']);
$stmt->bindParam(':fullname',$_POST['fullname']);
$stmt->bindParam(':email',$_POST['email']);
$stmt->bindParam(':password',$_POST['password']);
$stmt->execute();
$_SESSION['user']=$_POST['username'];
header("Location:project_show.php");
}
}
?> 
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>
					<?php 
					require 'pdo.php';
					?>
				<form class="login100-form validate-form" action="signup.php" method="post">
					<span style="margin-top:-80px;" class="login100-form-title">
						Create account
					</span>
								<h6><?php echo $error ?></h6>
								<br>
					<div class="wrap-input100 validate-input" data-validate = "Valid username is required: anubhav">
						<input class="input100" type="text" name="username" placeholder="Username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Valid username is required: Anubhav Singh">
						<input class="input100" type="text" name="fullname" placeholder="Fullname">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="password" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn" type="submit">
							Sign up
						</button>
					</div>

					<div style="margin-top: -40px;" class="text-center p-t-136">
						<a class="txt2" href="index.php">
							Login
							<i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

</body>
</html>
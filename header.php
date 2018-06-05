<?php
  require 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    $_SESSION['login_error']="";
  if(isset($_POST['email'])&&isset($_POST['password'])){
    $stmt=$db->prepare("SELECT email,password from users
      WHERE email=:email AND password=:password");
    $stmt->bindParam(':email',$_POST['email']);
    $stmt->bindParam(':password',$_POST['password']);
    $stmt->execute();
    $count=$stmt->rowCount();
    if($count>0){
			$email=$_POST['email'];
		    foreach($db->query("SELECT username from users WHERE email='$email'") as $row2){
				$_SESSION['user']=$row2['username'];
				break;
			}
		header("Location:project_show.php");
  }
 else{
   $_SESSION['login_error']="<div class='alert alert-danger'>
    <strong>Error!</strong> Invalid Login details</div>";
 }
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap 101 Template</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <script src="bootstrap/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <style>
        #headitems{
          margin-right: 30px;
          font-size: 18px;
        }
        #login_btn{
          margin-top: 1.4px;
          margin-right: 30px;
        }
      </style>
  </head>
  <body>
    <nav class="navbar navbar-default">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
    </div>
    <div class="navbar-collapse collapse navbar-top-fixed">
      <div class="navbar-header  navbar-right ">
        <ul class="nav navbar-nav">
            <li id="headitems" class="active"><a href="#">Home</a></li>
            <li id="headitems" ><a href="#">Contact</a></li>
            <li id="headitems" ><a href="#">About</a></li>
            <li id="login_btn" ><button data-target="#loginModal" data-toggle="modal"
              type="button" class="btn btn-primary btn-lg">Login</button></li>
        </ul>
      </div>
    </nav>
<div class="container">
  <div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-11 col-md-10">
        <div class="modal fade" tabindex="-1" id="loginModal" data-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
          <form action="index.php" method="post">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">
                    &times;
                </button>
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                    <div class="form-group">
                        <h4 style="margin-top:15px;margin-bottom:10px;">Email Address </h4>
                        <input required class="form-control" placeholder="Your Email Address"
                                type="text" name="email" />
                    </div>
                    <div class="form-group">
                        <h4 style="margin-top:20px;margin-bottom:10px;">Password </h4>
                        <input required class="form-control" name="password" placeholder="Login Password"
                                type="password" />
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Login</button>
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">Cancel</button>
            </div>
          </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
    </body>
</html>

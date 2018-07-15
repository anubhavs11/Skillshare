<html lang="en">
  <head>
<?php
  include 'user_header.php';
  include 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
  if(isset($_POST['save_btn'])){
  	$fullname=$_POST['fullname'];
  	$username=$_POST['username'];
  	$bio=$_POST['bio'];
  	$email=$_POST['email'];
  	$phone=$_POST['phone'];
  	$country=$_POST['country'];	
  	$user="anubhav";
  	$stmt=$db->prepare("UPDATE users SET username=:username,fullname=:fullname,email=:email,bio=:bio,phone=:phone,country=:country WHERE username=:user");
	$stmt->bindParam(':user',$user);
	$stmt->bindParam(':username',$username);
	$stmt->bindParam(':fullname',$fullname);
	$stmt->bindParam(':email',$email);
	$stmt->bindParam(':bio',$bio);
	$stmt->bindParam(':phone',$phone);
	$stmt->bindParam(':country',$country);
	$stmt->execute();
	$_SESSION['user']=$_POST['username']; 
?>
<script type="text/javascript">
 $(document).ready(function() {
        document.getElementById("notification").innerHTML="Saved Changes";
        $('#notification').show('fade');

            setTimeout(function () {
                $('#notification').hide('fade');
            }, 5000);
 });
</script>
<?php
}
?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <script src="bootstrap/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>
	  #tabs{
	  	  margin-top:140px;
		  margin-left:120px;
	  }
	  #tab_item{
		background-color:white;
		border-color:white;
		font-size: initial;
		margin:0px;
	    color: #555;
	  }
	  #tab_item:hover{
	    background-color:#fafafa;
		border-color:#fafafa;
		font-size: initial;
		margin:0px;
	    color: #555;
	  }
	  #btns{
	  	  margin:0px;
		  padding:0px;
	  }
	  #input_field{
	  	margin-top:10px;
	  	box-shadow: 0 0 black;
	  }
	  #input_label{    
	  	margin-top: 14px;
    	margin-bottom: 18px;
	  	font-size:18px;
	  	text-align: right;
	  }
	  #input_bio{
	  	margin-top: 15px;
    	text-align: right;
    	margin-bottom: 40px;
	  	font-size:18px;	
	  }
	  #save_btn{
	  	margin-top: 30px;
     margin-left: 10px;
     font-size: 16px;
     font-variant: common-ligatures;
     font-style: inherit;
     font-family: sans-serif;
	  }
	  #input_name{
	  	margin-top: 85px;
    	margin-bottom: 18px;
	  	font-size:18px;
	  	text-align: right;
	  }

      </style>
  </head>
  <body>
  <div class="container" style="margin-top: 100px;">
		<div class="col-lg-3 col-md-4 col-sm-4 hidden-xs">
			<ul id="btns" class="row panel panel-default panel-body nav nav-pills nav-stacked">
				<li><a class="acive panel panel-default panel-body"
					id="tab_item" data-toggle="tab" href="#edit">edit profile</a></li>
				<li><a  class="panel panel-default panel-body" id="tab_item" 
					data-toggle="tab" href="#change_password">Change Password</a></li>
			</ul>
			<br><br>
		</div>
		<div class="tab-content col-lg-9 col-md-8 col-sm-8 hidden-xs">
				<div id="edit" class="tab-pane fade in active form-group">
					<form action="edit_profile.php" method="post" spellcheck="false">
						<div class="col-lg-2 col-lg-offset-1 col-md-2 col-sm-3 ">
							<img 
							<?php 
							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$user);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>"
							height="40" width="40" align="right" class="img-responsive img-circle"/>
							<p id="input_name">Name  </p>
							<p id="input_label">Username </p>
							<p id="input_bio">Bio </p>
							<p id="input_label">Email ID </p>
							<p id="input_label">Phone No. </p>
							<p id="input_label">Country </p>
						</div>
						<div class="col-lg-6 col-md-8 col-sm-7 ">
							<p style="font-size: 14px;margin-bottom: 0px;"><?php echo $_SESSION['user']; ?></p>
							<a style="font-size:12px;" href="" data-target="#change_pic" data-toggle="modal">Edit Profile Photo</a></br>
							<?php
								if(isset($_FILES['file'])&&!empty($_FILES['file'])){
										$name=$_FILES['file']['name'];
										$size=$_FILES['file']['size'];
										$tmp_name=$_FILES['file']['tmp_name'];
										$extension = strtolower(substr($name,strpos($name,'.')+1));
										$loc="profile_pics/";
										$newname=$_SESSION['user'].".".$extension;
										if($size>10000000){
											echo "file is too large";
										}
										else if(!($extension=='jpeg'||$extension=='jpg'||$extension=='png')){
											echo "Such file format is not allowed to upload";
										}
										else if(move_uploaded_file($tmp_name,$loc.$newname)){
												echo "Image uploaded successfully,<a href=''> refresh</a> to update changes";
												$stmt=$db->prepare("UPDATE users SET picture=:picture WHERE username=:username");
												$stmt->bindParam(":picture",$newname);
												$stmt->bindParam(":username",$_SESSION['user']);
												$stmt->execute();
										}
									}
									if(isset($_POST['remove_pic'])){
										echo "Profile picture removed,<a href=''> refresh</a> to update changes";

										
												// $stmt5=$db->prepare("SELECT * from users WHERE username=:username");
												// $stmt5->bindParam(":username",$_SESSION['user']);
												// $stmt5->execute();
												// $res=$stmt5->fetch();
												// $imagename=$res['picture'];

												$stmt=$db->prepare("UPDATE users SET picture=:picture WHERE username=:username");
												$stmt->bindValue(":picture","");
												$stmt->bindParam(":username",$_SESSION['user']);
												$stmt->execute();

									}
								$user=$_SESSION['user'];
							 foreach($db->query("SELECT * FROM users WHERE username='$user'") as $result){
							?>
							<input name="fullname" style="box-shadow: 0 0 black;margin-top:40px;" type="text" 
							class="form-control" value="<?php echo $result['fullname']; ?>"/>
							
							<input name="username" id="input_field" type="text" class="form-control" 
							value="<?php echo $result['username']; ?>"/>

							<textarea name="bio" id="input_field" type="text" class="form-control" 
							placeholder="About you"><?php echo $result['bio']; ?></textarea>

							<input name="email" id="input_field" type="text" class="form-control" 
							value="<?php echo $result['email']; ?>"/>

							<input name="phone" id="input_field" type="text" class="form-control" placeholder="Phone Number" value="<?php echo $result['phone']; ?>"/>

							<input name="country" id="input_field" type="text" class="form-control" placeholder="Your country name" value="<?php echo $result['country']; ?>"/>

							<button name="save_btn" id="save_btn" class="btn btn-primary">Save</button>
							<div style="margin-top:20px; " id="notification" class="alert alert-success collapse">
    							</div>
							<?php } ?>
						</div>
					</form>
					<div class="modal" id="change_pic" tab-index=-1 data-backdrop="static">
						<div class="modal-dialog modal-md">
							<div class="modal-content modal-body" style="margin-top: 200px;">
									<form action="edit_profile.php" method="post"
											 enctype="multipart/form-data">
											<!--  image uploading -->          	
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<input required type="file" name="file">
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<button type="submit" class="btn btn-default">
													Change Profile Picture</button>
											</div>
										</div>
									</form>
									<form action="edit_profile.php" method="post">
										<button style="box-shadow: 0 0 black;font-size: 16px;" 
										name="remove_pic" type="submit" class="form-control btn btn-default btn-block">Remove Profile Picture</button>
									</form>
									<button style="box-shadow: 0 0 black;font-size: 16px;" data-dismiss="modal" class="form-control btn btn-default btn-block">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<div id="change_password" class="tab-pane fade">
						<form action="edit_profile.php" method="post" spellcheck="false">
							<div class="col-lg-3 col-lg-offset-1 col-md-2 col-sm-3 col-xs-3">
								<p id="input_label">Current Password  </p>
								<p id="input_label">New Password </p>
								<p id="input_label">Confirm Password </p>
							</div>
							<div class="col-lg-6 col-md-6  col-sm-6">
									<input name="cur_pwd" style="margin-top: 10px;" type="password" class="form-control"
									placeholder="Current Password" />

									<input name="new_pwd" id="input_field" type="password" class="form-control" placeholder="Set a Strong Password" />

									<input name="cnf_pwd" id="input_field" type="password" class="form-control" placeholder="Rewrite Your Password" />

									<button style="margin-top: 20px;" name="change_password" id="change_password" class="btn btn-primary">Change Password
									</button>
									
									<div style="margin-top:20px; " id="notification" class="alert alert-success collapse">
									</div>
							</div>
						</form>
				</div>
		</div>
		<div class="hidden-lg hidden-md hidden-sm col-xs-12">
			<ul id="btns" class="row panel panel-default panel-body nav nav-pills nav-stacked">
				<li><a class="acive panel panel-default panel-body"
					id="tab_item" data-toggle="tab" href="#edit2">edit profile</a></li>
				<li><a  class="panel panel-default panel-body" id="tab_item" 
					data-toggle="tab" href="#change_password2">Change Password</a></li>
			</ul>
			<br><br>
		</div>
		<div class="tab-content hidden-lg hidden-md hidden-sm col-xs-12">
				<div id="edit2" class="tab-pane fade in active form-group">
					<form action="edit_profile.php" method="post" spellcheck="false">
						<div class="row">
							<div class="col-xs-4 col-xs-offset-2">
								<img 
								<?php 
								$user=$_SESSION['user'];
								$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
								$stmt->bindParam(":username",$user);
								$stmt->execute();
								$result=$stmt->fetch();
								$image=$result['picture'];
								?>
								src="<?php echo 'profile_pics/'.$image; ?>"
								height="40" width="40" align="left" class="img-responsive img-circle"/>
							</div>
							<div class="col-xs-6">
								<p style="font-size: 14px;margin-bottom: 0px;"> anubhav_si</p>
								<a style="font-size:12px;" href="change_pic.php">Edit Profile Photo</a></br>
							</div>
						</div>
							<?php
								if(isset($_FILES['file'])&&!empty($_FILES['file'])){
										$name=$_FILES['file']['name'];
										$size=$_FILES['file']['size'];
										$tmp_name=$_FILES['file']['tmp_name'];
										$extension = strtolower(substr($name,strpos($name,'.')+1));
										$loc="profile_pics/";
										$newname=$_SESSION['user'].".".$extension;
										if($size>1000000){
											echo "file is too large";
										}
										if(!($extension=='jpeg'||$extension=='jpg'||$extension=='png')){
											echo "Such file format is not allowed to upload";
										}
										else if(move_uploaded_file($tmp_name,$loc.$newname)){
												$stmt=$db->prepare("UPDATE users SET picture=:picture WHERE username=:username");
												$stmt->bindParam(":picture",$newname);
												$stmt->bindParam(":username",$_SESSION['user']);
												$stmt->execute();
												echo "Image uploaded successfully";
										}
									}
									if(isset($_POST['remove_pic'])){
										echo "Profile picture removed,<a href''> refresh</a> to update changes";
												$stmt=$db->prepare("UPDATE users SET picture=:picture WHERE username=:username");
												$stmt->bindValue(":picture","");
												$stmt->bindParam(":username",$_SESSION['user']);
												$stmt->execute();
												$stmt2=$db->prepare("SELECT picture from users WHERE  username=:username");
												$stmt2->bindParam(":username",$_SESSION['user']);
												$stmt2->execute();
												$res=$stmt2->fetch();
									}
								$user=$_SESSION['user'];
							 foreach($db->query("SELECT * FROM users WHERE username='$user'") as $result){
							?>
							<h4 style="margin-top:40px;">Name </h4>
							<input style="box-shadow: 0 0 black;" type="text" 
							class="form-control" value="<?php echo $result['fullname']; ?>"/>
							
							<h4 style="margin-top:20px;">Username </h4>
							<input name="username" id="input_field" type="text" class="form-control" 
							value="<?php echo $result['username']; ?>"/>

							<h4 style="margin-top:20px;">Bio </h4>
							<textarea name="bio" id="input_field" type="text" class="form-control" 
							placeholder="About you"><?php echo $result['bio']; ?></textarea>

							<h4 style="margin-top:20px;">Email ID </h4>
							<input name="email" id="input_field" type="text" class="form-control" 
							value="<?php echo $result['email']; ?>"/>

							<h4 style="margin-top:20px;">Phone No. </h4>
							<input name="phone" id="input_field" type="text" class="form-control" placeholder="Phone Number" value="<?php echo $result['phone']; ?>"/>

							<h4 style="margin-top:20px;">Country </h4>
							<input name="country" id="input_field" type="text" class="form-control" placeholder="Your country name" value="<?php echo $result['country']; ?>"/>

							<button name="save_btn" id="save_btn" class="btn btn-primary">Save</button>
							<div style="margin-top:20px; " id="notification" class="alert alert-success collapse">
    							</div>
							<?php } ?>
					</form>
					<div class="modal" id="change_pic" tab-index=-1 data-backdrop="static">
						<div class="modal-dialog modal-xs">
							<div class="modal-content modal-body" style="margin-top: 200px;">
									<form action="edit_profile.php" method="post"
											 enctype="multipart/form-data">
											<!--  image uploading -->          	
										<div class="row">
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<input required type="file" name="file">
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
												<button type="submit" class="btn btn-default">
													Change Profile Picture</button>
											</div>
										</div>
									</form>
									<form action="edit_profile.php" method="post">
										<button style="box-shadow: 0 0 black;font-size: 16px;" 
										name="remove_pic" type="submit" class="form-control btn btn-default btn-block">Remove Profile Picture</button>
									</form>
									<button style="box-shadow: 0 0 black;font-size: 16px;" data-dismiss="modal" class="form-control btn btn-default btn-block">Cancel</button>
							</div>
						</div>
					</div>
				</div>
				<div id="change_password2" class="tab-pane fade">
						<form action="edit_profile.php" method="post" spellcheck="false">
							<div class="col-xs-12">
									<h4>Current Password  </h4>
									<input name="cur_pwd" style="margin-top: 10px;" type="password" class="form-control"
									placeholder="Current Password" />
									
									<h4>New Password </h4>
									<input name="new_pwd" id="input_field" type="password" class="form-control" placeholder="Set a Strong Password" />

									<h4>Confirm Password </h4>
									<input name="cnf_pwd" id="input_field" type="password" class="form-control" placeholder="Rewrite Your Password" />

									<button style="margin-top: 20px;" name="change_password" id="change_password" class="btn btn-primary">Change Password
									</button>
									
									<div style="margin-top:20px; " id="notification" class="alert alert-success collapse">
									</div>
							</div>
						</form>
				</div>
		</div>
	<div>
</body>
</html>
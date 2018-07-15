<html lang="en">
  <head>
<?php
  include 'user_header.php';
  include 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <script src="bootstrap/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
    <style>								
</style>
<div class="container">
	<div class="row">
		<div class="" style="text-align: center;margin-top: 100px;">
			<h4>Select a image to upload </h4>
			<form action="edit_profile.php" method="post" enctype="multipart/form-data">
					 <div class="col-xs-7 col-offset-xs-4" style="margin-bottom: 20px;">
						<input required type="file" name="file">
					</div>
				<button type="submit" class="btn btn-default">Change Profile Picture</button>
			</form>
			<form action="edit_profile.php" method="post">
				<button style="box-shadow: 0 0 black;font-size: 16px;" 
					name="remove_pic" type="submit" class="btn btn-default">Remove Profile Picture
				</button>
			</form>
			<a href="edit_profile.php" style="box-shadow: 0 0 black;font-size: 16px;" class=" btn btn-default">Cancel</a>
		</div>
	</div>
</div>

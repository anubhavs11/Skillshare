<?php
  include 'user_header.php';
  require 'pdo.php';
  if(isset($_POST['title'])&&isset($_POST['description'])&&isset($_POST['category'])&&
  isset($_POST['amount'])&&isset($_POST['currency'])){
		$stmt=$db->prepare("INSERT INTO projects(username,title,description,additional,category,amount,currency,postdate)
							VALUES (:username,:title,:description,:additional,:category,:amount,:currency,CURDATE())");
			$stmt->bindParam(':username',$_SESSION['user']);
			$stmt->bindParam(':title',$_POST['title']);
			$stmt->bindParam(':description',$_POST['description']);
			$stmt->bindParam(':additional',$_POST['additional']);
			$stmt->bindParam(':category',$_POST['category']);
			$stmt->bindParam(':amount',$_POST['amount']);
			$stmt->bindParam(':currency',$_POST['currency']);
			$stmt->execute();
			echo '<div class="alert alert-success" style="margin:100px;margin-bottom:0px;"> 
	  			<h4>Your Project have been uploaded succesfully</h4>
	  		</div>'	;
  }

?>
      <style>
		#heading{
	  	    margin-bottom: 0px;
			margin-top: 40px;
			background-color: #fff;
		}
		#post_button{
			margin-bottom: 15px;
			margin-top:20px;
		}
		.body{
			background-color: #fafafa;
		}
      </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
	  <h3>Post Your Project</h3>
	  <div class="col-lg-7 col-lg-offset-2">
    <form action="post_your_project.php" method="post">
	  <div class="form-group">
		<h4 id="heading">Project Title : </h4><br>
			<input maxlength="100" required name="title" type="text" class="form-control" placeholder="eg. Design a Media player">
		<h4 id="heading">Description : </h4><br>
			<textarea maxlength="500" required name="description" rows="8" cols="12" class="form-control"
			placeholder="Enter all the details about your project"></textarea>
		<h4 id="heading">Additional Details : </h4><br>
			<textarea maxlength="500" name="additional" rows="5" cols="12" class="form-control"
			placeholder="Additional information about the project"></textarea>
		<h4 id="heading">Select Category : </h4><br>
			<select required name="category" class="form-control">
				<option value="all">Any Category(default)</option>
				<option value="web">Web Projects</option>
				<option value="soft">Software Projects</option>
				<option value="doc">Document Preparations</option>
				<option value="assignment">Assignments</option>
			</select>
		<h4 style="margin-bottom: 15px;
					margin-top:40px;
					">Your Offer Price</h4>
				<div class="row">
					<div class="col-lg-7 col-md-7 col-sm-8 col-xs-7">
						<input maxlength="10" type="text" name="amount" class="form-control" placeholder="eg. 100">
					</div>
					<div class="col-lg-5 col-md-5 col-sm-4 col-xs-5">
						<select  required name="currency" class="form-control">
								<option value="INR">Rupees</option>
								<option value="USD">US Doller(USD)</option>
								<option value="EURO">Euro</option>
						</select>
					</div>
				</div>
			<br>
			<button id="post_button" class="btn btn-primary btn-block btn-lg">Post </button>
    </form>
			<br><br><br><br>
	  </div>
	  </div>
	</div>

<?php
  include 'user_header.php';
  include 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<div class="container">
    <div class="row" style="margin-top:60px;">
	  <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	  	<?php 
	  	  if(isset($_POST['title'])&&isset($_POST['description'])&&isset($_POST['category'])&&
			  isset($_POST['amount'])&&isset($_POST['currency'])){
					$stmt=$db->prepare("UPDATE projects SET title=:title,description=:description,additional=:additional,category=:category,amount=:amount,currency=:currency WHERE id=:id");
						$stmt->bindParam(':title',$_POST['title']);
						$stmt->bindParam(':description',$_POST['description']);
						$stmt->bindParam(':additional',$_POST['additional']);
						$stmt->bindParam(':category',$_POST['category']);
						$stmt->bindParam(':amount',$_POST['amount']);
						$stmt->bindParam(':currency',$_POST['currency']);
						$stmt->bindParam(':id',$_POST['post_button']);
						$stmt->execute();
						echo '<div class="alert alert-success">
					  			<h4>Project details Updated succesfully</h4>
					  		</div>'	;
			}
	  	if(isset($_POST['delete'])&&!empty($_POST['delete'])){
	  		$stmt=$db->prepare("DELETE FROM projects WHERE id=:id");
	  		$stmt->bindParam(":id",$_POST['delete']);
	  		$stmt->execute();
	  		?>
	  		<div class="alert alert-success">
	  			<h4>Project details deleted succesfully</h4>
	  		</div>
	  		<?php
	  	}
	  	else if(isset($_POST['edit'])&&!empty($_POST['edit'])){
	  		$stmt=$db->prepare("SELECT * FROM projects WHERE id=:id");
	  		$stmt->bindParam(":id",$_POST['edit']);
	  		$stmt->execute();
	  		$row=$stmt->fetch();
	  		?>
	  		<form action="update.php" method="post">
			  <div class="form-group">
				<h4 id="heading">Project Title : </h4><br>
					<input value="<?php echo $row['title']; ?>" maxlength="100" required name="title" type="text" class="form-control" >
				<h4 id="heading">Description : </h4><br>
					<textarea  maxlength="500" required name="description" rows="8" cols="12" class="form-control"
					><?php echo $row['description']; ?>"</textarea>
				<h4 id="heading">Additional Details : </h4><br>
					<textarea  maxlength="500" name="additional" rows="5" cols="12" class="form-control"
					><?php echo $row['additional']; ?>" </textarea>
				<h4 id="heading" >Select Category : </h4><br>
					<select value="<?php echo $row['category']; ?>" required name="category" class="form-control">
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
								<input value="<?php echo $row['amount']; ?>" maxlength="10" type="text" name="amount" class="form-control">
							</div>
							<div class="col-lg-5 col-md-5 col-sm-4 col-xs-5">
								<select value="<?php echo $row['currency']; ?>" required name="currency" class="form-control">
										<option value="INR">Rupees</option>
										<option value="USD">US Doller(USD)</option>
										<option value="EURO">Euro</option>
								</select>
							</div>
						</div>
					<br>
					<button id="post_button" value="<?php echo $row['id']; ?>" class="btn btn-primary btn-block btn-lg">Post </button>
   				</form>
	  		<?php
	  	}
	  	else if(isset($_POST['upload_file'])&&!empty($_POST['upload_file'])){
	  		if(isset($_FILES['file'])&&!empty($_FILES['file'])){
					$name=$_FILES['file']['name'];
					$size=$_FILES['file']['size'];
					$tmp_name=$_FILES['file']['tmp_name'];
					$extension = strtolower(substr($name,strpos($name,'.')+1));
					$loc="project_files/";
					$newname=$_POST['upload_file'].".".$extension;
					if($size>50000000){
						echo '<div style="margin-top:20px; " id="notification" class="alert alert-success ">
						file is too large
						</div>';
					}
					else if(!($extension=='zip')){
						echo '<div style="margin-top:20px; " id="notification" class="alert alert-success ">
							Such file format is not allowed to upload
						</div>';
					}
					else if(move_uploaded_file($tmp_name,$loc.$newname)){
							?>
							<div style="margin-top:20px; " id="notification" class="alert alert-success ">
								<h3>Project files uploaded successfully..</h3>
								<h3>You will shortly receive the money :)</h3>
    							</div>
    							<?php
    							$id=$_POST['upload_file'];
    							$stmt=$db->prepare("SELECT * from projects WHERE id=:id");
								$stmt->bindParam(':id',$id);
								$stmt->execute();
								$row=$stmt->fetch();
								$receiver=$row['username'];
								$stmt2=$db->prepare("UPDATE projects SET iscompleted=1 WHERE id=:id");
								$stmt2->bindParam(':id',$id);
								$stmt2->execute();
    							?>
    					<div class="hidden-xs">
    						<form action="chat_page.php" method="post">
    							<button style="font-size: 18px" type="submit" class="btn btn-default" 
    							value="<?php echo $receiver; ?>"> Ask for it</button>
    						</form>
    					</div>
    					<div class="hidden-lg hidden-md hidden-sm">
    						<form action="xs_chat_page.php" method="post">
    							<button style="font-size: 18px" type="submit" class="btn btn-default" 
    							value="<?php echo $receiver; ?>"> Ask for it</button>
    						</form>
    					</div>
    							<?php 

							$stmt=$db->prepare("INSERT INTO notification (username,id,other_user,type) VALUES(:username,:id,:other_user,:type)");
							$stmt->bindParam(":username",$receiver);
							$stmt->bindParam(":id",$id);
							$stmt->bindParam(":other_user",$_SESSION['user']);
							$stmt->bindValue(":type",'project_complete');
							$stmt->execute();
					}
				}
	  	}
	  	else if(isset($_POST['download_project'])&&!empty($_POST['download_project'])){
	  		?>
	  		<h3>Your Project have been completed </h3>
	  		<h4>You just need to make the payment via third party source</h4>
	  		<br>
	  		<h3>Download the project files now</h3>
	  		<a style="border-color: white;font-size: 18px;" class="w3-button w3-blue w3-hover-blue btn btn-default" 
	  		href="<?php echo 'project_files/'.$_POST['download_project'].'.zip';?>">download</a>


	  	<?php 
	  		}
	  	?>
	  </div>
	</div>
</div>
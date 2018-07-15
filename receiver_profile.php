<html lang="en">
  <head>
<?php
  include 'user_header.php';
  include 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
    }
    if(!isset($_SESSION['user'])){
    	die("session_destroy");
    }
	if(isset($_POST['view'])){
		$_SESSION['id']=$_POST['view'];
		$id=$_SESSION['id'];
	} 
	else{
		$id=$_SESSION['id'];
	}
	$stmt=$db->prepare("SELECT username FROM projects WHERE id = :id");
	$stmt->bindParam(':id',$id);
	$stmt->execute();
	$rows=$stmt->fetch(PDO::FETCH_ASSOC);
	$to=$rows['username'];
	$_SESSION['to']=$to;
	
?>
<style>
	  #follow_btn{
	  	margin-top:20px;
	  	background: #3897f0;
    	border-color: #3897f0;
    	color: #fff;
    	font-size: 16px;
    	font-weight: bold;	
	  }
	  #following_btn{
	  	margin-top:20px;
	  	background: white;
    	color: black;
    	font-size: 16px;
    	font-weight: bold;	
	  }
	  #username_heading{
	  	  font-family:inherit;
	  }
	  #discussion{
		     font-family: cursive;
			 font-size: 14px;
			 padding-top:8px;
			 color:black;
	  }
	  #follow{
	  	     border-color: white;
			 margin-left: 0px;
		     font-family: cursive;
			 background-color:white;
			 font-size: 14px;
			 color:black;
	  }
	  #follow:hover{
	  	     border-color: white;
			 background-color:white;
			 font-family: cursive;
			 font-size: 14px;
	  }
	  #follow:active{
			 background-color: transparent;
			 -moz-box-shadow:    none;
			 -webkit-box-shadow: none;
             box-shadow:         none;
			 border-radius: 0;
	  	     border-color: white;
			 background-color:white;
			 font-family: cursive;
			 font-size: 14px;
			 color:gray;
	  }
	  #tabs{
	  	  margin-top:60px;
		  background-color:;
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
	  #title_val{
	    font-size: 22px;
    	font-style: initial;
    	font-family: sans-serif;
    	color: black;
	  }
	  #title{
	  	font-size: 30px;
    	font-family: -webkit-body;
    	margin-bottom: 40px;
	  }
	  #discription{
	    font-size: 16px;
    	padding: 4px;
	  }
	  #prize{
	  	font-size: 24px;
    	font-family: inherit;
	  }
	  #accept_offer{
	  	border-radius:4px;
	  }
</style>
  </head>
<script type="text/javascript">
	function following()
	{
		var msg1=$("#follow_btn").val();
		document.getElementById("follow_btn").style.display = 'none';
		document.getElementById("following_btn").style.display = 'block';
			$.post("follow.php", {
			follow:msg1
			});
	}
	function follow()
	{
	var	msg1=$("#following_btn").val();
	document.getElementById("follow_btn").style.display = 'block';
	document.getElementById("following_btn").style.display = 'none';
			$.post("follow.php", {
			following: msg1
			});
	}
</script>
<?php if(isset($_POST['accept_offer'])){
		$id=$_POST['accept_offer'];
		$stmt2=$db->prepare("UPDATE projects SET status=:status , receiver=:receiver WHERE id = :id");
		$stmt2->bindParam(':id',$id);
		$stmt2->bindParam(':receiver',$_SESSION['user']);
		$stmt2->bindValue(':status',0);
		$stmt2->execute();

		$notifyto='';
			foreach($db->query("SELECT * FROM projects WHERE id='$id'") as $val){
				$notifyto=$val['username'];
		}


		$stmt2=$db->prepare("INSERT INTO notification(username,id,other_user,type) VALUES(:username,:id,:other_user,:type)");
		$stmt2->bindParam(':username',$notifyto);
		$stmt2->bindParam(':id',$id);
		$stmt2->bindParam(':other_user',$_SESSION['user']);
		$stmt2->bindValue(':type','project');
		$stmt2->execute();
			
	?>
<script> $(document).ready(function() {
        document.getElementById("notification").innerHTML="You have Successfully ordered the project";
        	$('#notification').show('fade');
        	document.getElementById("accept_offer").disabled = true;
            setTimeout(function () {
                $('#notification').hide('fade');
            }, 5000);
            $('#ordered').show('fade');
 });
</script>
<?php
	}
	?>
	<body>
<div class="container">
    <div class="row" style="margin-top:90px;">
    	<div class="col-lg-3 col-md-2 col-sm-3 col-sm-offset-2 col-xs-12" style="text-align: center;margin-left: 2%;margin-bottom: 50px;">
			<div align="center" class="row w3-card w3-center ">
				<?php 
					$user=$to;
					$stmt=$db->prepare("SELECT picture,fullname from users WHERE username=:username");
					$stmt->bindParam(":username",$user);
					$stmt->execute();
					$result=$stmt->fetch();
					$image=$result['picture'];
				?>
				<h3> My profile </h3>
				<img src="<?php echo 'profile_pics/'.$image; ?>" style="height:106px;width:106px;margin-left:30%;" class="img-responsive img-circle"></img>
				<hr>
				<h3><?php echo $result['fullname']; ?></h3>
				<h5 id="username_heading"><?php echo '('.$username.')'; ?></h5>
				<button style="margin-left:35%;" type="button" id="follow_btn" type="button" value="<?php echo $to; ?>" class="btn btn-default" onclick="following();" >follow</button>
                 <button style="margin-left:35%;" type="button" id="following_btn" type="button" value="<?php echo $to; ?>" class="btn btn-default" onclick="follow();" style="display: none;">following</button>
                 <br>
                 <?php
                 $stmt=$db->prepare("SELECT * from followings
					WHERE username=:username AND following=:following");
					$stmt->bindParam(':username',$_SESSION['user']);
					$stmt->bindValue(':following',$to);
					$stmt->execute();
					$res=$stmt->fetch();
					if(empty($res)){
					?>
					<script type="text/javascript">
						document.getElementById("follow_btn").style.display = 'block';
						document.getElementById("following_btn").style.display = 'none';
					</script>
					<?php } else{ ?>
					<script type="text/javascript">
						document.getElementById("follow_btn").style.display = 'none';
						document.getElementById("following_btn").style.display = 'block';
					</script>
					<?php } ?>
			</div>
			<br><br>
		</div>
		<?php
		$stmt=$db->prepare("SELECT * FROM projects WHERE id =:id");
		$stmt->bindParam(":id",$id);
		$stmt->execute();
			while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			?>
			<div class="col-lg-8 col-md-10 col-sm-8 col-xs-12 panel panel-default panel-body" style="margin-top: 20px;">
				<div id="notification" class="alert alert-success collapse"></div>

				<div class="w3-card-4">
                  <header class="w3-container w3-light-grey">
                    <h2 ><?php echo '<h4>'.$row['title'].'</h4>'; ?></h2>
                  </header>
                  	<div class="w3-container">     
                    	<h5><?php echo $row['description']; ?></br></h5>
                    	<h5><?php echo $row['additional']; ?></h5>
						<h4 style="font-size: 16px;  font-family: sans-serif;"><?php echo 'Price '.$row['amount'].' '.$row['currency']; ?></h4>
                    	<div class="row btn btn-group">
						  <form action="receiver_profile.php" method="post">

							<button name="accept_offer" id="accept_offer" type="submit" class="w3-button w3-blue
							<?php 
						  	if(!empty($row['receiver'])){
						  		echo "w3-disabled";
						  	}
						  	?>" value='<?php echo $row["id"];?>'>Accept Offer</button>
						</form>
						</div>
                	</div>
                </div>
			</div>
			<?php
			}?>
	</div>
</div>
</body>
</html>
<?php 
include 'pdo.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
	$from=$_SESSION['user'];
		if(isset($_POST['message'])&&!empty($_POST['message'])){
			$stmt=$db->prepare("INSERT INTO chats(sender,receiver,message)
			VALUES (:sender,:receiver,:message)");
			$stmt->bindParam(':sender',$from);
			$stmt->bindParam(':receiver',$_SESSION['to']);
			$stmt->bindParam(':message',$_POST['message']);
			$stmt->execute();
		}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
      <link rel='stylesheet' href='fontawesome-free-5.0.9\web-fonts-with-css\css\fontawesome-all.min.css'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Page</title>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <script src="bootstrap/jquery.min.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
      <script  type="text/javascript">
function ajax(){
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
  if (this.readyState == 4 && this.status == 200) {
    document.getElementById("chat").innerHTML =
    this.responseText;
  }
};
xhttp.open("POST", "chat.php", true);
xhttp.send();
}
setInterval(function(){ajax(); },100);
$(document).ready(function(){
	$("#msg").keydown(function() {
    	if (event.keyCode === 13) {
        	$("#send").click();
    	}
	});
	$("#send").click(function() {
		var msg1 = $("#msg").val();
		$.post("chat.php", {
		msg: msg1
		});
		document.getElementById('msg').value ='';
	});
});
</script>
   <style>
	  #head{
    		margin-top: 12px;
    	font-size: 16px;
    	font-family: inherit;
    	font-weight: unset;
	  }
	  ::-webkit-scrollbar {
		display: none;
		}
	  #msg_list{
	  border-right-color: #fff2f2;
      border-right-width: 1px;
      border-right-style: outset;
	  }
	  #mypic{
	  	  margin-right:310px;
	  }
	  .vl{
    	border-left: 10px solid #eeeeee;
    	height: 50px;
		margin-right:20px;
	  }
	  #reciever_pic{
	  	  margin-right:20px;
	  }
	  #chat_btn{
	  	  margin-left:40px;
		  margin-top:5px;
	  }
	  .chat_box{
	  	  margin-top:50px;
	  	  background-color:white;
		  height:100%;
		  width:70%;
	  }
	  .messages{
		  border-left:20px solid #eeeeee;
		  border-right:30px solid #eeeeee;
	  	  background-color:white;
	  	  width:100%;
	  	  height:90%;
	  }
	  .chat_section{
	  	  margin-top:20px;
	  	  margin-bottom:80px;
	  	  margin-left: 10%;
    	  margin-right: 10%;
	  }
	  .btn_holder{
			background-color:#eeeeee;
			height: 60px;
			width:65%;
			border-top:2px solid #eeeeee;
			margin-left: 37%;
	  }
	  #list_btn{
	  	  width:100%;
		  background-color:white;
		  height:80px;
		  border: .05px solid antiquewhite;
		  border-right: .1px solid antiquewhite;
		  border-bottom:0px;
	  }
	  #list_btn:hover{
	  	  width:100%;
		  background-color:white;
		  height:80px;
		  border: .05px solid antiquewhite;
		  border-right: .05px solid antiquewhite;
		  border-bottom:0px;
	  }
	  #list_btn:active{
	  	  width:100%;
		  background-color:white;
		  height:80px;
		  border: .05px solid antiquewhite;
		  border-top: .1px solid antiquewhite;
		  border-right: .1px solid antiquewhite;
		  border-bottom:0px;
	  }
	  #form_btn{
		  background-color:white;
	  	  margin:0px;
		  padding:0px;
	  }
	  #names {
        margin-top: 15px;
		padding-right: 200px;
		font-size: 18px;
		font-family: inherit;
	  }
	  #msg_text{
		  display:inline;
		  font-size: 18px;
	  }
	  </style>
  </head>
 <body onload="ajax()">
<div class="container">
<div class="row hidden-sm hidden-xs" style="overflow:hidden;">
   <div id="left" class="col-lg-4 col-md-4">
      <div style="background-color:#eeeeee;height:50px;" class="navbar-header navbar-fixed-top">
        <ul class="nav navbar-nav">
            <li id="mypic" class="active">
            	<img style="margin-left:40px;margin-top:5px;" 
            	<?php 
            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
            	$stmt->bindParam(":username",$_SESSION['user']);
            	$stmt->execute();
            	$res=$stmt->fetch();
            	$image=$res['picture'];
            	?>
            	src='<?php echo 'profile_pics/'.$image; ?>' height="40" width="40" class="img-circle img-responsive"></img></li>
			<li class="pull-right"><h4 style="margin-top: 14px;"><a href="home.php"> <i style="font-size: 25px;" class="fa fa-home"></i></a></h4></li>
		</ul>
     </div>	<div style="margin-top: 70px;">
	 			<?php
				require 'pdo.php';
				$username=$_SESSION['user'];
				$array = array(); 
				$n=0;
				$count=0;
					foreach($db->query("SELECT DISTINCT sender FROM chats WHERE receiver='$username' order by timestamp1") as $row){ 
						if($row['sender']!=$_SESSION['user']){
							$count=$count+1;
							$n=$n+1;
							$array[$n]=$row['sender'];
						?>
					<div class="row">
							<?php
						echo '<form id="form_btn" action="chat_page.php" method="post">';
							$to=$row['sender']; ?>
							 <button id="list_btn" name="to" value='<?php echo $to;?>' type="submit">
							<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
								<img 
				            	<?php 
				            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
				            	$stmt->bindParam(":username",$to);
				            	$stmt->execute();
				            	$res=$stmt->fetch();
				            	$image=$res['picture'];
				            	?>
				            	src='<?php echo 'profile_pics/'.$image; ?>'
									  height="60"  width="60" class="img-circle img-responsive"></img>
								
							</div>
							<div class="col-lg-9 col-md-9 hidden-sm hidden-xs">
								<?php	echo '<p id="names">'.$row['sender'].'</p>';
								?>
							</div>
							<?php
								echo '</button>';
								echo '</form>';
								?>
						</div>

						<?php }}
					foreach($db->query("SELECT * FROM followings WHERE username ='$username'") as $row){ 
						$count=$count+1;
						if (in_array($row['following'], $array, TRUE))
						  {
						  }else{
						?>
						<div class="row">
							<?php
						echo '<form id="form_btn" action="chat_page.php" method="post">';
							$to=$row['following']; ?>
							 <button id="list_btn" name="to" value='<?php echo $to;?>' type="submit">
							<div class="col-lg-3 col-md-3 hidden-sm hidden-xs">
								<img 
				            	<?php 
				            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
				            	$stmt->bindParam(":username",$to);
				            	$stmt->execute();
				            	$res=$stmt->fetch();
				            	$image=$res['picture'];
				            	?>
				            	src='<?php echo 'profile_pics/'.$image; ?>'
									  height="60"  width="60" class="img-circle img-responsive"></img>
								
							</div>
							<div class="col-lg-9 col-md-9 hidden-sm hidden-xs">
								<?php	echo '<p id="names">'.$row['following'].'</p>';
								?>
							</div>
							<?php
								echo '</button>';
								echo '</form>';
								?>
						</div>
						<?php }}
						if($count==0){
							echo '<h4>No followings in the list</h4>';
						}
						?>
			</div>
   </div>
   <div class="col-lg-8 col-md-8 hidden-sm hidden-xs" >
	  <div style="background-color:#eeeeee;position:relative;
				height:50px" class="navbar-header navbar-fixed-top">
        <ul  data-spy="affix" class="nav navbar-nav">
			<li><div class="vl"></div></li>
            <li id="reciever_pic" class="active"><img style="margin-left:10px;margin-top:5px;" 
            	<?php 
		            	if(isset($_POST['to'])&&!empty($_POST['to'])){
							$_SESSION['to']=$_POST['to'];
							$to=$_POST['to'];
						}
						if(empty($_SESSION['to'])){
							$_SESSION['to']="feedback";
						}
						$stmt2=$db->prepare("UPDATE notification SET seen=1 WHERE username=:username AND other_user=:other_user");
						$stmt2->bindParam(":username",$_SESSION['user']);
						$stmt2->bindParam(":other_user",$to);
						$stmt2->execute();

            			$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
		            	$stmt->bindParam(":username",$to);
		            	$stmt->execute();
		            	$res=$stmt->fetch();
		            	$image=$res['picture'];
            	 	?>
					src="<?php echo 'profile_pics/'.$image;?>" height="40" width="40"
					class="img-circle img-responsive"></img></li>
            <li ><p id="head">
			<?php 
				echo $_SESSION['to'];
			?>
			</p></li>
		</ul>
     </div>	
	  <div >
		<div data-spy="affix" class="chat_box" style="background-color:#eeeeee;">
			<div class="messages" style="overflow-y:scroll;">
				<div class="chat_section">
					<div id="chat">
					</div>
				</div>
			</div>	
			<div class="btn_holder navbar-header navbar-fixed-bottom">
				<div id="chat_btn" class="form-group nav navbar-nav">
					<div style="width:90%;" class="input-group">
						<input placeholder="   write your message here" style="font-style:serif; width:100%;
							font-size:16px;" id="msg" type="text" class="form-control"/>
						<span class="input-group-btn">
						<button style="height: 34px;" id="send" class="btn btn-default" type="submit">Send</button>
						</span>
					</div>
				</div>
			</div>
		 </div>
	  </div> 
	 </div>
	</div>
	<div class="row hidden-lg hidden-md">
		<div id="left" class="col-sm-12 col-sm-12">
      		<div style="background-color:#eeeeee;
				height:50px" class="navbar-header navbar-fixed-top">
        		<ul class="nav navbar-nav">
            		<li class="pull-left"><img style="margin-left:40px;margin-top:0px;" 
            			<?php 
		            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
		            	$stmt->bindParam(":username",$_SESSION['user']);
		            	$stmt->execute();
		            	$res=$stmt->fetch();
		            	$image=$res['picture'];
		            	?>
						src="<?php echo 'profile_pics/'.$image; ?>" height="38" width="38"
						class="img-circle img-responsive"></img></li>
					<li class="pull-right"><a href="home.php">
						 <i style="font-size: 25px;margin-right:10px;" class="fa fa-home"></i></a>
						</li>
				</ul>
     		</div>
     		<div style="margin-top: 70px;">
 			<?php
				$username=$_SESSION['user'];
				$array = array(); 
				$n=0;
				$count=0;
					foreach($db->query("SELECT DISTINCT sender FROM chats WHERE receiver='$username' order by timestamp1") as $row){ 
						if($row['sender']!=$_SESSION['user']){
							$count=$count+1;
							$n=$n+1;
							$array[$n]=$row['sender'];
						?>
					<div class="row">
							<?php
						echo '<form id="form_btn" action="xs_chat_page.php" method="post">';
							$to=$row['sender']; ?>
							 <button id="list_btn" name="to" value='<?php echo $to;?>' type="submit">
							<div class="col-sm-3 col-xs-3 hidden-lg hidden-md">
								<img 
				            	<?php 
				            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
				            	$stmt->bindParam(":username",$to);
				            	$stmt->execute();
				            	$res=$stmt->fetch();
				            	$image=$res['picture'];
				            	?>
				            	src='<?php echo 'profile_pics/'.$image; ?>'
									  height="60"  width="60" class="img-circle img-responsive"></img>
								
							</div>
							<div class="col-sm-9 col-xs-9 hidden-md hidden-lg">
								<?php	echo '<p id="names">'.$row['sender'].'</p>';
								?>
							</div>
							<?php
								echo '</button>';
								echo '</form>';
								?>
						</div>

						<?php }}
					foreach($db->query("SELECT * FROM followings WHERE username ='$username'") as $row){ 
						$count=$count+1;
						if (in_array($row['following'], $array, TRUE))
						  {
						  }else{
						?>
						<div class="row">
							<?php
						echo '<form id="form_btn" action="xs_chat_page.php" method="post">';
							$to=$row['following']; ?>
							 <button id="list_btn" name="to" value='<?php echo $to;?>' type="submit">
							<div class="col-sm-3 col-xs-3 hidden-md hidden-lg">
								<img 
				            	<?php 
				            	$stmt=$db->prepare("SELECT * FROM users WHERE username=:username");
				            	$stmt->bindParam(":username",$to);
				            	$stmt->execute();
				            	$res=$stmt->fetch();
				            	$image=$res['picture'];
				            	?>
				            	src='<?php echo 'profile_pics/'.$image; ?>'
									  height="60"  width="60" class="img-circle img-responsive"></img>
								
							</div>
							<div class="col-sm-9 col-xs-9 hidden-md hidden-lg">
								<?php	echo '<p id="names">'.$row['following'].'</p>';
								?>
							</div>
							<?php
								echo '</button>';
								echo '</form>';
								?>
						</div>
						<?php }}
						if($count==0){
							echo '<h4>No followings in the list</h4>';
						}
						?>
					</div>
		</div>
	</div>
</div>
</body>
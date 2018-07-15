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
    	margin-top: 8px;
    	font-size: 16px;
    	font-family: inherit;
    	font-weight: unset;
	  }
	  ::-webkit-scrollbar {
		display: none;
		}
	  .chat_box{
	  	  background-color:white;
		  margin-bottom: 60px;
	  }
	  .messages{
	  	  background-color:white;
	  	  width:100%;
	  }
	  .chat_section{
	  	  margin-top:60px;
	  	  width:100%;
	  	  margin-left: 5px;
	  	  margin-right: 5px;
	  }
	  #chat_btn{
		  margin-top:5px;
		  margin-right:15px;
		  margin-left: 20px;
	  }
	  .btn_holder{
			background-color:#eeeeee;
			height: 55px;
			border-top:2px solid #eeeeee;
	  }
	  #left_arrow{
	  		font-size: 20px;
	  }

	  #left_arrow:active{
	  		font-size: 20px;
	  		box-shadow: 0 0 black;
	  }
	  </style>
  </head>
<body onload="ajax()" class="hidden-md hidden-lg">
  <div class="container">
<div class="row" style="overflow:hidden;">
	  <div class="navbar-header navbar-fixed-top " style="background-color:#eeeeee;position:fixed;height:50px">
        <ul  class="nav navbar-nav">
            <li class="pull-left" id="left_arrow"><a style="font-size: 20px;margin-left:5px;" href="chat_page.php" ><span  class="glyphicon glyphicon-arrow-left"></span></a></li>
            <li class="pull-left" id="reciever_pic">
            	<img 
							<?php 
							if(isset($_POST['to'])&&!empty($_POST['to'])){
								$_SESSION['to']=$_POST['to'];
							}
							if(empty($_SESSION['to'])){
								$_SESSION['to']="feedback";
							}
							$stmt2=$db->prepare("UPDATE notification SET seen=1 WHERE username=:username AND other_user=:other_user");
							$stmt2->bindParam(":username",$_SESSION['user']);
							$stmt2->bindParam(":other_user",$_POST['to']);
							$stmt2->execute();

							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$_SESSION['to']);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>" style="margin-left:10px;" 
					 height="40" width="40"
					class="img-circle img-responsive"></img></li>
            <li class="pull-left"><p id="head" style="margin-left:10px;" >
				<?php 
					echo $_SESSION['to'];
				?>
				</p></li>
			<li class="pull-right dropdown-toggle" data-toggle="dropdown" style="margin-right:10px;"><a class="btn">
				<span class="glyphicon glyphicon-option-vertical"></span></a>
			</li>
				<ul class="dropdown-menu dropdown-menu-right" style="
						background-color: white;">
						<li><a href="project_show.php">Go to HomePage</a></li>
						<li><a href="index.php">Logout</a></li>
				</ul>
		</ul>
     	</div>
	  <div data-spy="affi">
		<div class="chat_box" style="background-color:#eeeeee;">
			<div class="messages" style="overflow-y:scroll;">
				<div class="chat_section">
					<div id="chat">
					</div>
				</div>
			</div>	
			<div class="btn_holder navbar-header navbar-fixed-bottom">
				<div id="chat_btn" class="form-group nav navbar-nav">
					<div class="input-group">
							<input placeholder="   write your message here" style="font-style:serif;
								font-size:16px;" id="msg" name="message" type="text" class="form-control"/>
							<span class="input-group-btn">
							<button style="height: 36px;" id="send" class="btn btn-default" type="submit"><span class="glyphicon glyphicon-send"></span></button>
							</span>
						</div>
				</div>
			</div>
		 </div>
	  </div> 
	 </div>
   </div>
</div>
</body>
<style type="text/css">
	#sent_msg{
	  	text-align: right;
	  	font-size: 18px;
		margin-right: 30px;
		margin-left: 60%;	
		font-style: initial;
	    font-family: sans-serif;
		color:black;
		margin-top:20px;
		padding-left: 0px;
		background-color: #e6ffb4;
		border-radius: 50px;
		border-bottom-right-radius: 0px;
	  }
	  #received_msg{
	  	margin-right: 65%;	
	  	font-size: 18px;
		font-style: initial;
	    font-family: sans-serif;
		color: black;
		background-color: #eee;
		margin-top:20px;
		border-radius: 50px;
		border-top-left-radius: 0px;
	  }
	  .jumbotron{
		padding: 10px;
	  }
	  #time{
	  	font-size: 12px;
	  }
</style>
<?php
	include 'pdo.php';
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(empty($_SESSION['user'])){
		echo 'error occured';
	}
	else{	
			$from=$_SESSION['user'];
		    if(isset($_POST['msg'])&&!empty($_POST['msg'])){
			$stmt=$db->prepare("INSERT INTO chats(sender,receiver,message,time1,date1)
			VALUES (:sender,:receiver,:message,:time1,:date1)");
			$stmt->bindParam(':sender',$from);
			$stmt->bindParam(':receiver',$_SESSION['to']);
			$stmt->bindParam(':message',$_POST['msg']);
			date_default_timezone_set('Asia/Kolkata'); 
			$stmt->bindParam(':time1',date('h:i a'));
			$stmt->bindParam(':date1',date("d:M"));
			$stmt->execute();
		}
	}
		$to=$_SESSION['to'];
		$text="SELECT * FROM chats WHERE (sender='$from' AND receiver='$to')
		OR (receiver='$from' AND sender='$to')";
		//echo "<embed loop='false' src='tasty.mp3' hidden='true' autoplay='true'/>";
		foreach($db->query($text) as $row){ 
			if($row['sender']==$_SESSION['user']){
				echo '<div class="jumbotron" id="sent_msg">'.$row['message'].'&nbsp;&nbsp;&nbsp;<sub id="time">';
				if(date("d:M")==$row['date1']){
				echo $row['time1'].'</sub></div>';	
				}
				if(date("d:M")!=$row['date1']){
				echo $row['date1'].'</sub></div>';	
				}
			}
			else{
				echo '<div class="jumbotron" id="received_msg">'.$row['message'].'&nbsp;&nbsp;&nbsp;<sub id="time">';
				if(date("d:M")==$row['date1']){
				echo $row['time1'].'</sub></div>';	
				}
				if(date("d:M")!=$row['date1']){
				echo $row['date1'].'</sub></div>';	
				}	
			}
		}
?>
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
		
			$stmt=$db->prepare("INSERT INTO chats(sender,receiver,message)
			VALUES (:sender,:receiver,:message)");
			$stmt->bindParam(':sender',$from);
			$stmt->bindParam(':receiver',$_SESSION['to']);
			$stmt->bindParam(':message',$_SESSION['message']);
			$stmt->execute();
		}
		$to=$_SESSION['to'];
		$text="SELECT * FROM chats WHERE (sender='$from' AND receiver='$to')
		OR (receiver='$from' AND sender='$to')";
		foreach($db->query($text) as $row){ 
			echo '<p id="from">'.$row['sender'].' : </p>';
			echo '<p id="msg_text">'.$row['message'].'</p></br>';
		}
?>
<?php 
include 'pdo.php';
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(empty($_SESSION['user'])){
		echo 'error occured';
	}
	if(empty($_SESSION['to'])){
		echo 'error occured';
	}
	if(isset($_POST['follow'])&&!empty($_POST['follow'])){
		$user=$_SESSION['user'];
		$to=$_SESSION['to'];
		$stmt=$db->prepare("INSERT INTO followings (username,following) VALUES(:username,:following)");
		$stmt->bindParam(':username',$user);
		$stmt->bindParam(':following',$to);
		$stmt->execute();
		$stmt2=$db->prepare("INSERT INTO followers (username,follower) VALUES(:username,:follower)");
		$stmt2->bindParam(':username',$to);
		$stmt2->bindParam(':follower',$user);
		$stmt2->execute();		
	}
	if(isset($_POST['following'])&&!empty($_POST['following'])){
		$stmt=$db->prepare("DELETE FROM followings WHERE username=:user AND following=:following");
		$stmt->bindParam(':user',$_SESSION['user']);
		$stmt->bindParam(':following',$_POST['following']);
		$stmt->execute();
		$stmt2=$db->prepare("DELETE FROM followers WHERE username=:user AND follower=:follower");
		$stmt2->bindParam(':user',$_SESSION['user']);
		$stmt2->bindParam(':follower',$_POST['following']); 
		$stmt2->execute();	

	}if(isset($_POST['follow_btn'])){
		$user=$_SESSION['user'];
		$stmt=$db->prepare("INSERT INTO followings (username,following) VALUES(:username,:following)");
		$stmt->bindParam(':username',$user);
		$stmt->bindParam(':following',$_POST['follow_btn']);
		$stmt->execute();
		$stmt2=$db->prepare("INSERT INTO followers (username,follower) VALUES(:username,:follower)");
		$stmt2->bindParam(':username',$_POST['follow_btn']);
		$stmt2->bindParam(':follower',$user);
		$stmt2->execute();		
	}
	if(isset($_POST['following_btn'])){
		$stmt=$db->prepare("DELETE FROM followings WHERE username=:user AND following=:following");
		$stmt->bindParam(':user',$_SESSION['user']);
		$stmt->bindParam(':following',$_POST['following_btn']);
		$stmt->execute();
		$stmt2=$db->prepare("DELETE FROM followers WHERE username=:user AND follower=:follower");
		$stmt2->bindParam(':user',$_SESSION['user']);
		$stmt2->bindParam(':follower',$_POST['following_btn']);
		$stmt2->execute();		
	}
?>
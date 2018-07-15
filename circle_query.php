<?php
require 'pdo.php';
session_start();
	if($_POST['type']=='add'){
		$stmt=$db->prepare("INSERT INTO circle_mem (circle_id,member) VALUES(:circle_id,:member)");
			$stmt->bindParam(':circle_id',$_SESSION['circle_id']);
			$stmt->bindParam(':member',$_POST['member']);
			$stmt->execute();

		$stmt=$db->prepare("INSERT INTO notification (username,id,other_user,type) 
				VALUES(:username,:id,:other_user,:type)");
			$stmt->bindParam(':username',$_SESSION['user']);
			$stmt->bindParam(':id',$_SESSION['circle_id']);
			$stmt->bindParam(':other_user',$_POST['member']);
			$stmt->bindValue(':type','circle');
			$stmt->execute();

	}
	else if($_POST['type']=='remove'){
		$stmt=$db->prepare("DELETE FROM circle_mem WHERE circle_id=:circle_id AND member=:member");
			$stmt->bindParam(':circle_id',$_SESSION['circle_id']);
			$stmt->bindParam(':member',$_POST['member']);
			$stmt->execute();
	}
?>
<?php
	include 'pdo.php';
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	if(empty($_SESSION['user'])){
		echo 'error occured';
	}
	else{
		if(!empty($_POST['circle_dis'])){
			$stmt=$db->prepare("INSERT INTO discussions(username,discussions,code,circle_id,time1,date1) values(:username,:discussions,:code,:circle_id,:time1,:date1)");
			$stmt->bindParam(":username",$_SESSION['user']);
			$stmt->bindParam(":discussions",$_POST['circle_dis']);
			$stmt->bindParam(":code",$_POST['code']);
			$stmt->bindParam(":circle_id",$_POST['circle_id']);
			date_default_timezone_set('Asia/Kolkata');
			$stmt->bindValue(':time1',date('h:i a'));
			$stmt->bindValue(':date1',date("M d,Y"));
			$stmt->execute();

			$stmt=$db->prepare("SELECT * FROM discussions order by id desc");
            $stmt->execute();
            $val=$stmt->fetch();
            $id=$val['id'];
			$user=$_SESSION['user'];
			foreach($db->query("SELECT * FROM followings WHERE following='$user'") as $val){

			$stmt2=$db->prepare("INSERT INTO notification(username,id,other_user,type) values(:username,:id,:other_user,:type)");
			$stmt2->bindParam(":username",$val['username']);
			$stmt2->bindParam(":id",$id);
			$stmt2->bindValue(":type","discussion");
			$stmt2->bindParam(":other_user",$_SESSION['user']);
			$stmt2->execute();
		}
		}
		if(!empty($_POST['discussion'])){
			$stmt=$db->prepare("INSERT INTO discussions(username,discussions,code,time1,date1) values(:username,:discussions,:code,:time1,:date1)");
			$stmt->bindParam(":username",$_SESSION['user']);
			$stmt->bindParam(":discussions",$_POST['discussion']);
			$stmt->bindParam(":code",$_POST['code']);
			date_default_timezone_set('Asia/Kolkata');
			$stmt->bindValue(':time1',date('h:i a'));
			$stmt->bindValue(':date1',date("M d,Y"));
			$stmt->execute();

			$stmt=$db->prepare("SELECT * FROM discussions order by id desc");
            $stmt->execute();
            $val=$stmt->fetch();
            $id=$val['id'];
			$user=$_SESSION['user'];
			foreach($db->query("SELECT * FROM followings WHERE following='$user'") as $val){

			$stmt2=$db->prepare("INSERT INTO notification(username,id,other_user,type) values(:username,:id,:other_user,:type)");
			$stmt2->bindParam(":username",$val['username']);
			$stmt2->bindParam(":id",$id);
			$stmt2->bindValue(":type","discussion");
			$stmt2->bindParam(":other_user",$usr);
			$stmt2->execute();
		}
		}
		if(isset($_POST['comment'])&&isset($_POST['id'])&&!empty($_POST['comment'])&&!empty($_POST['id'])){
			$stmt=$db->prepare("INSERT INTO comment(username,discussion_id,message,code,date1)
			values(:username,:discussion_id,:message,:code,:date1)");
			$stmt->bindParam(":username",$_SESSION['user']);
			$stmt->bindParam(":discussion_id",$_POST['id']);
			$stmt->bindParam(":message",$_POST['comment']);
			$stmt->bindParam(":code",$_POST['code']);
			date_default_timezone_set('Asia/Kolkata');
			$stmt->bindParam(':date1',date("M d ,Y"));
			$stmt->execute();
			$id=$_POST['id'];
			$notifyto='';
			foreach($db->query("SELECT * FROM discussions WHERE id='$id'") as $val){
				$notifyto=$val['username'];
			}
			$stmt2=$db->prepare("INSERT INTO notification(username,id,other_user,type) values(:username,:id,:other_user,:type)");
			$stmt2->bindParam(":username",$notifyto);
			$stmt2->bindParam(":id",$id);
			$stmt2->bindParam(":other_user",$_SESSION['user']);
			$stmt2->bindValue(":type",'comment');
			$stmt2->execute();
		}
		if(isset($_POST['follow_id'])&&!empty($_POST['follow_id'])){
      			$stmt=$db->prepare("INSERT INTO following_post(username,discussion_id) VALUES(:username,:id)");
      			$stmt->bindParam(":username",$_SESSION['user']);
      			$stmt->bindParam(":id",$_POST['follow_id']);
      			$stmt->execute();
		}
		if(isset($_POST['following_id'])&&!empty($_POST['following_id'])){
      			$stmt=$db->prepare("DELETE FROM following_post WHERE username=:username AND discussion_id=:id");
      			$stmt->bindParam(":username",$_SESSION['user']);
      			$stmt->bindParam(":id",$_POST['following_id']);
      			$stmt->execute();
		}
		if(isset($_POST['add_watchlist'])&&!empty($_POST['add_watchlist'])){
      			$stmt=$db->prepare("INSERT INTO watchlist(username,discussion_id) VALUES(:username,:id)");
      			$stmt->bindParam(":username",$_SESSION['user']);
      			$stmt->bindParam(":id",$_POST['add_watchlist']);
      			$stmt->execute();
		}
		if(isset($_POST['remove_watchlist'])&&!empty($_POST['remove_watchlist'])){
      			$stmt=$db->prepare("DELETE FROM watchlist WHERE username=:username AND discussion_id=:id");
      			$stmt->bindParam(":username",$_SESSION['user']);
      			$stmt->bindParam(":id",$_POST['remove_watchlist']);
      			$stmt->execute();
		}
		if(isset($_POST['awesome'])&&!empty($_POST['awesome'])){
				
				$user = $_SESSION['user'];
				$id = $_POST['awesome'];

      			$stmt=$db->prepare("INSERT INTO awesome(username,comment_id) VALUES(:username,:id)");
      			$stmt->bindParam(":username",$user);
      			$stmt->bindParam(":id",$id);
      			$stmt->execute();

      			$stmt2=$db->prepare("UPDATE comment SET awesome=awesome+1 WHERE comment_id=:id");
      			$stmt2->bindParam(":id",$_POST['awesome']);
      			$stmt2->execute();

      			$discussion_id='0';
      			$comment_id=$_POST['awesome'];
                foreach ($db->query("SELECT discussion_id FROM comment WHERE comment_id='$comment_id'") as $key) {
                    $discussion_id=$key['discussion_id'];
                    break;
                }

	            $stmt=$db->prepare("SELECT * FROM comment WHERE comment_id=:id");
      			$stmt->bindParam(":id",$_POST['awesome']);
	            $stmt->execute();
	            $res=$stmt->fetch();
	            $notifyto=$res['username'];

	            $stmt2=$db->prepare("INSERT INTO notification(username,id,other_user,type) values(:username,:id,:other_user,:type)");
				$stmt2->bindParam(":username",$_SESSION['user']);
				$stmt2->bindParam(":id",$discussion_id);
				$stmt2->bindValue(":type","awesome");
				$stmt2->bindParam(":other_user",$notifyto);
				$stmt2->execute();

		}
		if(isset($_POST['thumbs_uped'])&&!empty($_POST['thumbs_uped'])){
      			$stmt=$db->prepare("DELETE FROM awesome WHERE username=:username AND comment_id=:id");
      			$stmt->bindParam(":username",$_SESSION['user']);
      			$stmt->bindParam(":id",$_POST['thumbs_uped']);
      			$stmt->execute();

      			$stmt2=$db->prepare("UPDATE comment SET awesome=awesome-1 WHERE comment_id=:id");
      			$stmt2->bindParam(":id",$_POST['thumbs_uped']);
      			$stmt2->execute();
		}
		if(isset($_POST['noti_seen'])){
			$stmt2=$db->prepare("UPDATE notification SET seen=1 WHERE username=:username");
      			$stmt2->bindParam(":username",$_SESSION['user']);
      			$stmt2->execute();
		}
		if(isset($_POST['msg_seen'])){
			$stmt2=$db->prepare("UPDATE chats SET seen=1 WHERE receiver=:username");
      			$stmt2->bindParam(":username",$_SESSION['user']);
      			$stmt2->execute();
		}
	}

<?php
  include 'user_header.php';
  include 'pdo.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$username=$_SESSION['user'];
if(isset($_POST['delete'])&&!empty($_POST['delete'])){
	$stmt=$db->prepare("DELETE FROM projects WHERE id=:id");
	$stmt->bindParam(":id",$_POST['delete']);
	$stmt->execute();
	}
?>
<html lang="en">
  <head>
  	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
     <script src="bootstrap/jquery.min.js"></script>
     <script src="my_profile_functions.js"></script>
      <script src="bootstrap/js/bootstrap.min.js"></script>
    <link href="my_profile_css.css" rel="stylesheet">
  </head>

  <body>
  	
  <div class="container-fluid">
    <div class="row" style="margin-top:90px;">
		<!---->
	  <div class="col-lg-2 col-md-2 col-sm-3 col-sm-offset-2 col-xs-12" style="text-align: center;margin-left: 2%;margin-bottom: 50px;">

			<div class="row w3-card w3-center ">
				<?php 
					$user=$_SESSION['user'];
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
				<a href="edit_profile.php" class="btn btn-default">edit Details</a>
				<br><br>
			</div>
			<br><br>
			<div class="row w3-card w3-item-block w3-padding-top">
					<button style="font-size: 18px;"  data-toggle="pill" href="#myposts" class="w3-button w3-block w3-theme-l1 w3-left-align">
						discussions<span class="w3-badge w3-right w3-blue">
							<?php
							 $user=$_SESSION['user'];
							 $count=0;
                			foreach($db->query("SELECT * FROM discussions WHERE username ='$user'") as $row){
                				$count=$count+1;
                			}
							echo $count; 
							?>
						</span></button>
					<button style="font-size: 18px;" data-toggle="pill" href="#followers" class="w3-button w3-block w3-theme-l1 w3-left-align">
						followers <span class="w3-badge w3-right w3-blue">
						<?php
						$stmt=$db->prepare("SELECT * from followers WHERE username=:username");
							$stmt->bindParam(':username',$username);
							$stmt->execute();
							$count=$stmt->rowCount();
						echo $count;?> 
						</span></button>
					<button style="font-size: 18px;" data-toggle="pill" href="#followings" class="w3-button w3-block w3-theme-l1 w3-left-align" >
						following <span class="w3-badge w3-right w3-blue">
						 <?php
							$stmt=$db->prepare("SELECT * from followings WHERE username=:username");
							$stmt->bindParam(':username',$username);
							$stmt->execute();
							$count=$stmt->rowCount();
							echo $count; ?>
						</span></button>
			</div>		
		</div>
	<div class="col-lg-7 col-md-7 col-sm-8 col-sm-offset-2 col-xs-12" style="margin-left: 2%;margin-right: 2%;">
		<div class="tab-content row">
		 	<div id="myposts" class="tab-pane fade in active">
   		 		<?php
                require 'pdo.php';
                $user=$_SESSION['user'];
                foreach($db->query("SELECT * FROM discussions WHERE username ='$user'") as $row){
                ?><div id="jumbotron" class="jumbotron"><?php
                echo '<a href="#" id="ques">'.$row['discussions'].'</a></br>';
                ?>
                  <div class="media-left">
                       <img 
							<?php 
							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$user);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>"
							 class="media-object img-circle" style="width:45px">
                  </div>
                  <div class="media-body">
                        <h4 class="media-heading" style="margin-top:10px;"><?php echo $row['username'];?> <small><i>Posted on <?php echo $row['date1']; ?></i></small></h4>
                  </div>
                <div class="btn-group btn-group-lg">
                  <a id="comment_btn" class="btn btn-default" href="#comment" data-toggle="collapse">comment</a>

                  <button onclick="follow_post()" id="follow_post_btn"
                  class="btn btn-default" value="<?php echo $row['id']; ?>">follow </button>

                  <button style="margin-right:10px;" onclick="unfollow();"
                  value="<?php echo $row['id']; ?>" id="following" class="btn btn-default"
                    >following</button>
                    <?php
                        $username=$_SESSION['user'];
                        $id=$row['id'];
                        $stmt=$db->prepare("SELECT * from following_post WHERE username=:username AND discussion_id=:id");
                        $stmt->bindParam(':username',$_SESSION['user']);
                        $stmt->bindValue(':id',$row['id']);
                        $stmt->execute();
                        $count=$stmt->rowCount();
                        if($count<=0){
                        ?>
                        <script type="text/javascript">
                        document.getElementById("follow_post_btn").style.display = 'block';
                        document.getElementById("following").style.display = 'none';
                      </script>
                        <?php } else { ?>
                        <script type="text/javascript">
                        document.getElementById("follow_post_btn").style.display = 'none';
                        document.getElementById("following").style.display = 'block';
                      </script>
                          <?php }
                  ?>
                  <!---  watchlist -->

                        <button value="<?php echo $row['id']; ?>" onclick="add_watchlist()"
                     class="btn btn-default" id="add_watchlist">
                    <span style="padding: 0px;  font-size: 25px;"
                    class="glyphicon glyphicon-heart-empty"></span></button>
                  <button  value="<?php echo $row['id']; ?>" onclick="remove_watchlist()"       class="btn btn-default" id="remove_watchlist"><span  style="padding: 0px; font-size: 25px;"
                    class="glyphicon glyphicon-heart"></span></button>
                    <?php
                      $stmt=$db->prepare("SELECT * from watchlist WHERE username=:username AND discussion_id=:id");
                      $stmt->bindParam(':username',$_SESSION['user']);
                      $stmt->bindValue(':id',$row['id']);
                      $stmt->execute();
                      $count=$stmt->rowCount();

                      if($count<=0){
                      ?>
                      <script type="text/javascript">
                        document.getElementById("add_watchlist").style.display = 'block';
                        document.getElementById("remove_watchlist").style.display = 'none';
                      </script>
                      <?php
                      }else{ ?>
                      <script type="text/javascript">
                          document.getElementById("add_watchlist").style.display = 'none';
                          document.getElementById("remove_watchlist").style.display = 'block';
                      </script>
                      <?php }
                    ?>
                  </div>
                  </div>
                <?php
                }?>
        	</div>
			<div id="followingPost" class="tab-pane fade">
				<?php $user=$_SESSION['user'];
				 foreach($db->query("SELECT * FROM following_post WHERE username ='$user'") as $row){
	            	$id=$row['discussion_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                ?><div id="jumbotron" class="jumbotron"><?php
		                echo '<a href="#" id="ques">'.$row['discussions'].'</a></br>';
		                ?>
		                  <div class="media-left">
		                       <img 
							<?php 
							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$user);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>" class="media-object img-circle" style="width:45px">
		                  </div>
		                  <div class="media-body">
		                        <h4 class="media-heading" style="margin-top:10px;"><?php echo $row['username'];?> <small><i>Posted on <?php echo $row['date1']; ?></i></small></h4>
		                  </div>
		                <div class="btn-group btn-group-lg">
		                  <a id="comment_btn" class="btn btn-default" href="#comment" data-toggle="collapse">comment</a>

		                  <button onclick="follow_post2()" id="follow_post_btn2"
		                  class="btn btn-default" value="<?php echo $row['id']; ?>">follow </button>

		                  <button style="margin-right:10px;" onclick="unfollow2();"
		                  value="<?php echo $row['id']; ?>" id="following2" class="btn btn-default"
		                    >following</button>
		                    <?php
		                        $username=$_SESSION['user'];
		                        $id=$row['id'];
		                        $stmt=$db->prepare("SELECT * from following_post WHERE username=:username AND discussion_id=:id");
		                        $stmt->bindParam(':username',$_SESSION['user']);
		                        $stmt->bindValue(':id',$row['id']);
		                        $stmt->execute();
		                        $count=$stmt->rowCount();
		                        if($count<=0){
		                        ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn2").style.display = 'block';
		                        document.getElementById("following2").style.display = 'none';
		                      </script>
		                        <?php } else { ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn2").style.display = 'none';
		                        document.getElementById("following2").style.display = 'block';
		                      </script>
		                          <?php }
		                  ?>
		                  <!---  watchlist -->

		                        <button value="<?php echo $row['id']; ?>" onclick="add_watchlist2()"
		                     class="btn btn-default" id="add_watchlist2">
		                    <span style="padding: 0px;  font-size: 25px;"
		                    class="glyphicon glyphicon-heart-empty"></span></button>
		                  <button  value="<?php echo $row['id']; ?>" onclick="remove_watchlist2()"       class="btn btn-default" id="remove_watchlist2"><span  style="padding: 0px; font-size: 25px;"
		                    class="glyphicon glyphicon-heart"></span></button>
		                    <?php
		                      $stmt=$db->prepare("SELECT * from watchlist WHERE username=:username AND discussion_id=:id");
		                      $stmt->bindParam(':username',$_SESSION['user']);
		                      $stmt->bindValue(':id',$row['id']);
		                      $stmt->execute();
		                      $count=$stmt->rowCount();

		                      if($count<=0){
		                      ?>
		                      <script type="text/javascript">
		                        document.getElementById("add_watchlist2").style.display = 'block';
		                        document.getElementById("remove_watchlist2").style.display = 'none';
		                      </script>
		                      <?php
		                      }else{ ?>
		                      <script type="text/javascript">
		                          document.getElementById("add_watchlist2").style.display = 'none';
		                          document.getElementById("remove_watchlist2").style.display = 'block';
		                      </script>
		                      <?php }
		                    ?>
		                  </div>
		                  </div>
		                <?php
		             }
	           		}
            	?>
			</div>
			<div id="watchlist" class="tab-pane fade">
				<?php $user=$_SESSION['user'];
				 foreach($db->query("SELECT * FROM watchlist WHERE username ='$user'") as $row){
	            	$id=$row['discussion_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                ?><div id="jumbotron" class="jumbotron"><?php
		                echo '<a href="#" id="ques">'.$row['discussions'].'</a></br>';
		                ?>
		                  <div class="media-left">
		                       <img 
							<?php 
							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$user);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>" class="media-object img-circle" style="width:45px">
		                  </div>
		                  <div class="media-body">
		                        <h4 class="media-heading" style="margin-top:10px;"><?php echo $row['username'];?> <small><i>Posted on <?php echo $row['date1']; ?></i></small></h4>
		                  </div>
		                <div class="btn-group btn-group-lg">
		                  <a id="comment_btn" class="btn btn-default" href="#comment" data-toggle="collapse">comment</a>

		                  <button onclick="follow_post2()" id="follow_post_btn3"
		                  class="btn btn-default" value="<?php echo $row['id']; ?>">follow </button>

		                  <button style="margin-right:10px;" onclick="unfollow2();"
		                  value="<?php echo $row['id']; ?>" id="following3" class="btn btn-default"
		                    >following</button>
		                    <?php
		                        $username=$_SESSION['user'];
		                        $id=$row['id'];
		                        $stmt=$db->prepare("SELECT * from following_post WHERE username=:username AND discussion_id=:id");
		                        $stmt->bindParam(':username',$_SESSION['user']);
		                        $stmt->bindValue(':id',$row['id']);
		                        $stmt->execute();
		                        $count=$stmt->rowCount();
		                        if($count<=0){
		                        ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn3").style.display = 'block';
		                        document.getElementById("following3").style.display = 'none';
		                      </script>
		                        <?php } else { ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn3").style.display = 'none';
		                        document.getElementById("following3").style.display = 'block';
		                      </script>
		                          <?php }
		                  ?>
		                  <!---  watchlist -->

		                        <button value="<?php echo $row['id']; ?>" onclick="add_watchlist3()"
		                     class="btn btn-default" id="add_watchlist3">
		                    <span style="padding: 0px;  font-size: 25px;"
		                    class="glyphicon glyphicon-heart-empty"></span></button>
		                  <button  value="<?php echo $row['id']; ?>" onclick="remove_watchlist3()"       class="btn btn-default" id="remove_watchlist3"><span  style="padding: 0px; font-size: 25px;"
		                    class="glyphicon glyphicon-heart"></span></button>
		                    <?php
		                      $stmt=$db->prepare("SELECT * from watchlist WHERE username=:username AND discussion_id=:id");
		                      $stmt->bindParam(':username',$_SESSION['user']);
		                      $stmt->bindValue(':id',$row['id']);
		                      $stmt->execute();
		                      $count=$stmt->rowCount();

		                      if($count<=0){
		                      ?>
		                      <script type="text/javascript">
		                        document.getElementById("add_watchlist3").style.display = 'block';
		                        document.getElementById("remove_watchlist3").style.display = 'none';
		                      </script>
		                      <?php
		                      }else{ ?>
		                      <script type="text/javascript">
		                          document.getElementById("add_watchlist3").style.display = 'none';
		                          document.getElementById("remove_watchlist3").style.display = 'block';
		                      </script>
		                      <?php }
		                    ?>
		                  </div>
		                  </div>
		                <?php
		             }
	           		}
            	?>
			</div>
			<div id="myans" class="tab-pane fade">
				<h3 class='page-header'><b>My Answers</b></h3>
				<?php
				 foreach($db->query("SELECT * FROM comment WHERE username ='$user'") as $row){
	            	$id=$row['comment_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                if($row['discussions']==''){
		                	echo "<h3 class='page-header'>You have not answered till yet</h3>";
		                }
		                ?>
					<div id="jumbotron" class="jumbotron"><?php
		                echo '<a href="#" id="ques">'.$row['discussions'].'</a></br>';
		                ?>
		                  <div class="media-left">
		                       <img 
							<?php 
							$user=$_SESSION['user'];
							$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
							$stmt->bindParam(":username",$user);
							$stmt->execute();
							$result=$stmt->fetch();
							$image=$result['picture'];
							?>
							src="<?php echo 'profile_pics/'.$image; ?>" class="media-object img-circle" style="width:45px">
		                  </div>
		                  <div class="media-body">
		                        <h4 class="media-heading" style="margin-top:10px;"><?php echo $row['username'];?> <small><i>Posted on <?php echo $row['date1']; ?></i></small></h4>
		                  </div>
		                <div class="btn-group btn-group-lg">
		                  <a id="comment_btn" class="btn btn-default" href="#comment" data-toggle="collapse">comment</a>

		                  <button onclick="follow_post4()" id="follow_post_btn4"
		                  class="btn btn-default" value="<?php echo $row['id']; ?>">follow </button>

		                  <button style="margin-right:10px;" onclick="unfollow4();"
		                  value="<?php echo $row['id']; ?>" id="following4" class="btn btn-default"
		                    >following</button>
		                    <?php
		                        $username=$_SESSION['user'];
		                        $id=$row['id'];
		                        $stmt=$db->prepare("SELECT * from following_post WHERE username=:username AND discussion_id=:id");
		                        $stmt->bindParam(':username',$_SESSION['user']);
		                        $stmt->bindValue(':id',$row['id']);
		                        $stmt->execute();
		                        $count=$stmt->rowCount();
		                        if($count<=0){
		                        ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn4").style.display = 'block';
		                        document.getElementById("following4").style.display = 'none';
		                      </script>
		                        <?php } else { ?>
		                        <script type="text/javascript">
		                        document.getElementById("follow_post_btn4").style.display = 'none';
		                        document.getElementById("following4").style.display = 'block';
		                      </script>
		                          <?php }
		                  ?>
		                  <!---  watchlist -->

		                  <button value="<?php echo $row['id']; ?>" onclick="add_watchlist4()"
		                     class="btn btn-default" id="add_watchlist4">
		                     <span style="padding: 0px;  font-size: 25px;"
		                     class="glyphicon glyphicon-heart-empty"></span></button>
		                  <button  value="<?php echo $row['id']; ?>" onclick="remove_watchlist4()" class="btn btn-default" id="remove_watchlist4"><span  style="padding: 0px; font-size: 25px;"
		                    class="glyphicon glyphicon-heart"></span></button>
		                    <?php
		                      $stmt=$db->prepare("SELECT * from watchlist WHERE username=:username AND discussion_id=:id");
		                      $stmt->bindParam(':username',$_SESSION['user']);
		                      $stmt->bindValue(':id',$row['id']);
		                      $stmt->execute();
		                      $count=$stmt->rowCount();

		                      if($count<=0){
		                      ?>
		                      <script type="text/javascript">
		                        document.getElementById("add_watchlist4").style.display = 'block';
		                        document.getElementById("remove_watchlist4").style.display = 'none';
		                      </script>
		                      <?php
		                      }else{ ?>
		                      <script type="text/javascript">
		                          document.getElementById("add_watchlist4").style.display = 'none';
		                          document.getElementById("remove_watchlist4").style.display = 'block';
		                      </script>
		                      <?php }
		                    ?>
		                </div>
		             </div>
		                  	<div style="margin-left: 50px;" class="row" id="comments">
								<?php
								$id=$row['id'];
								foreach($db->query("SELECT * FROM comment WHERE comment_id='$id'") as $comments){ ?>
								<div class="media">
								    <div class="media-left">
									        <img 
												<?php 
												$user=$_SESSION['user'];
												$stmt=$db->prepare("SELECT picture from users WHERE username=:username");
												$stmt->bindParam(":username",$user);
												$stmt->execute();
												$result=$stmt->fetch();
												$image=$result['picture'];
												?>
												src="<?php echo 'profile_pics/'.$image; ?>" class="media-object" style="width:45px">
								    </div>
								    <div class="media-body">
									        <h4 class="media-heading"><?php echo $comments['username'] ?><small><i> Posted on <?php echo $comments['date1']; ?></i></small></h4>
								    	    <p><?php echo $comments['message']; ?></p>
							    <!--awesome --> <a id="awesome" href=""> Awesome <i style="font-size: 														20px;" class="glyphicon glyphicon-thumbs-up"> </i></a>
								    	    <a id="thumbs_up" href=""> Awesome <i style="color:blue;font-size: 20px;" class="glyphicon glyphicon-thumbs-up"> </i></a>

								    </div>
								</div>
								<?php } ?>
							</div>
							<br>
		                <?php
		             }
	           		}
            	?>
			</div>
			<!-- NOT WORKING FOR XS-->
			<div id="myorder" class="tab-pane fade">
				<?php
					$user=$_SESSION['user'];
				 foreach($db->query("SELECT * FROM projects WHERE receiver ='$user'")
					as $rows){ ?>
					<div class="panel panel-info">
						<div class="panel-heading"><?php echo '<h4>'.$rows['title'].'</h4>'; ?>
						</div>
						<div class="panel-body">
							<?php echo '<h4>'.$rows['description'].'</h4>'; ?></br>
							<?php echo '<h4>'.$rows['additional'].'</h4>'; ?>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sd-4 hidden-xs">
									<b style="margin-left: 20px;font-size:16px;"><?php
									echo 'Price '.$rows['amount'].' '.$rows['currency']; ?></b>
								</div>
								<div class="col-lg-4 col-md-4 col-sd-4 hidden-xs">
									<b style="margin-left: 20px;"><?php
									echo '<button class="btn btn-default btn-block">Upload Project</button>' ?></b>
								</div>
								<div class="hidden-lg hidden-md col-sd-4 col-xs-4 ">
									<b style="margin-left: 5px;" ><?php
									echo $row['amount'].' '.$row['currency']; ?></b>
								</div>
								<div class="hidden-lg hidden-md hidden-sd col-xs-4 ">
									<b style="margin-left: 5px;" ><?php
									echo '<button class="btn btn-default btn-block">Upload Project</button>' ?></b>
								</div>
							</div>
						</div>
					 </div><?php
				  } ?>
			</div>
			<div id="projects" class="tab-pane fade">
			</div>
			<div id="followers" class="tab-pane fade">
				<h4><b>Followers</b></h4>
				 <table class="table">
                      <tbody>
                          <?php
                      require 'pdo.php';
                      $stmt=$db->prepare("SELECT * FROM followers WHERE username =:username");
                      $stmt->bindParam(":username",$username);
                      $stmt->execute();
                      $z=0;
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                        	$z=$z+1;
                          echo '<tr>';
                          $name=$row['follower'];
                          $stmt2=$db->prepare("SELECT * FROM users WHERE username=:name");
                          $stmt2->bindParam(":name",$name);
                          $stmt2->execute();
                          $res=$stmt2->fetch();
                          $image=$res['picture'];
                          if(empty($image)){
                          	$image="default.jpg";
                          }
                          echo "<td><img src=profile_pics/".$image." style='border-radius:4px;' class='img-responsive' height='60' width='60' > </td>";
                          $name=$row['follower'];
                          $stmt3=$db->prepare("SELECT * FROM users WHERE username=:username");
                          $stmt3->bindParam(":username",$name);
                          $stmt3->execute();
                          $res=$stmt3->fetch();
                          $fullname=$res['fullname'];
                          echo '<td><h4>'.$fullname.' </h4>( '.$row['follower'].' )</td>'; 
                       ?>
                        <td><script type="text/javascript">
							function following2(clicked_id)
							{
								var b=clicked_id.slice(5);
								var	msg1=document.getElementById(clicked_id).value;
								document.getElementById(clicked_id).style.display = 'none';
								document.getElementById("folln"+b).style.display = 'block';
									$.post("follow.php", {
									follow_btn:msg1
									});
							}
							function follow2(clicked_id)
							{
									var b=clicked_id.slice(5);
									var	msg1=document.getElementById(clicked_id).value;
									document.getElementById("follw"+b).style.display = 'block';
									document.getElementById(clicked_id).style.display = 'none';
									$.post("follow.php", {
									following_btn: msg1
									});
							}
						</script>
                          	<button onclick="following2(this.id)" id="<?php echo 'follw'.$z ; ?>" class="btn btn-primary" 
                          	value="<?php echo $row['follower']; ?>" style="font-size: 18px;">follow </button>

							<button style="margin-right:10px;font-size: 18px;" value="<?php echo $row['follower']; ?>" id="<?php echo 'folln'.$z ; ?>" 
								onclick="follow2(this.id);" class="btn btn-default" >following</button>
								<?php
								$stmt3=$db->prepare("SELECT * FROM followings WHERE username=:username AND following=:following");
								$stmt3->bindParam(":username",$_SESSION['user']);
								$stmt3->bindParam(":following",$row['follower']);
								$stmt3->execute();
								$res=$stmt3->fetch();
								if(empty($res)){
									?>
									<script type="text/javascript">
										document.getElementById("follw"+<?php echo $z; ?>).style.display = 'block';
										document.getElementById("folln"+<?php echo $z; ?>).style.display = 'none';
									</script>
									<?php
								}
								else{
									?>
									<script type="text/javascript">
										document.getElementById("follw"+<?php echo $z; ?>).style.display = 'none';
										document.getElementById("folln"+<?php echo $z; ?>).style.display = 'block';
									</script>
									<?php
								}
							?>
                          </td>
                          </tr>
                        <?php } ?>
                    </tbody>
                </table>
			</div>
			<div id="followings" class="tab-pane fade">
				<h4><b>Following</b></h4>
				 <table class="table">

                      <tbody>
                          <?php
                      require 'pdo.php';
                      $stmt=$db->prepare("SELECT * FROM followings WHERE username =:username");
                      $stmt->bindParam(":username",$username);
                      $stmt->execute();
                      $a=0;
                        while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                        	$a=$a+1;
                          echo '<tr>';
                          $name=$row['following'];
                          $stmt2=$db->prepare("SELECT * FROM users WHERE username=:name");
                          $stmt2->bindParam(":name",$name);
                          $stmt2->execute();
                          $res=$stmt2->fetch();
                          $image=$res['picture'];
                          if(empty($image)){
                          	$image="default.jpg";
                          }
                          echo "<td><img src=profile_pics/".$image." style='border-radius:4px;' class='img-responsive' height='60' width='60' > </td>";
                          $name=$row['following'];
                          $stmt3=$db->prepare("SELECT * FROM users WHERE username=:username");
                          $stmt3->bindParam(":username",$name);
                          $stmt3->execute();
                          $res=$stmt3->fetch();
                          $fullname=$res['fullname'];
                          echo '<td><h4>'.$fullname.' </h4>( '.$row['following'].' )</td>';
                          ?>
                          <td><script type="text/javascript">
							function following(clicked_id)
							{
								var b=clicked_id.slice(4);
								var	msg1=document.getElementById(clicked_id).value;
								document.getElementById(clicked_id).style.display = 'none';
								document.getElementById("foln"+b).style.display = 'block';
									$.post("follow.php", {
									follow_btn:msg1
									});
							}
							function follow(clicked_id)
							{
							var b=clicked_id.slice(4);
							var	msg1=document.getElementById(clicked_id).value;
							document.getElementById("folw"+b).style.display = 'block';
							document.getElementById(clicked_id).style.display = 'none';
									$.post("follow.php", {
									following_btn: msg1
									});
							}
						</script>
                          	<button onclick="following(this.id)" style="display: none;font-size: 18px;" id="<?php echo 'folw'.$a ; ?>" class="btn btn-default w3-blue" 
                          	value="<?php echo $row['following']; ?>">follow </button>

							<button style="margin-right:10px;font-size: 18px;" value="<?php echo $row['following']; ?>" id="<?php echo 'foln'.$a ; ?>" 
								onclick="follow(this.id);" class="btn btn-default" >following</button>
                          </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
			</div>
			<!-- NOT WORKING -->
			<div id="completed" class="tab-pane fade">
					<?php
			 foreach($db->query("SELECT * FROM projects WHERE iscompleted='1' AND status='0'") as $row){
	           if(empty($row['title'])){
	             echo "<h4>You have not completed any project</h4>";
	           }
	           else{
	           ?>
					<div class="panel panel-info">
						<div class="panel-heading"><?php echo '<h4>'.$row['title'].'</h4>'; ?>
						</div>
						<div class="panel-body">
							<?php echo '<h4>'.$row['description'].'</h4>'; ?></br>
							<?php echo '<h4>'.$row['additional'].'</h4>'; ?>
						</div>
						<div class="panel-footer">
							<div class="row">
								<div class="col-lg-4 col-md-4 col-sd-4 hidden-xs">
									<b style="font-size:16px;"><?php
									echo 'Price '.$row['amount'].' '.$row['currency'].' received'; ?></b>
								</div>
								<div class="hidden-lg hidden-md col-sd-4 col-xs-4 ">
									<b style="" ><?php
									echo $row['amount'].' '.$row['currency'].' received'; ?></b>
								</div>
							</div>
						</div>
					 </div><?php
            	
				  }
				  } ?>
			</div>
		</div>
	</div>
		<div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 w3-card ">
			<h4 class="hidden-md hidden-lg hidden-sd">Find Your details</h4>
			<button class="w3-button w3-block" data-toggle="pill" href="#myposts">My Posts</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#followingPost">Following Post</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#watchlist">My Watchlist</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#myans">My Answers</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#projects">My Projects</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#myorder">My Orders</button>
			<button class="w3-button w3-block" data-toggle="pill" href="#completed">Completed Projects</button>
	</div>
  </div>
</div>
</body>
</html>
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
  </head>
<style type="text/css">
		#upload_btn,#upload_btn:hover,#upload_btn:active{
			border-radius: 4px;
			box-shadow: 0 0 black;
		}
	  	#foll{
		color: #fff;
	    height: 38px;
	    font-size: 16px;
	    width: 80px;
	    background-color: #337ab7;
	    border-color: #4f8dc3;
		}
		#edit_profile{
	  	  margin-top:20px;
		  font-family: unset;
		}
		#edit_profile:hover{
	  	  margin-top:20px;
		  background-color:white;
		  font-family: unset;
		  box-shadow: 0 0 black;
		}
		#edit_profile:active{
	  	  margin-top:20px;
	  	  box-shadow: 0 0 black;
		  background-color:white;
		  color:gray;
		  border:1px solid gray;
		  font-family: unset;
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
	  .nav-pills>li>a{
		font-size: 18px;
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
		#posted_by{
			margin-top: 6px;
			font-size: 14px;
		}
		#follow_post_btn,#follow_post_btn2,#follow_post_btn3,#follow_post_btn4,#following
		,#following2,#following3,#following4{
			margin-right:10px;
		    border-radius: 4px;
			line-height: 10px;
			background-color: #ccc;
		}
		#open_post{
			margin-left: 60px;
			margin-right: 10px;
			line-height: 10px;
			box-shadow: 0 0 gray;
			border-radius: 4px;
			background-color: #eee;
		}
		#add_watchlist,#add_watchlist2,#add_watchlist3,#add_watchlist4,#remove_watchlist
		,#remove_watchlist2,#remove_watchlist3,#remove_watchlist4{
			height:30px;
			padding:0px;
			padding-left: 5px;
			padding-right: 5px;,
			border-radius: 4px;
		}
		#textarea{
			box-shadow: 0 0 black;
			border-radius: 0px;
			margin:0px;
			padding:0px;
			font-size: 16px;
		}
		#code_snippet{
			background-color: white;
			border-color: white;
			box-shadow: 0 0 white;
			border-width: 0px;
		}
		#code_textarea{
			font-family: monospace;
			background-color: #eee;
			border:0;
			outline: 0;
		}
		a {
			color:black;
			text-decoration: none;
		}
		#ques{
		font-size: 20px;
		font-weight: bold;
		font-family: sans-serif;
		color: black;	
		}
		#jumbotron{
		padding-right: 60px;
		padding: 10px;
		padding-left: 60px;
		}
		#btn_list{
			font-size: 16px;
			font--weight:600px;
		}
  </style>
<script type="text/javascript">
	    var code='';
		function add_bold() {
			$('#textarea').append(' **Bold**');
  		}
		function add_list(){
			$('#textarea').append(' -List_Item-');
		}
  		function add_italic(){
  			$('#textarea').append(' *Italic*');
  		}
		function add_code_btn(){
				code=document.getElementById('code_textarea').value;
				document.getElementById("notification").innerHTML="Code Added";
        		$('#notification').show();
		}
  		function preview(){
  			var myString=document.getElementById('textarea').value;
  			var a=myString.replace(/<[^>]*>/g,'');
			for (i = 0; i < a.length; i++) { 
				a=a.replace("**", "<b>");
  				a=a.replace("** ", "</b> ");
			}
			for (i = 0; i < a.length; i++) { 
				a=a.replace("*", "<i>");
				a=a.replace("* ", "</i> ");
			}
			for (i = 0; i < a.length; i++) { 
				a=a.replace("-", "<li>");
  				a=a.replace("-", "</li> ");
			}
			if(code!=''){
				$('pre').show();
			}
			document.getElementById("text_code").innerHTML=a;
			document.getElementById("code").innerHTML=code;
			document.getElementById("demo").innerHTML=a;
  		}
      	function add_comment(){
			$('#notification').hide();
      		var myString=document.getElementById('textarea').value;
  			var a=myString.replace(/<[^>]*>/g,'');
				for (i = 0; i < a.length; i++) { 
					a=a.replace("**", "<b>");
  					a=a.replace("** ", "</b> ");
				}
				for (i = 0; i < a.length; i++) { 
					a=a.replace("*", "<i>");
					a=a.replace("* ", "</i> ");
				}
				for (i = 0; i < a.length; i++) { 
					a=a.replace("-", "<li>");
  					a=a.replace("-", "</li> ");
				}
      		var id2=$('#comment_post').val();   		
      			$.post("home2.php",{
      				comment: a,
					code:code,
      				id: id2
      			});
      			document.getElementById('textarea').value ='';
      			var xhttp = new XMLHttpRequest();
				xhttp.open("POST", "home2.php", true);
				xhttp.send();
			//$('#comments').load('home.php' +  ' #comments');
			$('body').load('home.php');
      	}
		function post() {
      			var text=$('#post_text').val();
      			$.post("home2.php",{
      				msg: text
      			});
      			document.getElementById('post_text').value ='';
      			var xhttp = new XMLHttpRequest();
				xhttp.open("POST", "home2.php", true);
				xhttp.send();
      		}
      	function follow_post(){
      			document.getElementById("following").style.display = 'block';
				document.getElementById("follow_post_btn").style.display = 'none';
      			var id=$('#follow_post_btn').val();
      			$.post("home2.php",{
      				follow_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
      	function follow_post2(){
      			document.getElementById("following2").style.display = 'block';
				document.getElementById("follow_post_btn2").style.display = 'none';
      			var id=$('#follow_post_btn2').val();
      			$.post("home2.php",{
      				follow_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
      	function follow_post3(){
      			document.getElementById("following3").style.display = 'block';
				document.getElementById("follow_post_btn3").style.display = 'none';
      			var id=$('#follow_post_btn3').val();
      			$.post("home2.php",{
      				follow_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
          function follow_post4(){
            document.getElementById("following4").style.display = 'block';
        document.getElementById("follow_post_btn4").style.display = 'none';
            var id=$('#follow_post_btn4').val();
            $.post("home2.php",{
              follow_id: id
            });
            var xhttps = new XMLHttpRequest();
        xhttps.open("POST", "home2.php", true);
        xhttps.send();
          }
        function unfollow(){
        		document.getElementById("follow_post_btn").style.display = 'block';
				document.getElementById("following").style.display = 'none';
      			var id=$('#following').val();
      			$.post("home2.php",{
      				following_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
      	function unfollow2(){
        		document.getElementById("follow_post_btn2").style.display = 'block';
				document.getElementById("following2").style.display = 'none';
      			var id=$('#following2').val();
      			$.post("home2.php",{
      				following_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
      	function unfollow3(){
        		document.getElementById("follow_post_btn3").style.display = 'block';
				document.getElementById("following3").style.display = 'none';
      			var id=$('#following3').val();
      			$.post("home2.php",{
      				following_id: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      		}
          function unfollow4(){
            document.getElementById("follow_post_btn4").style.display = 'block';
        document.getElementById("following4").style.display = 'none';
            var id=$('#following4').val();
            $.post("home2.php",{
              following_id: id
            });
            var xhttps = new XMLHttpRequest();
        xhttps.open("POST", "home2.php", true);
        xhttps.send();
          }
      	function add_watchlist(){
	      		document.getElementById("add_watchlist").style.display = 'none';
				document.getElementById("remove_watchlist").style.display = 'block';
				var id=$('#add_watchlist').val();
      			$.post("home2.php",{
      				add_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
      	function add_watchlist2(){
	      		document.getElementById("add_watchlist2").style.display = 'none';
				document.getElementById("remove_watchlist2").style.display = 'block';
				var id=$('#add_watchlist2').val();
      			$.post("home2.php",{
      				add_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
      	function add_watchlist3(){
	      		document.getElementById("add_watchlist3").style.display = 'none';
				document.getElementById("remove_watchlist3").style.display = 'block';
				var id=$('#add_watchlist3').val();
      			$.post("home2.php",{
      				add_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
        function add_watchlist4(){
            document.getElementById("add_watchlist4").style.display = 'none';
        document.getElementById("remove_watchlist4").style.display = 'block';
        var id=$('#add_watchlist4').val();
            $.post("home2.php",{
              add_watchlist: id
            });
            var xhttps = new XMLHttpRequest();
        xhttps.open("POST", "home2.php", true);
        xhttps.send();
        }
      	function remove_watchlist(){
	      		document.getElementById("add_watchlist").style.display = 'block';
				document.getElementById("remove_watchlist").style.display = 'none';
				var id=$('#remove_watchlist').val();
      			$.post("home2.php",{
      				remove_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
      	function remove_watchlist2(){
	      		document.getElementById("add_watchlist2").style.display = 'block';
				document.getElementById("remove_watchlist2").style.display = 'none';
				var id=$('#remove_watchlist2').val();
      			$.post("home2.php",{
      				remove_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
      	function remove_watchlist3(){
	      		document.getElementById("add_watchlist3").style.display = 'block';
				document.getElementById("remove_watchlist3").style.display = 'none';
				var id=$('#remove_watchlist3').val();
      			$.post("home2.php",{
      				remove_watchlist: id
      			});
      			var xhttps = new XMLHttpRequest();
				xhttps.open("POST", "home2.php", true);
				xhttps.send();
      	}
        function remove_watchlist4(){
            document.getElementById("add_watchlist4").style.display = 'block';
        document.getElementById("remove_watchlist4").style.display = 'none';
        var id=$('#remove_watchlist4').val();
            $.post("home2.php",{
              remove_watchlist: id
            });
            var xhttps = new XMLHttpRequest();
        xhttps.open("POST", "home2.php", true);
        xhttps.send();
        }
</script>
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
					<button style="font-size: 18px;"  data-toggle="pill" href="#mycircle" class="w3-button w3-block w3-theme-l1 w3-left-align">
						Circles<span class="w3-badge w3-right w3-blue">
							<?php
							 $user=$_SESSION['user'];
							 $count=0;
                			foreach($db->query("SELECT * FROM circle_list WHERE creater ='$user'") as $row){
                				$count=$count+1;
                			}
                			foreach($db->query("SELECT * FROM circle_mem WHERE member ='$user'") as $row){
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
		 		<h3 class='page-header'><b>My Discussions</b></h3>
   		 		<?php
   		 		$myposts=0;
                require 'pdo.php';
                $user=$_SESSION['user'];
                foreach($db->query("SELECT * FROM discussions WHERE username ='$user'") as $row){
                	$myposts=$myposts+1;








                ?><div id="jumbotron" class="jumbotron w3-card" style="background-color: white;"><?php
                $ids=$row['id'];
                ?>
                <a id="ques" href="<?php echo 'posts.php?post_id='.$ids; ?>"><?php echo $row['discussions']; ?></a>
                	<pre><?php echo $row['code']; ?></pre>
            		</br>
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
                <div class="btn-group btn-group-lg" style="margin-top: 10px;">
		          <a style="margin-right: 10px;line-height: 10px;box-shadow: 0 0 gray;border-radius: 4px;
				background-color: #eee;" class="btn btn-default" href="<?php echo 'posts.php?post_id='.$ids; ?>">Open</a>

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
        	<?php 
        	if($myposts==0){
        		echo "<h4>No discussions</h4>";
        	}?>
        	</div>
			<div id="followingPost" class="tab-pane fade">
				<h3 class='page-header'><b>Following Posts</b></h3>
				<?php $user=$_SESSION['user'];
				$followingPost=0;
				 foreach($db->query("SELECT * FROM following_post WHERE username ='$user'") as $row){
				 	$followingPost=$followingPost+1;
	            	$id=$row['discussion_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                ?><div id="jumbotron" class="jumbotron w3-card" style="background-color: white;">
		                <a href="<?php echo 'posts.php?post_id='.$row['id']; ?>" id="ques">
		                	<?php echo $row['discussions']; ?></a></br>
		                	<pre><?php echo $row['code']; ?></pre>
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
		                <div class="btn-group btn-group-lg" style="margin-top: 10px;">
		          			<a style="margin-right: 10px;line-height: 10px;box-shadow: 0 0 gray;border-radius: 4px;background-color: #eee;" class="btn btn-default" 
		          			href="<?php echo 'posts.php?post_id='.$ids; ?>">Open</a>

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
            	if($followingPost==0){
            		echo "<h4>no following posts</h4>";
            	}
            	?>
			</div>
			<div id="watchlist" class="tab-pane fade">
				<h3 class='page-header'><b>My Watchlist</b></h3>
				<?php $user=$_SESSION['user'];
				$watchlist=0;
				 foreach($db->query("SELECT * FROM watchlist WHERE username ='$user'") as $row){
				 	$watchlist=$watchlist+1;
	            	$id=$row['discussion_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                ?><div id="jumbotron" class="jumbotron w3-card" style="background-color: white;">
		                <a href="<?php echo 'posts.php?post_id='.$row['id']; ?>" id="ques">
		                	<?php echo $row['discussions']; ?></a>
		                <pre><?php echo $row['code']; ?></pre>
		            	</br>
		                
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
		                <div class="btn-group btn-group-lg" style="margin-top: 10px;">
		          			<a style="margin-right: 10px;line-height: 10px;box-shadow: 0 0 gray;border-radius: 4px;background-color: #eee;" class="btn btn-default" 
		          				href="<?php echo 'posts.php?post_id='.$ids; ?>">Open</a>

		                  	
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
            	if($watchlist==0){
            		echo "<h4>No posts in watchlist</h4>";
            	}?>
			</div>
			<div id="myans" class="tab-pane fade">
				<h3 class='page-header'><b>My Answers</b></h3>
				<?php
				$myans=0;
				 foreach($db->query("SELECT DISTINCT discussion_id FROM comment WHERE username ='$user'") as $row){
				 	$myans=$myans+1;
	            	$id=$row['discussion_id'];
					  foreach($db->query("SELECT * FROM discussions WHERE id ='$id'") as $row){
		                if($row['discussions']==''){
		                	echo "<h3 class='page-header'>You have not answered till yet</h3>";
		                }
		                ?>
					<div id="jumbotron" class="jumbotron w3-card" style="background-color: white;">
						<a href="<?php echo 'posts.php?post_id='.$row['id']; ?>" id="ques">
		                	<?php echo $row['discussions']; ?></a>
		                <pre><?php echo $row['code']; ?></pre>
		           	 </br>
		                
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
		                <div class="btn-group btn-group-lg" style="margin-top: 10px;">
		          			<a style="margin-right: 10px;line-height: 10px;box-shadow: 0 0 gray;border-radius: 4px;background-color: #eee;" class="btn btn-default" href="<?php echo 'posts.php?post_id='.$ids; ?>">Open</a>
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
            	if($myans==0){
            		echo "<h4>No answers</h4>";
            	}?>
			</div>
			<div id="projects" class="tab-pane fade">
				<?php
				$username=$_SESSION['user'];
				$projects_no=0;
				foreach($db->query("SELECT * FROM projects WHERE username='$username'") as $row){ 
					$projects_no=$projects_no+1;
				?>
				<div class="w3-card-4">
                  <header class="w3-container w3-light-grey">
                    <h2 style=""><?php echo '<h4>'.$row['title'].'</h4>'; ?></h2>
                  </header>
                  	<div class="w3-container">     
                    	<h5><?php echo $row['description']; ?></br></h5>
                    	<h5><?php echo $row['additional']; ?></h5>
						<h4 style="font-size: 16px;  font-family: sans-serif;"><?php echo 'Price '.$row['amount'].' '.$row['currency']; ?></h4>
                    	<div class="row btn btn-group">
						  <form id="project_form" action="receiver_profile.php" method="post" class="form-inline">

								<button style="border-radius: 4px;" type="submit" id="btn_list" class="w3-button w3-light-grey"  name="edit" value="<?php echo $row['id'] ?>">Edit details</button>

								<button style="border-radius: 4px;" type="submit" id="btn_list" class="w3-button w3-light-grey" name="delete" value="<?php echo $row['id'] ?>">Delete</button>

						   </form>
						</div>
                	</div>
                </div>
                <br>
                <?php }
                if($projects_no==0){
                	echo "<h4>No projects posted </h4>";
                }?>
			</div>
			<div id="myorder" class="tab-pane fade">
				<?php
					$user=$_SESSION['user'];
					$n=0;
				 foreach($db->query("SELECT * FROM projects WHERE receiver ='$user' AND iscompleted=0")
					as $row){ 
						$n=$n+1;?>
				<div class="w3-card-4" style="margin-bottom:20px;">
                  <header class="w3-container w3-light-grey">
                    <h2 style=""><?php echo '<h4>'.$row['title'].'</h4>'; ?></h2>
                  </header>
                  	<div class="w3-container">     
                    	<h5><?php echo $row['description']; ?></br></h5>
                    	<h5><?php echo $row['additional']; ?></h5>
						<h4 style="font-size: 16px;  font-family: sans-serif;"><?php echo 'Price '.$row['amount'].' '.$row['currency']; ?></h4>
							<button id="upload_btn" class="w3-button w3-light-grey w3-click-light-grey" data-toggle="modal"	href="<?php echo '#upload_file'.$n;?>" >+ Upload Files</button>	

						<div class="modal" id="<?php echo 'upload_file'.$n;?>" tab-index=-1 data-backdrop="static">
						<div class="modal-dialog modal-md">
							<div class="modal-content modal-body" style="margin-top: 200px;">
								<form action="update.php" method="post" enctype="multipart/form-data">
									<h4>Upload the project files (*.zip file only)</h4>
										<!--  project uploading -->          	
									<input required type="file" name="file">
									<br>
									<button style="box-shadow: 0 0 black;font-size: 16px;" data-dismiss="modal" class="btn btn-default">Cancel</button>
									<button style="border-color: white;" value="<?php echo $row['id']; ?>" type="submit" 
										name="upload_file" class="btn btn-default w3-blue">Upload</button>
								</form>
							</div>
						</div>
					</div>
                	</div>
                </div>
					<?php
				  }if($n==0){
				  	echo "<h4>No orders till now</h4>";
				  } ?>
			</div>
			<div id="completed" class="tab-pane fade">
				<?php
				$receiver=$_SESSION['user'];
				$n=0;
				foreach($db->query("SELECT * FROM projects WHERE iscompleted='1' AND receiver='$receiver'") as $row){
					$n=$n+1;
			        if(empty($row['title'])){
		             echo "<h4>no completion till now</h4>";
		           	}
		           else{
		           ?>
	           <div class="w3-card-4" style="margin-bottom:20px;">
                  <header class="w3-container w3-light-grey">
                    <h2 style=""><?php echo '<h4>'.$row['title'].'</h4>'; ?></h2>
                  </header>
                  	<div class="w3-container">     
                    	<h5><?php echo $row['description']; ?></br></h5>
                    	<h5><?php echo $row['additional']; ?></h5>
						<h4 style="font-size: 16px;  font-family: sans-serif;"><?php echo 'Price '.$row['amount'].' '.$row['currency']; ?></h4>
                	</div>
                </div>
					<?php
				  	}
				  }
				  if($n==0){
				  	echo "<h4> You have not completed any project till now</h4>";
				  } ?>
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
                          	<button onclick="following2(this.id)" id="<?php echo 'follw'.$z ; ?>" class="btn btn-default w3-blue" 
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
                <?php if($z==0){
                	echo "<h4>No followers</h4>";
                }?>
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
                    <?php if($a==0){
                	echo "<h4>No followings</h4>";
                }?>
			</div>
			<div id="mycircle" class="tab-pane fade">
				  	<h4><b>Circles</b></h4>
				  <table class="table">
					 <thead>
				      <tr>
				        <th></th>
				        <th><h4><b>Circle Type</b></h4></th>
				      </tr>
				    </thead>
				<?php 
					$username=$_SESSION['user'];
					$y=0;
					foreach($db->query("SELECT * FROM circle_list WHERE creater='$username'") as $row){
						$y=$y+1;
					$circle_id=$row['id'];
					?>		
					<h4>
						 <tr>
					        <td><h4><a href="<?php echo 'circle_feed2.php?circle_id='.$circle_id; ?>"
					        	style="font-size: 18px;"><i class="fa fa-users" style="color:blue;font-size:28px;"></i>
					        	<?php echo $row['name'];?></a></h4></td>
					        <td><h4 style="margin-top:20px;"><?php echo $row['type'];?></h4></td>
					        <td>
						 </tr>
					</h4>

					<?php
					}
					foreach($db->query("SELECT * FROM circle_mem WHERE member='$username'") as $row){
						$id=$row['circle_id'];
						$stmt=$db->prepare("SELECT * FROM circle_list WHERE id=:id");
						$stmt->bindParam(":id",$id);
						$stmt->execute();
						$row=$stmt->fetch();
						?>
						<h4><i class="fa fa-users" style="color:blue;font-size:28px;"></i>
							<a href="<?php echo 'circle_feed2.php?circle_id='.$circle_id; ?>"><?php echo ' '.$row['name']; ?></a>
						</h4>
					<?php
						}
					?>
					</table>
					<?php if($y==0){
                	echo "<h4>No circles</h4>";
                }?>
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
<div class="container-fluid" style="background-color: #8d9093;height:70px;text-align: center;">
	<h4 style="color: black;margin-top:20px;"> © Copyright 2018,All rights reserved</h4>
	</div>
</body>
</html>
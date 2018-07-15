<?php
require 'pdo.php';
include 'user_header.php';
?>
<style>
		#circle_btn,#circle_btn:hover{
			border-radius:4px;
			background-color: blue;
		}
		#comment_btn{
			margin-left: 60px;
			margin-right: 10px;
			line-height: 10px;
			box-shadow: 0 0 gray;
			border-radius: 4px;
			background-color: #eee;
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
			font-family: Menlo,Monaco,Consolas,"Courier New",monospace;
			background-color: #eee;
			border:0;
			outline: 0;
		}
		a {
			color:black;
			text-decoration: none;
		}
		.btn-default{
			color: #333;
			font-family: sans-serif;
			font-size: 18px;
			background-color: #eee;
			border-color: #ccc;
		}
		.btn-primary {
			font-family: sans-serif;
			font-size: 18px;
		}
		#text_code{
			font-size: 15px;
		}
		.panel-header a:hover{
			color:green;
		}
		#post_text{
			font-size: 20px;
		font-family: sans-serif;
		font-weight: bold;
		}
		#jumbotron{
		background-color: white;
		padding-right: 10px;
		padding: 10px;
		padding-left: 10px;
		margin-left: 0px;
		margin-right: 0px;
		}
		#ques{
		font-size: 20px;
		font-weight: bold;
		font-family: sans-serif;
		color: black;
		}
		#posted_by{
			margin-top: 6px;
			font-size: 14px;
		}
		.fa {
		    font-size: 25px;
		    cursor: pointer;
		    user-select: none;
		}
</style>
<body>
<script type="text/javascript">
		function add_bold1() {
			var val=$('#post_text').val();
			document.getElementById('post_text').value=val+' **Bold**';
  		}
		function add_list1(){
			var val=$('#post_text').val();
			document.getElementById('post_text').value=val+' -List_Item-';
		}
  		function add_italic1(){
			var val=$('#post_text').val();
			document.getElementById('post_text').value=val+' *Italic*';
  		}
		function add_code_btn1(){
				document.getElementById("notification").innerHTML="Code Added";
        		$('#notification').show();
		}
  		function previews(){
  			var myString=document.getElementById('post_text').value;
  			var a=myString.replace(/<[^>]*>/g,'');
  			var code=document.getElementById('code_textarea').value;
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
			document.getElementById("text_codes").innerHTML=a;
			document.getElementById("codes").innerHTML=code;
  		}
      	function add_post(id){
			$('#notification').hide();
      		var myString=document.getElementById('post_text').value;
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
				var code1=document.getElementById('code_textarea').value;
      			$.post("home2.php",{
      				circle_dis: a,
					code:code1,
					circle_id:id
      			});
      			document.getElementById('post_text').value ='';
      			var xhttp = new XMLHttpRequest();
				xhttp.open("POST", "home2.php", true);
				xhttp.send();
			//$('#comments').load('home.php' +  ' #comments');
			$('body').load('home.php');
      	}
</script>
	<div class="container">
		<div class="row" style="margin-top: 60px;">
			<?php
				$stmt2=$db->prepare("SELECT * FROM circle_list WHERE creater=:creater");
      			$stmt2->bindParam(":creater",$_SESSION['user']);
      			$stmt2->execute();
      			$count=$stmt2->rowCount();
      			$username=$_SESSION['user'];
      			$admin=0;
      			if($count>0){
					foreach($db->query("SELECT * FROM circle_list WHERE creater='$username'") as $row){
						$circle_id=$row['id'];
						$admin=1;
						break;
					}
				}else{
					foreach($db->query("SELECT * FROM circle_mem WHERE member='$username'") as $row1){
						$circle_id=$row1['circle_id'];
						$stmt=$db->prepare("SELECT * FROM circle_list WHERE id=:id");
						$stmt->bindParam(":id",$circle_id);
						$stmt->execute();
						$row=$stmt->fetch();
						break;
					}
				}
			?>
			<div class="col-lg-8 col-lg-offset-2 col-md-11 col-md-offset-1 col-sm-12 col-xs-12">
				<form action="add_mem.php" method="post">
				<div class="page-header">
					<h3><i class="fa fa-users" style="color:blue;font-size:48px;"></i>
					<?php echo ' '.$row['name'];
					if($admin==1){
					?>
					<button name="circle_id" type="submit" class="w3-button" style="font-size: 18px;border-radius: 4px;" value="<?php echo $circle_id; ?>"> <i class="fas fa-user-plus"></i></button></h3>
					<?php } ?>
				</div>
					<div class="w3-bar w3-light-gray">
						<button type="button" class="w3-button" style="font-size: 16px;" href="#add_post" data-toggle="tab" >Add post</button>
						<button type="button" class="w3-button" style="font-size: 16px;" href="#circles" data-toggle="tab" >All Circles</button>
						<button type="button" class="w3-button " style="font-size: 16px;" href="#circle_mem" data-toggle="tab" >Members</button>
					</div>
					    </form>
					 <div class="tab-content">
					 	<div id="circle_mem" class="tab-pane fade w3-animate-right">
					          <h4><b>Circle Members</b></h4>
					        	<div class="w3-card-4 ">
					        	<table class="table">
					        	<?php 
								foreach($db->query("SELECT * FROM circle_mem WHERE circle_id='$circle_id'") as $row){
					      			$username=$row['member'];
					      			$stmt2=$db->prepare("SELECT * FROM users WHERE username=:username");
					      			$stmt2->bindParam(":username",$username);
					      			$stmt2->execute();
					      			$row2=$stmt2->fetch();
					      			$fullname=$row2['fullname'];
					      			$image=$row2['picture'];
					        	?>
					        	<tr>
					        		<td><img src="<?php echo 'profile_pics/'.$image;?>" class="img-responsive img-circle"
					        		width="50" height="50" /></td>
					          		<td><h4><?php echo $fullname.'('.$row['member'].')'; ?></h4></td>
					          	</tr>
					        	<?php } ?>
					        	</table> 
					        </div>
					  	</div>
						<div id="add_post" class="tab-pane w3-animate-zoom">
							<div class="w3-card-4">
								<div class="panel panel-default">
									<header style="text-align: center;" class="w3-container w3-blue-gray">
									<h4>Start a discussion</h4>
									</header>
									<div class="w3-container">
				  					<div class="panel-header" style="padding:15px;">
				  						<a onclick="add_bold1()" ><span class="glyphicon glyphicon-bold"></span></a> &nbsp;&nbsp;
										<a onclick="add_list1()" ><span class="glyphicon glyphicon-th-list"></span></a> &nbsp;&nbsp;
				  						<a onclick="add_italic1()"><span class="glyphicon glyphicon-italic"></span></a> &nbsp;&nbsp;
				  						<a data-target="#add_code" data-toggle="modal" id="code_snippet">
										<span style="font-size: 16px;font-weight: bold;">&lt;/&gt;</span></a>
										<a id="notification" class="alert alert-success collapse">code added</a>
				  					</div>
				  					<textarea id="post_text" class="form-control" placeholder=" Write Your text here " rows="6" style="border-radius: 0px;margin-bottom: 5px;"></textarea>
									<button style="border-color: white;"  id="<?php echo $circle_id; ?>" 
										onclick="add_post(this.id)" class="btn btn-primary pull-right w3-blue" >Post</button>
									<button data-target="#preview_post" data-toggle="modal" onclick="previews()" class="btn btn-default pull-right w3-light-gray" type="submit" style='margin-right:5px;border-color: white;'>preview</button>
				  				</div>
								<!-- preview of the text data -->
								<div class="modal " tabindex="-1" id="preview_post" data-backdrop="static">
					    			<div class="modal-dialog modal-md">
					        			<div class="modal-content">
					        				<div class="modal-header">
					        					<button type="button" class="close" data-dismiss="modal">
								                    &times;
								                </button>
					        					<h4 style="font-weight: bold;" class="modal-title">Preview</h4>
					        				</div>
					        				<div class="modal-body" data-spy="scroll">
					        					<p id="text_codes"> </p>
												<pre hidden id="codes"> </pre>
					        				</div>
					        				<div class="modal-footer">
					        					<button class="btn btn-default pull-right" 
												data-dismiss='modal' type="submit">Okay</button>
					        				</div>
					        			</div>
					        		</div>
					        	</div>
								<!-- adding code snippet -->
					  			<div class="modal " tabindex="-1" id="add_code" data-backdrop="static">
					    			<div class="modal-dialog modal-md">
					        			<div class="modal-content">
					        				<div class="modal-header">
					        					<button type="button" class="close" data-dismiss="modal">
								                    &times;
								                </button>
					        					<h4 style="font-weight: bold;" class="modal-title">Add a Code Snippet</h4>
					        				</div>
					        				<div class="modal-body" data-spy="scroll">
					        					<textarea id="code_textarea" placeholder=" Write your code here.."
												class="form-control" rows="15"></textarea>
					        				</div>
					        				<div class="modal-footer">
					        					<button onclick="add_code_btn1()" id="add_code_btn" class="btn btn-default pull-right" 
												data-dismiss='modal' type="submit">Add</button>
					        				</div>
					        			</div>
					        		</div>
					        	</div>
					        </div>
					    	</div>
					    </div>
					    <div id="circles" class="tab-pane w3-animate-top">
					    	<div class="w3-card-4 w3-padding" align="center">
					    		<?php 
							$username=$_SESSION['user'];
							foreach($db->query("SELECT * FROM circle_list WHERE creater='$username'") as $row){
							$circle_id=$row['id'];
							?>		
							<h3><i class="fa fa-users" style="color:blue;font-size:24px;"></i>
								<a href="<?php echo 'circle_feed2.php?circle_id='.$circle_id; ?>"><?php echo ' '.$row['name']; ?></a></h3>

							<?php
							}
							foreach($db->query("SELECT * FROM circle_mem WHERE member='$username'") as $row){
								$id=$row['circle_id'];
								$stmt=$db->prepare("SELECT * FROM circle_list WHERE id=:id");
								$stmt->bindParam(":id",$id);
								$stmt->execute();
								$row=$stmt->fetch();
								?>
								<h3><i class="fa fa-users" style="color:blue;font-size:24px;"></i>
									<a href="<?php echo 'circle_feed2.php?circle_id='.$circle_id; ?>"><?php echo ' '.$row['name']; ?></a></h3>
							<?php
								}
							?>
					    	</div>					    	
					    </div>
					</div>
        			<?php
						include 'pdo.php';
						if(!($db->query("SELECT * FROM discussions WHERE circle_id='$circle_id'"))){
								echo "no discussions till now , be the first to start";
							}
						else{
							$a=0;
							$b=0;
							$post_no=0;
							$c=0;
							foreach($db->query("SELECT * FROM discussions WHERE circle_id='$circle_id'") as $row){
								$post_no=$post_no+1;
								$b=$b+1;
								$a=$a+1;
								?><div id="jumbotron" class="w3-card jumbotron" style="margin-top: 60px"><?php
								echo '<a href="#" id="ques">'.$row['discussions'].'</a></br>';
								if(!empty($row['code'])){
								?>
								<pre style="font-size: 14px;"><?php echo $row['code']; ?></pre>
								<?php } ?>
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
								<div style="margin-left:0px;padding-left:0px;margin-top:10px;" class="btn-group btn-group-lg">
									
									<button style="margin-left:20px;" id="comment_btn" type="button" class="btn btn-default" 
									data-target="<?php echo '#comment_btn'.$post_no; ?>" data-toggle="collapse">comment</button>

									<button onclick="follow_post(this.id)" id="<?php echo 'folw'.$a ?>"
									class="btn btn-default" value="<?php echo $row['id']; ?>" style="margin-right:10px; border-radius: 4px;	line-height: 10px;background-color: #ccc;">follow </button>

									<button onclick="unfollow(this.id);" value="<?php echo $row['id']; ?>" id="<?php echo 'foln'.$a ?>" class="btn btn-default"	style="margin-right:10px;border-radius: 4px;line-height: 10px;background-color: #ccc;">following</button>
										<script type="text/javascript">
											function follow_post(btn_id){
													var num=btn_id.slice(4);
									      			document.getElementById("foln"+num).style.display = 'block';
													document.getElementById(btn_id).style.display = 'none';
									      			var id=$('#'+btn_id).val();
									      			$.post("home2.php",{
									      				follow_id: id
									      			});
									      			var xhttps = new XMLHttpRequest();
													xhttps.open("POST", "home2.php", true);
													xhttps.send();
									      		}
									        function unfollow(btn_id){
													var num=btn_id.slice(4);
									        		document.getElementById("folw"+num).style.display = 'block';
													document.getElementById(btn_id).style.display = 'none';
									      			var id=$('#'+btn_id).val();
									      			$.post("home2.php",{
									      				following_id: id
									      			});
									      			var xhttps = new XMLHttpRequest();
													xhttps.open("POST", "home2.php", true);
													xhttps.send();
									      		}
										</script>
									<?php
											$username=$_SESSION['user'];
											$id=$row['id'];
											$stmt=$db->prepare("SELECT * from following_post WHERE username=:username AND discussion_id=:id");
											$stmt->bindParam(':username',$_SESSION['user']);
											$stmt->bindValue(':id',$row['id']);
											$stmt->execute();
											$count=$stmt->rowCount();
											if($count>0){
										  ?>
										  <script type="text/javascript">
											document.getElementById("foln"+<?php echo $a ?>).style.display = 'block';
											document.getElementById("folw"+<?php echo $a ?>).style.display = 'none';
										</script>
										  <?php } else { ?>
										  <script type="text/javascript">
											document.getElementById("foln"+<?php echo $a ?>).style.display = 'none';
											document.getElementById("folw"+<?php echo $a ?>).style.display = 'block';
										</script>
										  	<?php }
									?>
                  <!---  watchlist -->
		                  <script type="text/javascript">
		                  		function add_watchlist(btn_id){
			                  			var num=btn_id.slice(4);
							      		document.getElementById(btn_id).style.display = 'none';
										document.getElementById("remw"+num).style.display = 'block';
										var id=$('#'+btn_id).val();
						      			$.post("home2.php",{
						      				add_watchlist: id
						      			});
						      			var xhttps = new XMLHttpRequest();
										xhttps.open("POST", "home2.php", true);
										xhttps.send();
						      	}
						      	function remove_watchlist(btn_id){
		                  				var num=btn_id.slice(4);
							      		document.getElementById("addw"+num).style.display = 'block';
										document.getElementById(btn_id).style.display = 'none';
										var id=$('#'+btn_id).val();
						      			$.post("home2.php",{
						      				remove_watchlist: id
						      			});
						      			var xhttps = new XMLHttpRequest();
										xhttps.open("POST", "home2.php", true);
										xhttps.send();
						      	}
		                  </script>

			                <button value="<?php echo $row['id']; ?>" onclick="add_watchlist(this.id)"	class="btn btn-default" id="<?php echo 'addw'.$b;?>" style="padding:0px;font-size:25px;height:30px;padding-left: 5px;
							padding-right: 5px;	border-radius: 4px;"><span class="glyphicon glyphicon-heart-empty"></span></button>

						    <button  value="<?php echo $row['id']; ?>" onclick="remove_watchlist(this.id)" class="btn btn-default	" id="<?php echo 'remw'.$b;?>" style="padding:0px;font-size:25px;height:30px;padding-left:5x;padding-right: 5px;border-radius: 4px;"><span class="glyphicon glyphicon-heart"></span></button>
								<?php
									$stmt->bindParam(':username',$_SESSION['user']);
									$stmt->bindValue(':id',$row['id']);
									$stmt->execute();
									$count=$stmt->rowCount();
									if($count<=0){
									?>
									<script type="text/javascript">
										document.getElementById("addw"+<?php echo $b;?>).style.display = 'block';
										document.getElementById("remw"+<?php echo $b;?>).style.display = 'none';
									</script>
									<?php
									}else{ ?>
									<script type="text/javascript">
											document.getElementById("addw"+<?php echo $b;?>).style.display = 'none';
											document.getElementById("remw"+<?php echo $b;?>).style.display = 'block';
									</script>
									<?php }
								?>
							</div>
                    <!-- adding comments -->
                  </div>
                <script type="text/javascript">
					function add_bold(btn_id) {
						var id=btn_id.slice(4);
						var val=$('#textarea'+id).val();
						document.getElementById('textarea'+id).value=val+' **Bold**';
			  		}
					function add_list(btn_id){
						var id=btn_id.slice(4);
						var val=$('#textarea'+id).val();
						document.getElementById('textarea'+id).value=val+' -List_Item-';
					}
			  		function add_italic(btn_id){
						var id=btn_id.slice(4);
						var val=$('#textarea'+id).val();
						document.getElementById('textarea'+id).value=val+' *Italic*';
			  		}
                  	function add_comment(btn_id){
                  		var num=btn_id.slice(7);
						$('#notification'+num).hide();
			      		var myString=document.getElementById('textarea'+num).value;
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
						var val=document.getElementById("code_textarea"+num).value;
			      		var id2=$('#'+btn_id).val();
			      			$.post("home2.php",{
			      				comment: a,
								code:val,
			      				id: id2
			      			});
			      			document.getElementById('textarea'+num).value ='';
			      			var xhttp = new XMLHttpRequest();
							xhttp.open("POST", "home2.php", true);
							xhttp.send();
						//$('#comments').load('home.php' +  ' #comments');
						$('body').load('home.php');
			      	}
			      	function add_code(btn_id){
			  				var id=btn_id.slice(8);
							code=document.getElementById('code_textarea'+id).value;
							document.getElementById("notification"+id).innerHTML="Code Added";
			        		$('#notification'+id).show();
					}
			      	function preview(btn_id){
			      		var id=btn_id.slice(5);
			  			var myString=document.getElementById("textarea"+id).value;
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
						var code=document.getElementById("code_textarea"+id).value;
						if(code!=''){
							$('pre').show();
						}
						document.getElementById("text_code").innerHTML=a;
						document.getElementById("code").innerHTML=code;
			  		}
                </script>
					<div id="<?php echo 'comment_btn'.$post_no; ?>" class="collapse">
						<div class="row">
				  			<div class="col-lg-10">
				  				<div class="panel panel-default">
				  					<div class="panel-header" style="padding:15px;">
				  						<a onclick="add_bold(this.id)" id="<?php echo 'bold'.$post_no; ?>"><span class="glyphicon glyphicon-bold"></span></a> &nbsp;&nbsp;
										<a onclick="add_list(this.id)" id="<?php echo 'list'.$post_no; ?>"><span class="glyphicon glyphicon-th-list"></span></a> &nbsp;&nbsp;
				  						<a onclick="add_italic(this.id)" id="<?php echo 'ital'.$post_no; ?>"><span class="glyphicon glyphicon-italic"></span></a> &nbsp;&nbsp;

				  						<a data-target="<?php echo '#add_code'.$post_no;?>" data-toggle="modal" id="<?php echo 'code_snippet'.$post_no; ?>">	<span style="font-size: 16px;font-weight: bold;">&lt;/&gt;</span></a>
										<a id="<?php echo 'notification'.$post_no;?>" class="alert alert-success collapse">code added</a>
										<!--
										<span onclick="$(this).parent().parent().hide()" class="w3-button w3-display-topright">&times;</span>
									-->
				  					</div>
				  					<textarea id="<?php echo 'textarea'.$post_no; ?>" class="form-control" placeholder="  write a reply" rows="8" style="border-left-width: 0px;border-right-width: 0px;border-radius: 0px;"></textarea>
									<button  id="<?php echo 'comment'.$post_no; ?>" onclick="add_comment(this.id)" class="btn btn-primary pull-right" value="<?php echo $row['id']; ?>">Post</button>

									<button style='margin-right:5px;' id="<?php echo 'pview'.$post_no; ?>" data-target="#preview_data" data-toggle="modal" onclick="preview(this.id)" class="btn btn-default pull-right" type="submit">preview</button>
				  				</div>
				  			</div>
							<!-- preview of the text data -->
							<div class="modal " tabindex="-1" id="preview_data" data-backdrop="static">
				    			<div class="modal-dialog modal-md">
				        			<div class="modal-content">
				        				<div class="modal-header">
				        					<button type="button" class="close" data-dismiss="modal">
							                    &times;
							                </button>
				        					<h4 style="font-weight: bold;" class="modal-title">Preview</h4>
				        				</div>
				        				<div class="modal-body" data-spy="scroll">
				        					<p id="text_code"> </p>
											<pre hidden id="code"> </pre>
				        				</div>
				        				<div class="modal-footer">
				        					<button class="btn btn-default pull-right" 
											data-dismiss='modal' type="submit">Okay</button>
				        				</div>
				        			</div>
				        		</div>
				        	</div>
							<!-- adding code snippet -->
				  			<div class="modal " tabindex="-1" id="<?php echo 'add_code'.$post_no;?>" data-backdrop="static">
				    			<div class="modal-dialog modal-md">
				        			<div class="modal-content">
				        				<div class="modal-header">
				        					<button type="button" class="close" data-dismiss="modal">
							                    &times;
							                </button>
				        					<h4 style="font-weight: bold;" class="modal-title">Add a Code Snippet</h4>
				        				</div>
				        				<div class="modal-body" data-spy="scroll">
				        					<textarea id="<?php echo 'code_textarea'.$post_no;?>" placeholder=" Write your code here.."
											class="form-control" rows="15"></textarea>
				        				</div>
				        				<div class="modal-footer">
				        					<button onclick="add_code(this.id)" id="<?php echo 'add_code'.$post_no; ?>" class="btn btn-default pull-right" 
											data-dismiss='modal' type="submit">Add</button>
				        				</div>
				        			</div>
				        		</div>
				        	</div>
				  		</div>
					</div>
                  	<!-- comments are here -->
                    <div style="margin-left: 2%;" class="row" id="comments">
						<?php
						$id=$row['id'];
						
						foreach($db->query("SELECT * FROM comment WHERE discussion_id='$id'") as $comments){ 
							$c=$c+1;
							?>
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

				    	<div class="btn-group">
            		<!--awesome -->
            		<script type="text/javascript">
            			function awesome(btn_id){
            				var num=btn_id.slice(4);
            				//if($('like'+num)==$('dlik'+num)){}
			      			document.getElementById(btn_id).style.display = 'none';
			      			document.getElementById("dlik"+num).style.display = 'block';
			      			var id=document.getElementById(btn_id).value;
			      			var id=$("#"+btn_id).data('value');
			      				$.post("home2.php",{
		            				awesome: id
		            			});
			      				xhttps.open("POST", "home2.php", true);
			      				xhttps.send();
				      	}
				      	function remove_awesome(btn_id){
    						var num=btn_id.slice(4);
			      			document.getElementById(btn_id).style.display = 'none';
			      			document.getElementById("like"+num).style.display = 'block';
			      			var id=$("#"+btn_id).data('value');
		            			$.post("home2.php",{
		            				thumbs_uped: id
		            			});
		      				xhttps.open("POST", "home2.php", true);
		      				xhttps.send();
				      	}
            		</script>
            			
            			<a onclick="awesome(this.id)" id="<?php echo 'like'.$c; ?>"  data-value="<?php echo $comments['comment_id']; ?>" class="fa fa-thumbs-up"></a>

            			<a onclick="remove_awesome(this.id)" id="<?php echo 'dlik'.$c; ?>" data-value="<?php echo $comments['comment_id']; ?>" style="color: blue;" class="fa fa-thumbs-up"></a>
            					<?php
            						if($comments['awesome']!=0){
			            			   echo '<p>'.$comments['awesome'];?> finds it awesome</p>
			            			 <?php } ?>
										</div>
										<?php
											$stmt=$db->prepare("SELECT * from awesome WHERE username=:username 
												AND comment_id=:id");
											$stmt->bindParam(':username',$_SESSION['user']);
											$stmt->bindValue(':id',$comments['comment_id']);
											$stmt->execute();
											$count=$stmt->rowCount();
											if($count<=0){
											?>
											<script type="text/javascript">
												document.getElementById('like'+<?php echo $c; ?>).style.display = 'block';
												document.getElementById("dlik"+<?php echo $c; ?>).style.display = 'none';
											</script>
											<?php
											}else{ ?>
											<script type="text/javascript">
												document.getElementById('like'+<?php echo $c; ?>).style.display = 'none';
												document.getElementById('dlik'+<?php echo $c; ?>).style.display = 'block';

											</script>
											<?php }
										?>
								    	</div>
								        </div>
								        <?php } ?>
								 	</div>
								<?php
							}
						}
					?>
			</div>
		</div>
	</div>
</body>

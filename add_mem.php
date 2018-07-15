<?php
include 'user_header.php';
?>
<body>
	<div class="container">
		<div class="row" style="margin-top:80px;">
			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-xs-12">
				<?php 
				$circle_id='';
				if(isset($_POST['create'])){
					$stmt=$db->prepare("INSERT INTO circle_list (name,type,creater) VALUES(:name,:type,:creater)");
					$stmt->bindParam(':name',$_POST['name']);
					$stmt->bindParam(':type',$_POST['type']);
					$stmt->bindParam(':creater',$_SESSION['user']);
					$stmt->execute();
					$stmt=$db->prepare("SELECT id FROM circle_list WHERE name=:name AND type=:type AND creater=:creater");
					$stmt->bindParam(':name',$_POST['name']);
					$stmt->bindParam(':type',$_POST['type']);
					$stmt->bindParam(':creater',$_SESSION['user']);
					$stmt->execute();
					$res=$stmt->fetch();
					$circle_id=$res['id'];
					$_SESSION['circle_id']=$res['id'];
				}
				else if(isset($_POST["circle_id"])){
					$_SESSION['circle_id']=$_POST["circle_id"];
					$circle_id=$_POST["circle_id"];
				}
				else{
						$circle_id=$_SESSION["circle_id"];
				}
				?>
					<h4><b>Add members: </b></h4>
					<p>You can add only those learners who are following you</p>
					<div style="height:400px;overflow-y: scroll;" data-spy="scroll">
					<?php
					$username=$_SESSION['user'];
					$a=0;
					foreach($db->query("SELECT * FROM followers WHERE username='$username'") as $row){
					$a=$a+1;
					$stmt2=$db->prepare("SELECT * FROM users WHERE username=:username");
					$stmt2->bindParam(":username",$row['follower']);
					$stmt2->execute();
					$row2=$stmt2->fetch();
					$image=$row2['picture'];
					?>
					<script type="text/javascript">
						function add_user(btn_id){
							var id=btn_id.slice(3);
							document.getElementById('add'+id).style.display="none";
							document.getElementById('added'+id).style.display="block";
							var a=$("#add"+id).val();
							$.post("circle_query.php",{
								type:"add",
			      				member: a
			      			});
						}
						function remove_user(btn_id){
							var id=btn_id.slice(5);
							document.getElementById('add'+id).style.display="block";
							document.getElementById('added'+id).style.display="none";
							var a=$("#added"+id).val();
							$.post("circle_query.php",{
								type:'remove',
			      				member: a
			      			});
						}
					</script>
					  <table class="table table-striped">
					    <tbody>
					      <tr>
					        <td><img src="<?php echo 'profile_pics/'.$image?>" height="40" width="40" class="img-responsive img-circle" />
					        </td>
					        <td ><h4><?php echo $row['follower']; ?></h4></td>
					        <td>
					        	<button id='<?php echo "add".$a; ?>' onclick="add_user(this.id)" type="button" value="<?php echo $row['follower']; ?>" style="float: right;border-width:0px;background-color:silver;"
					        		class="btn btn-default">+ Add</button>
					        	<button  id='<?php echo "added".$a; ?>'  onclick="remove_user(this.id)" style="display:none;border-width:0px;float: right;" type="button" 
					        		value="<?php echo $row['follower']; ?>" class="btn btn-primary w3-blue">Added</button>
					        		<?php
					        		$stmt=$db->prepare("SELECT * FROM circle_mem WHERE circle_id=:circle_id AND member=:member");
									$stmt->bindParam(':circle_id',$circle_id);
									$stmt->bindParam(':member',$row['follower']);
									$stmt->execute();
									$count=$stmt->rowCount();
									if($count>0){
					        		?>
					        		<script type="text/javascript">
					        			document.getElementById('add'+<?php echo $a; ?>).style.display="none";
										document.getElementById('added'+<?php echo $a; ?>).style.display="block";
					        		</script>
					        		<?php }else{ ?>
					        		<script type="text/javascript">
					        			document.getElementById('add'+<?php echo $a; ?>).style.display="block";
										document.getElementById('added'+<?php echo $a; ?>).style.display="none";
					        		</script>
					        		<?php } ?>
					        </td>
					      </tr>
					    </tbody>
					  </table>
					  <?php } ?>
				</div>
				<a style="float: right;color: #000;font-size: 18px;margin-right:20px;background-color: #cacaca;
					border-color: #fff;" class="btn btn-default" href="home.php">done</a>
			</div>
		</div>
	</div>
</body>
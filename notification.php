<?php 
include 'user_header.php';
?>
<style type="text/css">
	h4{
		margin-bottom:15px;
	}
</style>
<div class="container">
	<div class="row" style="margin-top:60px;">
		<div class=" col-xs-offset-1 col-xs-10 w3-card " >
			<h3 id="noti"><b>Notifications</b></h3>
			<?php
				 foreach($db->query("SELECT * FROM notification WHERE username='$username' order by timestamp DESC ") as $row){
               		if($row['type']=='comment'){
                       $loc="posts.php?post_id=".$row['id']; ?></h4>
                           <h4> <a class="w3-bar-item" href="<?php echo $loc; ?>">
                                <?php echo $row['other_user'].' answered to your post </h4>';?>
                            </a>
                          <?php }  if($row['type']=='project'){  ?>
                        <h4><a class="w3-bar-item" href="<?php echo '#'; ?>">
                               <?php echo 'congrats , '.$row['other_user'].' accepted your project order '; 
                             } ?>
                         </a></h4><?php
                       if($row['type']=='discussion'){  ?>
                         <h4><a class="w3-bar-item" href="<?php echo $loc; ?>">
                               <?php echo $row['username'].' started a discussion '; 
                         } ?>
                     </a></h4>
                     <?php 
                   } 
			?>
		</div>
	</div>
</div>
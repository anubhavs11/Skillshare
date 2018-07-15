<?php
  include 'user_header.php';
  if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<style>
   .panel-info>.panel-heading {
    color: white;
    background-color: #805252;
    border-color: #000000;
	}
	.well{
    font-size: 15px;
    min-height: 10px;
    padding:8px;
    margin-bottom: 20px;
    font-family: inherit;
    background-color: #fbfbfb;
    border: 1px solid white;
    border-radius: 4px;
    padding-top: 10px;
    margin-top: 5px;
	}
	.panel-body {
    padding: 15px;
    background-color: lightyellow;
    color: black;
    font-size: 18.5px;
    font-family: serif;
 }
  .panel-group .panel-footer {
    background-color: #f9f9f9;
    border-top: 0;
 }
 #filter{
	margin-top:50px;
 }
 .form-control{
	margin-top:10px;
	margin-bottom:5px;
 }
 #project_form>.form-control{
 	box-shadow: 0 0 black;
 	border-width: 0px;
 }
 #filter_btn{
 	    color: #fff;
    font-size: 18px;
    font-family: cursive;
    height: 40px;
    background-color: gray;
    border-color: #ffffff;
 }
 #filter_apply{
 	    color: #fff;
    font-size: 18px;
    height: 40px;
    background-color: #31708f;
    border-color: #fff;
 }
</style>
  </head>
  <body>
  <div class="container">
    <div class="row" style="margin-top:60px;">
	  <div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
	  		<button id="filter_btn" class="btn btn-primary" data-target="#filter_projects" data-toggle="collapse"> filter <span class="glyphicon glyphicon-filter"></span></button>
	  		<div id="filter_projects" class=" collapse">
		  	 <h3 id="filter">Filter Project lists</h3>
			  <form action="project_show.php" method="post">
			  
					<input type="text" placeholder="Enter Maximum Price" name="maxprice" class="form-control">
					<select name="currency" class="form-control" placeholder="Currency Type">
						<option value="INR">INR</option>
						<option value="USD">USD</option>
						<option value="EURO">EURO</option>
					</select>
					<select name="category" class="form-control" placeholder="Project category">
						<option value="all">Any Category(default)</option>
						<option value="web">Web Projects</option>
						<option value="soft">Software Projects</option>
						<option value="doc">Document Preparations</option>
						<option value="assignment">Assignments</option>
					</select>
					</br>
					<button id="filter_apply" type="submit" class="btn btn-primary">Apply</button>
			   </form>
			</div>
		<h2 class="page-header">Projects</h2>
			  <?php 
			  include 'pdo.php';
			  if(empty($_SESSION['user'])){
						echo 'error occured';
					}
			  foreach($db->query("SELECT * FROM projects WHERE status=1") as $row){ 
				if(isset($_POST['maxprice'])&&isset($_POST['currency'])&&isset($_POST['category'])){
					if(!empty($_POST['maxprice'])){
						if(!($row['amount']<=$_POST['maxprice']&&$row['currency']==$_POST['currency']&&$row['category']==$_POST['category'])){
							if(!($_POST['category']=='all')){
								continue;
							}
						}
					}
					else{
						if(!($row['currency']==$_POST['currency']&&$row['category']==$_POST['category'])){
							if(!($_POST['category']=='all')){
								continue;
							}
						}
					}
				}
			  ?>
			
				 <div class="w3-card-4">
                  <header class="w3-container w3-light-grey">
                    <h2 style="margin-left: 10%;"><?php echo '<h4>'.$row['title'].'</h4>'; ?></h2>
                  </header>
                  	<div class="w3-container">      
                    	<?php echo $row['description']; ?></br>
                    	<div class="row">
						  <form id="project_form" action="receiver_profile.php" method="post" class="form-inline">
								<h4 class="form-control"><?php echo 'Price '.$row['amount'].' '.$row['currency']; ?></h4>
								
								<button type="submit" id="btn_list" class="btn btn-default form-control" name="view"
								value="<?php echo $row['id'] ?>">View More</button>
						   </form>
						</div>
                	</div>
                </div>
				</br></br>
				<?php } ?>
	  </div>
    </div>
  </div>
  </body>
<?php 
include 'user_header.php';
?>
<style type="text/css">
	#form>input{
		margin-bottom: 20px;
	}
</style>
<body>
	<div class="container">
		<div class="row" style="margin-top:100px;">
			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 hidden-xs">
				<form id="form" action="add_mem.php" method="post" style="width: 80%">
					<div class="jumbotron w3-padding" style="background-color: white;">
					<h4 >Circles are great for getting things done and staying in touch with just the people you want for particular purpose.</h4>
					</div>
					<h3><b>Create a Circle</b></h3>
					<hr>
					<h4>Circle Name</h4>
					<input required class="form-control" placeholder="e.g: networking group" type="text" name="name">
					<h4>Circle type</h4>
					<input required class="form-control" placeholder="e.g: networking" type="text" name="type">
					<br>
					<input value="<?php echo $a; ?>" name="no" style='display:none;' />
					<button type="submit"  name="create" class="btn btn-primary" 
						style="font-size: 18px;">Create Circle</button>
					<br><br><br><br><br><br>
				</form>
			</div>
			<div class="col-xs-12 hidden-lg hidden-md hidden-sm">
				<form id="form" action="add_mem.php" method="post">
					<div align="center" class="jumbotron w3-padding" style="background-color: white;font-family: initial;">
					<h4>Circles are great for getting things done and staying in touch with just the people you want for particular purpose.</h4>
					</div>
					<h6><b>Circle Name</b></h6>
					<input required class="form-control" placeholder="e.g: networking group" type="text" name="name">
					<h6><b>Circle type</b></h6>
					<input required class="form-control" placeholder="e.g: networking" type="text" name="type">
					<br>
					<input value="<?php echo $a; ?>" name="no" style='display:none;' />
					<button type="submit"  name="create" class="btn btn-primary" 
						style="font-size: 18px;">Create Circle</button>
					<br><br><br><br><br><br>
				</form>
			</div>
		</div>
	</div>
</body>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>

	<!-- bootstrap css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>">
	<!-- boostrap theme -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/bootstrap/css/bootstrap-theme.min.css') ?>">

	<!-- custom css -->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('custom/css/custom.css') ?>">	

	<!-- jquery -->
	<script type="text/javascript" src="<?php echo base_url('assets/jquery/jquery.min.js') ?>"></script>
	<!-- boostrap js -->
	<script type="text/javascript" src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js') ?>"></script>

</head>
<body>


<div class="col-md-6 col-md-offset-3 vertical-off-4">
	<div class="panel panel-default login-form">
	  	<div class="panel-body">
	  		<form method="post" action="<?php echo base_url('users/login') ?>" id="loginForm">
		    	<fieldset>
		    		<legend>
		    			Login
		    		</legend>

		    		<div id="message"></div>

					<div class="form-group">
				    	<label for="username">Username</label>
				    	<input type="text" class="form-control" id="username" name="username" placeholder="Username" autofocus>
				  	</div>
				  	<div class="form-group">
				    	<label for="password">Password</label>
				    	<input type="password" class="form-control" id="password" name="password" placeholder="Password">
				  	</div>					  						 
				  	
				  	<button type="submit" class="col-md-12 btn btn-primary login-button">Submit</button>					
		    	</fieldset>
		    </form>
	  	</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('custom/js/login.js') ?>"></script>

</body>
</html>
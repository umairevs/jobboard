<?php
include("common/top.php");
include("common/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Sign in as User or Employer </title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	<section class="clearfix job-bg user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account">
						<h2>User Login</h2>
						<!-- form -->
						 <form name="signup_form" id="signup_form" action="" method="post" enctype="multipart/form-data"> 
                         
							<div>
								<input type="radio" name="job_type" value="1" onClick="login_with(1)" style="height:auto;">  Job Seeker 
                                
                                <input type="radio" name="job_type" value="2" onClick="login_with(2)" style="height:auto; margin-left:30px;">  Employer 
                                
                              
							</div>
                            
                            <div class="form-group">
								<input type="text" name="email" class="form-control" placeholder="Email" >
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control" placeholder="Password" >
							</div>
                            
                            
                            <input type="submit" name="submitb" value="Sign in" class="btn" onClick="return validate_add(5);">
                           <div id="preloader_div"></div>
                           
                            <div id="employer_signin" style="display:none;"><h5><span>OR</span></h5>
                            <img src="images/linkedin-login.png" height="39">
                            </div>
						</form><!-- form -->
					
						<!-- forgot-password -->
						<div class="user-option">
							<!-- <div class="checkbox pull-left">
								<label for="logged"><input type="checkbox" name="logged" id="logged"> Keep me logged in </label>
							</div>  -->
							<div class="pull-right forgot-password">
								<a href="<?php echo SERVER_ROOTPATH;?>forgot-password">Forgot password</a>
                                <br>
                                <a href="<?php echo SERVER_ROOTPATH;?>signup">Job Seeker Signup</a>
                                <br>
                                <a href="<?php echo SERVER_ROOTPATH;?>employer-signup">Employer Signup</a>
							</div>
						</div><!-- forgot-password -->
					</div>
					
				</div><!-- user-login -->			
			</div><!-- row -->	
		</div><!-- container -->
	</section>
	
	<?php include("common/footer.php");?>   
  </body>
</html>
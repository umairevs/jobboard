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

    <title>Jobs | Forgot Password</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	
	<!-- banner-section -->

	<section class="clearfix job-bg user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account">
						<h2>Forgot Password</h2>
						<!-- form -->
						<form action="<?php echo SERVER_ROOTPATH;?>profile">
							 <div>
								<input type="radio" name="job_type" value="1"  style="height:auto;">  Job Seeker 
                                
                                <input type="radio" name="job_type" value="2" style="height:auto; margin-left:30px;">  Employer 
                             </div>
                            
                            <div class="form-group">
								<input type="email" class="form-control" placeholder="Email" required>
							</div>
						    
                           
                            
                            
                            
							<button type="submit" href="#" class="btn">Submit</button>
                            <div id="employer_signin" style="display:none;"><h5><span>OR</span></h5>
                            <img src="images/linkedin-login.png" height="39">
                            </div>
						</form><!-- form -->
					
						<!-- forgot-password -->
						<div class="user-option">
							<div class="checkbox pull-left">
								
							</div>
							<div class="pull-right forgot-password">
								<a href="<?php echo SERVER_ROOTPATH;?>signin">Back to Sign in</a>
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
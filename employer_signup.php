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
    <meta name="author" content="">
   	<meta name="keywords" content="Jobn portal, sign up for employer, Jobs website">
    <meta name="description" content="Job Portal / Job Board, Sign up for employer ">

    <title>Employer Sign up page</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	
	<!-- banner-section -->
	<section class="job-bg2 user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account job-user-account" id="jobseeker_register">
						<h2>Create Employer Account</h2>
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="find-job">
									 <form name="signup_form" id="signup_form" action="" method="post" enctype="multipart/form-data"> 
										
									    
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Email address" name="email" style="margin-bottom:10px;" >
                                                <small style="float:left;">Yahoo,Gmail,Hotmail,Facebook Email is not allowed </small>
                                            </div>
                                         
                                         <div class="clear_screen" style="margin-bottom:20px;"></div>
										<input type="submit" class="btn" onClick="return validate_add(3);" id="button1" value="Sumbit">
                                        <div id="preloader_div"></div>
									</form>
                                   
                                   <div class="user-option">
							<div class="checkbox pull-left">
								
							</div>
							<div class="pull-right forgot-password">
								<a href="<?php echo SERVER_ROOTPATH;?>signin">Back to Sign in</a>
							</div>
						</div>
								</div>
								
							</div>				
					</div>
                    
                    <div class="user-account job-user-account" id="success_message" style="display:none;">
						<h2 style="margin-bottom: 30px;">Almost there!</h2>
							
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active">
									 <p id="display_success_message"></p>
								</div>
								
							</div>				 
					</div>
				</div><!-- user-login -->			
			</div><!-- row -->	
		</div><!-- container -->
	</section>
	
	<?php include("common/footer.php");?>   
  </body>
</html>
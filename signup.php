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

    <title>Jobs | Sign up</title>
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
						<h2>Create Job Seeker Account</h2>
							
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="find-job">
									 <form name="signup_form" id="signup_form" action="" method="post" enctype="multipart/form-data"> 
										
										<div class="form-group" id="step1">
											<input type="file" name="cv_file" style="margin-bottom:0;">
                                            <small style="float:left;">Valid file format doc,docx or pdf</small>
										</div>
										
                                        <div id="step2" style="display:none;">
                                            <div class="form-group">
                                                <input type="email" class="form-control" placeholder="Email address" name="email" >
                                               
                                            </div>                                 
                                        </div>
                                         <div class="clear_screen"></div>
										<input type="submit" class="btn" onClick="return validate_adduser(1);" id="button_1" value="Next">
                                        <input type="submit" class="btn" onClick="return validate_adduser(2);" id="button_2" value="Sumbit" style="display:none; margin-bottom:0;">										
                                        <div id="preloader_div"></div>
                                         <div id="employer_signin" style="display:none;" ><h5><span>OR</span></h5>
	                                                <img src="images/linkedin-login.png" height="39">
                                                </div>
                                        <div id="loader"></div>
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
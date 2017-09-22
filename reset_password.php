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

    <title>Jobs | Job Portal / Job Board HTML Template</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	
	<!-- banner-section -->

	<section class="job-bg user-page">
		<div class="container">
			<div class="row text-center">
				<!-- user-login -->			
				<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3">
					<div class="user-account job-user-account">
						<h2>Set a Password</h2>
							<!--<ul class="nav nav-tabs text-center" role="tablist">
								<li role="presentation" class="active"><a href="#find-job" aria-controls="find-job" role="tab" data-toggle="tab">Find A Job</a></li>
								<li role="presentation"><a href="#post-job" aria-controls="post-job" role="tab" data-toggle="tab">Post A Job</a></li>
							</ul>
-->
							<div class="tab-content">
								<div role="tabpanel" class="tab-pane active" id="find-job">
									 <form name="signup_form" id="signup_form" action="" method="post" enctype="multipart/form-data"> 
										
										
										
                                       
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="Password" name="password" >
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control" placeholder="Repeat Password" name="repeat_password"  >
                                            </div>
										
                                         <div class="clear_screen"></div>
										<input type="submit" class="btn"  value="Sumbit">
									</form>
                                   
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
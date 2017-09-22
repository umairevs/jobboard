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
   	<meta name="title" content="Contact Us">
   	<meta name="keyword" content="Contact Us">
   	<meta name="description" content="Contact Us">
    <title>Contact Us</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	
	<!-- banner-section -->

	<div class="opage">
		<section class=" job-bg page  ad-profile-page" style="background:#CCCCCC;">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>">Home</a></li>
					<li>Contact Us</li>
				</ol>						
				<h2 class="title">&nbsp;</h2>
			</div><!-- breadcrumb-section -->

			<div class="resume-content">
				<!-- profile -->

				<div class="user-account">
						 <div class="career-info">
			        	<h3>Contact Us</h3>
			        	<p>We are working at the right end to provide the quality services,our mission is going ahead.</p>
                        <p style="color:#FF0000"> All fileds are Required Fields </p>
			        	</div>    
						<!-- form -->
						 <form name="signup_form" id="signup_form" action="" method="post" enctype="multipart/form-data"> 
                         <?php if($_SESSION['success']['msg']!='')
										{
										?>
										<div class="form-group">
										<div class="alert alert-success" style="margin-bottom:0;">
										<strong>Success!</strong> <?php echo $_SESSION['success']['msg'];?>
										</div>
										</div>
										<?php
										unset($_SESSION['success']);
										}
										?>
							<div class="form-group">
								<input type="text" name="name" id="name" class="form-control" placeholder="Name" value="">
							</div>
							<div class="form-group">
								<input type="text" name="email" id="email" class="form-control" placeholder="Email">
							</div>
                            <div class="form-group">
                            	<textarea class="form-control" placeholder="Message" rows="8" name="message" id="message"></textarea>
                             </div>   
                            
                            <input type="submit" name="submitb" value="Submit" class="btn" onClick="return validate_add(12);">
                           <div id="preloader_div"></div>
                           
                            
						</form><!-- form -->
					
						
					</div>							
			
			</div><!-- resume-content -->						
		</div><!-- container -->
	</section><!-- conainer -->
	</div><!-- page -->
	
	<?php include("common/footer.php");?>   
  </body>
</html>
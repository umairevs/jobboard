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
   	<meta name="title" content="FAQ>">
   	<meta name="keyword" content="FAQ">
   	<meta name="description" content="FAQ">
    <title>FAQ</title>
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
					<li>FAQ</li>
				</ol>						
				<h2 class="title">&nbsp;</h2>
			</div><!-- breadcrumb-section -->

			<div class="resume-content">
				<!-- profile -->

				
			        <?php $faq = get_faq(); 
					foreach($faq as $val) {
					?>
                    <div class="career-objective section">
			        <div class="career-info">
			        	<h3><?php echo $val['faq_question'];?></h3>
			        	
			        	<?php echo $val['faq_answer'];?>
                        
			        </div> 
                    	</div>                
                    <?php }  ?>         
                    
                          
			
                							
			
			</div><!-- resume-content -->						
		</div><!-- container -->
	</section><!-- conainer -->
	</div><!-- page -->
	
	<!-- download -->
	<!-- download -->
	
	<?php include("common/footer.php");?>   
  </body>
</html>
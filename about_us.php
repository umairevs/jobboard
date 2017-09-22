<?php
include("common/top.php");
include("common/functions.php");
$cms = get_cms(1);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   	<meta name="title" content="<?php echo $cms['metatitle'];?>">
   	<meta name="keyword" content="<?php echo $cms['metakeyword'];?>">
   	<meta name="description" content="<?php echo $cms['metadesc'];?>">
    <title><?php echo $cms['title'];?></title>
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
					<li><?php echo $cms['title'];?></li>
				</ol>						
				<h2 class="title">&nbsp;</h2>
			</div><!-- breadcrumb-section -->

			<div class="resume-content">
				<!-- profile -->

				<div class="career-objective section">
			        
			        <div class="career-info">
			        	<h3><?php echo $cms['title'];?></h3>
			        	
			        	<?php echo $cms['content'];?>
			        </div>                                 
				</div>							
			
			</div><!-- resume-content -->						
		</div><!-- container -->
	</section><!-- conainer -->
	</div><!-- page -->
	
	<!-- download -->
	<!-- download -->
	
	<?php include("common/footer.php");?>   
  </body>
</html>
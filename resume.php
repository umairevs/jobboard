<?php
include("common/top.php");
include("common/functions.php");

$id_get = base64_decode($_REQUEST['seeker_id']);

$resume_info  = get_seeker_resume($id_get);
if(!$resume_info)
{	
	$user_info  =  get_seeker_by_id($id_get);
	$full_name  =  stripslashes($user_info['name']);
	$db_image  =  stripslashes($user_info['image']);
	$email  =  stripslashes($user_info['email']);
	$mobile_number  =  stripslashes($user_info['mobile_number']);
	$resume_detail  =  "Post";
	$button_detail  =  "Post";
}	
else
{	
	$user_info  =  get_seeker_by_id($id_get);
	$email  =  stripslashes($user_info['email']);
	$mobile_number  =  stripslashes($user_info['mobile_number']);
	
	
	$full_name  =  stripslashes($resume_info['full_name']);
	$db_image   =  stripslashes($resume_info['photo_of_resume']);	
	$additional_info   =  stripslashes($resume_info['additional_info']);	
	$carrer_obj   =  stripslashes($resume_info['carrer_obj']);	
	$qualification   =  stripslashes($resume_info['qualification']);	
	$full_names   =  stripslashes($resume_info['full_names']);	
	$father_name   =  stripslashes($resume_info['father_name']);	
	$mother_name   =  stripslashes($resume_info['mother_name']);	
	$dob		   =  stripslashes($resume_info['dob']);	
	$birth_place		   =  stripslashes($resume_info['birth_place']);	
	$nationality		   =  stripslashes($resume_info['nationality']);	
	$sex		   =  stripslashes($resume_info['sex']);	
	$address	   =  stripslashes($resume_info['address']);
	$declaration	=  stripslashes($resume_info['declaration']);	
	
	$resume_detail  =  "Edit";
	$button_detail  =  "Update";
}

if($_SESSION['jobseeker']['id'])
{
	if($father_name=='')
	{
		?>
		<script type="text/javascript">
			alert("Please Post your CV first");
			window.location.href = "<?php echo SERVER_ROOTPATH;?>post-resume";
		</script>
		<?php
		
		exit;
	}
}?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title><?php echo $full_name;?> CV</title>
 	<?php include("common/top_script.php");
	?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	
	<!-- banner-section -->

	
	<section class=" job-bg page  ad-profile-page">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>">Home</a></li>
					<li><?php echo $full_name;?> Profile</li>
				</ol>						
				<h2 class="title"><?php echo $full_name;?> Resume</h2>
			</div><!-- breadcrumb-section -->

			<div class="resume-content">
				<div class="profile section clearfix">
					<div class="profile-logo">
					   <?php
					   if($db_image!='')
											{
												?>
												<img src="<?php echo SERVER_ROOTPATH;?>media/user_images/<?php echo $db_image;?>" class="img-responsive" title="<?php echo $full_name;?>" width="151" style="min-height:161px;">
												<?php 
											}
											else
											{
											?>
                                             <img class="img-responsive" src="<?php echo SERVER_ROOTPATH;?>images/job/resume.jpg" title="<?php echo $full_name;?>">
                                            <?php
											}
											?> 
					</div>
					<div class="profile-info">
					    <h1><?php echo $full_name;?></h1>
					    <address>
					        <p>Address: <?php echo $address;?>
                            <br> Phone: <?php echo $mobile_number;?> <br> Email:<a> <?php echo $email;?></a>
                            </p>
					    </address>
					</div>					
				</div><!-- profile -->

				<div class="career-objective section">
			        <div class="icons">
			            <i class="fa fa-black-tie" aria-hidden="true"></i>
			        </div>   
			        <div class="career-info">
			        	<h3>Career Objective</h3>
			        	<p><span><?php echo $carrer_obj;?></span></p>
			        </div>                                 
				</div><!-- career-objective -->

				<div class="work-history section">
			        <div class="icons">
			            <i class="fa fa-briefcase" aria-hidden="true"></i>
			        </div>   
			        <div class="work-info">
			        	<h3>Work History</h3>
			        	<ul>
                        <?php
						$query_work_history  =  get_seeker_working_history($id_get);
										if($query_work_history)
										{	
											$sizeof_workexp  = sizeof($query_work_history);
											$u=1;
											foreach($query_work_history as $work_info)
											{
												
												?>
                                                <li>
				        		<h4><?php echo stripslashes($work_info['designation']);?> @ <?php echo stripslashes($work_info['company_name']);?> <span><?php echo stripslashes($work_info['from_job']);?> - <?php echo stripslashes($work_info['to_job']);?></span></h4>
				        		<p><?php echo stripslashes($work_info['job_description']);?></p>
			        		</li>
                                                <?php
											}
										}?>
                                                
			        			
			        	</ul>
			        </div>                                 
				</div><!-- work-history -->

				<div class="educational-background section">
					<div class="icons">
					    <i class="fa fa-graduation-cap" aria-hidden="true"></i>
					</div>	
					<div class="educational-info">
						<h3>Education Background</h3>
						<ul>
							<?php
							$query_edu_background  =  get_seeker_education_background($id_get);
							if($query_edu_background)
							{	
								$sizeof_workexp  = sizeof($query_edu_background);
								$u=1;
								foreach($query_edu_background as $work_info)
								{
									?>
                                    <li>
								<h4><?php echo stripslashes($work_info['degree']);?> @ <?php echo stripslashes($work_info['inst_name']);?></h4>
								<ul>
									<li>Year: <span><?php echo get_year(stripslashes($work_info['from_date']));?> - <?php echo get_year(stripslashes($work_info['to_date']));?></span> </li>
								</ul>
								<p><?php echo stripslashes($work_info['description']);?></p>
							</li>
                                    <?php
								}
							}	
                            ?>
                            
							
						</ul>
					</div>				
				</div><!-- educational-background -->

				<div class="special-qualification: section">
					<div class="icons">
					    <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
					</div>	
					<div class="qualification">
						<h3>Special Qualification:</h3>
						<?php echo $qualification;?>
                        
                     
					</div>				
				</div><!-- educational-background -->

				<div class="language-proficiency section">
			        <div class="icons">
			            <i class="fa fa-language" aria-hidden="true"></i>
			        </div>
				    <div class="proficiency">
				    	<h3>Language Proficiency</h3>
				        <ul class="list-inline">
                         <?php
								  		$query_language_background  =  get_seeker_lanugage($_SESSION['jobseeker']['id']);
										if($query_language_background)
										{	
											$sizeof_workexp  = sizeof($query_language_background);
											$u=1;
											foreach($query_language_background as $work_info)
											{
												?>
                                                <li>
                                                    <h5><?php echo stripslashes($work_info['language']);?></h5>
                                                    <ul>
                                                       <?php
													   		for($m=1;$m<=5;$m++)
															{
																if($m<=$work_info['rating'])
																{
																
																?>
                                                                 <li><i class="fa fa-star" aria-hidden="true"></i></li>
                                                                 
                                                                <?php
																}
																else
																{
																	?>
                                                                      <li><i class="fa fa-star-o" aria-hidden="true"></i></li>
                                                                    <?php
																}
															}
													   ?>
                                                    
                                                    </ul>
                                                </li>
                                                <?php
                                             
                                             }
										}
									?>		 
                                    
				        </ul>
				    </div>
				</div><!-- language-proficiency -->		

				<div class="personal-deatils section">
				    <div class="icons">
				        <i class="fa fa-user-secret" aria-hidden="true"></i>
				    </div>  
				    <div class="personal-info">
				    	<h3>Personal Deatils</h3>
				        <ul class="address">
				            <li><h5>Full Name </h5> <span>:</span><?php echo $full_names;?></li>
				            <li><h5>Father's Name </h5> <span>:</span><?php echo $father_name;?></li>
				            <li><h5>Mother's Name </h5> <span>:</span><?php echo $mother_name;?></li>
				            <li><h5>Date of Birth </h5> <span>:</span><?php echo $dob;?></li>
				            <li><h5>Birth Place </h5> <span>:</span><?php echo $birth_place;?></li>
				            <li><h5>Nationality </h5> <span>:</span><?php echo $nationality;?></li>
				            <li><h5>Sex </h5> <span>:</span><?php echo $sex;?></li>
				            <li><h5>Address </h5> <span>:</span><?php echo $address;?></li>
				        </ul>    	
				    </div>                               
				</div><!-- personal-deatils -->	

				<div class="declaration section">
			        <div class="icons">
			            <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
			        </div>   
			        <div class="declaration-info">
			        	<h3>Declaration</h3>
			        	<p><span><?php echo $declaration;?></span></p>
			        </div>                                 
				</div><!-- career-objective -->									
				<div class="buttons">
					<a href="#" class="btn">Send Email</a>
				</div>
				<div class="download-button">
					<a href="<?php echo SERVER_ROOTPATH;?>download_resume.php?seeker_id=<?php echo $_REQUEST['seeker_id'];?>" class="btn">Download Resume as doc</a>
				</div>
			</div><!-- resume-content -->						
		</div><!-- container -->
	</section><!-- ad-profile-page -->
	<?php include("common/footer.php");?>   
  </body>
</html>
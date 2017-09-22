<?php
include("common/top.php");
include("common/functions.php");
$get_jobid = $_REQUEST['job_id'];

$job_info  =  jobs_detail($get_jobid);
$main_cat =  get_job_category_details($job_info['job_category']);

$job_description  = nl2br(stripslashes($job_info['job_description']));

$company_name	=	stripslashes($job_info['company_name']);
$mobile_no	=	stripslashes($job_info['mobile_no']);
$address	=	stripslashes($job_info['address']);
$company_name	=	stripslashes($job_info['company_name']);

$industry	=	stripslashes($job_info['industry']);
$country_id  = stripslashes($job_info['job_country']);
$state_id  = stripslashes($job_info['job_state']);
$city_id  = stripslashes($job_info['job_city']);
$job_type  = stripslashes($job_info['job_type']);
$job_function  = stripslashes($job_info['job_function']);
$job_experience_level	= stripslashes($job_info['job_experience_level']);

$expiry_date  = stripslashes($job_info['expiry_date']);

$exp_level	=	get_job_expeience_level_info($job_experience_level);

$job_salary_min  = stripslashes($job_info['job_salary_min']);
$job_salary_max  = stripslashes($job_info['job_salary_max']);

$country_name = country_name($country_id);
$state_name = state_name($country_id, $state_id);
$city_name = city_name($country_id, $state_id, $city_id);

$type_info = get_emp_type_name($job_type);

if($job_info['job_subcategory']!=0)
{
	$sub_main_cat =  get_job_category_details($job_info['job_subcategory']);
	$sub_main_cat_name	=	stripslashes($sub_main_cat['category_name']);
}
else
{
	$sub_main_cat_name = '';
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title><?php echo stripslashes($job_info['job_title']);?> job detail</title>
 	<?php include("common/top_script.php");?>
    <style type="text/css">
		.job-ad-item .ad-meta li
		{
			margin-left:9px;
		}
	</style>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	<section class="job-bg page job-details-page">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>">Home</a></li>
					<li><a href="#"><?php  echo stripslashes($main_cat['category_name']);?></a></li>
                    <?php if($sub_main_cat_name!='')
					{
						?>
                        <li><?php echo $sub_main_cat_name;?></li>
                        <?php
					}
					?>
					
				</ol><!-- breadcrumb -->						
				<h2 class="title"><?php echo stripslashes($job_info['job_title']);?></h2>
			</div><!-- breadcrumb -->

			<div class="banner-form banner-form-full job-list-form">
				<form action="<?php echo SERVER_ROOTPATH;?>job-list" method="post">
					<!-- category-change -->
					<div class="dropdown category-dropdown" style="padding:0; width:18%;">						
						
						
						<select name="job_category" class="form-control"  style="width:100%;"  onChange="get_category(this.value)">
						<option value="">Job Category</option><?php
                            $main_cat  =  get_job_main_categories_list();
                            if($main_cat)
                            {
                            
                                $s=1;
                                foreach($main_cat as $row_category)
                                {
                                    ?>
                                    <option value="<?php echo stripslashes($row_category['category_id']);?>" <?php if($_SESSION['search']['job_category'] == $row_category['category_id']){?> selected<?php }?>><?php echo stripslashes($row_category['category_name']);?></option>
                                    <?php
                                    
                                }
                             }?>
                            </select> 
                            
                            
                            
                            					
					</div><!-- category-change -->
                    
                    <div class="dropdown category-dropdown" style="padding:0; width:18%;">						
						
						<div id="category_data">
						<select class="form-control classic" onChange="get_category(this)" name="job_subcategory" id="job_subcategory" style="width:100%;">
<option value="">Select Sub Category</option>
                                        	<?php
											if($_SESSION['search']['job_category']!='')
											{
												$list_category  =  get_job_main_categories($_SESSION['search']['job_category']);	 
												$n=1; 
												if($list_category)
												{
													
													foreach($list_category as $row_cat)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_cat['category_id']);?>" <?php if($_SESSION['search']['job_subcategory']==$row_cat['category_id']){?> selected<?php }?>><?php echo stripslashes($row_cat['category_name']);?></option>
                                                        <?php
													}
												  }	
												} 
												?>
                                               
                                        </select>
                        </div>                
                                        
                            
                            
                            
                            					
					</div>
					
                    <div class="dropdown category-dropdown" style="padding:0; width:18%;">						
						<?php $list_country =  country_list_job();?>
						<select class="form-control classic" onChange="get_state_jobs(this.value)"  style="width:100%;"  name="job_country" id="job_country" >
                                       <option value="">Country</option>
                                        	 <?php
												$n=1; 
												if($list_country)
												{
													foreach($list_country as $row_list)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_list['CountryId']);?>" <?php if($_SESSION['search']['job_country']==$row_list['CountryId']){?> selected<?php }?>><?php echo stripslashes($row_list['Country']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>
						
                           
                            					
					</div>
                    
                    <div class="dropdown category-dropdown" style="padding:0; width:18%;">						
						
						<div  id="state_div">
						<select class="form-control classic" name="job_state" onChange="get_city_jobs(this.value, <?php echo $_SESSION['search']['job_country'];?>)" style="width:100%;">
												<option value="">State</option>
											  <?php
											if($_SESSION['search']['job_country'])
											{ 
											  if($_SESSION['search']['job_country']!='')
												{
												$list_state  =  state_list($_SESSION['search']['job_country']);
												}
												?>
												
												<?php 
													$n=1; 
													if($list_state)
													{
														
														foreach($list_state as $row_list)
														{
															?>
															 <option value="<?php echo stripslashes($row_list['RegionID']);?>" <?php if($_SESSION['search']['job_state']==$row_list['RegionID']){?> selected<?php }?>><?php echo stripslashes($row_list['Region']);?></option>
															<?php
														}
													}	
												?>
												
											                                     
                                           <?php
										   }
										   ?> 
                                           </select>
                        </div>
                            					
					</div>
                    
                    <div class="dropdown category-dropdown" style="padding:0; width:18%;">						
						
					 <div id="city_div"> 
                     	<select class="form-control classic" name="job_city" style="width:100%;" >
                                    <option value="">City</option>
                                            <?php
											if($_SESSION['search']['job_city'])
											{
														$country_id  =  $_SESSION['search']['job_country'];
														$state_id  =  $_SESSION['search']['job_state'];
														if($country_id!="" && $state_id!='')
														{
														$list_state  =  city_list($state_id, $country_id);
														}
														?>
											  
												<?php 
													$n=1; 
													if($list_state)
													{
														
														foreach($list_state as $row_list)
														{
															?>
															 <option value="<?php echo stripslashes($row_list['CityId']);?>" <?php if($_SESSION['search']['job_city']==$row_list['CityId']){?> selected<?php }?>><?php echo stripslashes($row_list['City']);?></option>
															<?php
														}
													}	
												}	
												?>
                                    
                                    </select>
						
                      </div>      
                            
                            
                            					
					</div>
					
					<input type="text" class="form-control" placeholder="Type your keyword" name="keyword" value="<?php echo $_SESSION['search']['keyword'];?>" style="margin-left: 10px; width: 90%;">
					<button type="submit" class="btn btn-primary" value="Search" name="submit_search">Search</button>
				</form>
			</div><!-- banner-form -->

			<div class="job-details">
				<div class="section job-ad-item">
					<div class="item-info">
						<div class="item-image-box col-md-1">
							<div class="item-image  " style="padding:0;">
                              <?php
					if($job_info['image']!='')
					{
						$com_img_url  = SERVER_ROOTPATH."media/emp_images/".$job_info['image'];
					}
					else
					{
						$com_img_url  = SERVER_ROOTPATH."images/no-image.png";
					}
					?>
						<img src="<?php echo $com_img_url;?>" alt="" class="img-responsive" style="width:100%; height:100%;" >
							</div><!-- item-image -->
						</div>

						<div class="ad-info  col-md-11">
							<span><span><a class="title"><?php echo stripslashes($job_info['job_title']);?></a></span> </span>
							<div class="ad-meta">
								<ul>
									<li><a href="#"><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo stripslashes($city_name['City']);?>, <?php echo stripslashes($state_name['Region']);?> , <?php echo stripslashes($country_name['Country']);?></a></li>
									<li><a href="#"><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo stripslashes($type_info['emp_title']);?></a></li>
									<li><i class="fa fa-money" aria-hidden="true"></i>$<?php echo $job_salary_min;?> - $<?php echo $job_salary_max;?></li>
									<li><a href="#"><i class="fa fa-tags" aria-hidden="true"></i><?php echo $job_function;?></a></li>
									<li><i class="fa fa-hourglass-start" aria-hidden="true"></i>Deadline : <?php echo date("M d, Y", strtotime($expiry_date));;?></li>
								</ul>
							</div><!-- ad-meta -->									
						</div><!-- ad-info -->
					</div><!-- item-info -->
					<div class="social-media" style="margin-left:10px;">
						<div class="button col-md-7">
                        <?php
							if($_SESSION['jobseeker']['id']!='')
							{
								$check = job_applied_check($get_jobid);
								if($check)
								{
								?>
                                <a  class="btn btn-primary"><i class="fa fa-briefcase" aria-hidden="true"></i>You Already Applied For This Job</a>
                                <?php
								}
								else
								{
									?>
                                <a href="javascript:;"  id="job_<?php echo $get_jobid;?>" class="btn btn-primary" onClick="apply_for_job(<?php echo $get_jobid;?>)"><i class="fa fa-briefcase" aria-hidden="true"></i>Apply For This Job</a>
                                <?php
								}
							}
							else
							{
								?>
                                <a href="javascript:;"  id="job_<?php echo $get_jobid;?>" class="btn btn-primary" onClick="apply_for_job(<?php echo $get_jobid;?>)"><i class="fa fa-briefcase" aria-hidden="true"></i>Apply For This Job</a>
                                <?php
							}
						?>
							 <span id="success_<?php echo $get_jobid;?>" style="color:#009900;"></span>
							 <span id="bookmark"><a href="javascript:;" onClick="bookmark_job(<?php echo $get_jobid;?>)"  class="btn btn-primary bookmark"><i class="fa fa-bookmark-o" aria-hidden="true"></i><?php $check = job_bookmark_check($get_jobid);
		if(!$check){ echo "Bookmark";} else {echo "Remove Bookmark";}?></a></span>
						</div>
						<!-- Go to www.addthis.com/dashboard to customize your tools -->
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<div class="addthis_inline_share_toolbox_49gb col-md-4"></div>
                        
                        
					</div>					
				</div><!-- job-ad-item -->
				
				<div class="job-details-info">
					<div class="row">
						<div class="col-sm-8">
							<div class="section job-description">
								<div class="description-info">
									<h1>Description</h1>
									<p><?php echo $job_description;?></p>
								</div>
								
															
							</div>							
						</div>
						<div class="col-sm-4">
							<div class="section job-short-info">
								<h1>Short Info</h1>
								<ul>
									<li><span class="icon"><i class="fa fa-bolt" aria-hidden="true"></i></span>
                                    <?php
										$posted_date = $job_info['posted_date'];
									
										$now = time(); // or your date as well
										$your_date = strtotime($posted_date);
										$datediff = $now - $your_date;
										$diff = floor($datediff / (60 * 60 * 24));
										
										

                                    ?>
                                    Posted: <?php if($diff<1){ echo "Today";} else {  if($diff==1){  echo $diff." day ago"; } else {  echo $diff." days ago";}}?> </li>
									<li><span class="icon"><i class="fa fa-industry" aria-hidden="true"></i></span>Industry: <a><?php echo $industry;?></a></li>
									<li><span class="icon"><i class="fa fa-line-chart" aria-hidden="true"></i></span>Experience: <a><?php echo stripslashes($exp_level['exp_title']);?></a></li>
									<li><span class="icon"><i class="fa fa-key" aria-hidden="true"></i></span>Job function: <?php echo $job_function;?></li>
								</ul>
							</div>
							<div class="section company-info">
								<h1>Company Info</h1>
								<ul>
									<li>Compnay Name: <a><?php echo $company_name;?></a></li>
									<li>Address: <?php echo $address;?></li>
									<li>Compnay SIze:  2k Employee</li>
									<li>Industry:  <?php echo $industry;?></li>
									<li>Phone:  <?php echo $mobile_no;?></li>									
								</ul>
								<ul class="share-social">
									<li><a href="#"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-twitter-square" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-google-plus-square" aria-hidden="true"></i></a></li>
									<li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
								</ul>								
							</div>
						</div>
					</div><!-- row -->					
				</div><!-- job-details-info -->				
			</div><!-- job-details -->
		</div><!-- container -->
	</section><!-- job-details-page -->

	<section id="something-sell" class="clearfix parallax-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="title">Add your resume and let your next job find you.</h2>
					<h4>Post your Resume for free on <a href="#">Jobs.com</a></h4>
					<a href="post-resume.html" class="btn btn-primary">Add Your Resume</a>
				</div>
			</div><!-- row -->
		</div><!-- contaioner -->
	</section><!-- something-sell -->
	

	
	
	<?php include("common/footer.php");?>   
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-536326df13c83e5f"></script>


  </body>
</html>
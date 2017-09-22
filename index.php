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

    <title>Welcome to Job Portal</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
        
    <!-- header -->
	<?php include("common/main_banner.php");?>   
	<!-- banner-section -->

	<div class="page">
		<div class="container">
        <?php
		$list_job_categories  =  get_job_main_categories(0);		
		?>
			<div class="section category-items job-category-items  text-center">
				<ul class="category-list">	
                <?php
					foreach($list_job_categories as $row_cat)
					{
						if($row_cat['category_image']=='')
						{
							$img_url  = SERVER_ROOTPATH."images/no-image.png";
						}
						else
						{
							$img_url  = SERVER_ROOTPATH."media/category/".$row_cat['category_image'];
						}
						
						 $query_Cat		=	"Select count(*) as total_job from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND j.job_category = '".$row_cat['category_id']."'";	
						 $cat_arr			=	$db->get_row($query_Cat,ARRAY_A);	 		
						?>
                        <li class="category-item">
						<a href="<?php echo SERVER_ROOTPATH;?>job-category/<?php echo base64_encode($row_cat['category_id']);?> ">
							<div class="category-icon"><img src="<?php echo $img_url;?>" alt="images" style="max-width:50px;" class="img-responsive"></div>
							<span class="category-title"><?php echo stripslashes($row_cat['category_name']);?></span>
							<span class="category-quantity">(<?php echo $cat_arr['total_job'];?>)</span>
						</a>
					</li>
                        <?php
					}
				?>
					
				</ul>				
			</div><!-- category ad -->			

			<div class="section latest-jobs-ads">
				<div class="section-title tab-manu">
					<h4>Latest Jobs</h4>					
				</div>

				<div class="tab-content">
				 

					<div role="tabpanel" class="tab-pane fade in active" id="popular-jobs">
						<?php
								 $jobs_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1  order by j.id desc LIMIT 5";	
	 		 $list_jobs			=	$db->get_results($jobs_query,ARRAY_A);	 							
                 if($list_jobs)
				 {   					
					foreach($list_jobs as $row_info)
					{
						$job_id  = stripslashes($row_info['id']);
						$job_title  = stripslashes($row_info['job_title']);
						$country_id  = stripslashes($row_info['job_country']);
						$state_id  = stripslashes($row_info['job_state']);
						$city_id  = stripslashes($row_info['job_city']);
						$job_type  = stripslashes($row_info['job_type']);
						$job_function  = stripslashes($row_info['job_function']);
						$company_name  = stripslashes($row_info['company_name']);
						
						$job_salary_min  = stripslashes($row_info['job_salary_min']);
						$job_salary_max  = stripslashes($row_info['job_salary_max']);
						
						$image  = stripslashes($row_info['image']);
						
						$country_name = country_name($country_id);
						$state_name = state_name($country_id, $state_id);
						$city_name = city_name($country_id, $state_id, $city_id);
						
						$type_info = get_emp_type_name($job_type);
						
						if($image!="")
						{
							$img_url = SERVER_ROOTPATH. "media/emp_images/".$image;
						}
						else
						{
							$img_url = SERVER_ROOTPATH. "images/no-image.png";
						}
						
						?>
                        <div class="job-ad-item">
								<div class="item-info">
									<div class="item-image-box">
										<div class="item-image col-md-3 padding_all" >
											<a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>"><img style="height:100%;" src="<?php echo $img_url;?>" alt="Image" class="img-responsive"></a>
										</div><!-- item-image -->
									</div>

									<div class="ad-info col-md-9 padding_all">
										<span><a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>" class="title"><?php echo $job_title;?></a> @ <a href="#"><?php echo $company_name;?></a></span>
										<div class="ad-meta">
										<ul>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo stripslashes($city_name['City']);?>, <?php echo stripslashes($state_name['Region']);?> , <?php echo stripslashes($country_name['Country']);?> </li>
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo stripslashes($type_info['emp_title']);?></li>
                                            <li><i class="fa fa-money" aria-hidden="true"></i>$<?php echo $job_salary_min;?> - $<?php echo $job_salary_max;?></li>
                                           	<li><i class="fa fa-tags" aria-hidden="true"></i><?php echo $job_function;?></li>
                                        </ul>
										</div><!-- ad-meta -->									
									</div><!-- ad-info -->
								</div><!-- item-info -->
							</div>
                        <?php
					}
				 }
				 else
				 {
				 		?>
                        <div class="alert alert-danger"><strong>Alert!</strong> No Record found.</div>
                        <?php
				 }
						?>
						
					</div><!-- tab-pane -->
				</div><!-- tab-content -->
			</div><!-- trending ads -->		

			<div class="ad-section text-center" style="display:none;">
				<a href="#"><img src="<?php echo SERVER_ROOTPATH;?>images/ads/3.jpg" alt="Image" class="img-responsive"></a>
			</div><!-- ad-section -->

			<div class="section workshop-traning" style="display:none;">
				<div class="section-title">
					<h4>Workshop Traning</h4>
					<a href="#" class="btn btn-primary">See all</a>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="workshop">
							<img src="<?php echo SERVER_ROOTPATH;?>images/job/5.png" alt="Image" class="img-responsive">
							<h3><a href="#">Business Process Management Training</a></h3>
							<h4>Course Duration: 3 Month ( Sat, Mon, Fri)</h4>
							<div class="workshop-price">
								<h5>Course instructor: Kim Jon ley</h5>
								<h5>Course Amount: $200</h5>
							</div>
							<div class="ad-meta">
								<div class="meta-content">
									<span class="dated"><a href="#">7 Jan 10:10 pm </a></span>
								</div>
								<div class="user-option pull-right">
									<a href="#"><i class="fa fa-map-marker"></i> </a>
								</div>
							</div>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="workshop">
							<img src="<?php echo SERVER_ROOTPATH;?>images/job/6.png" alt="Image" class="img-responsive">
							<h3><a href="#">Employee Motivation and Engagement</a></h3>
							<h4>Course Duration: 3 Month ( Sat, Mon, Fri)</h4>
							<div class="workshop-price">
								<h5>Course instructor: Kim Jon ley</h5>
								<h5>Course Amount: $200</h5>
							</div>
							<div class="ad-meta">
								<div class="meta-content">
									<span class="dated"><a href="#">7 Jan 10:10 pm </a></span>
								</div>
								<div class="user-option pull-right">
									<a href="#"><i class="fa fa-map-marker"></i> </a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!-- workshop-traning -->
			<?php $resources = get_resources();	?>		

		</div><!-- conainer -->
	</div><!-- page -->
	
	<!-- download -->
	<section id="download" class="clearfix parallax-section" style="display:none;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2>Download on App Store</h2>
				</div>
			</div><!-- row -->

			<!-- row -->
			<div class="row">
				<!-- download-app -->
				<div class="col-sm-4">
					<a href="#" class="download-app">
						<img src="images/icon/16.png" alt="Image" class="img-responsive">
						<span class="pull-left">
							<span>available on</span>
							<strong>Google Play</strong>
						</span>
					</a>

				</div><!-- download-app -->

				<!-- download-app -->
				<div class="col-sm-4">
					<a href="#" class="download-app">
						<img src="images/icon/17.png" alt="Image" class="img-responsive">
						<span class="pull-left">
							<span>available on</span>
							<strong>App Store</strong>
						</span>
					</a>
				</div><!-- download-app -->

				<!-- download-app -->
				<div class="col-sm-4">
					<a href="#" class="download-app">
						<img src="images/icon/18.png" alt="Image" class="img-responsive">
						<span class="pull-left">
							<span>available on</span>
							<strong>Windows Store</strong>
						</span>
					</a>
				</div><!-- download-app -->
			</div><!-- row -->
		</div><!-- contaioner -->
	</section><!-- download -->
	
	<section id="something-sell" class="clearfix parallax-section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center">
					<h2 class="title">Add your resume and let your next job find you.</h2>
					<h4>Post your Resume for free on <a href="#">Jobs.com</a></h4>
					<a href="<?php echo SERVER_ROOTPATH;?>signup" class="btn btn-primary">Add Your Resume</a>
				</div>
			</div><!-- row -->
		</div><!-- contaioner -->
	</section><!-- something-sell -->
	<?php include("common/footer.php");?>  


  </body>
</html>  

<?php
include("common/top.php");
include("common/functions.php");
if($_SESSION['employer_email']=='')
{
	?>
    <script type="text/javascript">
		window.location.href = "<?php echo SERVER_ROOTPATH;?>employer-signup";
	</script>
    <?php
	exit;
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

    <title>Post a Job  | Job Portal</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->
	
	<!-- banner-section -->

	<section class=" job-bg ad-details-page">
		<div class="container">
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li>Job Post </li>
				</ol><!-- breadcrumb -->						
				<h2 class="title">Post Your Job</h2>
			</div><!-- banner -->

			<div class="job-postdetails">
				<div class="row">	
					<div class="col-md-8">
						<form action="" method="post" name="signup_form" id="signup_form">
							<fieldset>
								<div class="section postdetails">
									<h4>Post Your Job<span class="pull-right">* Mandatory Fields</span></h4>
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Job Category</label>
										<div class="col-sm-9">
                                        <?php $list_category  =  get_job_main_categories(0);?>
                                       <select class="form-control classic" onChange="get_category(this.value)" name="job_category" id="job_category">
                                       <option value="">Select Category</option>
                                        	 <?php
												 
												$n=1; 
												if($list_category)
												{
													
													foreach($list_category as $row_cat)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_cat['category_id']);?>"><?php echo stripslashes($row_cat['category_name']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>
                                       	
										</div>
									</div>
                                    
                                    <div class="row form-group add-title" id="display_subcat" style="display:none">
										<label class="col-sm-3 label-title">Sub Category</label>
										<div class="col-sm-9">
                                       		<div id="category_data"></div>	
										</div>
									</div>			
									<div class="row form-group">
										<label class="col-sm-3">Job Type<span class="required">*</span></label>
										<div class="col-sm-9 user-type">
											<?php
                                                $list_emp_type  =  get_emp_type();
											  
												if($list_emp_type)
												{
													
													foreach($list_emp_type as $row_type)
													{
														?>
                                                          <input type="radio" name="jobtype"  id="jobtype_<?php echo stripslashes($row_type['emp_id']);?>" value="<?php echo stripslashes($row_type['emp_id']);?>"> <label for="jobtype_<?php echo stripslashes($row_type['emp_id']);?>"><?php echo stripslashes($row_type['emp_title']);?></label>
                                                        <?php
													}
												}	
												?>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Title for your job<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" placeholder="ex, Human Resource Manager" name="job_title">
										</div>
									</div>					
									<div class="row form-group item-description">
										<label class="col-sm-3 label-title">Description<span class="required">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" id="textarea" placeholder="Write few lines about your jobs" rows="8" name="job_description"></textarea>		
										</div>
									</div>
									<div class="row characters">
										<div class="col-sm-9 col-sm-offset-3">
											
										</div>
									</div>	
									<div class="row form-group add-title location">
										<label class="col-sm-3 label-title">Location<span class="required">*</span></label>
										<div class="col-sm-9">
											<div class="col-sm-4">
												  <?php $list_country =  country_list();?>
                                       <select class="form-control classic" onChange="get_state(this.value)" name="job_country" id="job_country" >
                                       <option value="">Country</option>
                                        	 <?php
												 
												$n=1; 
												if($list_country)
												{
													
													foreach($list_country as $row_list)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_list['CountryId']);?>"><?php echo stripslashes($row_list['Country']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>						
											</div>
                                            <div class="col-sm-4" id="state_div">
											  <select class="form-control classic"  name="job_state" >
                                               <option value="">State</option>
                                               
                                               </select>
                                               
                                   </div>
                                            <div class="col-sm-4" id="city_div">
												 <select class="form-control classic"  name="job_city" >
                                               <option value="">City</option>
                                               
                                               </select>
                                               
                                            </div>
										</div>
									</div>
									<div class="row form-group select-price">
										<label class="col-sm-3 label-title">Salary<span class="required">*</span></label>
										<div class="col-sm-9">
											<label>$USD</label>
											<input type="text" class="form-control" placeholder="Min" name="job_salary_min">
											<span>-</span>
											<input type="text" class="form-control" placeholder="Max" name="job_salary_max">
											<input type="radio" value="1" name="negotiable" id="negotiable">
											<label for="negotiable">Negotiable </label>
										</div>
									</div>	
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Salary Type<span class="required">*</span></label>
										<div class="col-sm-9">
										  <?php
											$list_job_salary  =  get_job_salary_type();
										
										?>
                                        <select class="form-control classic" name="job_salary_type">
                                        	 <?php
												 
												$n=1; 
												if($list_job_salary)
												{
													$count_salary_type = count($list_job_salary);
													foreach($list_job_salary as $row_type)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_type['id']);?>"><?php echo stripslashes($row_type['title']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>
                                    
											
										</div>
									</div>	
                                    
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Exprience<span class="required">*</span></label>
										<div class="col-sm-9">
                                        
											 <?php
											$list_job_salary  =  get_job_expeience_level();
										
										?>
                                        <select class="form-control classic" name="job_experience_level">
                                        	 <?php
												if($list_job_salary)
												{
													foreach($list_job_salary as $row_type)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_type['exp_id']);?>"><?php echo stripslashes($row_type['exp_title']);?></option>
                                                        <?php
													}
												}	
												?>
                                        </select>
										</div>
									</div>	
									<div class="row form-group brand-name">
										<label class="col-sm-3 label-title">Job Function<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" placeholder="human, reosurce, job, hrm" name="job_function">
										</div>
									</div>											
								</div><!-- postdetails -->
								
								<div class="section company-information">
									<h4>Company Information</h4>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Industry<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="industry" class="form-control" placeholder="Marketing and Advertising">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Company Name<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="company_name" class="form-control" placeholder="ex, Olx">
										</div>
									</div>
                                    
                                    <div class="row form-group">
										<label class="col-sm-3 label-title">Password<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="password" name="password" class="form-control" placeholder="Type your password">
										</div>
									</div>
									
									<div class="row form-group">
										<label class="col-sm-3 label-title">Mobile Number<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="mobile_no" class="form-control" placeholder="ex, +912457895">
										</div>
									</div>
									<div class="row form-group address">
										<label class="col-sm-3 label-title">Address<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" name="address" class="form-control" placeholder="ex, alekdera House, coprotec, usa">
										</div>
									</div>
								</div><!-- section -->
								
								<!-- section -->
								
								<div class="checkbox section agreement">
									<label for="send">
										<input type="checkbox" name="agree" id="send" value="1">
										You agree to our <a href="#">Terms of Use</a> and <a href="#">Privacy Policy</a> and acknowledge that you are the rightful owner of this item and using Jobs to find a genuine buyer.
									</label>
									<input type="submit" class="btn btn-primary" onClick="return validate_add(4);" id="button1" value="Post Your Job">
                                    <div id="preloader_div"></div>
								</div><!-- section -->
								
							</fieldset>
						</form><!-- form -->	
					</div>
				

					<!-- quick-rules -->	
					<div class="col-md-4">
						<div class="section quick-rules">
							<h4>Quick rules</h4>
							<p class="lead">Posting an ad on <a href="#">jobs.com</a> is free! However, all ads must follow our rules:</p>

							<ul>
								<li>Make sure you post in the correct category.</li>
								<li>Do not post the same ad more than once or repost an ad within 48 hours.</li>
								<li>Do not upload pictures with watermarks.</li>
								<li>Do not post ads containing multiple items unless it's a package deal.</li>
								<li>Do not put your email or phone numbers in the title or description.</li>
								<li>Make sure you post in the correct category.</li>
								<li>Do not post the same ad more than once or repost an ad within 48 hours.</li>
								<li>Do not upload pictures with watermarks.</li>
								<li>Do not post ads containing multiple items unless it's a package deal.</li>
							</ul>
						</div>
					</div><!-- quick-rules -->	
				</div><!-- photos-ad -->				
			</div>	
		</div><!-- container -->
	</section>
	
	<?php include("common/footer.php");?>   
  </body>
</html>
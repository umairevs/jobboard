<?php
include("common/top.php");
include("common/security_login.php");
include("common/functions.php");

if($_REQUEST['job_id']!='')
{
	$job_info	=	get_edit_job($_REQUEST['job_id'], $_SESSION['employer']['id']);
	if(!$job_info)
	{
		header("location:".SERVER_ROOTPATH."emp-jobs-list");
		exit;
	}
		$page_show = "Edit";
		$button_text  = "Update Your Job";
	
}
else
{
	$page_show = "Add new";
	$button_text  = "Post Your Job";
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

    <title><?php echo $page_show;?> Job</title>
 	<?php include("common/top_script.php");?>   
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->


<section class=" job-bg page  ad-profile-page">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>emp-profile">Home</a></li>
					<li><a href="<?php echo SERVER_ROOTPATH;?>emp-jobs-list">Job Listing</a></li>
                    <li><?php echo $page_show;?> Job</li>                    
				</ol>						
				<h2 class="title"><?php echo $page_show;?> Job</h2>
			</div><!-- breadcrumb-section -->
			
			<?php include("common/profile_area.php");?> 
            
            <!-- ad-profile -->

			<div class="job-postdetails">
				<div class="row">	
					<div class="col-md-8">
						<form action="" method="post" name="signup_form" id="signup_form">
							<fieldset>
								<div class="section postdetails">
									<h4>Post Your Job<span class="pull-right">* Mandatory Fields</span></h4>
                                    
                                       <?php if($_SESSION['success']['jobmsg']!='')
					{
					?>
					<div class="form-group">
					<div class="alert alert-success" style="margin-bottom:0;">
					<strong>Success!</strong> <?php echo $_SESSION['success']['jobmsg'];?>
					</div>
					</div><br>
					<?php
					unset($_SESSION['success']);
					}
					?>
                    
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Job Category<span class="required">*</span></label>
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
                                                         <option value="<?php echo stripslashes($row_cat['category_id']);?>" <?php if($job_info['job_category']==$row_cat['category_id']){?> selected<?php }?>><?php echo stripslashes($row_cat['category_name']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>
                                       	
										</div>
									</div>
                                    
                                    <div class="row form-group add-title" id="display_subcat">
										<label class="col-sm-3 label-title">Sub Category</label>
										<div class="col-sm-9">
                                       		<div id="category_data">
                                            	<select class="form-control classic" onChange="get_category(this)" name="job_subcategory" id="job_subcategory">
<option value="">Select Sub Category</option>
                                        	<?php
											if($job_info)
											{
												$list_category  =  get_job_main_categories($job_info['job_category']);	 
												$n=1; 
												if($list_category)
												{
													
													foreach($list_category as $row_cat)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_cat['category_id']);?>" <?php if($job_info['job_subcategory']==$row_cat['category_id']){?> selected<?php }?>><?php echo stripslashes($row_cat['category_name']);?></option>
                                                        <?php
													}
												  }	
												} 
												?>
                                               
                                        </select>
                                            </div>	
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
                                                          <input type="radio" name="jobtype"  id="jobtype_<?php echo stripslashes($row_type['emp_id']);?>" value="<?php echo stripslashes($row_type['emp_id']);?>" <?php if($job_info['job_type']==$row_type['emp_id']){?> checked<?php }?>> <label for="jobtype_<?php echo stripslashes($row_type['emp_id']);?>"><?php echo stripslashes($row_type['emp_title']);?></label>
                                                        <?php
													}
												}	
												?>
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Title for your job<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" placeholder="ex, Human Resource Manager" name="job_title" value="<?php echo stripslashes($job_info['job_title']);?>">
										</div>
									</div>					
									<div class="row form-group item-description">
										<label class="col-sm-3 label-title">Description<span class="required">*</span></label>
										<div class="col-sm-9">
											<textarea class="form-control" id="textarea" placeholder="Write few lines about your jobs" rows="8" name="job_description"><?php echo stripslashes($job_info['job_description']);?></textarea>		
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
                                                         <option value="<?php echo stripslashes($row_list['CountryId']);?>" <?php if($job_info['job_country']==$row_list['CountryId']){?> selected<?php }?>><?php echo stripslashes($row_list['Country']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>						
											</div>
                                            <div class="col-sm-4" id="state_div">
                                            <select class="form-control classic" name="job_state" onChange="get_city(this.value, <?php echo $_REQUEST['country_id'];?>)">
												<option value="">State</option>
											  <?php
											if($job_info)
											{ 
											  if($job_info['job_country']!='')
												{
												$list_state  =  state_list($job_info['job_country']);
												}
												?>
												
												<?php 
													$n=1; 
													if($list_state)
													{
														
														foreach($list_state as $row_list)
														{
															?>
															 <option value="<?php echo stripslashes($row_list['RegionID']);?>" <?php if($job_info['job_state']==$row_list['RegionID']){?> selected<?php }?>><?php echo stripslashes($row_list['Region']);?></option>
															<?php
														}
													}	
												?>
												
											                                     
                                           <?php
										   }
										   ?> 
                                           </select> 
                                   </div>
                                   
                                            <div class="col-sm-4" id="city_div"> 
												
                                          <select class="form-control classic" name="job_city" >
                                    <option value="">City</option>
                                            <?php
											if($job_info)
											{
														$country_id  =  $job_info['job_country'];
														$state_id  =  $job_info['job_state'];
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
															 <option value="<?php echo stripslashes($row_list['CityId']);?>" <?php if($job_info['job_city']==$row_list['CityId']){?> selected<?php }?>><?php echo stripslashes($row_list['City']);?></option>
															<?php
														}
													}	
												}	
												?>
                                    
                                    </select>
                                               
                                            </div>
										</div>
									</div>
									<div class="row form-group select-price">
										<label class="col-sm-3 label-title">Salary<span class="required">*</span></label>
										<div class="col-sm-9">
											<label>$USD</label>
											<input type="text" class="form-control" placeholder="Min" name="job_salary_min" value="<?php echo $job_info['job_salary_min'];?>">
											<span>-</span>
											<input type="text" class="form-control" placeholder="Max" name="job_salary_max" value="<?php echo $job_info['job_salary_max'];?>">
											<input type="checkbox"  value="1" name="negotiable" id="negotiable" value="1" <?php if($job_info['negotiable']==1){?> checked<?php }?> >
											<label for="negotiable">Negotiable </label>
										</div>
									</div>	
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Salary Type<span class="required">*</span></label>
										<div class="col-sm-9">
										  <?php
											$list_job_salary  =  get_job_salary_type();
										
										?>
                                        <select class="form-control classic_border" name="job_salary_type">
                                        	 <?php
												 
												$n=1; 
												if($list_job_salary)
												{
													$count_salary_type = count($list_job_salary);
													foreach($list_job_salary as $row_type)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_type['id']);?>" <?php if($job_info['job_salary_type']==$row_type['id']){?> selected<?php }?>><?php echo stripslashes($row_type['title']);?></option>
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
                                        <select class="form-control classic_border" name="job_experience_level">
                                        	 <?php
												if($list_job_salary)
												{
													foreach($list_job_salary as $row_type)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_type['exp_id']);?>" <?php if($job_info['job_experience_level']==$row_type['exp_id']){?> selected<?php }?>><?php echo stripslashes($row_type['exp_title']);?></option>
                                                        <?php
													}
												}	
												?>
                                        </select>
										</div>
									</div>	
									<div class="row form-group add-title">
										<label class="col-sm-3 label-title">Job Function<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text" class="form-control" placeholder="human, reosurce, job, hrm" name="job_function" value="<?php echo stripslashes($job_info['job_function']);?>">
										</div>
									</div>	
                                    
                                    <div class="row form-group add-title-name">
										<label class="col-sm-3 label-title">Job Expire Date<span class="required">*</span></label>
										<div class="col-sm-9">
											<input type="text"  class="dpick form-control" readonly placeholder="" value="<?php echo stripslashes($job_info['expiry_date']);?>" name="expiry_date" >
                                            
										</div>
									</div>
                                    
                                    <div class="checkbox section agreement">
                                    <?php
									if($job_info)
									{
										?>
                                        <input type="hidden" name="edit_id" value="<?php echo $_REQUEST['job_id'];?>">
                                        <?php
									}
									?>
									<input type="submit" class="btn btn-primary" onClick="return validate_add(8);" id="button1" value="<?php echo $button_text;?>">
                                    <div id="preloader_div"></div>
								</div>
                                										
								</div><!-- postdetails -->
								
								
								
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
								
							</ul>
						</div>
					</div><!-- quick-rules -->	
				</div><!-- photos-ad -->				
			</div><!-- latest-jobs-ads -->									
		</div><!-- container -->
	</section>

	
	
	<?php include("common/footer.php");?>   
<script type="text/javascript">

	
$(function() {
                $(".dpick").datepicker({minDate: '1', dateFormat: 'yy-mm-dd' });
});

function remove_area(val)s
{
	 
	
	 $(".showdiv_2").remove();
	
	 
}
 
$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
   
    var x = 1; //initlal text box count
    $("#add_new").click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div class="showdiv_'+x+'"><hr><div class="form-group"><label>Skill Name</label><input type="text" name="name" class="form-control" placeholder=""></div><div class="form-group"><label>Rating</label><div class="rating-star"><div class="rating"><input id="star1" name="rating" type="radio"><label class="full" for="star1"></label><input id="star2" name="rating" type="radio"><label class="half" for="star2"></label><input id="star3" name="rating" type="radio"><label class="full" for="star3"></label><input id="star4" name="rating" type="radio"><label class="half" for="star4"></label><input id="star5" name="rating" type="radio"><label class="full" for="star5"></label><input id="star6" name="rating" type="radio"><label class="half" for="star6"></label><input id="star7" name="rating" type="radio"><label class="full" for="star7"></label><input id="star8" name="rating" type="radio"><label class="half" for="star8"></label><input id="star9" name="rating" type="radio"><label class="full" for="star9"></label></div></div></div><div class="form-group"><label>Time Period</label><div class="col-sm-3" style="padding-left:0; padding-right:0;"><input type="text" name="name" class="form-control" placeholder="dd/mm/yy"  style="float:left;"></div><div class="col-sm-3" style="padding-left:0; padding-right:0;"><input type="text" name="name" class="form-control" placeholder="dd/mm/yy"  style="float:left"></div></div><a href="javascript:;" class="remove_field" id="remove_'+x+'" onclick="remove_area('+x+')">Remove</a></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

</script>


  </body>
</html>
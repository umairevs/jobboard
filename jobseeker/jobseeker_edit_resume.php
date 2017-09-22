<?php

include("../common/top.php");
include("../common/security_seeker_login.php");
include("../common/functions.php");

$resume_info  = get_seeker_resume($_SESSION['jobseeker']['id']);
if(!$resume_info)
{	
	$user_info  =  get_seeker_by_id($_SESSION['jobseeker']['id']);
	$full_name  =  stripslashes($user_info['name']);
	$db_image  =  stripslashes($user_info['image']);
	$resume_text  =  nl2br(stripslashes($user_info['resume_text']));	
	$resume_detail  =  "Post";
	$button_detail  =  "Post";
}	
else
{	
	$user_info  =  get_seeker_by_id($_SESSION['jobseeker']['id']);
	
	$full_name  =  stripslashes($resume_info['full_name']);
	$db_image   =  stripslashes($resume_info['photo_of_resume']);	
	$resume_text  =  nl2br(stripslashes($user_info['resume_text']));	
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

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title><?php echo $resume_detail;?> Resume | Jobs</title>
 	<?php include("../common/top_script.php");?>   
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

  
  </head>
  <body>
	<!-- header -->
		<?php include("../common/header.php");?>   	
    <!-- header -->

	<section class=" job-bg ad-details-page">
		<div class="container">
		
			<div class="breadcrumb-section">
				<!-- breadcrumb -->
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><?php echo $resume_detail;?> Resume</li>
				</ol><!-- breadcrumb -->						
				<h2 class="title"><?php echo $resume_detail;?> Resume</h2>
			</div><!-- banner -->

			<div class="adpost-details post-resume">
				<div class="row">	
					<div class="col-md-8 clearfix">
					
                
                
                <form action="" method="post" name="signup_form" id="signup_form">
                
							<fieldset>
                             
							<div class="section express-yourself">
									<h4>Express Yourself</h4>
									<div class="row form-group">
										<label class="col-sm-4 label-title">Full Name</label>
										<div class="col-sm-8">
											<input type="text" name="fullname" class="form-control" placeholder="ex Jhon Doe" value="<?php echo $full_name;?>">
										</div>
									</div>
									<div class="row form-group additional-information">
										<label class="col-sm-4 label-title">Additional Information</label>
										<div class="col-sm-8">
											<textarea class="form-control" name="additional_info" placeholder="Address: 123 West 12th Street, Suite 456 New York, NY 123456\n Phone: +022 222 444 120 \n *"><?php echo $additional_info;?></textarea>
										</div>
									</div>
									<div class="row form-group photos-resume">
										<label class="col-sm-4 label-title">Photos for your Resume</label>
										<div class="col-sm-8 ">
											
											<label class="upload-image" for="upload-image-two" style="float:left;">
												<input type="file" id="upload-image-two" name="image_filename">
												Upload Photo
											</label>
                                            
                                            <?php
												if($db_image!='')
											{
												?>
												<img src="<?php echo SERVER_ROOTPATH;?>media/user_images/<?php echo $db_image;?>" style="width:95px; margin-left:15px;">
												<?php 
											}
											?>
                                              <input type="hidden" name="old_image" value="<?php echo stripslashes($db_image);?>">
										</div>
									</div>
								</div><!-- postdetails -->
								
								<div class="section career-objective">
									<h4>Career Objective</h4>
									<div class="form-group">
										<textarea class="form-control" name="carrer_obj" placeholder="Write few lines about your career objective" rows="8"><?php echo $carrer_obj;?></textarea>		
									</div>
									
								</div><!-- career-objective -->
								
								<div class="section">
									<h4>Work History</h4>
                                  <div class="input_fields_wrap">
                                   <?php 
								  		$query_work_history  =  get_seeker_working_history($_SESSION['jobseeker']['id']);
										if($query_work_history)
										{	
											$sizeof_workexp  = sizeof($query_work_history);
											$u=1;
											foreach($query_work_history as $work_info)
											{
												?>
                                          		 
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 label-title">Compnay Name</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="company_name[]" class="form-control" placeholder="Name" value="<?php echo stripslashes($work_info['company_name']);?>">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <label class="col-sm-3 label-title">Designation</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="designation[]" class="form-control" placeholder="Human Resource Manager"  value="<?php echo stripslashes($work_info['designation']);?>">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group time-period">
                                                            <label class="col-sm-3 label-title">Time Period</label>
                                                            <div class="col-sm-9">
                                                                <input type="text" name="from_job[]" class="dpick date-own form-control"  placeholder="yyyy-mm-dd"  value="<?php echo stripslashes($work_info['from_job']);?>">
                                                             


	
   <span>-</span>
                                                                <input type="text" name="to_job[]"  class="dpick date-own form-control pull-right" placeholder="yyyy-mm-dd"  value="<?php echo stripslashes($work_info['to_job']);?>">
                                                            </div>
                                                        </div>
                                                        <div class="row form-group job-description">
                                                            <label class="col-sm-3 label-title">Job Description</label>
                                                            <div class="col-sm-9">
                                                                <textarea class="form-control" placeholder="" rows="8" name="job_description[]"> <?php echo stripslashes($work_info['job_description']);?></textarea>		
                                                            </div>
                                                        </div>
                                            
                                            
                                           		 <?php
												 if($u!=$sizeof_workexp)
												 {
												 	?>
                                                    <hr>
                                                    <?php
												 }
												 $u++;
											}
											
										}
										else
										{
											?>
                                            
                                        <div class="row form-group">
                                            <label class="col-sm-3 label-title">Compnay Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="company_name[]" class="form-control" placeholder="Name">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <label class="col-sm-3 label-title">Designation</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="designation[]" class="form-control" placeholder="Human Resource Manager">
                                            </div>
                                        </div>
                                        <div class="row form-group time-period">
                                            <label class="col-sm-3 label-title">Time Period</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="from_job[]" class="dpick date-own form-control"  placeholder="yyyy-mm-dd"><span>-</span>
                                                <input type="text" name="to_job[]"  class="dpick date-own form-control pull-right" placeholder="yyyy-mm-dd">
                                            </div>
                                        </div>
                                        
                                        
    
                                        <div class="row form-group job-description">
                                            <label class="col-sm-3 label-title">Job Description</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="" rows="8" name="job_description[]"></textarea>		
                                            </div>
                                        </div>
                                  
                                            <?php
										}
								  ?>  
									</div> 
									<div class="clear_screen"></div>
                                <div class="buttons pull-right">
                               		<a href="javascript:;" class="btn" id="add_new">Add New Exprience</a>
                                    <div id="iframe"></div>
								</div>
                                
                                
								</div><!-- work-history -->
								
								<div class="section education-background">
									<h4>Education Background</h4>
									 <div class="input_fields_wrap_edu">
                                      <?php
								  		$query_edu_background  =  get_seeker_education_background($_SESSION['jobseeker']['id']);
										if($query_edu_background)
										{	
											$sizeof_workexp  = sizeof($query_edu_background);
											$u=1;
											foreach($query_edu_background as $work_info)
											{
												?>
                                          		  
                                                      <div class="row form-group">
                                                        <label class="col-sm-3 label-title">Institute Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="inst_name[]" class="form-control" placeholder="ropbox" value="<?php echo stripslashes($work_info['inst_name']);?>">
                                                        </div>
                                                    </div>
                                                      <div class="row form-group">
                                                        <label class="col-sm-3 label-title">Degree</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="degree[]" class="form-control" placeholder="Human Resource Manager" value="<?php echo stripslashes($work_info['degree']);?>">
                                                        </div>
                                                    </div>
                                                      <div class="row form-group time-period">
                                                        <label class="col-sm-3 label-title">Time Period</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="from_date[]" class="dpick date-own form-control"  placeholder="yyyy-mm-dd" value="<?php echo stripslashes($work_info['from_date']);?>"><span>-</span>
                                                            <input type="text" name="to_date[]" class="dpick date-own form-control pull-right" placeholder="yyyy-mm-dd" value="<?php echo stripslashes($work_info['to_date']);?>">
                                                        </div>
                                                    </div>
                                                    
                                                    
                                                      <div class="row form-group job-description">
                                                        <label class="col-sm-3 label-title">Description</label>
                                                        <div class="col-sm-9">
                                                            <textarea class="form-control" placeholder="" rows="8" name="description[]"><?php echo stripslashes($work_info['description']);?></textarea>		
                                                        </div>
                                                    </div>
                                                  
                                           		 <?php
												 if($u!=$sizeof_workexp)
												 {
												 	?>
                                                    <hr>
                                                    <?php
												 }
												 $u++;
											}
											
										}
										else
										{
											?>
                                            
                                      <div class="row form-group">
										<label class="col-sm-3 label-title">Institute Name</label>
										<div class="col-sm-9">
											<input type="text" name="inst_name[]" class="form-control" placeholder="ropbox">
										</div>
									</div>
									  <div class="row form-group">
										<label class="col-sm-3 label-title">Degree</label>
										<div class="col-sm-9">
											<input type="text" name="degree[]" class="form-control" placeholder="Human Resource Manager">
										</div>
									</div>
									  <div class="row form-group time-period">
										<label class="col-sm-3 label-title">Time Period</label>
										<div class="col-sm-9">
											<input type="text" name="from_date[]"  class="dpick date-own form-control" placeholder="yyyy-mm-dd"><span>-</span>
											<input type="text" name="to_date[]"  class="dpick date-own form-control pull-right" placeholder="yyyy-mm-dd">
										</div>
									</div>
                                    
                                    
									  <div class="row form-group job-description">
										<label class="col-sm-3 label-title">Description</label>
										<div class="col-sm-9">
											<textarea class="form-control" placeholder="" rows="8" name="description[]"></textarea>		
										</div>
									</div>
                                   
                                            <?php
										}
								  ?>  
                                  </div>
										<div class="clear_screen"></div>
                                <div class="buttons pull-right">
                               		<a href="javascript:;" class="btn" id="add_education">Add New Education</a>
								</div>
                                
                                
								</div><!-- work-history -->

								<div class="section special-qualification">
									<h4>Special Qualification</h4>
									<div class="form-group item-description">
										<textarea class="form-control" name="qualification" placeholder="Write few lines about your special qualification" rows="8"><?php echo $qualification;?></textarea>
									</div>								
								</div><!-- special-qualification -->								
								
								<div class="section language-proficiency">
									<h4>Language Proficiency:</h4>
                                    <div class="input_fields_wrap_language"> 
									 <?php
								  		$query_language_background  =  get_seeker_lanugage($_SESSION['jobseeker']['id']);
										if($query_language_background)
										{	
											$sizeof_workexp  = sizeof($query_language_background);
											$u=1;
											foreach($query_language_background as $work_info)
											{
												?>
                                             
                                                    <div class="row form-group">
                                                        <label class="col-sm-3 label-title">Language Name</label>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="language[]" class="form-control" placeholder="English" value="<?php echo stripslashes($work_info['language']);?>">
                                                        </div>
                                                    </div>
                                                    <div class="row form-group rating">
                                                        <label class="col-sm-3 label-title">Rating</label>
                                                        <div class="col-sm-9">
                                                            <div class="rating-star">
                                                                
                                                              
                                                            <div class="rating">
                                                            <input type="radio" id="star5_<?php echo $u;?>" name="rating_<?php echo $u;?>" value="5" <?php if($work_info['rating']==5){?> checked<?php }?> /><label class = "full" for="star5_<?php echo $u;?>" title="Awesome - 5 stars"></label>
                                                           
                                                            <input type="radio" id="star4_<?php echo $u;?>" name="rating_<?php echo $u;?>" value="4" <?php if($work_info['rating']==4){?> checked<?php }?> /><label class = "full" for="star4_<?php echo $u;?>" title="Pretty good - 4 stars"></label>
                                                           
                                                            <input type="radio" id="star3_<?php echo $u;?>" name="rating_<?php echo $u;?>" value="3" <?php if($work_info['rating']==3){?> checked<?php }?>/><label class = "full" for="star3_<?php echo $u;?>" title="Meh - 3 stars"></label>
                                                           
                                                            <input type="radio" id="star2_<?php echo $u;?>" name="rating_<?php echo $u;?>" value="2" <?php if($work_info['rating']==2){?> checked<?php }?>/><label class = "full" for="star2_<?php echo $u;?>" title="Kinda bad - 2 stars"></label>
                                                           
                                                            <input type="radio" id="star1_<?php echo $u;?>" name="rating_<?php echo $u;?>" value="1" /><label class = "full" for="star1_<?php echo $u;?>" title="Sucks big time - 1 star"></label>
                                                           
                                                            <input type="hidden" name = "rat_val[]" value="<?php echo $u;?>">
                                                            </div>                                                  
                                                                
                                                                
                                                             
                                                            </div><!-- rating-star -->
                                                        </div>
                                                    </div>
                                               
                                           		 <?php
												 if($u!=$sizeof_workexp)
												 {
												 	?>
                                                    <hr>
                                                    <?php
												 }
												 $u++;
											}
											
										}
										else
										{
											?>
                                            
                                        <div class="row form-group">
                                            <label class="col-sm-3 label-title">Language Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" name="language[]" class="form-control" placeholder="English">
                                            </div>
                                        </div>
                                        <div class="row form-group rating">
                                            <label class="col-sm-3 label-title">Rating</label>
                                            <div class="col-sm-9">
                                                <div class="rating-star">
                                                    
                                                  
<div class="rating">
    <input type="radio" id="star5_1" name="rating_1" value="5" /><label class = "full" for="star5_1" title="Awesome - 5 stars"></label>
  
    <input type="radio" id="star4_1" name="rating_1" value="4" /><label class = "full" for="star4_1" title="Pretty good - 4 stars"></label>
  
    <input type="radio" id="star3_1" name="rating_1" value="3" /><label class = "full" for="star3_1" title="Meh - 3 stars"></label>
  
    <input type="radio" id="star2_1" name="rating_1" value="2" /><label class = "full" for="star2_1" title="Kinda bad - 2 stars"></label>
  
    <input type="radio" id="star1_1" name="rating_1" value="1" /><label class = "full" for="star1_1" title="Sucks big time - 1 star"></label>
  
    <input type="hidden" name = "rat_val[]" value="1">
</div>                                                  
                                                    
                                                    
                                                 
                                                </div><!-- rating-star -->
                                            </div>
                                        </div>
                                    
                                    
                                            <?php
										}
								  ?>  
                                    
                                     </div>   
									
                                    <div class="clear_screen"></div>
                                    <div class="buttons pull-right">
                                        <a href="javascript:;" class="btn" id="add_language">Add New Language</a>
                                    </div>
                                
                                
                                
								</div><!-- language-proficiency -->

								<div class="section company-information">
									<h4>Personal Deatils</h4>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Full Name</label>
										<div class="col-sm-9">
											<input type="text" name="full_name" class="form-control" placeholder="Jhon Doe" value="<?php echo $full_names;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Father's Name</label>
										<div class="col-sm-9">
											<input type="text" name="father_name" class="form-control" placeholder="Robert Doe" value="<?php echo $father_name;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Mother's Name</label>
										<div class="col-sm-9">
											<input type="text" name="mother_name" class="form-control" placeholder="Ismatic Roderos Doe" value="<?php echo $mother_name;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Date of Birth</label>
										<div class="col-sm-9">
											<input type="text" name="dob"   class="dpick form-control" placeholder="" value="<?php echo $dob;?>">
										</div>
									</div>
                                  
  
  
								
                                <div class="row form-group">
										<label class="col-sm-3 label-title">Birth Place</label>
										<div class="col-sm-9">
											<input type="text" name="birth_place" class="date-own form-control" placeholder="United State of America" value="<?php echo $birth_place;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Nationality</label>
										<div class="col-sm-9">
											<input type="text" name="nationality" class="form-control" placeholder="Canadian" value="<?php echo $nationality;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Sex</label>
										<div class="col-sm-9">
											<input type="text" name="sex" class="form-control" placeholder="Male" value="<?php echo $sex;?>">
										</div>
									</div>
									<div class="row form-group">
										<label class="col-sm-3 label-title">Address</label>
										<div class="col-sm-9">
											<input type="text" name="address" class="form-control" placeholder="121 King Street, Melbourne Victoria, 1200 USA" value="<?php echo $address;?>">
										</div>
									</div>
									
								</div><!-- section -->

								<div class="section special-qualification">
									<h4>Declaration</h4>
									<div class="form-group item-description">
										<textarea class="form-control" name="declaration" placeholder="" rows="8"><?php echo $declaration;?></textarea>
									</div>								
								</div><!-- special-qualification -->	
							</fieldset>
                            <div class="buttons">
							<input type="submit" class="btn" style="color:#fff; background-color:#00A651;" onClick="return validate_add(11);" id="button1" value="<?php echo $resume_detail;?> Cv">
							<div id="preloader_div"></div>
						</div>							
						</form><!-- form -->
						
					</div>
				
					<!-- quick-rules -->	
					<div class="col-md-4">
						<div class="section quick-rules">
							<h4>Quick Read your uploaded CV</h4>
                           <?php
						   		if($resume_text!='')
								{
							 ?>
						    <small style="color:red;">You are able to copy CV text from right side and paste in left side in required fields.</small>
							<p class="lead">
                            	<?php
									echo $resume_text;
									
								?>
                            </p>
							<?php
							}
							?>
						</div>
					</div><!-- quick-rules -->	
				</div><!-- photos-ad -->				
			</div>	
		</div><!-- container -->
	</section>
	
	<?php  include("../common/footer.php");?>   
    
  
    
  

	<script type="text/javascript">
	
	
$(function() {
                $(".dpick").datepicker({maxDate: '0', dateFormat: 'yy-mm-dd' });
});

function remove_area(val)
{
	 $(".showdiv_"+val).remove();
	  $("#removes_"+val).remove();
}

function remove_edu(val)
{
	 $(".showdivedu_"+val).remove();
	 $("#remove_edus"+val).remove();
}

function remove_language(val)
{
	 $(".showdivlanguage_"+val).remove();
	 $("#remove_languages"+val).remove();
	 
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
		

            $(wrapper).append('<div class="showdiv_'+x+'"><hr><div class="row form-group"><label class="col-sm-3 label-title">Compnay Name</label><div class="col-sm-9"><input type="text" name="company_name[]" class="form-control" placeholder="Name"></div></div><div class="row form-group"><label class="col-sm-3 label-title">Designation</label><div class="col-sm-9"><input type="text" name="designation[]" class="form-control" placeholder="Human Resource Manager"></div></div><div class="row form-group time-period"><label class="col-sm-3 label-title">Time Period</label><div class="col-sm-9"><input type="text" name="from_job[]" class="dpick form-control" placeholder="yyyy-mm-dd"><span>-</span><input type="text" name="to_job[]" class="dpick form-control pull-right" placeholder="yyyy-mm-dd"></div></div><div class="row form-group job-description"><label class="col-sm-3 label-title">Job Description</label><div class="col-sm-9"><textarea class="form-control" placeholder="" rows="8" name="job_description[]"></textarea></div></div><div class="buttons" id="removes_'+x+'"><a href="javascript:;" class="remove_field btn delete" id="remove_'+x+'" onclick="remove_area('+x+')">Remove</a></div><div class="clearfix"></div></div>'); //add input box
        }
		 $(".dpick").datepicker({maxDate: '0', dateFormat: 'yy-dd-mm' });
    });
   
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
	
	
	// Education background add more features
	
	 var max_fields      = 10; //maximum input boxes allowed
    var wrapper2         = $(".input_fields_wrap_edu"); //Fields wrapper
   
	 
	 var x = 1; //initlal text box count
    $("#add_education").click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper2).append('<div class="showdivedu_'+x+'"><hr><div class="row form-group"><label class="col-sm-3 label-title">Institute Name</label><div class="col-sm-9"><input type="text" name="inst_name[]" class="form-control" placeholder="ropbox"></div></div><div class="row form-group"><label class="col-sm-3 label-title">Degree</label><div class="col-sm-9"><input type="text" name="degree[]" class="form-control" placeholder="Human Resource Manager"></div></div><div class="row form-group time-period"><label class="col-sm-3 label-title">Time Period</label><div class="col-sm-9"><input type="text" name="from_date[]" class="dpick form-control" placeholder="yyyy-mm-dd"><span>-</span><input type="text" name="to_date[]" class="dpick form-control pull-right" placeholder="yyyy-mm-dd"></div></div><div class="row form-group job-description"><label class="col-sm-3 label-title">Description</label><div class="col-sm-9"><textarea class="form-control" placeholder="" rows="8" name="description[]"></textarea></div></div></div><div class="buttons" id="remove_edus'+x+'"><a href="javascript:;" class="remove_field_edu btn delete" id="remove_edu'+x+'" onclick="remove_edu('+x+')">Remove</a></div><div class="clearfix"></div></div>'); //add input box
        }
		
		$(".dpick").datepicker({maxDate: '0', dateFormat: 'yy-dd-mm' });
    });
   
    $(wrapper).on("click",".remove_field_edu", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    });
	
	 var max_fields      = 10; //maximum input boxes allowed
    var wrapper3         = $(".input_fields_wrap_language"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
	
	
	
	 var x = $('input[name="language[]"]').length; //initlal text box count
    $("#add_language").click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper3).append('<div class="showdivlanguage_'+x+'"><hr><div class="row form-group"><label class="col-sm-3 label-title">Language Name</label><div class="col-sm-9"><input type="text" name="language[]" class="form-control" placeholder="English"></div></div><div class="row form-group rating"><label class="col-sm-3 label-title">Rating</label><div class="col-sm-9"><div class="rating-star"><div class="rating"><input type="radio" id="star5_'+x+'" name="rating_'+x+'" value="5" /><label class = "full" for="star5_'+x+'" title="Awesome - 5 stars"></label><input type="radio" id="star4half_'+x+'" name="rating_'+x+'" value="4.5" /><label class="half" for="star4half_'+x+'" title="Pretty good - 4.5 stars"></label><input type="radio" id="star4_'+x+'" name="rating_'+x+'" value="4" /><label class = "full" for="star4_'+x+'" title="Pretty good - 4 stars"></label><input type="radio" id="star3half_'+x+'" name="rating_'+x+'" value="3.5" /><label class="half" for="star3half_'+x+'" title="Meh - 3.5 stars"></label><input type="radio" id="star3_'+x+'" name="rating_'+x+'" value="3" /><label class = "full" for="star3_'+x+'" title="Meh - 3 stars"></label><input type="radio" id="star2half_'+x+'" name="rating_'+x+'" value="2.5" /><label class="half" for="star2half_'+x+'" title="Kinda bad - 2.5 stars"></label><input type="radio" id="star2_'+x+'" name="rating_'+x+'" value="2" /><label class = "full" for="star2_'+x+'" title="Kinda bad - 2 stars"></label><input type="radio" id="star1half_'+x+'" name="rating_'+x+'" value="1.5" /><label class="half" for="star1half_'+x+'" title="Meh - 1.5 stars"></label><input type="radio" id="star1_'+x+'" name="rating_'+x+'" value="1" /><label class = "full" for="star1_'+x+'" title="Sucks big time - 1 star"></label><input type="radio" id="starhalf_'+x+'" name="rating_'+x+'" value="0.5" /><label class="half" for="starhalf_'+x+'" title="Sucks big time - 0.5 stars"></label><input type="hidden" name = "rat_val[]" value="'+x+'"></div></div><!-- rating-star --></div></div></div><div class="buttons" id="remove_languages'+x+'"><a href="javascript:;" class="remove_field_language btn delete" id="remove_language'+x+'" onclick="remove_language('+x+')">Remove</a></div><div class="clearfix"></div></div>'); //add input box
        }
    });
   
    $(wrapper).on("click",".remove_field_language", function(e){ 
	//user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
	
});



</script>



  </body>
</html>
<?php
include("../common/top.php");
include("../common/security_seeker_login.php");
include("../common/functions.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Profile</title>
 	<?php include("../common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("../common/header.php");?>   	
    <!-- header -->

	<section class="clearfix job-bg  ad-profile-page">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-profile">Home</a></li>
					<li>Profile Details</li>
				</ol>						
				<h2 class="title">My Profile</h2>
			</div><!-- breadcrumb-section -->
			
			<?php include("../common/profile_area_seeker.php");
			
														
													
														?>   
           
                                    	

			
            <div class="row" >
<form action="" method="post" name="signup_form" id="signup_form">
	
							<fieldset>
								<div class="section express-yourself">
									<h2>Profile Details</h2>
                                     <?php if($_SESSION['success']['profile']!='')
										{
										?>
										<div class="form-group">
										<div class="alert alert-success" style="margin-bottom:0;">
										<strong>Success!</strong> <?php echo $_SESSION['success']['profile'];?>
										</div>
										</div>
										<?php
										unset($_SESSION['success']);
										}
										?>

									<div class="row form-group">
										<label class="col-sm-2  label-title">Name</label>
										<div class="col-sm-9 ">
												<input type="text" name="user_name" class="form-control" value="<?php echo stripslashes($seeker_info['name']);?>" placeholder="">
										</div>
									</div>
                                    
                                    <div class="row form-group">
										<label class="col-sm-2  label-title">Mobile#</label>
										<div class="col-sm-9 ">
											<input type="text" name="mobile_number" value="<?php echo stripslashes($seeker_info['mobile_number']);?>" class="form-control" placeholder="">
										</div>
									</div>
                                    
                                    <div class="row form-group">
										<label class="col-sm-2  label-title">Location</label>
										<div class="col-sm-9 ">
											<div class="col-sm-4" style="padding-left:0;">
												  <?php $list_country =  country_list();?>
                                       <select class="form-control" onChange="get_state(this.value)" name="job_country" id="job_country" style="float:left;" >
                                       <option value="">Country</option>
                                        	 <?php
												$n=1; 
												if($list_country)
												{
													foreach($list_country as $row_list)
													{
														?>
                                                         <option value="<?php echo stripslashes($row_list['CountryId']);?>" <?php if($seeker_info['country']==$row_list['CountryId']){?> selected<?php }?>><?php echo stripslashes($row_list['Country']);?></option>
                                                        <?php
													}
												}	
												?>
                                               
                                        </select>						
											</div>
                                            <div class="col-sm-4" id="state_div">
                                            <select class="form-control" name="job_state" onChange="get_city(this.value, <?php echo $_REQUEST['country_id'];?>)">
												<option value="">State</option>
											  <?php
											if($seeker_info)
											{ 
											  if($seeker_info['country']!='')
												{
												$list_state  =  state_list($seeker_info['country']);
												}
												?>
												
												<?php 
													$n=1; 
													if($list_state)
													{
														
														foreach($list_state as $row_list)
														{
															?>
															 <option value="<?php echo stripslashes($row_list['RegionID']);?>" <?php if($seeker_info['state']==$row_list['RegionID']){?> selected<?php }?>><?php echo stripslashes($row_list['Region']);?></option>
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
												
                                          <select class="form-control" name="job_city" >
                                    <option value="">City</option>
                                            <?php
											if($seeker_info)
											{
														$country_id  =  $seeker_info['country'];
														$state_id  =  $seeker_info['state'];
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
															 <option value="<?php echo stripslashes($row_list['CityId']);?>" <?php if($seeker_info['city']==$row_list['CityId']){?> selected<?php }?>><?php echo stripslashes($row_list['City']);?></option>
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
										<label class="col-sm-2  label-title">Image</label>
										<div class="col-sm-9" >
											<div class="col-sm-4" style="padding:0;">
                                    <input type="file" name="image_filename" >
                            	    <input type="hidden" name="old_image" value="<?php echo stripslashes($seeker_info['image']);?>">
                                    </div>
                                    <div class="col-sm-8">
                                <?php
								if($seeker_info['image']!='')
								{
									?>
                                    <img src="<?php echo SERVER_ROOTPATH;?>media/user_images/<?php echo $seeker_info['image'];?>" style="width:95px;">
                                    <?php 
								}
								?>
                                </div>
										</div>
									</div>
                                    
                                    
                                   <div class="form-group button">
                                   <label class="col-sm-2  label-title">&nbsp;</label>
                           	 <input type="submit" class="btn" style="color:#fff; background-color:#00A651;" onClick="return validate_add(9);" id="button1" value="Update">
                            
                            <div id="preloader_div"></div>
                            
                            
                            </div>
                            
									<div style="margin-bottom:20px;">&nbsp;</div>
                                    
                                    
                                      
								</div><!-- postdetails -->
								
							</fieldset>
						</form>
 </div>   
            
            
            
            
			</div>				
		</div><!-- container -->
	</section>
	
	<?php include("../common/footer.php");?>   
<script type="text/javascript">

function remove_area(val)
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
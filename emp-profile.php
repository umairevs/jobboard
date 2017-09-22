<?php
include("common/top.php");
include("common/security_login.php");
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

    <title>Profile</title>
 	<?php include("common/top_script.php");?>   
  </head>
  <body>
	<!-- header -->
		<?php include("common/header.php");?>   	
    <!-- header -->

	<section class="clearfix job-bg  ad-profile-page">
		<div class="container">
			<div class="breadcrumb-section">
				<ol class="breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li>Profile Details</li>
				</ol>						
				<h2 class="title">My Profile</h2>
			</div><!-- breadcrumb-section -->
			
			<?php include("common/profile_area.php");?>   	

			<div class="profile job-profile">
				<div class="user-pro-section">
					<!-- profile-details -->
					<div class="profile-details section">
						<h2>Profile Details</h2>
						<form action="" method="post" name="signup_form" id="signup_form">
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
							<div class="form-group">
								<label>Industry</label>
								<input type="text" name="industry" class="form-control" value="<?php echo stripslashes($emp_info['industry']);?>" placeholder="">
							</div>
                            
                            <div class="form-group">
								<label>Company name</label>
								<input type="text" name="company_name" value="<?php echo stripslashes($emp_info['company_name']);?>" class="form-control" placeholder="">
							</div>
                            
                           
							 <div class="form-group">
								<label>Mobile Number</label>
								<input type="text" name="mobile_no" class="form-control" value="<?php echo stripslashes($emp_info['mobile_no']);?>" placeholder="">
							</div>
                            
                            <div class="form-group">
								<label>Address</label>
								<textarea class="form-control" name="address" placeholder=""><?php echo stripslashes($emp_info['address']);?></textarea>
                                
							</div>
                            
                             <div class="form-group">
								
                                 <label>Image</label>
                                
								
                                <div class="col-sm-8" style="padding:0;">
                                	<div class="col-sm-4" style="padding:0;">
                                    <input type="file" name="image_filename" >
                            	    <input type="hidden" name="old_image" value="<?php echo stripslashes($emp_info['image']);?>">
                                    </div>
                                    <div class="col-sm-8">
                                <?php
								if($emp_info['image']!='')
								{
									?>
                                    <img src="<?php echo SERVER_ROOTPATH;?>media/emp_images/<?php echo $emp_info['image'];?>" style="width:95px;">
                                    <?php 
								}
								?>
                                </div>
                                </div>
							</div>
                               
                            <div class="form-group button">
                            <input type="submit" class="btn" style="color:#fff; background-color:#00A651;" onClick="return validate_add(6);" id="button1" value="Update Profile">
                            <div id="preloader_div"></div>
                            </div>
						</form>		  		
					</div><!-- profile-details -->
                          
                        </div>
                    
				</div><!-- user-pro-edit -->
			</div>				
		</div><!-- container -->
	</section>
	
	<?php include("common/footer.php");?>   
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
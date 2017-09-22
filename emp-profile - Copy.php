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

    <title>Jobs | Job Portal / Job Board HTML Template</title>
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
						<form action="#">
							<div class="form-group">
								<label>Name</label>
								<input type="text" class="form-control">
							</div>
                            
                           
							 <div class="form-group">
								<label>Phone Number</label>
								<input type="text" class="form-control" >
							</div>
                            
                            <div class="form-group">
								<label>Address</label>
								<textarea class="form-control" placeholder=""></textarea>
                                <small style="float:right;">Like: 123 West 12th Street, Suite 456 New York, NY 123456</small>
							</div>
                            
                             <div class="form-group">
								<label>Email address</label>
								<input type="text" class="form-control">
							</div>

							 <div class="form-group">
								<label>Linkdin ID</label>
								<input type="text" class="form-control">
							</div>
                             
                            
						</form>				
					</div><!-- profile-details -->
                    
                   
 <div class="change-password section">   
                         <h2>Technical Skills</h2>
                           <div class="input_fields_wrap">
                              <div class="form-group"><label>Skill Name</label><input type="text" name="name" class="form-control" placeholder=""></div>
                              
                              <div class="form-group"><label>Rating</label><div class="rating-star"><div class="rating"><input id="star1" name="rating" type="radio"><label class="full" for="star1"></label><input id="star2" name="rating" type="radio"><label class="half" for="star2"></label><input id="star3" name="rating" type="radio"><label class="full" for="star3"></label><input id="star4" name="rating" type="radio"><label class="half" for="star4"></label><input id="star5" name="rating" type="radio"><label class="full" for="star5"></label><input id="star6" name="rating" type="radio"><label class="half" for="star6"></label><input id="star7" name="rating" type="radio"><label class="full" for="star7"></label><input id="star8" name="rating" type="radio"><label class="half" for="star8"></label><input id="star9" name="rating" type="radio"><label class="full" for="star9"></label></div></div></div>
                               <div class="form-group">
                                       <label>Time Period</label>
                                       <div class="col-sm-3" style="padding-left:0; padding-right:0;">
                                       <input type="text" name="name" class="form-control" placeholder="dd/mm/yy"  style="float:left;">
                                       </div>
                                      
                                       <div class="col-sm-3" style="padding-left:0; padding-right:0;">
                                       <input type="text" name="name" class="form-control" placeholder="dd/mm/yy"  style="float:left">
                                       </div>
                                </div>
                                
                                
                               </div>
                               
                               
                               
                             	<div class="clear_screen"></div>
                                <div class="buttons pull-right">
                               		<a href="javascript:;" class="btn" id="add_new">Add New Skill</a>
								</div>
                            </div>
                          
                        </div>
                        

					<!-- change-password -->
					<div class="change-password section">
						<h2>Change password</h2>
						<!-- form -->
						<div class="form-group">
							<label>Old Password</label>
							<input type="password" class="form-control" >
						</div>
						
						<div class="form-group">
							<label>New password</label>
							<input type="password" class="form-control">	
						</div>
						
						<div class="form-group">
							<label>Confirm password</label>
							<input type="password" class="form-control">
						</div>			
                        <div class="buttons">
							<a href="#" class="btn">Update Profile</a>
							<a href="#" class="btn cancle">Cancle</a>
						</div>																								
					</div><!-- change-password -->
					
					<!-- preferences-settings -->
					<!-- preferences-settings -->
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
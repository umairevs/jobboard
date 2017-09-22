<?php
include("common/top.php");
include("common/functions.php");
include("common/security_login.php");
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Theme Region">
   	<meta name="description" content="">

    <title>Employer Job listings</title>
 	<?php include("common/top_script.php");?>   
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
					<li>Job Listing</li>
                    
				</ol>						
				<h2 class="title">Jobs List</h2>
			</div><!-- breadcrumb-section -->
			
			<?php include("common/profile_area.php");?> 
            
            <!-- ad-profile -->

			<div class="section trending-ads latest-jobs-ads">
				<h4>Jobs List <a href="<?php echo SERVER_ROOTPATH;?>emp-add-job" class="btn" style="color:#fff; background-color:#00A651; float:right;">ADD New Job</a></h4>
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
				<?php
                	$list_jobs  =  jobs_list($_SESSION['employer']['id']);
					
					foreach($list_jobs as $row_info)
					{
						$job_id  = stripslashes($row_info['id']);
						$job_title  = stripslashes($row_info['job_title']);
						$country_id  = stripslashes($row_info['job_country']);
						$state_id  = stripslashes($row_info['job_state']);
						$city_id  = stripslashes($row_info['job_city']);
						$job_type  = stripslashes($row_info['job_type']);
						$job_function  = stripslashes($row_info['job_function']);
						
						$job_salary_min  = stripslashes($row_info['job_salary_min']);
						$job_salary_max  = stripslashes($row_info['job_salary_max']);
						
						$country_name = country_name($country_id);
						$state_name = state_name($country_id, $state_id);
						$city_name = city_name($country_id, $state_id, $city_id);
						
						$type_info = get_emp_type_name($job_type);
						
						$count_total = job_applied_count($job_id);
						$count_apply = sizeof($count_total);
						
				?>
                
                        <div class="job-ad-item">
                            <div class="item-info">
                                
        
                                <div class="ad-info" style="padding-left:5px;">
                                    <span><a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>" class="title"><?php echo $job_title;?></a>  <a href="<?php echo SERVER_ROOTPATH;?>apply-jobs-applicants/<?php echo $job_id;?>" style="font-size:14px; color:#00A651; float:right;" > Applied Candidates ( <strong><?php echo $count_apply;?></strong> )</a></span>
                                    <div class="ad-meta">
                                        <ul>
                                            <li><i class="fa fa-map-marker" aria-hidden="true"></i><?php echo stripslashes($city_name['City']);?>, <?php echo stripslashes($state_name['Region']);?> , <?php echo stripslashes($country_name['Country']);?> </li>
                                            <li><i class="fa fa-clock-o" aria-hidden="true"></i><?php echo stripslashes($type_info['emp_title']);?></li>
                                            <li><i class="fa fa-money" aria-hidden="true"></i>$<?php echo $job_salary_min;?> - $<?php echo $job_salary_max;?></li>
                                            <li><i class="fa fa-tags" aria-hidden="true"></i><?php echo $job_function;?></li>
                                        </ul>
                                    </div><!-- ad-meta -->									
                                </div><!-- ad-info -->
                                <div class="close-icon">
                                    <a href="<?php echo SERVER_ROOTPATH;?>emp-edit-job/<?php echo $job_id;?>" title="Edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a><br>
                                   <a href="javascript:;" title="Delete" style="margin-top:10px; float:right;" onClick="delete_job(<?php echo $job_id;?>)"> <i class="fa fa-window-close" aria-hidden="true"></i></a>
                                   
                                </div>
                            </div><!-- item-info -->
                        </div><!-- ad-item -->
    
                    <?php
                    }
                    ?>

				
			</div><!-- latest-jobs-ads -->									
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
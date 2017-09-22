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

    <title>Applied Jobs</title>
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
                    <li>Applied Jobs</li>
                  
				</ol>						
				<h2 class="title">Applied Jobs</h2>
			</div><!-- breadcrumb-section -->
			
			<?php include("../common/profile_area_seeker.php"); ?>   
           
                                    	

			
            <div class="section trending-ads latest-jobs-ads">
            
				<h4>Applied Jobs List </h4>

				<?php
                	$list_jobs  =  jobs_list_applied_jobs();
					
					$targetpage = SERVER_ROOTPATH."jobseeker-applied-jobs"; 	//your file name  (the name of this file)	
					$total_pages = sizeof($list_jobs);
					$limit = 10; 								//how many items to show per page					
											
					$page = $_GET['page'];
					if($page) 
					{
						$start = ($page - 1) * $limit; 			//first item to display on this page
					}	
					else
					{
						$start = 0;								//if no page var is given, set start to 0
						$page=1;
					}	
					//PAGGING CODE ENDS HERE	
					//============================================================
					
					if(isset($page))
					{
						$sr_no = ($page*$limit)-$limit;
					}
					else
					{
						$sr_no = 0;
						$page=1;
					}
				
					 $jobs_query		=	"Select e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j, tbl_jobs_applied a where j.employer_id = e.id AND j.job_status = 1 AND e.status = 1 AND a.job_id = j.id ANd e.id = a.emp_id AND a.seeker_id = '".$_SESSION['jobseeker']['id']."' order by a.id desc  LIMIT $start, $limit";	
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
						
						$job_salary_min  = stripslashes($row_info['job_salary_min']);
						$job_salary_max  = stripslashes($row_info['job_salary_max']);
						
						$country_name = country_name($country_id);
						$state_name = state_name($country_id, $state_id);
						$city_name = city_name($country_id, $state_id, $city_id);
						
						$type_info = get_emp_type_name($job_type);
						
						
						
				?>
                
                        <div class="job-ad-item">
                            <div class="item-info">
                                
        
                                <div class="ad-info" style="padding-left:5px;">
                                    <span><a href="<?php echo SERVER_ROOTPATH;?>job-detail/<?php echo $job_id;?>" class="title"><?php echo $job_title;?></a> </span>
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
                        </div><!-- ad-item -->
    
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
                    
                    
                    <div class="text-center">
								<?php include("../common/paging.php"); ?>
                              
							</div>

				
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
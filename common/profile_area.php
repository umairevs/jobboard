<?php
$emp_info = get_user_by_employer($_SESSION['employer']['email']);
?>
<div class="job-profile section">	
				<div class="user-profile">
					<div class="user-images">
                    <?php
					if($emp_info['image']!='')
					{
						$com_img_url  = SERVER_ROOTPATH."media/emp_images/".$emp_info['image'];
					}
					else
					{
						$com_img_url  = SERVER_ROOTPATH."images/user.jpg";
					}
					?>
						<img src="<?php echo $com_img_url;?>" alt="User Images" style="width:95px;" class="img-responsive">
					</div>
					<div class="user">
						<h2>Hello, <a href="#"><?php echo stripslashes($emp_info['company_name']);?></a></h2>
                        <?php
                        	if($_SESSION['employer']['last_login_date']=='')
							{
								
								?>
                                <h5>Today logged in at: <?php echo change_dateformat($emp_info['last_login_date']);?> </h5>
                                <?php
                                
							}
							else
							{
								?>
                                <h5>You last logged in at: <?php echo change_dateformat($_SESSION['employer']['last_login_date']);?> </h5>
                                <?php		
							}
						?>
					</div>

					<div class="favorites-user">
						<div class="my-ads">
							<a href="<?php echo SERVER_ROOTPATH;?>emp-jobs-list"><?php echo jobs_list_count($_SESSION['employer']['id']);?><small>Jobs</small></a>
						</div>
						<div class="favorites">
							<a href="<?php echo SERVER_ROOTPATH;?>emp-jobs-applicants"><?php $list_jobs  =  jobs_list_applicants(); echo sizeof($list_jobs);?><small>Applied Candidates</small></a>
						</div>
					</div>								
				</div><!-- user-profile -->
						
				<ul class="user-menu">
					<li <?php if($current_File=='emp-profile.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>emp-profile">Account Info </a></li>
					<li <?php if($current_File=='emp_jobs_list.php' ){?> class="active"<?php }?>>
                    <a href="<?php echo SERVER_ROOTPATH;?>emp-jobs-list">Jobs List</a></li>
					<li <?php if($current_File=='emp_add_jobs.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>emp-add-job">Add new Job</a></li>
				    <li  <?php if($current_File=='emp_change_password.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>emp-jobs-applicants">Job Applicants</a></li>
                    	<li  <?php if($current_File=='emp_change_password.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>emp-change-password">Change Password</a></li>
                    
                
                    <li><a href="#">Followers</a></li>
				</ul>
			</div><!-- ad-profile -->	
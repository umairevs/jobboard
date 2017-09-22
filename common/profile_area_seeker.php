<?php
$seeker_info = get_user_by_email($_SESSION['jobseeker']['email']);

?>
<div class="job-profile section">	
				<div class="user-profile">
					<div class="user-images">
                    <?php
					if($seeker_info['image']!='')
					{
						$com_img_url  = SERVER_ROOTPATH."media/user_images/".$seeker_info['image'];
					}
					else
					{
						$com_img_url  = SERVER_ROOTPATH."images/user.jpg";
					}
					?>
						<img src="<?php echo $com_img_url;?>" alt="" style="width:95px;" class="img-responsive">
					</div>
					<div class="user">
						<h2>Hello <?php if($seeker_info['name']!=''){?>, <a href="#"><?php echo stripslashes($seeker_info['name']);?></a><?php }?></h2>
                        <?php
                        	if($_SESSION['jobseeker']['last_login_date']=='')
							{
								
								?>
                                <h5>Today logged in at: <?php echo change_dateformat($seeker_info['last_login_date']);?> </h5>
                                <?php
                                
							}
							else
							{
								?>
                                <h5>You last logged in at: <?php echo change_dateformat($_SESSION['jobseeker']['last_login_date']);?> </h5>
                                <?php		
							}
						?>
					</div>

					<div class="favorites-user">
						<div class="my-ads">
							<a href="<?php echo SERVER_ROOTPATH;?>jobseeker-applied-jobs"><?php $list_jobs  =  jobs_list_applied_jobs(); echo sizeof($list_jobs);?><small>Apply Job</small></a>
						</div>
						<div class="favorites">
							<a href="<?php echo SERVER_ROOTPATH;?>jobseeker-bookmark"><?php $list_jobs  =  jobs_list_bookmark_jobs(); echo sizeof($list_jobs);?><small>Favourites</small></a>
						</div>
					</div>								
				</div><!-- user-profile -->
				<?php
					$resume_info  = get_seeker_resume($_SESSION['jobseeker']['id']);
				?>		
				<ul class="user-menu">
					<li <?php if($current_File=='jobseeker-profile.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-profile">Account Info </a></li>
					<li <?php if($current_File=='jobseeker_edit_resume.php' ){?> class="active"<?php }?>>
                    <?php
                    if(!$resume_info)
					{
					?>
                    <a href="<?php echo SERVER_ROOTPATH;?>post-resume">Post Resume</a>
                    <?php
                    }
					else
					{
						?>
                        <a href="<?php echo SERVER_ROOTPATH;?>edit-resume">Edit Resume</a>
                        <?php
					}
					?>
                    </li>
					<li <?php if($current_File=='resume.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>resume/<?php echo base64_encode($_SESSION['jobseeker']['id']);?>">View Resume</a></li>
                    
                    <li <?php if($current_File=='jobseeker-applied-jobs.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-applied-jobs">Applied Jobs</a></li>
                    
                    <li <?php if($current_File=='bookmark.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-bookmark">Bookmark</a></li>
                    
					<li  <?php if($current_File=='jobseeker_change_password.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-change-password">Change Password</a></li>
                    <li <?php if($current_File=='jobseeker_close_account.php'){?> class="active"<?php }?>><a href="<?php echo SERVER_ROOTPATH;?>jobseeker-close-account">Close Account</a></li>
				</ul>
			</div><!-- ad-profile -->	
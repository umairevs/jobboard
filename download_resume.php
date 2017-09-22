<?php 
@ob_start();
include("common/top.php");
include("common/functions.php");

$id_get = base64_decode($_REQUEST['seeker_id']);

$resume_info  = get_seeker_resume($id_get);
if(!$resume_info)
{	
	$user_info  =  get_seeker_by_id($id_get);
	$full_name  =  stripslashes($user_info['name']);
	$db_image  =  stripslashes($user_info['image']);
	$email  =  stripslashes($user_info['email']);
	$mobile_number  =  stripslashes($user_info['mobile_number']);
	$resume_detail  =  "Post";
	$button_detail  =  "Post";
}	
else
{	
	$user_info  =  get_seeker_by_id($id_get);
	$email  =  stripslashes($user_info['email']);
	$mobile_number  =  stripslashes($user_info['mobile_number']);
	
	
	$full_name  =  stripslashes($resume_info['full_name']);
	$db_image   =  stripslashes($resume_info['photo_of_resume']);	
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
<style>
	body
	{
		font-family:Arial, Helvetica, sans-serif;
	}
	
	tr
	{
		margin-bottom:18px;
		float:left;
		clear:both;
		width:100%;
	}
	
	h2
	{
	font-size:18px;
	}
	
	h4
	{
	font-size:14px;
	}
	
	strong
	{
		font-size:14px;
	}	
</style>
<?php				
$namess =  str_replace(" ","-",$full_name."-CV");
 header("Content-type: application/msword");
 header("Content-Disposition: attachment; Filename=$namess.doc");
	
    echo "<html>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=Windows-1252\">";
	//include("common/top_script.php");
    echo "<body>";
 	?>
    
    
    
     <table width="100%" style="border:none;">
     <tr style="margin-bottom:10px;"><td width="15%"><?php
      if($db_image!='')
											{
												$img_url  = SERVER_ROOTPATH."media/user_images/".$db_image;
											}
											else
											{
											
												$img_url  = SERVER_ROOTPATH."images/job/resume.jpg";
											}
											?>
                                            <img src="<?php echo $img_url;?>" class="img-responsive" title="Susie Queue" width="151" height="120"></td>
     <td><h2><?php echo $full_name;?></h2>
     <p>Address: <?php echo $address;?><br> 
     Phone: <?php echo $mobile_number;?> <br> 
     Email:<a> <?php echo $email;?></a>
     </p></td></tr>
     
     <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/career.png" style="height:20px;" /> &nbsp; Career Objective:</h2>
     <p><?php echo $carrer_obj;?></p>
     </td></tr>
     
      <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/work_history.png" style="height:20px;" /> &nbsp; Work History:</h2>
    <ul>
                        <?php
						$query_work_history  =  get_seeker_working_history($id_get);
										if($query_work_history)
										{	
											$sizeof_workexp  = sizeof($query_work_history);
											$u=1;
											foreach($query_work_history as $work_info)
											{
												
												?>
                                                <li>
				        		<h4><?php echo stripslashes($work_info['designation']);?> @ <?php echo stripslashes($work_info['company_name']);?> <span><?php echo stripslashes($work_info['from_job']);?> - <?php echo stripslashes($work_info['to_job']);?></span></h4>
				        		<p><?php echo stripslashes($work_info['job_description']);?></p>
			        		</li>
                                                <?php
											}
										}?>
                                                
			        			
			        	</ul>
     </td></tr>
     
     
     <tr><td colspan="2">
     <h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/education.png" style="height:20px;" /> &nbsp; Education Background:</h2>
   <ul>
							<?php
							$query_edu_background  =  get_seeker_education_background($id_get);
							if($query_edu_background)
							{	
								$sizeof_workexp  = sizeof($query_edu_background);
								$u=1;
								foreach($query_edu_background as $work_info)
								{
									?>
                                    <li>
								<h4><?php echo stripslashes($work_info['degree']);?> @ <?php echo stripslashes($work_info['inst_name']);?></h4>
								<ul>
									<li>Year: <span><?php echo get_year(stripslashes($work_info['from_date']));?> - <?php echo get_year(stripslashes($work_info['to_date']));?></span> </li>
								</ul>
								<p><?php echo stripslashes($work_info['description']);?></p>
							</li>
                                    <?php
								}
							}	
                            ?>
                            
							
						</ul>
     </td></tr>
     
     
      <tr><td width="100%" colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/qualification.png" style="height:20px;" /> &nbsp; Special Qualification:</h2>
		<p><?php echo $qualification;?></p>
     
     </td></tr>
     
     
  
      <tr><td colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/language.png" style="height:20px;" /> &nbsp; Language Proficiency:</h2>
		<p>
         <?php
								  		$query_language_background  =  get_seeker_lanugage($_SESSION['jobseeker']['id']);
										if($query_language_background)
										{	
											$sizeof_workexp  = sizeof($query_language_background);
											$u=1;
											foreach($query_language_background as $work_info)
											{
												echo stripslashes($work_info['language'])." ".$work_info['rating']."/5";
												if($u!=$sizeof_workexp)
												{
													echo ", ";
												}
											}
										}?></p>
        
     
     </td></tr>
     
     
     <tr><td colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/personal.png" style="height:20px;" /> &nbsp; Personal Deatils:</h2>
		<ul class="address">
				            <li><strong>Full Name</strong> : <?php echo $full_names;?></li>
				            <li><strong>Father's Name</strong> : <?php echo $father_name;?></li>
				            <li><strong>Mother's Name</strong> : <?php echo $mother_name;?></li>
				            <li><strong>Date of Birth</strong> : <?php echo $dob;?></li>
				            <li><strong>Birth Place</strong>  : <?php echo $birth_place;?></li>
				            <li><strong>Nationality</strong> : <?php echo $nationality;?></li>
				            <li><strong>Sex</strong> : <?php echo $sex;?></li>
				            <li><strong>Address</strong> : <?php echo $address;?></li>
				        </ul>
                        
     
     </td></tr>
     
     
      <tr><td width="100%" colspan="2">
    	<h2><img src="<?php echo SERVER_ROOTPATH;?>images/icon/declaration.png" style="height:20px;" /> &nbsp; Declaration:</h2>
		<p><?php echo $declaration;?></p>
     
     </td></tr>
     
     </table>           
    <?php
    echo "</body>";
    echo "</html>";
 exit();
?>

<?php
    defined('_JEVS') or die('Restricted access');
 
 $query		= mysql_query("Select count(*) as COUNT from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 1" );
$row_res	= mysql_fetch_array($query);
$total_active_jobs	= $row_res['COUNT'];

 $query		= mysql_query("Select count(*) as COUNT from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.job_status = 0" );
$row_res	= mysql_fetch_array($query);
$total_inactive_jobs	= $row_res['COUNT'];

if (isset ($_REQUEST['reset'] ) )
{
	unset($_SESSION['admin_search_query']);
	unset($_SESSION['search_admin']);	
}
else
{
if (isset ($_REQUEST['doSearch'] ) )
{
$where_query = '';
	if($_REQUEST['search_type']!='')
	{
		$_SESSION['search_admin_applied']['search_type']	=	$_REQUEST['search_type'];
		
		if($_REQUEST['search_type']=='job_title')
		{
			$where_query	.=	" AND j.job_title like '%".$_REQUEST['keyword']."%'";	
		}
		else
		if($_REQUEST['search_type']=='company_name')
		{
			$where_query	.=	" AND e.company_name like '%".$_REQUEST['keyword']."%'";	
		} 
		
		$_SESSION['search_admin_applied']['keyword']	=	$_REQUEST['keyword'];
		
	}
	else
	{
		unset($_SESSION['search_admin_applied']['search_type']);
		unset($_SESSION['search_admin_applied']['keyword']);
	}	
	
	
	if($_REQUEST['job_status']!='')
	{
			$_SESSION['search_admin_applied']['job_status'] = $_REQUEST['job_status'];
			
			$where_query	.=	" AND j.job_status = '".$_REQUEST['job_status']."'";	
	}
	else
	{
		unset($_SESSION['search_admin_applied']['job_status']);
		
	}	
	
	
	if($_REQUEST['txtDateFrom']!='' && $_REQUEST['txtDateTo']!='')
	{
		$date_from = explode("-",$_REQUEST['txtDateFrom']);
		$date_search_from  =  $date_from[2]."-".$date_from[1]."-".$date_from[0];
		
		$date_to = explode("-",$_REQUEST['txtDateTo']);
		$date_search_to  =  $date_to[2]."-".$date_to[1]."-".$date_to[0];
		
		
			$where_query	.=	" AND (j.expiry_date >='".$date_search_from."' AND j.expiry_date <='".$date_search_to."')";	
			$_SESSION['search_admin_applied']['txtDateFrom'] = $_REQUEST['txtDateFrom'];
			$_SESSION['search_admin_applied']['txtDateTo'] = $_REQUEST['txtDateTo'];
	}
	else
	{
		$date_from = explode("-",$_REQUEST['txtDateFrom']);
		$date_search_from  =  $date_from[2]."-".$date_from[1]."-".$date_from[0];
		
		$date_to = explode("-",$_REQUEST['txtDateTo']);
		$date_search_to  =  $date_to[2]."-".$date_to[1]."-".$date_to[0];
		
		
		if($_REQUEST['txtDateFrom']!='')
		{
				$_SESSION['search_admin_applied']['txtDateFrom'] = $_REQUEST['txtDateFrom'];
				
				$where_query	.=	" AND j.expiry_date >='".$date_search_from."'";	
		}	
		 
		if($_REQUEST['txtDateTo']!='')
		{
				$_SESSION['search_admin_applied']['txtDateTo'] = $_REQUEST['txtDateTo'];
				
				$where_query	.=	" AND j.expiry_date <='".$date_search_to."'";	
		}
	}	
	
	$_SESSION['admin_search_query']  =  $where_query;
} 
else
{
	if($_REQUEST['search_type']!='')
	{
		$_SESSION['search_admin_applied']['search_type']	=	$_REQUEST['search_type'];
		
		if($_REQUEST['search_type']=='job_title')
		{
			$where_query	.=	" AND j.job_title like '%".$_REQUEST['keyword']."%'";	
		}
		else
		if($_REQUEST['search_type']=='company_name')
		{
			$where_query	.=	" AND e.company_name like '%".$_REQUEST['keyword']."%'";	
		} 
		
		$_SESSION['search_admin_applied']['keyword']	=	$_REQUEST['keyword'];
		
	}
	else
	{
		unset($_SESSION['search_admin_applied']['search_type']);
		unset($_SESSION['search_admin_applied']['keyword']);
	}	
	
	$_SESSION['admin_search_query']  =  $where_query;
	
}
}
?>

<table cellpadding="0" cellspacing="0" border="0" width="100%" id="internaltable">
		 <tr>
			<td class="top-bar"><div style=" float:left">Applied Job List</div>
			 <div  class="message"> 
			 <?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']);}?>
			</div>
			
			</td>
			
		  </tr>
			
		 <tr>
			<td>
			<div class="tracking_box"><table width="100%" cellspacing="0" cellpadding="0">
		<tbody>
        <form method="post" action="home.php?p=apply_jobs_list&mod=jobs"></tr>
		<tr>
			<td colspan="7" style="font-size:10px;color:#666666;font-weight:600;border:1px solid #F8F8F8; padding:4px;">
			Job Status:&nbsp;
			<select name="job_status" class="topsearch">			
				 <option value="">Select Status</option>
                <option value="1" <?php if($_SESSION['search_admin_applied']['job_status']=='1'){?> selected="selected"<?php }?>>Active</option>	
                <option value="0 <?php if($_SESSION['search_admin_applied']['job_status']=='0'){?> selected="selected"<?php }?>">Suspended </option>
				</select>
                &nbsp;Search:&nbsp;<select name="search_type"  class="topsearch">			
				<option value="job_title" <?php if($_SESSION['search_admin_applied']['search_type']=='job_title'){?> selected="selected"<?php }?>>Job Title</option>
				<option  value="company_name" <?php if($_SESSION['search_admin_applied']['search_type']=='company_name'){?> selected="selected"<?php }?>>Company Name</option> 
			</select>
            
	<input size="25" name="keyword" class="topsearch" value="<?php echo $_SESSION['search_admin_applied']['keyword'];?>" type="text" placeholder = "Keyword">
    Deadline:  
    	<input size="10" readonly="readonly" name="txtDateFrom" id="txtDateFrom" class="topsearchdate" onclick="this.value='';showCalendarControl(document.getElementById('txtDateFrom'));" value="<?php echo $_SESSION['search_admin_applied']['txtDateFrom'];?>" onblur="this.value='';showCalendarControl(document.getElementById('txtDateFrom'));" type="text">&nbsp;To:&nbsp;
					<input size="10" readonly="readonly" name="txtDateTo" id="txtDateTo" class="topsearchdate" onclick="this.value='';showCalendarControl(document.getElementById('txtDateTo'));" onblur="this.value='';showCalendarControl(document.getElementById('txtDateTo'));" value="<?php echo $_SESSION['search_admin_applied']['txtDateTo'];?>" type="text">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;
	
	&nbsp;	
					<input name="doSearch" id="doSearch" value="Search" class="searchbtn" type="submit">
				 		<input type="submit" name="reset" id="reset" value="Reset" class="searchbtn"  />	
			</td>
		</tr>	
		 </form>
		<tr>
			<td colspan="7"></td>
		</tr>
	</tbody></table> 
	</div>
	</td>
	</tr>
         
         <tr>
				<td colspan="4" align="center">
					
					<table cellpadding="0" cellspacing="0" border="0" width="100%" class="grid">
						
					<tr class="rowtitle">
						<th width="4%" style="text-align:center;">S#</th>
						<th width="10%"  style="text-align:center;">Job Seeker</th>
                        <th width="19%"  style="text-align:center;">Title</th>
                        <th width="13%"  style="text-align:center;">Company</th>
                        <th width="10%"  style="text-align:center;">Country</th>
                         <th width="10%"  style="text-align:center;">State</th>
                          <th width="10%"  style="text-align:center;">City</th>
                           <th width="10%"  style="text-align:center;">Price</th>
                            <th width="7%"  style="text-align:center;">Deadline </th>
						<th width="10%" style="padding-right:40px;">Action</th>				
					</tr>
					
						 <form name="joblist" action="" method="post">
						<?php  
						 $where_search = $_SESSION['admin_search_query'];
								// pagination 2 of 3 
								  $query = "Select count(*) as COUNT from tbl_employer e, tbl_jobs j, tbl_jobs_applied a where j.employer_id = e.id AND a.job_id = j.id AND a.emp_id = e.id $where_search order by j.id desc";
								  $query_data = $db->get_row($query,ARRAY_A);
								  $numrows = $query_data[COUNT];  
								   $rows_per_page = 30;
								   $lastpage= ceil($numrows/$rows_per_page);
								   $pageno = (int)$pageno;
								 if ($pageno < 1) {
								   $pageno = 1;
								 } elseif ($pageno > $lastpage) {
								   $pageno = $lastpage;
								 } 
								 if($numrows==0)
								  $limit = 'LIMIT ' .($pageno).',' .$rows_per_page;
								  else
								  $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
								 //..............
							    
							     $min=$pageno;
								 if(isset($min))
								 if(!isset($pageno) or $pageno==1)
								  	$i=0;
								  else 
									$i=$min+1;
					  
							     $queryfaq="Select a.seeker_id, e.company_name, e.image, j.* from tbl_employer e, tbl_jobs j, tbl_jobs_applied a where j.employer_id = e.id AND a.job_id = j.id AND a.emp_id = e.id $where_search  order by a.id desc $limit";
							   $rowfaq=$db->get_results($queryfaq,ARRAY_A);
							   $counter=0;
								if(isset($rowfaq))
								{
									foreach($rowfaq as $arrfaq)
									{	
										$counter++;	
										$bgcolor = ($bgcolor == 'class="colortr"')?'class="colortr2"':'class="colortr"';							
										
										$status  =  $arrfaq['job_status'];
										$country_name = country_name($arrfaq['job_country']);
										$state_name = state_name($arrfaq['job_country'], $arrfaq['job_state']);
										$city_name = city_name($arrfaq['job_country'], $arrfaq['job_state'], $arrfaq['job_city']);
										
										$seeker_id  =  $arrfaq['seeker_id'];
										
										 $query_info="Select  name from tbl_job_seaker where id = '$seeker_id'";
							  			 $row_info = $db->get_row($query_info,ARRAY_A);
										 
										 $get_name  =  stripslashes($row_info['name']);
										
						?>
						<tr <?php echo $bgcolor;?>>
							<td style="padding-left:15px;">
								<?php echo $counter;?>							</td>
							 <td style="padding-left:10px;"><a href="home.php?p=viewituser&mod=users&u=<?php echo $seeker_id;?>" target="_blank"><?php  echo stripslashes($get_name);?> 
                           </i>
                             </a></td>
                             
                             <td style="padding-left:10px;"><a href="<?php echo $ru;?>job-detail/<?php echo $arrfaq['id'];?>" target="_blank"><?php  echo stripslashes($arrfaq['job_title']);?></a></td>
                            <td style="padding-left:10px;"><a href="home.php?p=viewitemployer&mod=users&u=<?php echo $arrfaq['employer_id'];?>"><?php  echo stripslashes($arrfaq['company_name']); ?></a></td>
                            
                            <td style="padding-left:10px;"><?php  echo stripslashes($country_name['Country']); ?></td>
                            
                            <td style="padding-left:10px;"><?php  echo stripslashes($state_name['Region']); ?></td>
                            <td style="padding-left:10px;"><?php  echo stripslashes($city_name['City']); ?></td>
                            <td style="padding-left:10px;"><?php  echo $currency_symbol.stripslashes($arrfaq['job_salary_min'])." - ".$currency_symbol.stripslashes($arrfaq['job_salary_max']); ?></td>
						<td style="padding-left:10px;"><?php  echo stripslashes($arrfaq['expiry_date']); ?></td>
                            
                            
							<td style="padding-left:10px;">
							
							
							
					
			<a href="home.php?mod=<?php echo $mod;?>&p=jobsoperations&deletepage=<?php echo $arrfaq[id]?>" onClick="return confirm('Are you sure you want to delete this job?')">
							<img src="img/delete.jpg" width="16" height="16" border="0" alt="" title="Delete"></a>	</td>
						</tr>
                        
						<?php 
						
						}
						?>
						
                  
				 
							
					<?php
						}
						
						
						
						 else{ ?>
						<tr> <td colspan="10" class="msg" align="center"> No Applicant Found </td>
							
						<?php } ?>
                        </form>
					</table>
<div align="center">
								<?php
									//pagination 3 of 3
							if($numrows >$rows_per_page)
							{
								if ($pageno == 1) 
								{
									echo " FIRST PREV ";
								} 
								else 
								{
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=apply_jobs_list&pageno=1'>FIRST</a> ";
									$prevpage = $pageno-1;
									echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=apply_jobs_list&pageno=$prevpage'>PREV</a> ";
								} 
							//........
								echo " ( Page $pageno of $lastpage ) ";
							
							//....................
								if ($pageno == $lastpage) 
								{
									echo " NEXT LAST ";
								
								} 
								else 
								{
								$nextpage = $pageno+1;
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=apply_jobs_list&pageno=$nextpage'>NEXT</a> ";
								echo " <a href='{$_SERVER['PHP_SELF']}?mod=$mod&p=apply_jobs_list&pageno=$lastpage'>LAST</a> ";
							
							
								}
							}
								
							 ?> 
							 </div>
				</td>
			</tr>
			<tr>
				
				<td colspan="3" align="center" id="errormsg">
					
				</td>
			</tr>
		</table>
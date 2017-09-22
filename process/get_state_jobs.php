<?php
error_reporting(0);
include("../common/top.php");
include("../common/functions.php");
if($_REQUEST['country_id']!='')
{
$list_state  =  job_state_list($_REQUEST['country_id']);
}
?>
<select class="form-control" name="job_state" onchange="get_city_jobs(this.value, <?php echo $_REQUEST['country_id'];?>)" style="width:100%;">
<option value="">State</option>
<?php 
	$n=1; 
	if($list_state)
	{
		
		foreach($list_state as $row_list)
		{
			?>
			 <option value="<?php echo stripslashes($row_list['RegionID']);?>"><?php echo stripslashes($row_list['Region']);?></option>
			<?php
		}
	}	
?>

</select>
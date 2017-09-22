<?php
error_reporting(0);
include("../common/top.php");
include("../common/functions.php");

$country_id  =  $_REQUEST['country_id'];
$state_id  =  $_REQUEST['state_id'];
if($country_id!="" && $state_id!='')
{
$list_state  =  jobs_city_list($state_id, $country_id);
}
?>
<select class="form-control" name="job_city" style="width:100%;" >
<option value="">City</option>
<?php 
	$n=1; 
	if($list_state)
	{
		
		foreach($list_state as $row_list)
		{
			?>
			 <option value="<?php echo stripslashes($row_list['CityId']);?>"><?php echo stripslashes($row_list['City']);?></option>
			<?php
		}
	}	
?>
</select>
<?php 
include ('../config/conndb.php');
include('../includes/common/bright_escrow.php');


defined('_JEVS') or die('Restricted access');
include('../includes/functions/functions.php');

if(isset($_GET['slots_availble']) && (trim($_GET['pid'])!='')  )
{
		 $qry = "update tbl_slots set  
						artist_id  				=  '".addslashes($_GET['artist_id'])."',
						payment_status  				=  'r'
						where slot_id    =  '".$_GET['slots_availble']."'";
					//	$updateqry = @mysql_query($qry);
		$qry = "delete from tbl_slotsrequested	where concert_id=".$_GET['concert_id']." and slot_id =  '".$_GET['old_slot']."' and artist_id =  '".$_GET['artist_id']."'";
						//$updateqry = @mysql_query($qry);
		
		
		
		
				
		die();
	header('location:home.php?p=concert_pending&mod=organizer&concert_id='.$_GET['concert_id']);exit;


}elseif(isset($_GET['slots_availble']))
{
	$genreqry = mysql_query("select * from tbl_slots where slot_id=".$_GET['old_slot']);  
	while($genre1 = mysql_fetch_array($genreqry))
	{ 
		$payment_status= $genre1['payment_status'];
		$payment_received= $genre1['payment_received'];
	}
	  	 $qry = "update tbl_slots set  
					artist_id  				=  '".addslashes($_GET['artist_id'])."',
					payment_status  				=  '".addslashes($payment_status)."',
					payment_received  				=  '".addslashes($payment_received)."'
					where slot_id    =  '".$_GET['slots_availble']."'";
					$updateqry = @mysql_query($qry);
		  	$qry = "update tbl_slots set  
					artist_id  				=  '0',
					payment_status  		=  '',
					payment_received  		=  '0'
						where slot_id    =  '".$_GET['old_slot']."'";										
					$updateqry = @mysql_query($qry);
					
					//die();
	header('location:home.php?p=concert_pending&mod=organizer&concert_id='.$_GET['concert_id']);exit;
}

$genreqry = mysql_query("select * from tbl_slots where concert_id=".$_POST['concert_id']." AND artist_id < 1 order by slot_id");  
echo "<form name='myForm' action='get_all_slots.php'><select class='topsearch' name='slots_availble' style='width:215px; height:22px;'>";

while($genre1 = mysql_fetch_array($genreqry))
{
	echo  "<option value=".$genre1['slot_id'].">".$genre1['time_slot']."</option>";
}
echo "<select><input type='hidden' name='pid' value=".$_POST['pid']."><input type='hidden' name='concert_id' value=".$_POST['concert_id']."><input type='hidden' name='artist_id' value='".$_POST['artist_id']."'><input type='hidden' name='old_slot' value='".$_POST['old_slot']."'>
<input type='image' name='type' width='16' border='0' height='16' alt='Update' src='img/icon_terms.gif'><img width='16' style='cursor: pointer;' onclick='$(\".slots_class\").html(\"\");' border='0' height='16' alt='Update' src='img/delete.jpg'></form>";

?>
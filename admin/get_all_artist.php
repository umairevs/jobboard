<?php 
include ('../config/conndb.php');
defined('_JEVS') or die('Restricted access');
include('../includes/functions/functions.php');
if(isset($_GET['deleteslot']) && $_GET['deleteslot']=='yes' )
{
	$qry = "delete from tbl_slotsrequested	where slot_reqid =  '".$_POST['slot_id']."'";
	$updateqry = @mysql_query($qry);
	header('location:home.php?p=concert_pending&mod=organizer&concert_id='.$_GET['concert_id']);
	exit;
}
if(isset($_GET['artist_availble']))
{
	echo $qry = "INSERT INTO tbl_slotsrequested SET 	
					concert_id  				=  '".addslashes($_GET['concert_id'])."',
					slot_id  				=  '".addslashes($_GET['old_slot'])."',
					artist_id  				=  '".addslashes($_GET['artist_availble'])."'";
	
					$updateqry = @mysql_query($qry);
	header('location:home.php?p=concert_pending&mod=organizer&concert_id='.$_GET['concert_id']);exit;
}

$genreqry = mysql_query("select * from tbl_artist where status='a'");  
echo "<form id='artist_rem' name='myForm' action='get_all_artist.php'><select class='topsearch' name='artist_availble' style='width:215px; height:22px;'>";

while($genre1 = mysql_fetch_array($genreqry))
{
	echo  "<option value=".$genre1['id'].">".$genre1['full_name']."</option>";
}
echo "<select><input type='hidden' name='concert_id' value=".$_POST['concert_id']."><input type='hidden' name='artist_id' value='".$_POST['artist_id']."'><input type='hidden' name='old_slot' value='".$_POST['old_slot']."'>
<input type='image' name='type' width='16' border='0' height='16' alt='Update' src='img/icon_terms.gif'><img width='16' style='cursor: pointer;' onclick='$(\".slots_class1\").html(\"\");' border='0' height='16' alt='Update' src='img/delete.jpg'></form>";

?>
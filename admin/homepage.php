
<?php 
defined('_JEVS') or die('Restricted access');
/***********************************************************************************************
*																								*
*									User Statistics							*
************************************************************************************************/

//  User Count Query Active Users
$activeuser= mysql_query("SELECT count(*) as activeusers FROM `tbl_users` WHERE  STATUS = 'a'" );
$activeuser_row=mysql_fetch_array($activeuser); 
// User Count Query Suspending Users
$suspenduser= mysql_query("SELECT count(*) as suspendusers FROM `tbl_users` WHERE  STATUS = 's'" );
$suspenduser_row=mysql_fetch_array($suspenduser);
// User Count Query Pending Users	
$pendinguser= mysql_query("SELECT count(*) as pendingusers FROM `tbl_users` WHERE  STATUS = 'p'" );
$pendinguser_row=mysql_fetch_array($pendinguser);	
// User Count Query All Users	
$alluser= mysql_query("SELECT count(*) as allusers FROM `tbl_users`" );
$alluser_row=mysql_fetch_array($alluser);
// User Count Query for Current Week users
$currweek_user= mysql_query("select count(*) as currweek_users from tbl_users where `add_date` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) " );
$currweek_user_row=mysql_fetch_array($currweek_user);
// User Count Query for Last Week users
$lastweek_user= mysql_query("select count(*) as lastweek_users from tbl_users where `add_date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 14 DAY ) AND DATE_SUB( CURDATE( ) ,INTERVAL 7 DAY )" );
$lastweek_user_row=mysql_fetch_array($lastweek_user);	
// User Count Query for Current Month users
$currmonth_user=mysql_query("SELECT count(*) as currmonth_users FROM tbl_users WHERE YEAR(add_date) = YEAR(CURDATE()) AND MONTH(add_date) = MONTH(CURDATE())");
$currmonth_user_row=mysql_fetch_array($currmonth_user);	
//User Count Query for Last Month users
$lastmonth_user=mysql_query("SELECT count( * ) AS lastmonth_users FROM tbl_users WHERE MONTH( add_date ) = MONTH( DATE_ADD( now( ) , INTERVAL -1 MONTH ) ) AND YEAR(add_date)=YEAR(CURDATE()) ");
$lastmonth_user_row=mysql_fetch_array($lastmonth_user);		



/***********************************************************************************************
*																								*
*									Jobs Statistics							*
************************************************************************************************/

//  User Count Query Active jobs
$activeuser= mysql_query("SELECT count(*) as activejobs FROM `tbl_jobs` WHERE  job_status = 1 " );
$activeuser_row=mysql_fetch_array($activeuser); 
// User Count Query Expired jobs
$suspenduser= mysql_query("SELECT count(*) as expiredjobs FROM `tbl_jobs` WHERE  job_status = 0 " );
$suspenduser_row=mysql_fetch_array($suspenduser);
// User Count Query Pending Jobs
// $pendinguser= mysql_query("SELECT count(*) as pendingusers FROM `tbl_users` WHERE  STATUS = 'p'" );
// $pendinguser_row=mysql_fetch_array($pendinguser);	
// User Count Query All Jobs
$alluser= mysql_query("SELECT count(*) as alljobs FROM `tbl_jobs`" );
$alluser_row=mysql_fetch_array($alluser);
// User Count Query for Current Week Jobs
 $currweek_user= mysql_query("select count(*) as currweek_jobs from tbl_jobs where `posted_date` >= DATE_SUB(CURDATE(), INTERVAL 7 DAY) " );
 $currweek_user_row=mysql_fetch_array($currweek_user);
// User Count Query for Last Week Jobs
 $lastweek_user= mysql_query("select count(*) as lastweek_jobs from tbl_jobs where `posted_date` BETWEEN DATE_SUB( CURDATE( ) ,INTERVAL 14 DAY ) AND DATE_SUB( CURDATE( ) ,INTERVAL 7 DAY )" );
// $lastweek_user_row=mysql_fetch_array($lastweek_user);	
// User Count Query for Current Month Jobs
$currmonth_user=mysql_query("SELECT count(*) as currmonth_jobs FROM tbl_jobs WHERE YEAR(posted_date) = YEAR(CURDATE()) AND MONTH(posted_date) = MONTH(CURDATE())");
$currmonth_user_row=mysql_fetch_array($currmonth_user);	
//User Count Query for Last Month Jobs
$lastmonth_user=mysql_query("SELECT count( * ) AS lastmonth_jobs FROM tbl_jobs WHERE MONTH( posted_date ) = MONTH( DATE_ADD( now( ) , INTERVAL -1 MONTH ) ) AND YEAR(posted_date)=YEAR(CURDATE()) ");
$lastmonth_user_row=mysql_fetch_array($lastmonth_user);	



?>

<table width="100%" >
	<?php if ( isset ($_SESSION['msgUpdate'] ) ) {?>
	<tr>
		<td class="msg" align="center"><?php echo  $_SESSION['msgUpdate']; unset($_SESSION['msgUpdate']); ?></td>
	</tr>
	<?php } ?>
</table>
<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
	<tr>
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="tracking_box" >
	
	<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
		<tr>
			<td>&nbsp;</td>
			<td >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
      
	<table cellpadding="3" cellspacing="0" border="0" width="100%"  class="grid" align="center" style="border:solid #cccccc 1px;">
	<tr>
		<th colspan="6" style="text-align:left"> <img src="img/userstats.gif" height="20" width="20" align="absbottom" /> Users Statistics </th>
	</tr>
	<tr class="colortr2">
		<td width="47"><img src="img/activeuser.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Active Users :</strong></td>
		<td width="32" class="msgred"><?php echo $activeuser_row['activeusers']; ?></td>
		<td width="34"><img src="img/suspended.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Suspended Users:</strong> :</td>
		<td width="82" class="msgred"><?php echo $suspenduser_row['suspendusers']; ?></td>
	</tr>
	<tr class="colortr">
		<td width="47"><img src="img/pending.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Pending Users :</strong></td>
		<td width="32" class="msgred"><?php echo $pendinguser_row['pendingusers']; ?></td>
		<td width="34">&nbsp;</td>
		<td width="223">&nbsp;</td>
		<td width="82">&nbsp;</td>
	</tr>
	<tr class="colortr2">
		<td width="47"><img src="img/currentweek.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Current Week Registered  Users :</strong></td>
		<td width="32" class="msgred"><?php echo $currweek_user_row['currweek_users']; ?></td>
		<td width="34"><img src="img/lastweek.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Last Week Registered  Users :</strong>: </td>
		<td width="82" class="msgred"><?php echo $lastweek_user_row['lastweek_users']; ?></td>
	</tr>
	<tr class="colortr">
		<td width="47"><img src="img/lastmonth.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Current Month Registered  Users :</strong></td>
		<td width="32" class="msgred"><?php echo $currmonth_user_row['currmonth_users']; ?></td>
		<td width="34"><img src="img/lastmonth.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Last Month Registered  Users :</strong></td>
		<td width="82" class="msgred"><?php echo $lastmonth_user_row['lastmonth_users']; ?></td>
	</tr>
	<tr class="colort2">
		<td width="47"><img src="img/user.png" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Total Registered  Users :</strong></td>
		<td width="32" class="msgred"><?php echo $alluser_row['allusers']; ?></td>
		<td width="34">&nbsp;</td>
		<td width="223">&nbsp;</td>
		<td width="82">&nbsp;</td>
	</tr>
	<tr class="colort2">
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td class="msgred">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
	<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
		<tr>
			<td>&nbsp;</td>
			<td >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>




<!-- Post Jobs Statistics -->
<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
	<tr>
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
<div class="tracking_box" >
	
	<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
		<tr>
			<td>&nbsp;</td>
			<td >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>

	<table cellpadding="3" cellspacing="0" border="0" width="100%"  class="grid" align="center" style="border:solid #cccccc 1px;">
	<tr>
		<th colspan="6" style="text-align:left"> <img src="img/userstats.gif" height="20" width="20" align="absbottom" /> Posts Jobs Statistics </th>
	</tr>
	<tr class="colortr2">
		<td width="47"><img src="img/activeuser.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Active Jobs :</strong></td>
		<td width="32" class="msgred"><?php echo $activeuser_row['activejobs']; ?></td>
		<td width="34"><img src="img/suspended.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Expired Jobs :</strong>: </td>
		<td width="82" class="msgred"><?php echo $suspenduser_row['expiredjobs']; ?></td>
	</tr>
	<!-- <tr class="colortr">
		<td width="47"><img src="img/pending.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Pending Users:</strong></td>
		<td width="32" class="msgred"><?php echo $pendinguser_row['pendingusers']; ?></td>
		<td width="34">&nbsp;</td>
		<td width="223">&nbsp;</td>
		<td width="82">&nbsp;</td>
	</tr>   -->
	<tr class="colortr2">
		<td width="47"><img src="img/currentweek.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Current Week Posts Jobs :</strong></td>
		<td width="32" class="msgred"><?php echo $currweek_user_row['currweek_jobs']; ?></td>
		<td width="34"><img src="img/lastweek.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Last Week Posts Jobs :</strong>: </td>
		<td width="82" class="msgred"><?php echo $lastweek_user_row['lastweek_jobs']; ?></td>
	</tr>   
	<tr class="colortr">
		<td width="47"><img src="img/lastmonth.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Current Month Posts Jobs :</strong></td>
		<td width="32" class="msgred"><?php echo $currmonth_user_row['currmonth_jobs']; ?></td>
		<td width="34"><img src="img/lastmonth.gif" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="223"><strong>Last Month Posts Jobs :</strong></td>
		<td width="82" class="msgred"><?php echo $lastmonth_user_row['lastmonth_jobs']; ?></td>
	</tr>
	<tr class="colort2">
		<td width="47"><img src="img/user.png" height="20" width="20" align="right" Style="margin-right:5px;"  /></td>
		<td width="233" ><strong>Total Posts Jobs :</strong></td>
		<td width="32" class="msgred"><?php echo $alluser_row['alljobs']; ?></td>
		<td width="34">&nbsp;</td>
		<td width="223">&nbsp;</td>
		<td width="82">&nbsp;</td>
	</tr>
	<tr class="colort2">
		<td>&nbsp;</td>
		<td >&nbsp;</td>
		<td class="msgred">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
</table>
	<table cellpadding="0" cellspacing="0" border="0" width="81%" align="center" >
		<tr>
			<td>&nbsp;</td>
			<td >&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
</div>
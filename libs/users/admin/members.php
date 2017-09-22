<?php 
//Check access of module
include("security_module.php");
 
 	 if (isset ($_POST['reset'] ) ) 
	{
	 	unset($_SESSION['js_userStatus']);
		unset($_SESSION['js_sType']);
		unset($_SESSION['js_sText']);
		unset($_SESSION['js_SortBy']);
		unset($_SESSION['js_txtDateFrom']);
		unset($_SESSION['js_txtDateTo']);
		unset($_SESSION['js_sectorBy']);
		unset($_SESSION['js_companyidBy']);
		
	}
	//createTable('user'); // if not exist ;
    if (isset ($_POST['doSearch'] ) ) 
	{
	 	$_SESSION['js_userStatus']	=	$_POST['userStatus'];
		$_SESSION['js_sType']		=	$_POST['sType'];
		$_SESSION['js_sText']		=	trim($_POST['sText']);
		$_SESSION['js_SortBy']		=	$_POST['SortBy'];
		$_SESSION['js_txtDateFrom']	=	trim($_POST['txtDateFrom']);
		$_SESSION['js_txtDateTo']	=	trim($_POST['txtDateTo']);
		
		$_SESSION['js_sectorBy']	=	trim($_POST['sector']);
		$_SESSION['js_companyidBy']	=	trim($_POST['companies']);
		
		unset ($_SESSION['mpage']);
		header("location:home.php?p=members&mod=".$mod);exit;
	}
	
	
	
	
	//unset($_SESSION['js_userStatus']);//done by aleem for test
	if ( !isset($_SESSION['js_userStatus']))
	{
		$_SESSION['js_userStatus'] = '1';
	}
	$qryString .= " where  status = '".$_SESSION['js_userStatus']."'";	
	
	if ( $_SESSION['js_sText'] != '' )
	   {
		 $qryString .= " and ".addslashes($_SESSION['js_sType']) ." like '%".addslashes($_SESSION['js_sText'])."%'";
		 
		 if ($_SESSION['js_sType'] =='full_name' )  $SearchMsg .= ', Full Name:'. $_SESSION['js_sText'] ;
		// if ($_SESSION['js_sType'] =='lname' )  $SearchMsg .= ', Last Name:'. $_SESSION['js_sText'] ;
		 if ($_SESSION['js_sType'] =='email' )  $SearchMsg .= ', email:'. $_SESSION['js_sText'] ;
	  }	
	if  (($_SESSION['js_txtDateTo'] != '')  and  ($_SESSION['js_txtDateFrom'] != '')) 
	 {
		$list = split('-', $_SESSION['js_txtDateFrom']); //dd/mm/yyyy
		$dfrom= $list[2].'-'.$list[1].'-'.$list[0];
		$list2 = split('-', $_SESSION['js_txtDateTo']);
		$dto= $list2[2].'-'.$list2[1].'-'.$list2[0];
        $SearchMsg .=' , Join date: '.$_SESSION['js_txtDateFrom'].','.$_SESSION['js_txtDateTo']; 
		$qryString .= " and   DATE(posted_date)  >= '".$dfrom."' and DATE(posted_date) <= '".$dto."'  ";
	}
	
	
	?>
	<?php
	if (isset($_SESSION['js_SortBy'])){
		$_SESSION['js_SortBy'] = $_SESSION['js_SortBy'];
	}
	//sorting order
	if(isset($_GET['sortOrd']) && $_GET['sortOrd'] !='birth_date asc' && $_GET['sortOrd'] !='birth_date desc'){ 
		$_SESSION['js_SortBy'] = $_GET['sortOrd'] ;
	}else{
		$_SESSION['js_SortBy'] = $_GET['sortOrd'];
	}	 
		
	if(!isset($_SESSION['js_SortBy']) && !isset($_GET['sortOrd'])){
		$_SESSION['js_SortBy'] = 'id asc';
	}
		
	$qryString .= ' order by '.$_SESSION['js_SortBy'].' ';
	if (isset($_GET["page"]))
	{
		$page =$_GET["page"];
	}else{
		$page = $_SESSION['mpage'];
	}
    if ($page == '' ) $page =1;
	$_SESSION['mpage'] =$page;


$UserRS		= mysql_query("SELECT count(*) FROM `tbl_job_seaker` " );
$UserROW	= mysql_fetch_array($UserRS);
$totalUser	= $UserROW[0];

$UserRS		= mysql_query("SELECT count(*) FROM `tbl_job_seaker` WHERE  STATUS = '1'" );
$UserROW	= mysql_fetch_array($UserRS);
$activeUser	= $UserROW[0];

$UserRS		= mysql_query("SELECT count(*) FROM `tbl_job_seaker` WHERE  STATUS = '0'" );
$UserROW	= mysql_fetch_array($UserRS);
$suspendedUser	= $UserROW[0];

//PAGINARE-----------------------------------------------------------------
	
	$nritem = 30;
    
    $q_c	=mysql_query("select * from `tbl_job_seaker` ".$qryString ) or die(mysql_error());
    $count_item=mysql_num_rows($q_c);
    $limitvalue = ($page - 1) * $nritem;
	if ($_SESSION['js_userStatus'] =='1')  $SearchMsg = 'Showing: Active User('.$count_item.') '.$SearchMsg;
	if ($_SESSION['js_userStatus'] =='0')  $SearchMsg = 'Showing: Suspended User('.$count_item.') '.$SearchMsg;
//-------------------------------------------------------------------------
?>


<?php 
$t .= '<table width="100%" ><tr><td class="top-bar">
<div style="float:left; width:98%"><div style="float:left; width:250px">Users Management</div>';
      
if(isset($_SESSION['msg']))
 {
 	//style="width:300px; color:#99CC66; float:left; margin-left:50px;"
	$t .='<div class="message" > ' .$_SESSION['msg'].'</div>';
    unset($_SESSION['msg']);
}
$t .='<div style="float:right">Add New User
	<a href="home.php?p=user_add&mod='.$mod.'"><img src="img/new_faq_class.png" border="0"  alt="" title="Add User" /> </a></div>';
$t .='</div> </td></tr>';
 /*if ( isset ($_SESSION['msgMember'] ) ) { $t.='<tr><td class="msg" align="center">'.$_SESSION['msgMember'].'</td></tr>'; } 
 unset($_SESSION['msgMember']);
 if ( isset ($_SESSION['updatemsg'] ) ) { $t.='<tr><td class="msg" align="center">'.$_SESSION['updatemsg'].'</td></tr>'; } 
 unset($_SESSION['updatemsg']);*/
   
$t.='</table>';
	$t.=' <form method="post" action="home.php?p=members&mod='.$mod.'" ><table cellpadding="0" cellspacing="0" id="vtop" width="100%">
	    <tr>
			<td>
			<div class="tracking_box"><table cellpadding="0" cellspacing="0" width="100%" >
		<tr class="rowtitle5" >
			<td>Total Users:&nbsp;&nbsp;<strong>'. $totalUser .'</strong></td>
			<td>&nbsp;&nbsp;</td>
			<td>Active Users:&nbsp;&nbsp;<strong>'. $activeUser .'</strong></td>
			<td>&nbsp;&nbsp;</td>
			<td>Pending Users:&nbsp;&nbsp;<strong>'.$suspendedUser.'</strong></td>
		</tr>
		<tr>
			<td colspan="7" style="font-size:10px;color:#666666;font-weight:600;border:1px solid #F8F8F8; padding:4px;">
			User:&nbsp;
			<select name="userStatus"   class="topsearch">			
				<option ';
				if ($_SESSION['js_userStatus'] =='1' )  $t.=' selected="selected" ';
				$t.=' value="1">Active</option>	<option ';
				if ($_SESSION['js_userStatus'] =='0' )  $t.=' selected="selected" ';
				$t.=' value="0">Suspended </option>
				';
				$t .= '</select>&nbsp;Search:&nbsp;<select name="sType" id="sType"  class="topsearch"  >			
				<option ';
				if (stripslashes($_SESSION['js_sType']) =='Name' )  $t.=' selected="selected" ';
				$t.='value="name">Name</option>
				<option ';
				if ($_SESSION['js_sType'] =='email' )  $t.=' selected="selected" ';
				$t.=' value="email">Email Address</option>
				
										
	</select>
	<input type="text" size="25"   name="sText" class="topsearch" value="'.$_SESSION['js_sText'].'" >&nbsp;Date&nbsp;from:&nbsp;
				
					<input type="text" size="10" readonly="readonly" name="txtDateFrom" id="txtDateFrom" class="topsearchdate" onclick="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateFrom\'));" value ="'.$_SESSION['js_txtDateFrom'].'" onblur="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateFrom\'));" />&nbsp;To:&nbsp;
					<input type="text" size="10" readonly="readonly" name="txtDateTo" id="txtDateTo" class="topsearchdate" onclick="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateTo\'));" onblur="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateTo\'));" value ="'.$_SESSION['js_txtDateTo'].'"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;
	
	&nbsp;	
					<input type="submit" name="doSearch" id="doSearch" value="Search" class="searchbtn"  />
					<input type="submit" name="reset" id="reset" value="Reset" class="searchbtn"  />
				 			
			</td>
		</tr>	
		<tr>
			<td colspan = "7"  style="font-size:12px;color:#000;font-weight:600; padding:3"> <br>'.$SearchMsg.'</td>
		</tr>
		<tr>
			<td colspan = "7"></td>
		</tr>
	</table> 
	</div>
	</td>
	</tr>
	<tr>
		<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
			<tr >
				<th width="3%"> <b> &nbsp;&nbsp;S# </b> </th>
				
				
				<th width="10%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=members&mod='.$mod.'&sortOrd=fname asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Name</b><img id="nameds" onclick="window.location=\'home.php?p=members&mod='.$mod.'&sortOrd=fname desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
				
				
				<th width="15%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=members&mod='.$mod.'&sortOrd=email asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Email</b><img id="nameds" onclick="window.location=\'home.php?p=members&mod='.$mod.'&sortOrd=email desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
		 
				
				<th width="10%">Phone</th>
				
				<th width="10%">Location</th>
				
				<th width="10%">Posted Date</th>
				
				
				<th width="15%"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action</b></th>
			</tr>';

	//Select Users
	if(!isset($_GET['page'])){$x = 1;}else{ 
		$ss = $page-1;
		$sxs = $ss * $nritem;
		$x = $sxs + 1;
	}
	
	$counter = 0;
	
	 $sql_sel_user = "SELECT * FROM `tbl_job_seaker`  $qryString limit $limitvalue, $nritem";
	
	//echo  $sql_sel_user;
	$query_sel_user = mysql_query($sql_sel_user) or die(mysql_error());
	if(mysql_num_rows($query_sel_user) > 0)
	{
	while($row_user = mysql_fetch_array($query_sel_user))
	{   
	    $counter++;
		if ($counter % 2 == 0)
		{
			$bgcolor = "#F5F7D9";
		}
		else
		{
			$bgcolor = "#FFFFFF";
		}
	//bgcolor="'.$bgcolor.'"
	
	$cname = '';
	if($row_user["country"]!=0)
	{
		$country_list	=	get_country($row_user["country"]);
		$country_name =  stripslashes($country_list['Country']);
		
		$cname .= $country_name;
	}
	else
	{
		$country_name = '';
		$cname .= '';;
	}	
	
	if($row_user["state"]!=0)
	{
		$state_list	=	get_state($row_user["state"]);
		$state_name	=	stripslashes($state_list['Region']);
		
		$cname .= ", ".$state_name;
	}
	else
	{
		$state_name = '';
		$cname .= "";
	}	
	
	if($row_user["city"]!=0)
	{
		$city_list	=	get_city($row_user["city"]);
		$city_name	= stripslashes($city_list['City']);
		
		$cname .= ", ".$city_name;
	}
	else
	{
		$city_name = '';
		$cname .= "";
	}	
	
	
		 
		 $t.='<tr><td class="tdborder" > &nbsp;  &nbsp;'.$counter.'</td>
		  <td class="tdborder" >'.stripslashes($row_user["name"]).'</td>		
		  <td class="tdborder" >'.stripslashes($row_user["email"]).'</td>
		  <td class="tdborder" >'.stripslashes($row_user["mobile_number"]).'</td>
		  <td class="tdborder" >'.$cname.'</td>
		   <td class="tdborder" >'.stripslashes($row_user["posted_date"]).'</td>
		 
		  <td class="tdborder" >
		  <input type="hidden" name="mode" value="userid">
		  &nbsp;&nbsp;';
		  
		  if($row_user["status"] == '1'){
			  $t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Detail" onclick="window.location=\'home.php?p=viewituser&mod='.$mod.'&u='.$row_user["id"].'\';" />&nbsp;
					
					<img src="img/remove.jpg" width="16" height="16"  style="cursor:pointer;" title="Block Member " onclick="var tmp=confirm(\'This will block user to login. Are you sure!\'); if (tmp) {	window.location=\'home.php?p=updatemember&mod='.$mod.'&a=0&u='.$row_user["id"].'\';}" />&nbsp;
					<img src="img/delete.jpg" width="16" height="16" title="Delete Member " onclick="var tmp=confirm(\'This will Delete the user. Are you sure!\'); if (tmp) {	window.location=\'home.php?p=updatemember&mod='.$mod.'&a=d&u='.$row_user["id"].'\';}" style="cursor:pointer;" />';
			}elseif($row_user["status"] == '0'){
				$t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Detail" onclick="window.location=\'home.php?p=viewituser&mod='.$mod.'&u='.$row_user["id"].'\';" />&nbsp;
					<img src="img/icon_terms.gif" width="16" height="16" title="Approve/verify member " onclick="window.location=\'home.php?p=updatemember&mod='.$mod.'&a=1&u='.$row_user["id"].'\';" style="cursor: pointer;" height="18" width="18">&nbsp;&nbsp;&nbsp;
					<img src="img/delete.jpg" width="16" height="16" title="Delete Member " onclick="var tmp=confirm(\'This will Delete user. User not able to login. Are you sure!\'); if (tmp) {	window.location=\'home.php?p=updatemember&mod='.$mod.'&a=d&u='.$row_user["id"].'\';}" style="cursor:pointer;" />';
			}
			$t.='
		</td>	
	</tr>';

	$x++;
	} 
	}else{
	$t .='<tr> <td colspan="9" style="color:#CC0000; font-weight:bold; text-align:center"> No Member Found  </td> </tr>';
	}

	$t .='</table>';
	
		$t.='
		<div> Page:'; 			
			
			 $numofpages =  ceil($count_item / $nritem);
			 $pageNums   =  ceil($page /10);
			// echo  $pageNums ;
			 if  (  $pageNums > 1)
			 {	//First Page  
				 $t.='<a  href="home.php?p=members&mod='.$mod.'&page=1"><b>First</b></a>&nbsp&nbsp';
			 	  
			 }else{
			 	 $t.='<b>First</b>&nbsp&nbsp';
			 
			 }
			 if (  $pageNums > 1 )
			 { //Previous 
				$Previouspage  = ( $pageNums -1) * 10;
				$t.='<a  href="home.php?p=members&mod='.$mod.'&page='.$Previouspage.'"><b>Previous</b></a>&nbsp&nbsp';
			 }else{
			 	$t.='<b>Previous</b>&nbsp&nbsp';
			 }
			 if  ( ( $pageNums *10 )  <= $numofpages ) {
			 		
					$maxPageNum = $pageNums *10;
					$minPageNum =  $maxPageNum-9;
			 }else{
			 	
			 		$maxPageNum =  $numofpages;
					$minPageNum = $maxPageNum   - (   9 - ( (  $pageNums * 10 ) - $maxPageNum) );
					
			 }
			//  echo 	$minPageNum .'---'.$maxPageNum ;
			 $tmpT = '';
			 if  ($numofpages > ( ( $pageNums *10 ) +1) )
					
			 {
			 	$tmpT .= '<a href="home.php?p=members&mod='.$mod.'&page='. ( $maxPageNum+1 ).'"><b>Next</b></a>&nbsp&nbsp';
			 }else{
			 	$tmpT .= '<b>Next</b>&nbsp&nbsp';
			 }

			 if  ( ($numofpages >10)  and ($numofpages >$maxPageNum) )
			 {
			 	$tmpT .= '<a  href="home.php?p=members&mod='.$mod.'&page='.$numofpages.'"><b>Last</b></a>&nbsp&nbsp';
			 }else{
			 	$tmpT .= '<b>Last</b>&nbsp&nbsp';
			 }
			 
          	 for($i = $minPageNum; $i <= $maxPageNum; $i++)
          	 {
				if($page == $i)
				{ 
					$t.='<b style="font-size:14px;">'.$i.'</b>&nbsp&nbsp';
				 }
				 else
				 {
					$t.='<a  href="home.php?p=members&mod='.$mod.'&page='.$i.'" ><b>'.$i.'</a>&nbsp&nbsp';
				 }
          	 }
			 
			  $t.=$tmpT;
			  $t .='</div>';	
		
	$t .='</td>
	</tr>
</table></form>
';
echo $t;
?>
</div>  


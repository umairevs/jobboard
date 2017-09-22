<?php 
//Check access of module
include("security_module.php");

unset($_SESSION['search_admin']);

	 if (isset ($_POST['reset'] ) ) 
	{
	 	unset($_SESSION['em_userStatus']);
		unset($_SESSION['em_sType']);
		unset($_SESSION['em_sText']);
		unset($_SESSION['em_SortBy']);
		unset($_SESSION['em_txtDateFrom']);
		unset($_SESSION['em_txtDateTo']);
		unset($_SESSION['em_sectorBy']);
		unset($_SESSION['em_companyidBy']);
		
	}
	
	//createTable('user'); // if not exist ;
    if (isset ($_POST['doSearch'] ) ) 
	{
	 	$_SESSION['em_userStatus']	=	$_POST['userStatus'];
		$_SESSION['em_sType']		=	$_POST['sType'];
		$_SESSION['em_sText']		=	trim($_POST['sText']);
		$_SESSION['em_SortBy']		=	$_POST['SortBy'];
		$_SESSION['em_txtDateFrom']	=	trim($_POST['txtDateFrom']);
		$_SESSION['em_txtDateTo']	=	trim($_POST['txtDateTo']);
		
		$_SESSION['em_sectorBy']	=	trim($_POST['sector']);
		$_SESSION['em_companyidBy']	=	trim($_POST['companies']);
		
		unset ($_SESSION['mpage']);
		header("location:home.php?p=employers&mod=".$mod);exit;
	}
	
	
	//unset($_SESSION['em_userStatus']);//done by aleem for test
	if ( !isset($_SESSION['em_userStatus']))
	{
		$_SESSION['em_userStatus'] = '1';
	}
	$qryString .= " where  status = '".$_SESSION['em_userStatus']."'";	
	
	if ( $_SESSION['em_sText'] != '' )
	   {
		 $qryString .= " and ".addslashes($_SESSION['em_sType']) ." like '%".addslashes($_SESSION['em_sText'])."%'";
		 
		 if ($_SESSION['em_sType'] =='full_name' )  $SearchMsg .= ', Full Name:'. $_SESSION['em_sText'] ;
		// if ($_SESSION['em_sType'] =='lname' )  $SearchMsg .= ', Last Name:'. $_SESSION['em_sText'] ;
		 if ($_SESSION['em_sType'] =='email' )  $SearchMsg .= ', email:'. $_SESSION['em_sText'] ;
	  }	
	if  (($_SESSION['em_txtDateTo'] != '')  and  ($_SESSION['em_txtDateFrom'] != '')) 
	 {
		$list = split('-', $_SESSION['em_txtDateFrom']); //dd/mm/yyyy
		$dfrom= $list[2].'-'.$list[1].'-'.$list[0];
		$list2 = split('-', $_SESSION['em_txtDateTo']);
		$dto= $list2[2].'-'.$list2[1].'-'.$list2[0];
        $SearchMsg .=' , Join date: '.$_SESSION['em_txtDateFrom'].','.$_SESSION['em_txtDateTo']; 
		$qryString .= " and   DATE(added_date)  >= '".$dfrom."' and DATE(added_date) <= '".$dto."'  ";
	}
	
	
	?>
	<?php
	if (isset($_SESSION['em_SortBy'])){
		$_SESSION['em_SortBy'] = $_SESSION['em_SortBy'];
	}
	//sorting order
	if(isset($_GET['sortOrd']) && $_GET['sortOrd'] !='birth_date asc' && $_GET['sortOrd'] !='birth_date desc'){ 
		$_SESSION['em_SortBy'] = $_GET['sortOrd'] ;
	}else{
		$_SESSION['em_SortBy'] = $_GET['sortOrd'];
	}	 
		
	if(!isset($_SESSION['em_SortBy']) && !isset($_GET['sortOrd'])){
		$_SESSION['em_SortBy'] = 'id asc';
	}
		
	$qryString .= ' order by '.$_SESSION['em_SortBy'].' ';
	if (isset($_GET["page"]))
	{
		$page =$_GET["page"];
	}else{
		$page = $_SESSION['mpage'];
	}
    if ($page == '' ) $page =1;
	$_SESSION['mpage'] =$page;


$UserRS		= mysql_query("SELECT count(*) FROM `tbl_employer` " );
$UserROW	= mysql_fetch_array($UserRS);
$totalUser	= $UserROW[0];

$UserRS		= mysql_query("SELECT count(*) FROM `tbl_employer` WHERE  STATUS = '1'" );
$UserROW	= mysql_fetch_array($UserRS);
$activeUser	= $UserROW[0];

$UserRS		= mysql_query("SELECT count(*) FROM `tbl_employer` WHERE  STATUS = '0'" );
$UserROW	= mysql_fetch_array($UserRS);
$suspendedUser	= $UserROW[0];


//PAGINARE-----------------------------------------------------------------
	
	$nritem = 30;
    
    $q_c	=mysql_query("select * from `tbl_employer` ".$qryString ) or die(mysql_error());
    $count_item=mysql_num_rows($q_c);
    $limitvalue = ($page - 1) * $nritem;
	if ($_SESSION['em_userStatus'] =='1')  $SearchMsg = 'Showing: Active User('.$count_item.') '.$SearchMsg;
	if ($_SESSION['em_userStatus'] =='0')  $SearchMsg = 'Showing: Suspended User('.$count_item.') '.$SearchMsg;
//-------------------------------------------------------------------------
?>


<?php 
$t .= '<table width="100%" ><tr><td class="top-bar">
<div style="float:left; width:98%"><div style="float:left; width:250px">Employers Management</div>';
      
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
	$t.=' <form method="post" action="home.php?p=employers&mod='.$mod.'" ><table cellpadding="0" cellspacing="0" id="vtop" width="100%">
	    <tr>
			<td>
			<div class="tracking_box"><table cellpadding="0" cellspacing="0" width="100%" >
		<tr class="rowtitle5" >
			<td>Total Employers:&nbsp;&nbsp;<strong>'. $totalUser .'</strong></td>
			<td>&nbsp;&nbsp;</td>
			<td>Active Employers:&nbsp;&nbsp;<strong>'. $activeUser .'</strong></td>
			<td>&nbsp;&nbsp;</td>
			<td>Inactive Employers:&nbsp;&nbsp;<strong>'.$suspendedUser.'</strong></td>
		</tr>
		<tr>
			<td colspan="7" style="font-size:10px;color:#666666;font-weight:600;border:1px solid #F8F8F8; padding:4px;">
			User:&nbsp;
			<select name="userStatus"   class="topsearch">			
				<option ';
				if ($_SESSION['em_userStatus'] =='1' )  $t.=' selected="selected" ';
				$t.=' value="1">Active</option>	<option ';
				if ($_SESSION['em_userStatus'] =='0' )  $t.=' selected="selected" ';
				$t.=' value="0">Suspended </option>
				';
				$t .= '</select>&nbsp;Search:&nbsp;<select name="sType" id="sType"  class="topsearch"  >			
				<option ';
				if (stripslashes($_SESSION['em_sType']) =='company_name')  $t.=' selected="selected" ';
				$t.='value="company_name">Company Name</option>
				<option ';
				if ($_SESSION['em_sType'] =='email' )  $t.=' selected="selected" ';
				$t.=' value="email">Email Address</option>
				
										
	</select>
	<input type="text" size="25"   name="sText" class="topsearch" value="'.$_SESSION['em_sText'].'" >&nbsp;&nbsp;Date&nbsp;from:&nbsp;
				
					<input type="text" size="10" readonly="readonly" name="txtDateFrom" id="txtDateFrom" class="topsearchdate" onclick="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateFrom\'));" value ="'.$_SESSION['em_txtDateFrom'].'" onblur="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateFrom\'));" />&nbsp;To:&nbsp;
					<input type="text" size="10" readonly="readonly" name="txtDateTo" id="txtDateTo" class="topsearchdate" onclick="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateTo\'));" onblur="this.value=\'\';showCalendarControl(document.getElementById(\'txtDateTo\'));" value ="'.$_SESSION['em_txtDateTo'].'"  />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
				
				
				<th width="10%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=employers&mod='.$mod.'&sortOrd=company_name asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Company Name</b><img id="nameds" onclick="window.location=\'home.php?p=employers&mod='.$mod.'&sortOrd=company_name desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
				
				
				<th width="15%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=employers&mod='.$mod.'&sortOrd=email asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Email</b><img id="nameds" onclick="window.location=\'home.php?p=employers&mod='.$mod.'&sortOrd=email desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
		 
				
				<th width="10%">Phone</th>
				
				<th width="10%">Address</th>
				
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
	
	 $sql_sel_user = "SELECT * FROM `tbl_employer`  $qryString limit $limitvalue, $nritem";
	
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
	
	 $query		= mysql_query("Select count(*) as COUNT from tbl_employer e, tbl_jobs j where j.employer_id = e.id AND j.employer_id = '".$row_user["id"]."'" );
	$row_res	= mysql_fetch_array($query);
	$total_jobs	= $row_res['COUNT'];
	 
		 
		 $t.='<tr><td class="tdborder" > &nbsp;  &nbsp;'.$counter.'</td>
		  <td class="tdborder" >'.stripslashes($row_user["company_name"]).'<br><i style="color: #666666; 
    font-family: "Trebuchet MS",Arial,Helvetica,sans-serif;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;"><a style="cursor:pointer;" href="home.php?p=joblist&mod=jobs&search_type=company_name&keyword='.stripslashes($row_user["company_name"]).'">('.$total_jobs.' Jobs)</a></i></td>		
		  <td class="tdborder" >'.stripslashes($row_user["email"]).'</td>
		  <td class="tdborder" >'.stripslashes($row_user["mobile_no"]).'</td>
		  <td class="tdborder" >'.stripslashes($row_user["address"]).'</td>
		   <td class="tdborder" >'.stripslashes($row_user["added_date"]).'</td>
		 
		  <td class="tdborder" >
		  <input type="hidden" name="mode" value="userid">
		  &nbsp;&nbsp;';
		  
		  if($row_user["status"] == '1'){
			  $t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Detail" onclick="window.location=\'home.php?p=viewitemployer&mod='.$mod.'&u='.$row_user["id"].'\';" />&nbsp;
					
					<img src="img/remove.jpg" width="16" height="16"  style="cursor:pointer;" title="Block Member " onclick="var tmp=confirm(\'This will block user to login. Are you sure!\'); if (tmp) {	window.location=\'home.php?p=updateemployer&mod='.$mod.'&a=0&u='.$row_user["id"].'\';}" />&nbsp;
					<img src="img/delete.jpg" width="16" height="16" title="Delete Member " onclick="window.location=\'home.php?p=viewitemployer&mod='.$mod.'&u='.$row_user["id"].'\';" style="cursor:pointer;" />';
			}elseif($row_user["status"] == '0'){
				$t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Detail" onclick="window.location=\'home.php?p=viewituser&mod='.$mod.'&u='.$row_user["id"].'\';" />&nbsp;
					<img src="img/icon_terms.gif" width="16" height="16" title="Approve/verify member " onclick="window.location=\'home.php?p=updateemployer&mod='.$mod.'&a=1&u='.$row_user["id"].'\';" style="cursor: pointer;" height="18" width="18">&nbsp;&nbsp;&nbsp;
					<img src="img/delete.jpg" width="16" height="16" title="Delete Member "onclick="var tmp=confirm(\'This will Delete user. User not able to login. Are you sure!\'); 
 if (tmp) {	window.location=\'home.php?p=updateemployer&mod='.$mod.'&a=d&u='.$row_user["id"].'\';}" style="cursor:pointer;" />';
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
				 $t.='<a  href="home.php?p=employers&mod='.$mod.'&page=1"><b>First</b></a>&nbsp&nbsp';
			 	  
			 }else{
			 	 $t.='<b>First</b>&nbsp&nbsp';
			 
			 }
			 if (  $pageNums > 1 )
			 { //Previous 
				$Previouspage  = ( $pageNums -1) * 10;
				$t.='<a  href="home.php?p=employers&mod='.$mod.'&page='.$Previouspage.'"><b>Previous</b></a>&nbsp&nbsp';
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
			 	$tmpT .= '<a href="home.php?p=employers&mod='.$mod.'&page='. ( $maxPageNum+1 ).'"><b>Next</b></a>&nbsp&nbsp';
			 }else{
			 	$tmpT .= '<b>Next</b>&nbsp&nbsp';
			 }

			 if  ( ($numofpages >10)  and ($numofpages >$maxPageNum) )
			 {
			 	$tmpT .= '<a  href="home.php?p=employers&mod='.$mod.'&page='.$numofpages.'"><b>Last</b></a>&nbsp&nbsp';
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
					$t.='<a  href="home.php?p=employers&mod='.$mod.'&page='.$i.'" ><b>'.$i.'</a>&nbsp&nbsp';
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


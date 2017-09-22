<?php  defined('_JEVS') or die('Restricted access');

		$orderBy = $_GET['sortOrd'];
	    $order_by = 'order by'.' '.$orderBy ; 
		
		
		
	$qryString .= ' order by '.$_SESSION['js_SortBy'].' ';
	if (isset($_GET["page"]))
	{
		$page =$_GET["page"];
	}else{
		$page = $_SESSION['mpage'];
	}
    if ($page == '' ) $page =1;
	$_SESSION['mpage'] =$page;




//------------------------------PAGINATION START-----------------------------------
	
	$nritem = 30;
    
    $q_c = mysql_query("SELECT tbl_users.id, tbl_users.fname, tbl_users.lname,tbl_users.email,tbl_users.password,
	                    tbl_users.status,
						tbl_adminpayment.add_date
                        FROM tbl_users
                        INNER JOIN
						tbl_adminpayment
                        ON
					    tbl_users.id = tbl_adminpayment.user_id ") or die(mysql_error());
    $count_item = mysql_num_rows($q_c);
    $limitvalue = ($page - 1) * $nritem;
//-------------------------------PAGINATION END------------------------------------------
?>


<?php 
$t .= '<table width="100%" ><tr><td class="top-bar">
<div style="float:left; width:98%"><div style="float:left; width:250px">Manage Sent Email</div>';
      
if(isset($_SESSION['msg']))
{
	$t .='<div class="message" > ' .$_SESSION['msg'].'</div>';
    unset($_SESSION['msg']);
}

$t .='</div> </td></tr>';
$t.='</table>';
	$t.=' <form method="post" action="home.php?p=members&mod='.$mod.'" ><table cellpadding="0" cellspacing="0" id="vtop" width="100%">
	<tr>
		<td>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="grid">
			<tr >
				<th width="3%"> <b> &nbsp;&nbsp;S# </b> </th>
				
				
				<th width="12%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=fname asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>First Name</b><img id="nameds" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=fname desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
				<th width="12%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=lname asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Last Name</b><img id="nameds" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=lname desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>
				
				<th width="10%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=email asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Email</b><img id="nameds" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=email desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>

<th width="10%"><img id="nameas" style="cursor:pointer" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=add_date asc\';" src="img/ascending.gif" title="ascending" />&nbsp;<b>Add Date</b><img id="nameds" onclick="window.location=\'home.php?p=managesendemail&mod='.$mod.'&sortOrd=add_date desc\';" src="img/descending.gif" style="cursor:pointer;" title="descending" /></th>				
				

				
			
				
				<th width="5%"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Action</b></th>
			</tr>';

	if (!isset($_GET['page']))
	{
		$x = 1;
	}
	else {
			$ss = $page-1;
			$sxs = $ss * $nritem;
			$x = $sxs + 1;
	 	}
	
	$counter = 0;
	if(isset($_GET['sortOrd']))
	{
		 $sql_sel_user = "SELECT tbl_users.id, tbl_users.fname, tbl_users.lname,tbl_users.email,tbl_users.password,
	                      tbl_users.status,
						  tbl_adminpayment.add_date
                          FROM tbl_users
                          INNER JOIN
						  tbl_adminpayment
                          ON
					      tbl_users.id = tbl_adminpayment.user_id 
		                 ".$order_by." "."limit $limitvalue, $nritem";
	}
	else
	{
		 $sql_sel_user = "SELECT tbl_users.id, tbl_users.fname, tbl_users.lname,tbl_users.email,tbl_users.password,
	                      tbl_users.status,
						  tbl_adminpayment.add_date
                          FROM tbl_users
                          INNER JOIN
						  tbl_adminpayment
                          ON
					      tbl_users.id = tbl_adminpayment.user_id 
		                  order by id DESC  limit $limitvalue, $nritem ";
	}
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
	$t.='<tr><td class="tdborder" > &nbsp;  &nbsp;'.$counter.'</td>
		  <td class="tdborder" >'.stripslashes($row_user["fname"]).'</td>		
		  <td class="tdborder" >'.stripslashes($row_user["lname"]).'</td>		  
		  <td class="tdborder" >'.stripslashes($row_user["email"]).'</td>
		  <td class="tdborder" >'.stripslashes($row_user["add_date"]).'</td>
		  <td class="tdborder" >
		  <input type="hidden" name="mode" value="userid">
		  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		  
		  $t.='<img src="img/icon_info.gif" width="16" height="16"  style="cursor:pointer;" title="View Detail" onclick="window.location=\'home.php?p=sendemaildetails&mod='.$mod.'&u='.$row_user["id"].'\';" />&nbsp; ';
			}
			$t.='
		</td>	
	</tr>';
 
	}else{
	$t .='<tr> <td colspan="10" style="color:#CC0000; font-weight:bold; text-align:center"> No Member Found  </td> </tr>';
	}

	$t .='</table>';
	
		$t.='
		<div> Page:'; 			
			
			 $numofpages =  ceil($count_item / $nritem);
			 $pageNums   =  ceil($page/10);
			// echo  $pageNums ;
			 if  (  $pageNums > 1)
			 {	//First Page  
				 $t.='<a  href="home.php?p=managesendemail&mod='.$mod.'&page=1"><b>First</b></a>&nbsp&nbsp';
			 	  
			 }else{
			 	 $t.='<b>First</b>&nbsp&nbsp';
			 
			 }
			 if ($pageNums > 1)
			 { //Previous 
				$Previouspage  = ( $pageNums -1) * 10;
				$t.='<a  href="home.php?p=managesendemail&mod='.$mod.'&page='.$Previouspage.'"><b>Previous</b></a>&nbsp&nbsp';
			 }else{
			 	$t.='<b>Previous</b>&nbsp&nbsp';
			 }
			 if  (($pageNums *10)  <= $numofpages)
			 {
			 		
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
			 	$tmpT .= '<a href="home.php?p=managesendemail&mod='.$mod.'&page='. ( $maxPageNum+1 ).'"><b>Next</b></a>&nbsp&nbsp';
			 }else{
			 	$tmpT .= '<b>Next</b>&nbsp&nbsp';
			 }

			 if  ( ($numofpages >10)  and ($numofpages >$maxPageNum) )
			 {
			 	$tmpT .= '<a  href="home.php?p=managesendemail&mod='.$mod.'&page='.$numofpages.'"><b>Last</b></a>&nbsp&nbsp';
			 }else{
			 	$tmpT .= '<b>Last</b>&nbsp&nbsp';
			 }
			 
          	 for($i = $minPageNum; $i <= $maxPageNum; $i++)
          	 {
				if($page == $i)
				{ 
					$t.='<b style="font-size:14px;">'.$i.'</b>&nbsp&nbsp';
				}else{
					$t.='<a  href="home.php?p=managesendemail&mod='.$mod.'&page='.$i.'" ><b>'.$i.'</a>&nbsp&nbsp';
				}
          	 }
			 
			  $t.=$tmpT;
			  $t.='</div>';	
		
	$t .='</td>
	</tr>
</table></form>
';
echo $t;
?>
</div>  


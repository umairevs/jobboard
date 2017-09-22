<?php
include('security.php');
include("../includes/functions/functions.php");

foreach($_POST  as $key => $value) 
{
   $$key = $value;
}

foreach($_GET as $key => $value)
{
   $$key = $value;
}
//	error_reporting(0);
	$where_condition 	= '';
	$where_rest 		= '';
	$group_by	 		= '';
	
	if($_GET['bymonth'] != ''){ 
		$where_condition 	.= " AND MONTH(o.order_date_time) = '".$_GET['bymonth']."' "; 
	}
	
	if($_GET['byyear'] != ''){ 
		$where_condition 	.= " AND YEAR(o.order_date_time) = '".$_GET['byyear']."' "; 
	}
	
	if($_GET['id'] != '' && $_GET['type'] == 'custom'){
		$where_condition 	.=  " AND o.retailer_id = '".$_GET['id']."' ";
	}
	
	if($_GET['user_id'] != ''){
		$where_condition 	.=  " AND o.user_id = '".$_GET['user_id']."' ";
	}
	
	// Get Order information
	if($_GET['type'] == 'custom'){
		
		$sql_order = "	SELECT 
							o.id, o.order_date_time, o.total_amount, o.retailer_id,  
							r.spacename, r.location_address, r.contact_number, r.contact_preference, r.contact_besttime, 
							COUNT(o.id) as total_orders, SUM(o.total_amount) as totalamount 
						FROM 
							tbl_order o, tbl_retailer r 
						WHERE 
							o.payment_status = 'done' AND r.id = '$id' $where_condition
						GROUP BY 
							o.retailer_id 
						ORDER BY 
							o.order_date_time desc ";
							
		$row_order = mysql_fetch_assoc(mysql_query($sql_order));
	
		
	}else{
		
		$sql_order = "	SELECT 
							COUNT(o.id) as total_orders, SUM(o.total_amount) as totalamount 
						FROM 
							tbl_order o 
						WHERE 
							payment_status = 'done' $where_condition
						ORDER BY 
							o.order_date_time desc ";
		$row_order = mysql_fetch_assoc(mysql_query($sql_order));
	}
	
?>
<link type="text/css" rel="stylesheet" href="css/slip.css">
<script>
function myFunction() {
    document.getElementById("printme").style.display='none';
	window.print();
}
</script>
<table cellpadding="0" cellspacing="0" border="0" align="left" class="page">
	<?php 
		include("slip/slip_header.php"); 
		
		if($_GET['type'] == 'custom'){
			include("slip/slip_user_info.php");
		}
		include("slip/slip_order_info.php"); 
		include("slip/slip_footer.php"); 
	?>	
</table>

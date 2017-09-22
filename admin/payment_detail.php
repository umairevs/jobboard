<?php
include('security.php');
include("../includes/functions/functions.php");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<head>
<title>Order Detail</title>
<link type="text/css" rel="stylesheet" href="css/style.css" />

</head>
<body style="margin:0px; background:#F7F7F7;">
<?php
if($_REQUEST['id']!='')
{
	$id = $_REQUEST['id'];
	$querycatlist = mysql_query("select 
									o.id, o.subtotal_amount, o.other_amount, o.total_amount, o.payment_method  
								from 
									tbl_order o
								where 
									 o.id = '".$id."'");			
	$row_info   =  mysql_fetch_assoc($querycatlist);
	//echo "<pre>";print_r($row_info);
	if($row_info)
	{
?>
	<table width="100%" cellpadding="3" cellspacing="0" border="0">
		<tr>
			<td colspan="4" align="left" style="font-weight:bold; color:#fff; background-color:#2973b8">Order Detail <?php echo 'JRS-'.$id;?>: </td>
		</tr>
		<tr>
			<td width="5%">&nbsp;</td>
			<td width="30%"><strong>Order Id:</strong></td>
			<td><?php echo 'JRS-'.$id;?></td>
			<td width="5%">&nbsp;</td>
		</tr>
		
		<tr>
			<td>&nbsp;</td>
			<td><strong>Payment Method:</strong></td>
			<td><?php if($row_info['payment_method'] == '1'){ echo "Escrow.com"; }else{ echo "Stripe"; }?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Subtotal:</strong></td>
			<td><?php echo $currency_symble.number_format($row_info['subtotal_amount'], 2);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Other Charges:</strong></td>
			<td><?php echo $currency_symble.number_format($row_info['other_amount'], 2);?></td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td width="5%">&nbsp;</td>
			<td><strong> Total Amount:</strong></td>
			<td><strong><?php echo $currency_symble.number_format($row_info['total_amount'], 2);?></strong></td>
			<td>&nbsp;</td>
		</tr>

		
	</table>
	
<?php
	}else{
?>
<b>No Record Found</b>
<?php
	}
}
	?>
</body>
</html>
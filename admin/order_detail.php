<?php
include('security.php');
include("../includes/functions/functions.php");

//Check access of module

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
									o.*, r.spacename, od.charge_id  
								from 
									tbl_order o, tbl_retailer r, tbl_order_payment od 
								where 
									o.retailer_id = r.id AND o.id = od.order_id AND o.id = '".$id."'");			
	$row_info   =  mysql_fetch_assoc($querycatlist);
	//echo "<pre>";print_r($row_info);
	if($row_info)
	{

?>
	<table width="100%" cellpadding="1" cellspacing="0" border="0">
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
			<td><strong>Order Tracking Code:</strong></td>
			<td><?php echo stripslashes($row_info['track_code']);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Order date:</strong></td>
			<td><?php echo stripslashes($row_info['order_date_time']);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Payment Method:</strong></td>
			<td><?php if($row_info['payment_method'] == '1'){ echo "Escrow.com"; }else{ echo "Stripe"; }?></td>
			<td>&nbsp;</td>
		</tr>
		<?php  if($row_info['payment_method'] == '1'){ ?>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Escrow Payment Status:</strong></td>
			<td><?php echo Get_Escrow_Staus($PartnerID, $escrow_userpwd, $row_info['charge_id']); ?></td>
			<td>&nbsp;</td>
		</tr>
		<?php  } ?>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Order Amount:</strong></td>
			<td><?php echo $currency_symble.number_format($row_info['total_amount'], 2);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Order Payment status:</strong></td>
			<td><?php if($row_info['payment_status'] == 'done'){ echo "Received"; }else{ echo "No"; } ?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Booking Dates:</strong></td>
			<td><?php echo date("D M j Y", strtotime($row_info['from_date'])).' <strong>To</strong> '.date("D M j Y", strtotime($row_info['to_date']));?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Booking Date/Time:</strong></td>
			<td><?php echo date("D M j Y G:i a", strtotime($row_info['order_date_time']));?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="left" style="font-weight:bold; color:#fff; background-color:#2973b8">Customer Detail:</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Customer Name:</strong></td>
			<td><?php echo stripslashes($row_info['customer_name']);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Customer Type:</strong></td>
			<td>
			<?php 
				echo stripslashes($row_info['user_type']);
				if($row_info['user_type']!='Guest')
				{
			?> 
				<img src="img/green-circle-icon.png" width="8" />
			<?php
				}	
			?>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><strong>Customer Email:</strong></td>
			<td><?php echo stripslashes($row_info['email']);?></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="left" style="font-weight:bold; color:#fff; background-color:#2973b8">Booking Detail: </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">
				<table width="100%" style="border-collapse: collapse;">
					<tr>
						<td width="50%" style="border: 1px solid #cccccc;font-weight: bold;">Retailer Space Name</td>
						<td width="25%" style="border: 1px solid #cccccc;font-weight: bold;">Booking Days</td>
						<td width="25%" style="border: 1px solid #cccccc;font-weight: bold;">Booking Amount</td>
					</tr>
			<?php

			$qry_order_items = mysql_query("SELECT * FROM tbl_order_items WHERE order_id = ".$id." ");
				
			$subtotal 	= 0;
			$order_items 	= '';
			while($row_order_items = mysql_fetch_assoc($qry_order_items))
			{
			?>
					<tr>
						<td style="border: 1px solid #cccccc;"><?php echo stripslashes($row_info['spacename'])?></td>
						<td style="border: 1px solid #cccccc;"><?php echo stripslashes($row_order_items['quantity']). ' Days';?></td>
						<td style="border: 1px solid #cccccc;"><?php echo $currency_symble.number_format($row_order_items['price'], 2)?></td>
					</tr>
			<?php				
			}
			?>
				</table>
			</td>
			<td>&nbsp;</td>
		</tr>
		
		<tr>
			<td colspan="4" align="left" style="font-weight:bold;">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align="left" style="font-weight:bold; color:#fff; background-color:#2973b8">Booking Payment Detail: </td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td colspan="2">
				<table width="50%" style="border-collapse: collapse;">
					<tr>
						<td width="20%" style="border: 1px solid #cccccc;font-weight: bold;">Subtotal</td>
						<td width="20%" style="border: 1px solid #cccccc;font-weight: bold;">Other Charges</td>
					</tr>
					<tr>
						<td style="border: 1px solid #cccccc;"><?php echo $currency_symble.number_format($row_info['subtotal_amount'], 2);?></td>
						<td style="border: 1px solid #cccccc;"><?php echo $currency_symble.number_format($row_info['other_amount'], 2);?></td>
					</tr>
				</table>
			</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
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
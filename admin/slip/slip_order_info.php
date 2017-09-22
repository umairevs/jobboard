	<tr>
		<td colspan="2"><table cellpadding="3" cellspacing="0" border="0" width="100%" align="left" class="tableborder fontsize_12" >
				<tr class="fontsize_14">
					<td width="50%" class="tdbackground">REPORT DURATION</td>
					<td width="20%" class="tdbackground">TOTAL ORDERs</td>
					<td width="35%" class="tdbackground">TOTAL ORDERS AMOUNT</td>
				</tr>
				<tr>
					<td class="paddingleft_10" align="center">
						<?php 
							if($_GET['bymonth'] != ''){ 
								echo $months[$_GET['bymonth']-1]; 
							}
							
							if($_GET['bymonth'] != '' && $_GET['byyear'] != ''){ 
								echo " - "; 
							}
							
							if($_GET['byyear'] != ''){ 
								echo $_GET['byyear']; 
							}
						?>
					</td>
					<td class="paddingleft_10"><?php echo $row_order['total_orders'];?></td>
					<td class="paddingleft_10"><?php echo $currency_symble.curr_format($row_order['totalamount']);?></td>
				</tr>
			</table></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2"><table cellpadding="3" cellspacing="0" border="0" width="100%" align="center"  class="tableborder fontsize_12 " >
				<tr class="fontsize_14">
					<td width="3%" class="tdbackground">#</td>
					<td width="10%" class="tdbackground">Order #</td>
					<td width="20%" class="tdbackground">Customer Name</td>
					<td width="25%" class="tdbackground">Booking Dates</td>
					<td width="10%" class="tdbackground">Amount</td>
					<td width="15%" class="tdbackground">Date</td>
				</tr>
				<?php
				$count = 1;
				$sql_orderdetail = mysql_query("SELECT 
													o.id, o.customer_name, o.status, o.total_amount, o.order_date_time, o.from_date, o.to_date 
												FROM 
													tbl_order o 
												WHERE 
													payment_status = 'done'  $where_condition 
												ORDER BY 
													order_date_time desc ")	;
				while($row_orderdetail=mysql_fetch_assoc($sql_orderdetail))
				{
				?>
				<tr>
					<td class="paddingleft_10"><?php echo $count;?></td>
					<td class="paddingleft_10"><?php echo 'JRS-'.$row_orderdetail['id'];?></td>
					<td class="paddingleft_10"><?php if(empty($row_orderdetail['customer_name'])){ echo "None"; }else{ echo stripslashes($row_orderdetail['customer_name']); }?></td>
					<td class="paddingleft_10"><?php echo date("M j Y", strtotime($row_orderdetail['from_date'])).' <strong>To</strong> '.date("M j Y", strtotime($row_orderdetail['to_date']));?></td>
					<td class="paddingleft_10" align="right"><?php echo $currency_symble.curr_format($row_orderdetail['total_amount']);?></td>
					<td class="paddingleft_10"><?php echo date("M j, Y", strtotime($row_orderdetail['order_date_time'])); ?></td>
				</tr>
				<?php
					$count++;
				}
				?>				
			</table></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	
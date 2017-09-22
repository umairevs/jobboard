	<tr>
		<td colspan="2"><table cellpadding="3" cellspacing="0" border="0" width="100%" align="center" class="fontsize_12"  >
				<tr>
					<td width="20%"><strong>Space Name:</strong></td>
					<td width="70%" colspan="3"><?php echo stripslashes($row_order['spacename']);?></td>
				</tr>
				<tr>
					<td><strong>Address:</strong></td>
					<td colspan="3"><?php echo stripslashes($row_order['location_address']);?></td>
				</tr>
				<tr>
					<td width="20%"><strong>Contact #:</strong></td>
					<td width="30%"><?php echo stripslashes($row_order['contact_number']);?></td>
					<td width="20%"><strong>Best Time:</strong></td>
					<td width="30%"><?php echo stripslashes($row_order['contact_preference']).' ('.stripslashes($row_order['contact_besttime']).')';?></td>
				</tr>
				
			</table></td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	
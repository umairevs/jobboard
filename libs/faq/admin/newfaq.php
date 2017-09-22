<?php 
	defined('_JEVS') or die('Restricted access'); 
	foreach($_POST  as $key => $value)
	{
	   $$key = $value;
	}
	foreach($_GET as $key => $value)
	{
	   $$key = $value;
	}
?>
	<form name="newfaq" action="home.php?mod=<?php echo $mod?>&p=faqoperations" method="post">
		<table cellpadding="2" cellspacing="0" border="0" width="100%" id="internaltable">
			 <tr>
			<td class="top-bar"><div style="float:left">FAQ</div><div style="float:right; text-align:right; width:100px;  padding-right:20px;"><label onclick="history.go(-1)" title="Click here to Back">Back</label></div> </td>
		 	 </tr>
			</tr>
			
			<?php if(isset($editid)){
				$qry=mysql_query("select * from tbl_faq where faq_id = '".$editid."'");
				$rowedit=mysql_fetch_array($qry);
				
				}
			?>
			<tr>
				<td colspan="3" align="center" width="100%">
					<table cellpadding="0" cellspacing="2" border="0" width="100%">
						
						  <?php if($_GET['questerror']!='')
						  		{ 
									$questerror=$_GET['questerror']; ?>
								<tr>
								  <td align="right" id="txtlebel" >&nbsp;</td>
								  <td id="madfield">&nbsp;</td>
								  <td align="left" class="msg"><?php echo $questerror; ?>	</td>
					  			</tr>	
						  	<?php
								 
								}
								if($_GET['anserror']!='')
						  		{ 
									$anserror=$_GET['anserror'];
						  		?>
								<tr>
								  <td align="right" id="txtlebel" >&nbsp;</td>
								  <td id="madfield">&nbsp;</td>
								  <td align="left" class="msg"><?php echo $anserror; ?>	</td>
					  			</tr>	
						  <?php }
						 ?>
						
						<tr>
							<td width="18%" align="right" id="txtlebel" >
							FAQ Question							</td>
							<td width="4%" id="madfield">
								*							</td>
							<td width="78%" align="left" >
							 <?php
							  $qvalue = ''; 
							 	
								 if(isset($_SESSION['question']))
								  {
								  	$qvalue = $_SESSION['question'];
									unset($_SESSION['question']);
								  }
								  else
								   {
								     $qvalue = stripslashes($rowedit[faq_question]);
								   }
							 
							 ?>
								<input type="text" class="txtstyle" name="question" id="question" size="40" value="<?php  echo $qvalue; unset($_SESSION['question']);?>" /></td>
						</tr>
					<!--	<tr>
						  <td align="right" id="txtlebel2" >Question Order</td>
						  <td id="madfield2">&nbsp;</td>
						  <td align="left" ><input type="text" class="txtstyle" name="qtnorder" id="qtnorder" size="5" value="<?php  echo $qvalue; unset($_SESSION['qtnorder']);?>" /></td>
					  </tr>-->
							<tr style="display:none;">
							<td width="18%" align="right" id="txtlebel" >
							FAQ Group Name							</td>
							<td width="4%" id="madfield">
								*							</td>
							<td width="78%" align="left" >
								<select name="qgroup" id="qgroup">
									<?php $querygp="select * from tbl_faq_groups";
									     $rowgp=$db->get_results($querygp,ARRAY_A);
										 if(isset($rowgp))
										 foreach($rowgp as $arrgp)
										 {
										 	if($arrgp[faqg_id]==$rowedit[faq_groupid])
											echo "<option value='$arrgp[faqg_id]' selected='selected'>$arrgp[group_title]</option>";
											else
											echo "<option value='$arrgp[faqg_id]'>$arrgp[group_title]</option>";
											
										}
									 ?>
								</select>						  </td>
						</tr>
						<tr>
							<td align="right" id="txtlebel"  >
								Status							</td>
							<td id="madfield">
								*							</td>
						  <td  align="left">
								
								<input type="checkbox" name="active" value="1" id="active" <?php if($rowedit[faq_status]==1)	{ ?> checked="checked" <?php }?> />
								<label for="checkbox" id="txtlebel" >Active</label>				</td>
						</tr>
						<tr>
							<td align="center" colspan="3" id="txtlebel" >
								Answer
								<br>
								<span class="txtstyle"  >
							<?php
								$avalue = ''; 
							 	if(isset($_SESSION['answer']))
								  {
								  	$avalue = $_SESSION['answer'];
									unset($_SESSION['answer']);
								  }
								  else
								   {
								    $avalue = $rowedit[faq_answer];
								   }
								
								
								include_once 'ckeditor/ckeditor.php';
								$content = $avalue;
								$ckeditor = new CKEditor();
								$ckeditor->basePath = '';
								$ckeditor->config['filebrowserBrowseUrl'] = '/ckfinder/ckfinder.html';
								$ckeditor->config['filebrowserImageBrowseUrl'] =	
								'ckeditor/ckfinder/ckfinder.html?type=Images';
								$ckeditor->config['filebrowserFlashBrowseUrl'] = 
								'ckeditor/ckfinder/ckfinder.html?type=Flash';
								
								$ckeditor->config['width'] = '60%';
								
								$ckeditor->editor('answer',$content);
								
						
					
								//------------------------------------------
							?>
							</span>							</td>
						</tr>
						
						<tr>
							<td colspan="3" align="center">
								<?php if(isset($editid)) {?>
								
								<input type="submit" value="Update Page"  name="updatequestion" class="txtbutton" >
									<input type="hidden" name="faqid" value="<?php echo $editid?>"   />
								<?php } else {?>
									<input type="submit" value="Add Question"  name="addquestion"  class="txtbutton" >
								<?php }?>							</td>
						</tr>
					</table>
			  </td>
			</tr>
		</table>
		<input type="hidden" name="userid" value="<?php echo $authauserid;?>" />
		</form>
	<?php 
	 unset($_SESSION['question']);
	 unset($_SESSION['answer']);
	?>
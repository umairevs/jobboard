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
<form name="newfaq" action="home.php?mod=<?php echo $mod;?>&p=faqoperations" method="post">
          <table cellpadding="2" cellspacing="0" border="0" width="100%" id="internaltable">
           <tr>
			<td class="top-bar"><div style="float:left">Add FAQ Groups</div><div style="float:right; text-align:right; width:100px;  padding-right:20px;"><label onclick="history.go(-1)" title="Click here to Back">Back</label></div></td>
		  </tr>
            <tr>
              <td colspan="3" align="center" ><h2><?php echo 	$authauseremail;?></h2></td>
            </tr>
            <tr>
              <td colspan="3" align="center" width="100%"><table cellpadding="0" cellspacing="2" border="0" width="100%">
			  
			  <?php 
			  	if(isset($editidgroup))
				{ 	
					$editidgroup = base64_decode($editidgroup);
			  	 	$qry=mysql_query("select * from tbl_faq_groups where faqg_id = '".$editidgroup."'");
					$roweditg=mysql_fetch_array($qry);	
				}
			  ?>
			  
                  <tr>
                    <td width="18%" align="right" id="txtlebel" > FAQ Group Name </td>
                    <td width="4%" id="madfield"> * </td>
					<?php 
					     $groupValue = '';
						 if(isset($editidgroup))
						  {
						     $groupValue = $roweditg['group_title'];
						  }
						  if(isset($_SESSION['groupName']))
						   {
						   	  $groupValue = $_SESSION['groupName'];
							  unset($_SESSION['groupName']); 	
						   }
					?>
                    <td width="78%" align="left" ><input type="text" class="txtstyle" name="groupname" id="groupname" size="40" value="<?php echo $groupValue; ?>"  />&nbsp;<font style="color:#FF0000; font-weight:bold;"><?php echo $grerror; ?></font>
                    </td>
                  </tr>
                  <tr>
                    <td width="18%" align="right" id="txtlebel" > Sorting Order </td>
                    <td width="4%" id="madfield"> * </td>
					<?php
						$sortValue = '';
						if(isset($editidgroup))
						  {
						 	$sortValue = $roweditg['sortorder'];
						  }
						 if(isset($_SESSION['sortOrder']))
						  {
						    $sortValue = $_SESSION['sortOrder'];
							unset($_SESSION['sortOrder']);
						  }
					
					?>
                    <td width="78%" align="left"><input type="text" size="10" class="txtstyle" name="sortingorder" id="sortingorder" value="<?php echo $sortValue; ?>"  />&nbsp;<font style="color:#FF0000; font-weight:bold;"><?php echo $sorterror; ?></font>
                    </td>
                  </tr>
                  <tr>
                    <td align="right" id="txtlebel"  > Status </td>
                    <td id="madfield"> * </td>
                    <td  align="left"><input type="checkbox" name="active" value="1" id="active" <?php if($roweditg['group_status']==1)	{ ?> checked="checked" <?php }?> />
                      <label for="checkbox" id="txtlebel" >Active</label>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" style="padding-left:190px; padding-top:20px;"><?php if(isset($editidgroup)) {?>
                      <input type="submit" value="Update Group"  name="updategroup" class="txtbutton"  >
                      <input type="hidden" name="faqgid" value="<?php echo $editidgroup?>"   />
                      <?php } else {?>
                      <input type="submit" value="Add Group"  name="addgroup"  class="txtbutton" >
                      <?php }?>
                    </td>
                  </tr>
                  
                </table></td>
            </tr>
          </table>
          <input type="hidden" name="userid" value="<?php echo $authauserid;?>" />
        </form>
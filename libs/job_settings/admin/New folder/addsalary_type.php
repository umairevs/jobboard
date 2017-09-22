<?php 

//Check access of module
include("security_module.php");

	foreach($_POST  as $key => $value)

	{

	   $$key = $value;

	}

	foreach($_GET as $key => $value)

	{

	   $$key = $value;

	}





	if(isset($editid))

	{ 	

		$action = 'Edit';
		$recipe  = get_salary_type(base64_decode($editid));
		if($recipe['salary_id']==""){

			header("location:home.php?p=salary_type&mod=job_settings");

			exit;

		

		}

	}else{
	
		$action = 'Add';
	
	}

  ?>

 <form name="frmbank" id="frmbank" enctype="multipart/form-data" method="post" action="">

          <table cellpadding="2" cellspacing="0" border="0" width="100%" id="internaltable">

           <tr>

			<td class="top-bar">
            <div style="float:left"><?php echo $action;?> Employment Type</div><div style="float:right; text-align:right; width:100px;  padding-right:20px;"><label onclick="history.go(-1)" title="Click here to Back">Back</label></div></td>

		  </tr>

            <tr>

              <td colspan="3" align="center" ><div  id="error_div" style="display:none; color:#FF0000;">&nbsp;</div></td>

            </tr>

            <tr>

              <td colspan="3" align="center" width="100%"><table cellpadding="0" cellspacing="2" border="0" width="100%">

                  <tr>

                    <td width="18%" align="right" id="txtlebel" > Title </td>

                    <td width="4%" id="madfield"> * </td>

                    <td width="78%" align="left" ><input type="text" class="txtstyle" name="salary_title" id="salary_title"  value="<?php echo utf8_decode(stripslashes($recipe['salary_title']));?>"  /></font>

                    </td>

                  </tr>
                  <tr>

                    <td align="right" id="txtlebel"  > Status </td>

                    <td id="madfield"> * </td>

                    <td  align="left"><input type="checkbox" name="status" value="1" id="status" <?php if($recipe['status']==1)	{ ?> checked="checked" <?php }?> />

                      <label for="checkbox" id="txtlebel" >Active</label>

                    </td>

                  </tr>
                


                  <tr>

                    <td colspan="3" align="left" style="padding-left:190px; padding-top:20px;"><?php if(isset($recipe['salary_id'])) {?>

                      <input type="submit" value="Update"  class="txtbutton" id="bank_button" name="bank_button" onclick="return manage_bank('7');">

                      <input type="hidden" name="salary_id" value="<?php echo $recipe['salary_id']?>"   />
                      

                      <?php } else {?>

                      <input type="submit" value="Add"  class="txtbutton" id="bank_button" name="bank_button" onclick="return manage_bank('7');">

                      <?php }?>
						<div id="loader1"></div>
                    </td>

                  </tr>

                  

                </table></td>

            </tr>

          </table>

          <input type="hidden" name="userid" value="<?php echo $authauserid;?>" />

        </form>
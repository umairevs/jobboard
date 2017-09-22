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
		$recipe  = get_state(base64_decode($editid));

		if($recipe['RegionID']==""){

		   header("location:home.php?p=statelist&mod=location");
   		   exit;

		}

	}else{
	
		$action = 'Add';
	
	}

  ?>

 <form name="frmbank" id="frmbank" enctype="multipart/form-data" method="post" action="">

          <table cellpadding="2" cellspacing="0" border="0" width="100%" id="internaltable">

           <tr>

			<td class="top-bar"><div style="float:left"><?php echo $action;?> State</div><div style="float:right; text-align:right; width:100px;  padding-right:20px;"><label onclick="history.go(-1)" title="Click here to Back">Back</label></div></td>

		  </tr>

            <tr>

              <td colspan="3" align="center" ><div  id="error_div" style="display:none; color:#FF0000;">&nbsp;</div></td>

            </tr>

            <tr>

              <td colspan="3" align="center" width="100%"><table cellpadding="0" cellspacing="2" border="0" width="100%">

			  

			 

			  

   <tr>

                    <td width="18%" align="right" id="txtlebel" > Country </td>

                    <td width="4%" id="madfield"> * </td>

                    <td width="78%" align="left" >
                    <?php
					$country_list = get_country_list();
					?>
                    <select name="CountryID" id="CountryID" class="txtstyle">
                    <?php foreach($country_list as $country) { ?>	
                    
                        <option value="<?php echo $country['CountryId'];?>" <?php if($recipe['CountryID']==$country['CountryId']){echo "selected";}?>><?php echo utf8_decode($country['Country']);?></option>
                        
                    <?php } ?>
                    </select>
                    

                    </td>

                  </tr>
                              
               
                  <tr>

                    <td width="18%" align="right" id="txtlebel" > State Name </td>

                    <td width="4%" id="madfield"> * </td>

                    <td width="78%" align="left" ><input type="text" class="txtstyle" name="Region" id="Region"  value="<?php echo stripslashes($recipe['Region']);?>"  /></font>

                    </td>

                  </tr>
                  
                  <tr>

                    <td width="18%" align="right" id="txtlebel" > State Code </td>

                    <td width="4%" id="madfield"> * </td>

                    <td width="78%" align="left" ><input type="text" class="txtstyle" name="Code" id="Code"  value="<?php echo stripslashes($recipe['Code']);?>"  /></font>

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

                    <td colspan="3" align="left" style="padding-left:190px; padding-top:20px;"><?php if(isset($recipe['RegionID'])) {?>

                      <input type="submit" value="Update"  class="txtbutton" id="bank_button" name="bank_button" onclick="return manage_bank('2');">

                      <input type="hidden" name="RegionID" value="<?php echo $recipe['RegionID']?>"   />

                      

                      <?php } else {?>

                      <input type="submit" value="Add"  class="txtbutton" id="bank_button" name="bank_button" onclick="return manage_bank('2');">

                      <?php }?>
						<div id="loader1"></div>
                    </td>

                  </tr>

                  

                </table></td>

            </tr>

          </table>

          <input type="hidden" name="userid" value="<?php echo $authauserid;?>" />

        </form>
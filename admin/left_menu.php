<div class="glossymenu"> <a class="menuitem" href="<?php echo $ruAdmin.'home.php?p=homepage' ?>" >
	<div style="padding-left:15px; width:100%;" class="color_change"> Home </div>
	</a>
	<style>
	.color_change
	{
		 color:#ffffff;
		 	
	}
</style>
<?php 
//echo "<pre>"; print_r($xmlPath_arr); exit;     
foreach($xmlPath_arr as $modulep)
{	
	$mode_array= explode('/', $modulep);
	$module= $mode_array[0];
	$xml= $homepage = @file_get_contents( $dir.$modulep);
	$xml =str_replace('&','^',$xml);
	$DataArray = xml2array($xml);		
	$topMenuTitle=str_replace('^','&',$DataArray['Config']['TopMenu']['Title']['value']); 
	$topMenlink= str_replace('^','&',$DataArray['Config']['TopMenu']['Link']['value']); 
	$subMenuArray=$DataArray['Config']['LeftMenu']['Menu'];
	 //echo "<pre>"; print_r($subMenuArray); exit;
?>
	<a href="<?php echo $ruAdmin.$topMenlink.'&mod='.$module;?>" class="menuitem <?php echo 'submenuheader'; ?>">
	<div style="padding-left:15px; width:100%;" class="color_change"><?php echo $topMenuTitle; ?></div>
	</a>
<?php
if($subMenuArray !='')
{ 
echo '<div class="submenu" ><ul>';
foreach($subMenuArray as $arrSubMenu)
{
	$leftMenuTitle=str_replace('^','&',$arrSubMenu['Title']['value']);  
	$leftMenlink= str_replace('^','&',$arrSubMenu['Link']['value']);
	if(trim($leftMenuTitle)!=''){
?>
	<li><a href="<?php echo $ruAdmin.$leftMenlink.'&mod='.$module;?>" class="color_change"><?php echo $leftMenuTitle; ?></a></li>
	<?php
			 	} // end  if
			} // end sub menu loop
				echo '</ul></div>';
				
		 } 
	 }  //end outer loop   ?>
	<a class="menuitem" href="<?php echo $ruAdmin.'home.php?p=preference' ?>" >
	<div style="padding-left:15px; width:100%;" class="color_change"> Preference </div>
	</a> <a class="menuitem" href="<?php echo $ruAdmin.'home.php?p=logout' ?>" >
	<div style="padding-left:15px; width:100%;" class="color_change"> Logout </div>
	</a> </div>

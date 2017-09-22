<?php
    $dir ="../libs/";
	
	$xmlPath_arr= array();
	$module_arr = array();
	$dh = opendir($dir);
	
	while (($file = readdir($dh)) !== false) 
	{
		if ($file != "." && $file != "..") 
		{  
		   if(@file_exists($dir.$file.'/admin/config.xml'))
		   {
			    	$module_arr[]=$file;
				    $xmlPath_arr[]=$file.'/admin/config.xml'; 
		   
		   }
			
	
		}          
	}
	//echo "<pre>";print_r($xmlPath_arr);exit;
	closedir($dh);
?>

<div class="header-bg1">
	<div class="logodiv"><img src="img/logo1.png" style="margin-top:0px; margin-left:10px; " width="200" /><br/>
	</div>
	<div class="admin_container">
		<h1> <span>Admin</span> Control Panel</h1>
	</div>
	<div class="headertxt"> <a style="padding:10px;color:#1184D2; font-weight:bold;font-size:12px;
			font-family:Arial;"  href="<?php echo "logout.php" ?>" > (Logout) </a> </div>
</div>
<div class="header-bg9" >
	<div id="tabs" class="topnav"   >
		<ul>
			<li><a href="<?php echo $ruAdmin;?>"><span>Home</span></a></li>
			<?php
			$index=0;
	    	 foreach($xmlPath_arr as $modulep)
			 {	
			        $mode_array= explode('/', $modulep);
			        $module= $mode_array[0];
					$xml= $homepage = @file_get_contents( $dir.$modulep);
					$xml =str_replace('&','^',$xml);
					$DataArray = xml2array($xml);		
					$topMenuTitle=$DataArray['Config']['TopMenu']['Title']['value']; 
					$topMenlink= $DataArray['Config']['TopMenu']['Link']['value']; 
					$topMenuTitle=str_replace('^','&',$topMenuTitle);    
					$topMenlink=str_replace('^','&',$topMenlink);		
				    $topTab=$DataArray['Config']['TopTab']['Title']['value']; 
					
					if($topTab=='yes')
					{
		 	 ?>
			<li > <a href="<?php echo $ruAdmin.$topMenlink.'&mod='.$module;?>&submenuheader=<?php echo $index;?>"><span><?php echo $topMenuTitle; ?></span></a></li>
			<?php  }
			   
			   $index++; 
			   
			   } ?>
		</ul>
	</div>
</div>

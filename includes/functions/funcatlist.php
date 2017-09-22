<?php
 function addcategorylist2($id,$sel=0)
 { 
    global $cat_arr;
    global $filter;
	global $db;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='&nbsp;';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
				//$value_opt = $rowsubopt[category_id].",".$rowsubopt[category_level];
				$value_opt = $rowsubopt[category_id];
				if(in_array($rowsubopt[category_id],$cat_arr))
				{
					$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				else
				{
					$opt.="<option value='$value_opt' onclick='document.catlist.submit()' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				 $opt.=addcategorylist($rowsubopt[category_id]);
			   
		}
	
		
	}
	
	return $opt;
 
 }
 function addcategorylist($id,$sel=0)
 {
    global $filter;
	global $db;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='&nbsp;';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
				$value_opt = $rowsubopt[category_id].",".$rowsubopt[category_level];
				if($rowsubopt[category_id]==$filter)
				{
					$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				else
				{
					$opt.="<option value='$value_opt' onclick='document.catlist.submit()' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				 $opt.=addcategorylist($rowsubopt[category_id]);
			   
		}
	
		
	}
	
	return $opt;
 
 }
  //**********************************************************************************************
  function categorylist($id,$sel=0)
 {
    global $filter;
	global $db;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}

				if($rowsubopt[category_id]==$filter)
				{
					$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				else
				{
					$opt.="<option value='$rowsubopt[category_id]' onclick='document.catlist.submit()' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				 $opt.=categorylist($rowsubopt[category_id]);
			   
		}
	
		
	}
	
	return $opt;
 
 }
 //**********************************************************************************************
 function categorylistmove($id)
 {
 
	global $filter;	
	global $db;
	$querychkm="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchkm=$db->get_row($querychkm,ARRAY_A);
	if($rowchkm[COUNT]>=1)
	{
		
	    $querygetoptm="select * from tbl_categories where parent_id=".$id;
		$arrsuboptm=$db->get_results($querygetoptm,ARRAY_A)	;
	    if(isset($arrsuboptm))
		foreach($arrsuboptm as $rowsuboptm)
		{
			$count=$rowsuboptm[category_level]*3;
			$space=' ';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
			if($rowsuboptm[category_id]==$filter)
			{	
		    	$optm.="<option value='$rowsuboptm[category_id]' selected='selected'  >".$space." ".$rowsuboptm[category_name]."</option>";
			}
			else
			{
				$optm.="<option value='$rowsuboptm[category_id]'  >".$space."   ".$rowsuboptm[category_name]."</option>";
			}
		    $optm.=categorylistmove($rowsuboptm[category_id]);
			   
		}
	
		
	}
	
	return $optm;
 
 }
 //************************************************function update category level
 function updatecatlevel($id)
{
	global $db;
	$querypcat="select * from tbl_categories where category_id=".$id;
	$rowpcat=$db->get_row($querypcat,ARRAY_A);
	$levelchild=$rowpcat[category_level]+1;
	//******************************************
	$querychkparent="select count(*) as COUNTC from tbl_categories where parent_id=".$id;
	$rowchkparent=$db->get_row($querychkparent,ARRAY_A);
	if($rowchkparent[COUNTC]>=1){
		$querypupdate="update tbl_categories set category_level=$levelchild where parent_id=".$id;
		$db->query($querypupdate);
	}
	//****************************************************
	$queryselcat="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowselcat=$db->get_row($queryselcat,ARRAY_A);
	if($rowselcat[COUNT]>=1)
	{
	  	$queryselect="select * from tbl_categories where parent_id=".$id;
		$arrpupdate=$db->get_results($queryselect,ARRAY_A);
		if(isset($arrpupdate))
		foreach($arrpupdate as $rowpupdate)
		{
			updatecatlevel($rowpupdate[category_id]);
		}
	}
	
}
//*********************************************category list upto two level********************************
function categorylisttow($id,$counter=1)
 {
 
	global $filter;
	global $db;
	$counter++;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
			   if($counter<3)
			   {
					if($rowsubopt[category_id]==$filter)
					{
						$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
						
					}
					else
					{
						$opt.="<option value='$rowsubopt[category_id]'>".$space." ".$rowsubopt[category_name]."</option>";
						
					}
					 $opt.=categorylisttow($rowsubopt[category_id],$counter);
				}
				
			   
		}
	
		
	}
	
	return $opt;
 
 }
 
 //**********************************************mercaht categores clicks**********************
  function merchantcatelist($id,$sel=0)
 {
 
	global $filter;
	global $db;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
			
				if($rowsubopt[category_id]==$filter)
				{
					$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				else
				{
					$opt.="<option value='$rowsubopt[category_id]'  >".$space." ".$rowsubopt[category_name]."</option>";
					
				}
				 $opt.=merchantcatelist($rowsubopt[category_id]);
			   
		}
	
		
	}
	
	return $opt;
 
 }
 //*********************************************category list upto htree level********************************
function categorylistthree($id,$counter=1)
 {
 
	global $filter;
	global $db;
	$counter++;
	$querychk="select count(*) as COUNT from tbl_categories where parent_id=".$id;
	$rowchk=$db->get_row($querychk,ARRAY_A);
	if($rowchk[COUNT]>=1)
	{
		
		$querygetopt="select * from tbl_categories where parent_id=".$id;
		$arrsubopt=$db->get_results($querygetopt,ARRAY_A)	;
	    if(isset($arrsubopt))
		foreach($arrsubopt as $rowsubopt)
		{
			$count=$rowsubopt[category_level]*3;
			$space='';
			for($x=0;$x<$count;$x++)
			{
				$space.='&nbsp;';
			}
			   if($counter<4)
			   {
					if($rowsubopt[category_id]==$filter)
					{
						$opt.="<option value='$rowsubopt[category_id]'  selected='selected' >".$space." ".$rowsubopt[category_name]."</option>";
						
					}
					else
					{
						$opt.="<option value='$rowsubopt[category_id]'>".$space." ".$rowsubopt[category_name]."</option>";
						
					}
					 $opt.=categorylistthree($rowsubopt[category_id],$counter);
				}
				
			   
		}
	
		
	}
	
	return $opt;
 
 }
 ?>
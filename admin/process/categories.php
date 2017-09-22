<?php
$case = 1;
$error_str = "<ul>";



if($category_name== '')
{
	$error_str .= "<li>Title is required</li>";
	$case = 0;
}

$error_str .= "</ul>";

if($_FILES["category_image"]['name']!="")
{
	
	$filename = $_FILES["category_image"]['name'];
	$path = "../media/category/";
	$TmpExt   = strtolower(substr($filename, strrpos($filename, '.')+1));
	$ext = array('jpg','png','gif','jpeg','JPEG','PNG','GIF','JPG');
	if(!in_array($TmpExt,$ext))
	{
		$error_str .= "<li>JPG, GIF, PNG picture format only\n</li>";
		$case = 0;
	}else{
		$upload = 1;
	}

}

if($case==0){
	echo $error_str; 
}else{
	
	if($status==""){
		$status = 0;
	}

	if($category_id==""){

		$sortorder = get_sortorder_subcat('tbl_categories',$filter);
		$db->query("insert into tbl_categories set category_name = '".addslashes($category_name)."', active_status = '".$status."', sortorder='".$sortorder."', parent_id = '$filter'");
		$category_id = mysql_insert_id();
		
	}else{
		$db->query("update tbl_categories set category_name = '".addslashes($category_name)."', active_status = '".$status."' where category_id='".$category_id."'");    // remove parent_id= '$filter'
	}

	  if($upload==1){       // remove  && $filter==0  for if($upload==1 && $filter==0)
		
		$ext = array('jpg','png','gif','jpeg','JPEG','PNG','GIF','JPG');
		$upload = new upload('category_image', '../media/category', '777', $ext);
		
		$uploadfilename=addslashes($upload->filename);
		$simpleImage = new SimpleImage();
		$simpleImage->load('../media/category/'.$upload->filename); 
		$simpleImage->resizeToWidth(100);

		$simpleImage->save('../media/category/thumbs/'.$upload->filename);	
	
		$db->query("update tbl_categories set category_image = '".addslashes($uploadfilename)."' where category_id = '".$category_id."'");
		if($oldfile!=""){

			@unlink("../media/category/$oldfile");
			@unlink("../media/category/thumbs/$oldfile");
		}
	}
	
	
	$_SESSION['msg'] = 'Request Processed Successfully.';			
	
	
	if($filter!='')
	{
		echo "done-SEPARATOR-home.php?p=categorylist&mod=job_settings&parent=$filter";	
	}
	else
	{
		echo "done-SEPARATOR-home.php?p=categorylist&mod=job_settings";	
	}		
	
}


?>

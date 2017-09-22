<?php
error_reporting(0);
include("../common/top.php");
include("../common/functions.php");

if($_REQUEST['type_id']!='')
{
$list_category  =  get_job_main_categories($_REQUEST['type_id']);
}
?>
<select class="form-control" onchange="get_category(this)" name="job_subcategory" id="job_subcategory" style="width:100%;">
<option value="">Select Sub Category</option>
 <?php
     
    $n=1; 
    if($list_category)
    {
        
        foreach($list_category as $row_cat)
        {
            ?>
             <option value="<?php echo stripslashes($row_cat['category_id']);?>"><?php echo stripslashes($row_cat['category_name']);?></option>
            <?php
        }
    }	
    ?>
   
</select>
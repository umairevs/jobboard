<?php 
	defined('_JEVS') or die('Restricted access');
	if (isset ( $_REQUEST['a']) )
	{
		$temid = $_REQUEST['id']; 
		$qry = "delete from `tbl_articles` where id='".$temid."'";
		$myqry=mysql_query($qry);
	
		$qry2 = "select * from tbl_articles where parent = '".$temid."'";
		$res2 = mysql_query($qry2);
		$num2 = mysql_num_rows($res2);
		if($num2 > 0){
		while($row2 = mysql_fetch_array($res2)){
			$qry3 = "delete from `tbl_articles` where id='".$row2['id']."'";
			$myqry3 = mysql_query($qry3);
		}
		}
		
		if ($myqry)
		{
		 $_SESSION['msg'] = "Article Deleted Successfully";
		 }
}
	header("location:home.php?mod=$mod&p=articles");exit; 
	
	
?>
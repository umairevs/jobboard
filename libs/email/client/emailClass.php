<?php
class emailClass
{
    // property declaration
    public $var = 'a default value';
    public $tempRow = '';	
    public function emailClass($type) 
	{
         $sqlEmail=mysql_query("select * from tbl_emails where type like '".$type."'");
		 if(mysql_num_rows($sqlEmail) > 0)
		 {
		 	$rowEmail=mysql_fetch_array($sqlEmail);
			$this->tempRow = $rowEmail; 
		 }else{
		     $this->row = 'No Email temp found';
		 }
    }
	 public function getEmailTemp() 
	{
		return $this->tempRow; 
		 
    }
	
	
	
}


?>
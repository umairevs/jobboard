<?php
	if(isset($_REQUEST['submitb']))
	{
		$error = ''; 
		$allowedExts = array(
		  "pdf", 
		  "doc", 
		  "docx"
		); 
		
		$allowedMimeTypes = array( 
		  'application/msword',
		  'text/pdf',
		  'image/gif',
		  'image/jpeg',
		  'image/png'
		);
		
		if($_FILES["cv_info"]["name"]=='')
		{
			$error .= "Please upload file <br>";
		}
		else
		{
		$extension = end(explode(".", $_FILES["cv_info"]["name"]));
		
		
		if ( ! ( in_array($extension, $allowedExts ) ) ) {
		  $error .= "Please provide document or pdf file. <br>";
		}
		
		if ( in_array( $_FILES["cv_info"]["type"], $allowedMimeTypes ) ) 
		{      
		 move_uploaded_file($_FILES["cv_info"]["tmp_name"], "resumes/" . $_FILES["cv_info"]["name"]); 
		}
		else
		{
			$error .= "Please provide another file type . <br>";
		}
		}
	}
	
	if($error!='')
	{
		?>
        
        <div style="color:red;"><?php echo $error;?></div>
        <?php
	}
?><form method="post" action="" enctype="multipart/form-data">
	Upload File: <input type="file" name="cv_info" />
    
    <input type="submit" name="submitb" value="Submit" />
</form>


<?php

exit;
$filename = "Professional_CV_Letter.doc";  //File that resides on your server
$byteArr = file_get_contents($filename); //This actually reads the content as a string but is automatically converted to a byte array for the web service
$key = "e70d3452-3365-e711-9104-00155d692ee1";
$password = "pass1234";

$atservices_wsdl = "http://www.cvparseapi.com/cvparseapi.asmx?WSDL";

echo $filename . "<br />";
 
try {
  $atservices_client = new SoapClient($atservices_wsdl);

  //The names f, fileName, YourKey, Password must match exactly what the service expects (this is case sensitive)
  $args = array('f' => $byteArr,
  'fileName' => $filename,
  'YourKey' => $key,
  'Password' => $password
  );

  $myXMLData = $atservices_client->ParseResumeNTG($args);
  $xml=simplexml_load_string($myXMLData->ParseResumeNTGResult);
  
  foreach($xml->Resume[0]->children() as $child) {
    echo $child->getName() . ": " . $child . "<br />";
  }
} catch (Exception $e) {
  echo 'Caught exception: ',  $e->getMessage(), "\n";
}

?> 
<?php
$currency_symbol = "$";
function log_it($str){return mysql_query("INSERT INTO tbl_logs SET message='$str'");}
function log_json($str){return log_it(json_encode($str));}
function is_record_exists($table_name,$value,$table_field_name='id')
{
	$value=addslashes($value);
	$sql="SELECT $table_field_name FROM $table_name WHERE $table_field_name='$value'";
	$resultset=mysql_query($sql);
	return (mysql_num_rows($resultset)==0)?false:true;
}
function get_default_currency_symbol()
{
	global $mosConfig_currency;
	return $mosConfig_currency;
}
function exchange_currency($amount,$exchange_rate)
{
	return (floatval($amount) * floatval($exchange_rate));
}

function retailer_order_count($rid)
{
	$query_orders = "select id from tbl_order where retailer_id  = '$rid'";	
	$result_order = mysql_query($query_orders);
	$row_order = mysql_num_rows($result_order);
	
	return $row_order;
}

function user_order_count($rid)
{
	$query_orders = "select id from tbl_order where user_id  = '$rid'";	
	$result_order = mysql_query($query_orders);
	$row_order = mysql_num_rows($result_order);
	
	return $row_order;
}


function payment_history_count($rid)
{
	$query_orders = "select id from tbl_retailer_payemnt where retailer_id  = '$rid'";	
	$result_order = mysql_query($query_orders);
	$row_order = mysql_num_rows($result_order);
	
	return $row_order;
}

function get_retailer_info($rid)
{
	$query_orders = "select * from tbl_retailer_payemnt where retailer_id  = '$rid'";	
	$result_order = mysql_query($query_orders);
	$row_order = mysql_fetch_assoc($result_order);
	
	return $row_order;
}

function get_seeker_info($id)
{
	 $query_orders = "select * from tbl_seeker where user_id  = '$id'";	
	$result_order = mysql_query($query_orders);
	$row_order = mysql_num_rows($result_order);
	
	return $row_order;
}

//=== Emails Related Functions ====
function send_email($email,$type='signup')
{
	$query_email = "select * from tbl_emails where type = '$type'";	
	$result_email = mysql_query($query_email);
	$row_email = mysql_fetch_array($result_email);
	
	// fetching admin credentials //
	$qry_adm = "select * from tbl_admin where Id = '1'";
	$res_adm = mysql_query($qry_adm);
	$row_adm = mysql_fetch_array($res_adm);
	
	// fetching admin credentials //
	$htmlbody = "<html><head><title></title></head><body>" .stripslashes(nl2br($row_email['body'])) . "</body></html>";
	$body = str_replace('{{FirstName}}' ,  $forgetUser['fname']  , $htmlbody);
	/*$body = str_replace('{{password}}' ,  $newpassword , $body );*/
	$body = str_replace('{{ActivationLink}}' ,  $dropboxURL ,$body );	
	  
	 // echo $body; exit;
	  sendMail_Notic($row_email['touser'], $row_email['adminname'], $email, $forgetUser['full_name'], stripslashes($row_email['subject']), $body);
}
function send_order_email($email,$firstname,$lastname)
{	
	global $ru;
	$order_url=$ru.'order_list';
	$order_link='<a href="'.$order_url.'">Orders list</a>';
	$query_email = "select * from tbl_emails where type = 'ordersubmission'";	
	$result_email = mysql_query($query_email);
	$row_email = mysql_fetch_array($result_email);
	
	// fetching admin credentials //
	$qry_adm = "select * from tbl_admin where Id = '1'";
	$res_adm = mysql_query($qry_adm);
	$row_adm = mysql_fetch_array($res_adm);
	
	// fetching admin credentials //
	$htmlbody = "<html><head><title></title></head><body>" .stripslashes(nl2br($row_email['body'])) . "</body></html>";
	$body = str_replace('{{FirstName}}' ,  $firstname  , $htmlbody);
	$body = str_replace('{{LastName}}' ,  $lastname  , $body);
	$body = str_replace('{{OrderUrl}}' ,  $order_url  , $body);
	$body = str_replace('{{OrdersLink}}' ,  $order_link  , $body);
	
	/*$body = str_replace('{{password}}' ,  $newpassword , $body );*/
	
	//--debuging--
				/*$temp=array('touser' => $row_email['touser'],'adminname' => $row_email['adminname'],'email' => $email,'fname' => $firstname,'subject' => $row_email['subject'],'body' => $body);
				//log_json($temp);
				echo '<pre>';print_r($_SESSION['bayzones']);print_r($temp);echo '</pre>';exit;*/
	//--debuging end--
	  
	 // echo $body; exit;
	  sendMail_Notic($row_email['touser'], $row_email['adminname'], $email, $firstname, stripslashes($row_email['subject']), $body);
	  
	 //===== Email to admin =======
	 $admin_mail_body="<p>New Order has been received by $firstname $lastname. ($email) </p>";
	 sendMail_Notic($row_email['touser'], $row_email['adminname'], $qry_adm['email'], $firstname, 'New Order received', $admin_mail_body);
}
function send_registration_success_email($user_id)
{
	global $ru;	
	$login_link='<a href="'.$ru.'login">Click here to login</a>';
	$query_email = "select * from tbl_emails where type = 'registrationcomplete'";	
	$result_email = mysql_query($query_email);
	$row_email = mysql_fetch_array($result_email);
	
	// fetching user data //
	$sql = "select * from tbl_artist where id = '".intval($user_id)."'";
	$res = mysql_query($sql);
	$row = mysql_fetch_object($res);
	$fname= $row->fname;
	$lname= $row->lname;
	// fetching admin credentials //
	$htmlbody = "<html><head><title></title></head><body>" .stripslashes(nl2br($row_email['body'])) . "</body></html>";
	$body = str_replace('{{FirstName}}' , $fname  , $htmlbody);
	$body = str_replace('{{LastName}}' ,  $lname  , $body);
	$body = str_replace('{{LoginLink}}' ,  $login_link  , $body);
	//--debuging--
/*	$temp=array('touser' => $row_email['touser'],'adminname' => $row_email['adminname'],'email' => $row->email,'fname' => $row->fname,'subject' => $row_email['subject'],'body' => $body);
				
	$_SESSION['bayzones']['registration_success_email_data']['emaildata']=$temp;
	$_SESSION['bayzones']['registration_success_email_data']['userdata']=$row;
	$_SESSION['bayzones']['registration_success_email_data']['users']="$fname  $lname";
	if(isset($_SESSION['bayzones']['registration_success_email_calls']))
	{
		$_SESSION['bayzones']['registration_success_email_calls']=intval($_SESSION['bayzones']['registration_success_email_calls']) + 1;
	}
	else
	{
		$_SESSION['bayzones']['registration_success_email_calls']=1;
		
	}*/		
	//--debuging end--	
	sendMail_Notic($row_email['touser'], $row_email['adminname'], $row->email, $row->fname, stripslashes($row_email['subject']), $body);
}
function validate_phone_hardcoded($string)
{
	$first_two_chars=substr($string, 0, 2);
	if($first_two_chars=='07' or $first_two_chars=='08')
	{
		return validate_phone($string);
	}
	return false;
}

function validate_phone_start($string)
{
	if(  is_numeric($string) )
	{
		return true;
	}else{
		return false;
	}
}

function validate_phone($string,$max_length='10') 
{
    if (preg_match('/^0\d{'.$max_length.'}$/', $string) ) 
	//if(preg_match('/^\+27[0-9]{9}$/',$string))
	//if(preg_match('/^\07[0-9]{9}$/',$string))	
	{
	  return true;
	} else {
		return false;
	}
}
//------------------------------------------------------------------------------------
            // XML to ARRAY Function
//------------------------------------------------------------------------------------

function xml2array($contents, $get_attributes=1)
{
    if(!$contents) return array();
    if(!function_exists('xml_parser_create'))
    {
        //print "'xml_parser_create()' function not found!";
        return array();
    }
    //Get the XML parser of PHP - PHP must have this module for the parser to work
    $parser = xml_parser_create();
    xml_parser_set_option( $parser, XML_OPTION_CASE_FOLDING, 0 );
    xml_parser_set_option( $parser, XML_OPTION_SKIP_WHITE, 1 );
    xml_parse_into_struct( $parser, $contents, $xml_values );
    xml_parser_free( $parser );
   
    if(!$xml_values) return;//Hmm...
   
    //Initializations 
    $xml_array = array();
    $parents = array();
    $opened_tags = array();
    $arr = array();
   
    $current = &$xml_array;
   
    //Go through the tags.
    foreach($xml_values as $data)
    {
        unset($attributes,$value);//Remove existing values, or there will be trouble
        extract($data);//We could use the array by itself, but this cooler.
   
        $result = '';
        if($get_attributes)
        {//The second argument of the function decides this.
            $result = array();
            if(isset($value)) $result['value'] = $value;
   
            //Set the attributes too.
            if(isset($attributes))
            {
                foreach($attributes as $attr => $val)
                {
                    if($get_attributes == 1) $result['attr'][$attr] = $val; //Set all the attributes in a array called 'attr'
                    /**  :TODO: should we change the key name to '_attr'? Someone may use the tagname 'attr'. Same goes for 'value' too */
                }
            }
        }
        elseif(isset($value))
        {
       
            $result = $value;           
        }
   
        // See tag status and do the needed.
       
        if($type == "open")
        {    //The starting of the tag ''
            $parent[$level-1] = &$current;
   
            if(!is_array($current) or (!in_array($tag, array_keys($current))))
            { //Insert New tag
                $current[$tag] = $result;
                $current = &$current[$tag];
   
            }
            else
            { //There was another element with the same tag name
                if(isset($current[$tag][0]))
                {
                    array_push($current[$tag], $result);
                }
                else
                {
                    $current[$tag] = array($current[$tag],$result);
                }
                $last = count($current[$tag]) - 1;
                $current = &$current[$tag][$last];
            }
   
        } elseif($type == "complete")
        { //Tags that ends in 1 line ''
            //See if the key is already taken.
            if(!isset($current[$tag]))
            { //New Key
                $current[$tag] = $result;
   
            }
            else
            { //If taken, put all things inside a list(array)
                if((is_array($current[$tag]) and $get_attributes == 0)//If it is already an array...
                        or (isset($current[$tag][0]) and is_array($current[$tag][0]) and $get_attributes == 1))
                {
                    array_push($current[$tag],$result); // ...push the new element into that array.
                }
                else
                { //If it is not an array...
                    $current[$tag] = array($current[$tag],$result); //...Make it an array using using the existing value and the new value
                }
            }
   
        }
        elseif($type == 'close')
        { //End of tag ''
            $current = &$parent[$level-1];
        }
    }
   
    return($xml_array);
}
  	
//------------------------------------------------------------------------------------
            //  Functions Create Table if does not Exist
//------------------------------------------------------------------------------------

function createTable($strs)
{
         if($strs=='faq')
		 {
			$sqlTblFaq=" CREATE TABLE IF NOT EXISTS `tbl_faq` (
			`faq_id` bigint(20) NOT NULL AUTO_INCREMENT,
			`faq_question` text,
			`faq_answer` longblob,
			`faq_status` int(1) DEFAULT '0',
			`faq_groupid` bigint(20) DEFAULT NULL,
			PRIMARY KEY (`faq_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 "; 
			$tblRes=mysql_query($sqlTblFaq);
			
			$sqlTblFaqGrp="CREATE TABLE IF NOT EXISTS `tbl_faq_groups` (
			`faqg_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			`group_title` tinytext,
			`sortorder` int(11) DEFAULT NULL,
			`group_status` int(1) DEFAULT '0',
			PRIMARY KEY (`faqg_id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1";
			$tblResGrp=mysql_query($sqlTblFaqGrp);
          }
		   
		 if($strs=='cms')
		 {
		   
			$sqlCreateTable="CREATE TABLE IF NOT EXISTS `tbl_cms` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `type` varchar(255) NOT NULL,
				  `title` varchar(255) CHARACTER SET utf8 NOT NULL,
				  `content` longtext CHARACTER SET utf8 NOT NULL,
				  PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1";
				 
				if(@mysql_query($sqlCreateTable))
				 {
				 	$selectQuery= mysql_query("SELECT COUNT(*) as count from tbl_cms") or die(mysql_error());
				 	$rowCount = mysql_fetch_array($selectQuery);
				 	$rowCount =  $rowCount['count'];	
					if($rowCount == 0)
					 {
					 	mysql_query("INSERT INTO `tbl_cms` (`id`, `type`, `title`, `content`) VALUES
						(1, 'aboutus', 'About Us', '<p>About Us Page Description...</p>')") or die(mysql_error());
					 
					 }				 
				 
				 }	
         }
		 //end cms table
		if($strs=='meta')
		 { 
			$metatbl=  "CREATE TABLE IF NOT EXISTS `tbl_metaInfo` (
			  `logo_id` int(5) NOT NULL AUTO_INCREMENT,
			  `logoname` varchar(155) NOT NULL,
			  `header_desc` text CHARACTER SET utf8 NOT NULL,
			  `meta_tags` longtext NOT NULL,
			  `meta_discription` longtext NOT NULL,
			  `website_title` varchar(50) NOT NULL,
			  PRIMARY KEY (`logo_id`)
			 ) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1";
			if(mysql_query($metatbl))
			{
				
			  @mysql_query("INSERT INTO `tbl_metaInfo` (`logo_id`, `logoname`, `header_desc`, `meta_tags`, `meta_discription`, `website_title`) 
			  VALUES(1, 'safari(1).png', 'Your site header Discription .', 'Your site Meta Tag ,', 'Your site Meta Discription ,', 'your site  title')");
			
			}
			 	 
			 
		 }
		if($strs=='admin')
		 { 
				$admintbl= "CREATE TABLE IF NOT EXISTS `tbl_admin` (
				`Id` int(6) unsigned NOT NULL AUTO_INCREMENT,
				`fname` varchar(255) DEFAULT NULL,
				`lname` varchar(100) DEFAULT NULL,
				`pass` varchar(100) DEFAULT NULL,
				`type` varchar(100) DEFAULT NULL,
				`email` varchar(255) DEFAULT NULL,
				`name` varchar(255) DEFAULT NULL,
				`papal_id` varchar(50) NOT NULL,
				PRIMARY KEY (`Id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ";
				
				if(mysql_query($admintbl))
				{
				 $selectQuery= mysql_query("SELECT COUNT(Id) as count from tbl_admin") or die(mysql_error());
				 $rowCount = mysql_fetch_array($selectQuery);
				 $rowCount =  $rowCount['count'];
				 if($rowCount == 0)
				 	{
					@mysql_query("INSERT INTO `tbl_admin` (`Id`, `fname`, `lname`, `pass`, `type`, `email`, `name`, `papal_id`) VALUES
					(1, 'Muhammad', 'Moeez', '123456', 'admin', 'moeez@evsoft.pk', 'admin', 'moeez_1194329580_biz@evsoft.pk ')");
					}
				
				}
		 
          }


		 
		 
		if($strs=='emailTemp')
		 { 
		
			$emailTemp= "CREATE TABLE IF NOT EXISTS `tbl_emails` (
			`type` varchar(255) NOT NULL,
			`adminname` varchar(255) NOT NULL,
			`touser` varchar(255) NOT NULL,
			`toadmin` varchar(255) NOT NULL,
			`subject` varchar(255) NOT NULL,
			`body` longblob NOT NULL,
			PRIMARY KEY (`type`)
			) ENGINE=MyISAM DEFAULT CHARSET=latin1";
           if(mysql_query($emailTemp))
				{
				 $selectQuery= mysql_query("SELECT COUNT(*) as count from tbl_emails") or die(mysql_error());
				 $rowCount = mysql_fetch_array($selectQuery);
				 $rowCount =  $rowCount['count'];
				 if($rowCount == 0)
				 	{
				@mysql_query("INSERT INTO `tbl_emails` (`type`, `adminname`, `touser`, `toadmin`, `subject`, `body`) VALUES
('contactus', 'Support', '', 'mushtaq@evsoft.pk', 'Contact Us', 0x596f7572207465787420676f657320686572650d0a0d0a5468616e6b732c0d0a0d0a5465616d206162632050726f6a656374),
('signup', 'Support', 'mushtaq@evsoft.pk', 'mushtaq@evsoft.pk', 'Welcome to abc.com Registertion', 0x796f75207465787420676f657320686572650d0a0d0a5468616e6b732c0d0a70726f6a656374205465616d),
('forgetpassword', 'ProjectSupport', 'mushtaq@evsoft.pk', 'mushtaq@evsoft.pk', 'Forgot Password Reminder', 0x4465617220207b7b46697273744e616d657d7d207b7b4c6173744e616d657d7d2c0d0a596f7572207465787420676f657320686572652e2e2e0d0a0d0a7468616e6b73200d0a0d0a6162632050726f6a656374205465616d),
('changepassword', 'Project Support', 'mushtaq@evsoft.pk', 'mushtaq@evsoft.pk', 'Change Password', 0x44656172207b7b46697273744e616d657d7d207b7b4c6173744e616d657d7d2c0d0a0d0a596f7572207465787420676f657320686572652e2e2e0d0a5468616e6b732c0d0a0d0a5465616d206162632050726f6a656374)");
					
					}				
				
				} 
		 
		  } 
			
		if($strs=='news')
		 { 
			$newstbl= mysql_query(" CREATE TABLE IF NOT EXISTS `tbl_news` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`newstitle` varchar(255) NOT NULL,
			`newslink` varchar(255) NOT NULL,
			`newsdate` date NOT NULL,
			`discription` longtext CHARACTER SET utf8 NOT NULL,
			`status` int(11) NOT NULL,
			`meta_title` varchar(255) NOT NULL,
			`meta_keywords` varchar(255) NOT NULL,
			`meta_disc` mediumtext NOT NULL,
			`newsimagealt` varchar(255) NOT NULL,
			`newsimage` varchar(255) NOT NULL DEFAULT 'default.jpg',
			`add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1");
		 
		 }	
		
		//CREATE SEO TABLE
		if($strs == 'seo')
		 {
			$seoTbl = mysql_query("CREATE TABLE IF NOT EXISTS `tbl_seo` (
			`id` int(11) NOT NULL AUTO_INCREMENT,
			`page_name` varchar(255) NOT NULL,
			`page_title` varchar(255) NOT NULL,
			`page_keywords` varchar(255) NOT NULL,
			`page_description` varchar(255) NOT NULL,
			`status` int(2) NOT NULL DEFAULT '1',
			`add_date` date NOT NULL,
			PRIMARY KEY (`id`)
			) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1");
			
		 
		 }			
	
	
	
		if($strs=='events')
		 { 
				$newstbl= mysql_query(" CREATE TABLE IF NOT EXISTS `tbl_news` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`newstitle` varchar(255) NOT NULL,
				`newslink` varchar(255) NOT NULL,
				`newsdate` date NOT NULL,
				`discription` longtext CHARACTER SET utf8 NOT NULL,
				`status` int(11) NOT NULL,
				`meta_title` varchar(255) NOT NULL,
				`meta_keywords` varchar(255) NOT NULL,
				`meta_disc` mediumtext NOT NULL,
				`newsimagealt` varchar(255) NOT NULL,
				`newsimage` varchar(255) NOT NULL DEFAULT 'default.jpg',
				`add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`)
				) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ");
		 
		 }		
		 
		//CREATE USER, COUNTRY, STATE, CITY, ZIP TABLES	 
		if($strs == 'user')
		 {
		 		//CREATE USER TABLE
		 	 	$userTblQuery = mysql_query("CREATE TABLE IF NOT EXISTS `tbl_artist` (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `fname` varchar(255) NOT NULL,
					  `lname` varchar(255) NOT NULL,
					  `full_name` varchar(255) NOT NULL,
					  `phone` varchar(50) NOT NULL,
					  `sphone` varchar(50) NOT NULL,
					  `location` varchar(255) DEFAULT NULL,
					  `country` varchar(255) NOT NULL,
					  `state` varchar(50) NOT NULL,
					  `city` varchar(50) NOT NULL,
					  `address` varchar(50) NOT NULL,
					  `about_me` varchar(255) NOT NULL,
					  `image` varchar(100) NOT NULL DEFAULT 'default.gif',
					  `email` varchar(255) NOT NULL,
					  `gender` varchar(20) NOT NULL,
					  `password` varchar(255) NOT NULL,
					  `zipcode` varchar(50) NOT NULL,
					  `agree` varchar(10) NOT NULL DEFAULT 'yes',
					  `status` varchar(10) NOT NULL,
					  `payment` varchar(1) NOT NULL,
					  `dob` varchar(55) NOT NULL,
					  `remote_ip_address` varchar(100) NOT NULL,
					  `server_ip_address` varchar(100) NOT NULL,
					  `add_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
					  `lastmodified` date NOT NULL,
					  `paypal_email` varchar(250) NOT NULL,
					  `emailupdates` varchar(50) NOT NULL,
					  `shipping_method` varchar(255) NOT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1") or die(mysql_error());
		 
		 	//CREATE COUNTRY TABLE	
			     $countryTblQuery = "CREATE TABLE IF NOT EXISTS `tbl_countries` (
									`CountryId` int(6) unsigned NOT NULL AUTO_INCREMENT,
									`Country` varchar(50) NOT NULL,
									`status` varchar(5) DEFAULT NULL,
									PRIMARY KEY (`CountryId`)
									) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1 ";
						
						if(mysql_query($countryTblQuery))
						{	
						 	//CHECK IF TABLE IS EMPTY
							 $selectCountry = mysql_query("SELECT COUNT(CountryId) as count from tbl_countries") or die(mysql_error());
							 $rowCount = mysql_fetch_array($selectCountry);
							 $rowCount =  $rowCount['count'];
							 if($rowCount == 0)
							   {
							   $countryInsQuery = mysql_query("INSERT INTO `tbl_countries` (`CountryId`, `Country`, `status`) VALUES
										(1, 'United States of America', 'New'),
										(2, 'Canada', 'New'),
										(3, 'Afghanistan', 'New'),
										(5, 'Albania', 'New'),
										(6, 'Algeria', 'New'),
										(7, 'American Samoa', 'New'),
										(8, 'Andorra', 'New'),
										(9, 'Angola', 'New'),
										(10, 'Anguilla', 'New'),
										(11, 'Antarctica', 'New'),
										(12, 'Antigua And Barbuda', 'New'),
										(13, 'Argentina', 'New'),
										(14, 'Armenia', 'New'),
										(15, 'Aruba', 'New'),
										(16, 'Australia', 'New'),
										(17, 'Austria', 'New'),
										(18, 'Azerbaijan', 'New'),
										(19, 'Bahamas', 'New'),
										(20, 'Bahrain', 'New'),
										(21, 'Bangladesh', 'New'),
										(22, 'Barbados', 'New'),
										(23, 'Belarus', 'New'),
										(24, 'Belgium', 'New'),
										(25, 'Belize', 'New'),
										(26, 'Benin', 'New'),
										(27, 'Bermudaz', 'New'),
										(28, 'Bhutan', 'New'),
										(29, 'Bolivia', 'New'),
										(30, 'Bosnia and Herzegovina', 'New'),
										(31, 'Botswana', 'New'),
										(32, 'Brazil', 'New'),
										(33, 'British Indian Ocean Territory', 'New'),
										(34, 'Brunei', 'New'),
										(35, 'Bulgaria', 'New'),
										(36, 'Burkina Faso', 'New'),
										(37, 'Burma', 'New'),
										(38, 'Burundi', 'New'),
										(39, 'Cambodia', 'New'),
										(40, 'Cameroon', 'New'),
										(41, 'Cape Verde', 'New'),
										(42, 'Cayman Islands', 'New'),
										(43, 'Central African Republic', 'New'),
										(44, 'Chad', 'New'),
										(45, 'Chile', 'New'),
										(46, 'China', 'New'),
										(47, 'Christmas Island', 'New'),
										(48, 'Cocos (Keeling) Islands', 'New'),
										(49, 'Colombia', 'New'),
										(50, 'Comoros', 'New'),
										(51, 'Congo, Democratic Republic of the', 'New'),
										(52, 'Cook Islands', 'New'),
										(53, 'Costa Rica', 'New'),
										(54, 'Cote dIvoire', 'New'),
										(55, 'Croatia', 'New'),
										(56, 'Cuba', 'New'),
										(57, 'Cyprus', 'New'),
										(58, 'Czech Republic', 'New'),
										(59, 'Denmark', 'New'),
										(60, 'Djibouti', 'New'),
										(61, 'Dominica', 'New'),
										(62, 'Dominican Republic', 'New'),
										(63, 'East Timor', 'New'),
										(64, 'Ecuador', 'New'),
										(65, 'Egypt', 'New'),
										(66, 'El Salvador', 'New'),
										(67, 'Equatorial Guinea', 'New'),
										(68, 'Eritrea', 'New'),
										(69, 'Estonia', 'New'),
										(70, 'Ethiopia', 'New'),
										(71, 'Falkland Islands', 'New'),
										(72, 'Faroe Islands', 'New'),
										(73, 'Fiji', 'New'),
										(74, 'Finland', 'New'),
										(75, 'France', 'New'),
										(76, 'French Guiana', 'New'),
										(77, 'French Polynesia', 'New'),
										(78, 'Gabon', 'New'),
										(79, 'Gambia', 'New'),
										(80, 'Gaza Strip', 'New'),
										(81, 'Georgia', 'New'),
										(82, 'Germany', 'New'),
										(83, 'Ghana', 'New'),
										(84, 'Gibraltar', 'New'),
										(85, 'Greece', 'New'),
										(86, 'Greenland', 'New'),
										(87, 'Grenada', 'New'),
										(88, 'Guadeloupe', 'New'),
										(89, 'Guam', 'New'),
										(90, 'Guatemala', 'New'),
										(91, 'Guernsey', 'New'),
										(92, 'Guinea', 'New'),
										(93, 'Guinea-Bissau', 'New'),
										(94, 'Guyana', 'New'),
										(95, 'Haiti', 'New'),
										(96, 'Honduras', 'New'),
										(97, 'Hong Kong', 'New'),
										(98, 'Hungary', 'New'),
										(99, 'Iceland', 'New'),
										(100, 'India', 'New'),
										(101, 'Indonesia', 'New'),
										(103, 'Iran', 'New'),
										(104, 'Iraq', 'New'),
										(105, 'Ireland', 'New'),
										(106, 'Israel', 'New'),
										(107, 'Italy', 'New'),
										(108, 'Jamaica', 'New'),
										(109, 'Japan', 'New'),
										(110, 'Jordan', 'New'),
										(111, 'Kazakhstan', 'New'),
										(112, 'Kenya', 'New'),
										(113, 'Kiribati', 'New'),
										(114, 'Korea, North', 'New'),
										(115, 'Korea, South', 'New'),
										(116, 'Kuwait', 'New'),
										(117, 'Kyrgyzstan', 'New'),
										(118, 'Laos', 'New'),
										(119, 'Latvia', 'New'),
										(120, 'Lebanon', 'New'),
										(121, 'Lesotho', 'New'),
										(122, 'Liberia', 'New'),
										(123, 'Libya', 'New'),
										(124, 'Liechtenstein', 'New'),
										(125, 'Lithuania', 'New'),
										(126, 'Luxembourg', 'New'),
										(127, 'Macau', 'New'),
										(128, 'Macedonia', 'New'),
										(129, 'Madagascar', 'New'),
										(130, 'Malawi', 'New'),
										(131, 'Malaysia', 'New'),
										(132, 'Maldives', 'New'),
										(133, 'Mali', 'New'),
										(134, 'Malta', 'New'),
										(135, 'Marshall Islands', 'New'),
										(136, 'Martinique', 'New'),
										(137, 'Mauritania', 'New'),
										(138, 'Mauritius', 'New'),
										(139, 'Mayotte', 'New'),
										(140, 'Mexico', 'New'),
										(141, 'Micronesia, Federated States of', 'New'),
										(142, 'Moldova', 'New'),
										(143, 'Monaco', 'New'),
										(144, 'Mongolia', 'New'),
										(145, 'Montserrat', 'New'),
										(146, 'Morocco', 'New'),
										(147, 'Mozambique', 'New'),
										(148, 'Namibia', 'New'),
										(149, 'Nauru', 'New'),
										(150, 'Nepal', 'New'),
										(151, 'Netherlands', 'New'),
										(152, 'Netherlands Antilles', 'New'),
										(153, 'New Caledonia', 'New'),
										(154, 'New Zealand', 'New'),
										(155, 'Nicaragua', 'New'),
										(156, 'Niger', 'New'),
										(157, 'Nigeria', 'New'),
										(158, 'Niue', 'New'),
										(159, 'Norfolk Island', 'New'),
										(160, 'Northern Mariana Islands', 'New'),
										(161, 'Norway', 'New'),
										(162, 'Oman', 'New'),
										(163, 'Pakistan', 'New'),
										(164, 'Palau', 'New'),
										(165, 'Panama', 'New'),
										(166, 'Papua New Guinea', 'New'),
										(167, 'Paraguay', 'New'),
										(168, 'Peru', 'New'),
										(169, 'Philippines', 'New'),
										(170, 'Pitcairn', 'New'),
										(171, 'Poland', 'New'),
										(172, 'Portugal', 'New'),
										(173, 'Puerto Rico', 'New'),
										(174, 'Qatar', 'New'),
										(175, 'Reunion', 'New'),
										(176, 'Romania', 'New'),
										(177, 'Russia', 'New'),
										(178, 'Rwanda', 'New'),
										(179, 'Saint Kitts and Nevis', 'New'),
										(180, 'Saint Lucia', 'New'),
										(181, 'Saint Vincent and the Grenadines', 'New'),
										(182, 'Samoa', 'New'),
										(183, 'San Marino', 'New'),
										(184, 'Sao Tome and Principe', 'New'),
										(185, 'Saudi Arabia', 'New'),
										(186, 'Senegal', 'New'),
										(236, 'Serbia and Montenegro', 'New'),
										(187, 'Seychelles', 'New'),
										(188, 'Sierra Leone', 'New'),
										(189, 'Singapore', 'New'),
										(190, 'Slovakia', 'New'),
										(191, 'Slovenia', 'New'),
										(192, 'Solomon Islands', 'New'),
										(193, 'Somalia', 'New'),
										(194, 'South Africa', 'New'),
										(195, 'Spain', 'New'),
										(196, 'Sri Lanka', 'New'),
										(197, 'St. Helena', 'New'),
										(198, 'St. Pierre and Miquelon', 'New'),
										(199, 'Sudan', 'New'),
										(200, 'Suriname', 'New'),
										(201, 'Svalbard and Jan Mayen Islands', 'New'),
										(202, 'Swaziland', 'New'),
										(203, 'Sweden', 'New'),
										(204, 'Switzerland', 'New'),
										(205, 'Syria', 'New'),
										(206, 'Taiwan', 'New'),
										(207, 'Tajikistan', 'New'),
										(208, 'Tanzania', 'New'),
										(209, 'Thailand', 'New'),
										(210, 'Togo', 'New'),
										(211, 'Tokelau', 'New'),
										(212, 'Tonga', 'New'),
										(213, 'Trinidad and Tobago', 'New'),
										(214, 'Tunisia', 'New'),
										(215, 'Turkey', 'New'),
										(216, 'Turkmenistan', 'New'),
										(217, 'Turks and Caicos Islands', 'New'),
										(218, 'Tuvalu', 'New'),
										(219, 'Uganda', 'New'),
										(220, 'Ukraine', 'New'),
										(221, 'United Arab Emirates', 'New'),
										(222, 'United Kingdom', 'New'),
										(223, 'Uruguay', 'New'),
										(224, 'Uzbekistan', 'New'),
										(225, 'Vanuatu', 'New'),
										(226, 'Vatican City State', 'New'),
										(227, 'Venezuela', 'New'),
										(228, 'VietNam', 'New'),
										(229, 'Virgin Islands (British)', 'New'),
										(230, 'Virgin Islands (U.S.)', 'New'),
										(231, 'Wallis and Futuna Islands', 'New'),
										(232, 'Western Sahara', 'New'),
										(233, 'Yemen', 'New'),
										(234, 'Zambia', 'New'),
										(235, 'Zimbabwe', 'New')") or die(mysql_error());
										
									}//end if count 	
							
						}//END IF COUNTRY QUERY		
					
											//CREATE STATE TABLE
										 $stateTblQuery = "CREATE TABLE IF NOT EXISTS `tbl_state` (
												  `state_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
												  `state_name` varchar(50) DEFAULT NULL,
												  `code` varchar(10) DEFAULT NULL,
												  `country_id` int(10) DEFAULT NULL,
												  `status` varchar(10) DEFAULT NULL,
												  PRIMARY KEY (`state_id`)
												) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
											
									if(mysql_query($stateTblQuery))
									  {
									  	//CHECK IF TABLE IS EMPTY
										 $selectState= mysql_query("SELECT COUNT(state_id) as count from tbl_state") or die(mysql_error());
										 $rowCount = mysql_fetch_array($selectState);
										 $rowCount =  $rowCount['count'];
									  		if($rowCount == 0)
											  {
											  	$stateInsQuery = mysql_query("INSERT INTO `tbl_state` (`state_id`, `state_name`, `code`, `country_id`, `status`) VALUES
														(1, 'Alabama', 'AL', 1, 'New'),
														(2, 'Alaska', 'AK', 1, 'New'),
														(3, 'Arizona', 'AZ', 1, 'New'),
														(4, 'Arkansas', 'AR', 1, 'New'),
														(5, 'California', 'CA', 1, 'New'),
														(6, 'Colorado', 'CO', 1, 'New'),
														(7, 'Connecticut', 'CT', 1, 'New'),
														(8, 'Delaware', 'DE', 1, 'New'),
														(9, 'District of Columbia', 'DC', 1, 'New'),
														(10, 'Florida', 'FL', 1, 'New'),
														(11, 'Georgia ', 'GA', 1, 'New'),
														(12, 'Hawaii ', 'HI', 1, 'New'),
														(13, 'Idaho ', 'ID', 1, 'New'),
														(14, 'Illinois ', 'IL', 1, 'New'),
														(15, 'Indiana ', 'IN', 1, 'New'),
														(16, 'Iowa ', 'IA', 1, 'New'),
														(17, 'Kansas ', 'KS', 1, 'New'),
														(18, 'Kentucky ', 'KY', 1, 'New'),
														(19, 'Louisiana ', 'LA', 1, 'New'),
														(20, 'Maine ', 'ME', 1, 'New'),
														(21, 'Maryland ', 'MD', 1, 'New'),
														(22, 'Massachusetts ', 'MA', 1, 'New'),
														(23, 'Michigan ', 'MI', 1, 'New'),
														(24, 'Minnesota ', 'MN', 1, 'New'),
														(25, 'Mississippi ', 'MS', 1, 'New'),
														(26, 'Missouri ', 'MO', 1, 'New'),
														(27, 'Montana', 'MT', 1, 'New'),
														(28, 'Nebraska ', 'NE', 1, 'New'),
														(29, 'Nevada ', 'NV', 1, 'New'),
														(30, 'New Hampshire ', 'NH', 1, 'New'),
														(31, 'New Jersey ', 'NJ', 1, 'New'),
														(32, 'New Mexico ', 'NM', 1, 'New'),
														(33, 'New York ', 'NY', 1, 'New'),
														(34, 'North Carolina ', 'NC', 1, 'New'),
														(35, 'North Dakota ', 'ND', 1, 'New'),
														(36, 'Ohio ', 'OH', 1, 'New'),
														(37, 'Oklahoma ', 'OK', 1, 'New'),
														(38, 'Oregon ', 'OR', 1, 'New'),
														(39, 'Pennsylvania ', 'PA', 1, 'New'),
														(40, 'Puerto Rico ', 'PR', 1, 'New'),
														(41, 'Rhode Island ', 'RI', 1, 'New'),
														(42, 'South Carolina ', 'SC', 1, 'New'),
														(43, 'South Dakota ', 'SD', 1, 'New'),
														(44, 'Tennessee ', 'TN', 1, 'New'),
														(45, 'Texas ', 'TX', 1, 'New'),
														(46, 'Utah ', 'UT', 1, 'New'),
														(47, 'Vermont ', 'VT', 1, 'New'),
														(48, 'Virgin Islands ', 'VI', 1, 'New'),
														(49, 'Virginia ', 'VA', 1, 'New'),
														(50, 'Washington ', 'WA', 1, 'New'),
														(51, 'West Virginia ', 'WV', 1, 'New'),
														(52, 'Wisconsin ', 'WI', 1, 'New'),
														(53, 'Wyoming ', 'WY', 1, 'New'),
														(54, 'Alberta', 'AB', 2, 'New'),
														(55, 'British Columbia', 'BC', 2, 'New'),
														(56, 'Manitoba', 'MB', 2, 'New'),
														(57, 'New Brunswick', 'NB', 2, 'New'),
														(58, 'Newfoundland and Labrador', 'NL', 2, 'New'),
														(59, 'Northwest Territories', 'NT', 2, 'New'),
														(60, 'Nova Scotia', 'NS', 2, 'New'),
														(61, 'Nunavut', 'NU', 2, 'New'),
														(62, 'Ontario', 'ON', 2, 'New'),
														(63, 'Prince Edward Island', 'PE', 2, 'New'),
														(64, 'Quebec', 'QC', 2, 'New'),
														(65, 'Saskatchewan', 'SK', 2, 'New'),
														(66, 'Yukon Territory', 'YT', 2, 'New')") or die(mysql_error());
											  
											  
											  		}//end if state insert query
													
									  }//end if state query
										
											//CREATE CITY TABLE
											$cityTblQuery = "CREATE TABLE IF NOT EXISTS `tbl_city` (
												  `city_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
												  `city_name` varchar(50) DEFAULT NULL,
												  `state_id` int(6) DEFAULT NULL,
												  `country_id` int(10) DEFAULT NULL,
												  `status` varchar(5) DEFAULT 'NEW',
												  PRIMARY KEY (`city_id`)
												) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
							
												if(mysql_query($cityTblQuery))
										  			 {
													 	//check if table is empty
														 $selectCity = mysql_query("SELECT COUNT(city_id) as count from tbl_city") or die(mysql_error());
														 $rowCount = mysql_fetch_array($selectCity);
														 $rowCount =  $rowCount['count'];
														 
														 	if($rowCount == 0)
																{
																	include('insertdb/insertcity.php');		
																}
															
										  			 
													 }//end if city query		
											
										//CREATE ZIP TABLE
										 $zipTblQuery = "CREATE TABLE IF NOT EXISTS `tbl_zip` (
													  `zip_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
													  `zip_code` varchar(10) DEFAULT NULL,
													  `city_id` int(10) DEFAULT NULL,
													  `status` varchar(10) DEFAULT NULL,
													  `latitude` double(11,6) DEFAULT '0.000000',
													  `longitude` double(11,6) DEFAULT NULL,
													  PRIMARY KEY (`zip_id`)
													) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1";
											
											if(mysql_query($zipTblQuery))
											  {
											  		$selectZip = mysql_query("SELECT COUNT(zip_id) as count from tbl_zip") or die(mysql_error());
													$rowCount = mysql_fetch_array($selectZip);
													$rowCount =  $rowCount['count'];
													
													if($rowCount == 0)
													  {
													  		include('insertdb/insertzip.php');
															
													  }											  
											  
											  }			
											
		 
				 } //end if statement	

			if($strs=='gallery')
			{               
					        //-----------------------------------------------------------------
									//this will create two tables  tbl_album and  tbl_album_photos
							//-----------------------------------------------------------------
							$sql_album=mysql_query("CREATE TABLE IF NOT EXISTS `tbl_album` (
							`id` int(255) NOT NULL AUTO_INCREMENT,
							`title` varchar(99) CHARACTER SET utf8 NOT NULL,
							`image` varchar(255) NOT NULL,
							`desc` text CHARACTER SET utf8 NOT NULL,
							`content` longblob NOT NULL,
							`status` int(1) NOT NULL DEFAULT '1',
							`meta_keywords` varchar(255) NOT NULL,
							`meta_description` varchar(255) NOT NULL,
							`add_date` date NOT NULL,
							PRIMARY KEY (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ");
							
							$sql_photo=mysql_query("CREATE TABLE IF NOT EXISTS `tbl_album_photos` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`albumid` varchar(40) NOT NULL,
							`name` varchar(255) NOT NULL,
							`description` text CHARACTER SET utf8 NOT NULL,
							`image` varchar(255) NOT NULL,
							`status` int(2) DEFAULT '1',
							`meta_keywords` varchar(255) NOT NULL,
							`meta_description` varchar(255) NOT NULL,
							`add_date` date NOT NULL,
							PRIMARY KEY (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1");
			}
			if($strs=='multiLevelCms')
			{               
					        //-----------------------------------------------------------------
									//this will create table tbl_articles
							//-----------------------------------------------------------------
							$sql_multi_cms=mysql_query("CREATE TABLE IF NOT EXISTS `tbl_articles` (
							`id` int(11) NOT NULL AUTO_INCREMENT,
							`title` varchar(255) NOT NULL,
							`description` varchar(255) NOT NULL,
							`exlink` varchar(255) NOT NULL,
							`parent` varchar(30) NOT NULL DEFAULT '0',
							`orderby` varchar(20) NOT NULL,
							`category_level` int(6) NOT NULL DEFAULT '1',
							`status` varchar(30) NOT NULL DEFAULT '1',
							`content` longblob NOT NULL,
							`metatitle` varchar(255) NOT NULL,
							`metakeyword` varchar(255) NOT NULL,
							`metadesc` varchar(255) NOT NULL,
							PRIMARY KEY (`id`)
							) ENGINE=MyISAM  DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC AUTO_INCREMENT=1");
			
			}
}//end createTable funtion

//------------------------------------------------------------------------------------
            // module Path Function
//------------------------------------------------------------------------------------
function modulePath($mod)
{
	$path='../libs/'.$mod.'/admin/'; 
	return $path;


}

function isValidURL($str)
{
	return ( ! preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $str));
}


	
	$_ERR['register']['dob'] = 'Date of birth not valid.';
	
	$_ERR['register']['sc'] = 'invalid Security Code';
	
	$_ERR['register']['phone_number'] = 'Please enter a valid phone number.';
	
	$_ERR['register']['emaile'] = 'The email is already in use by someone else, please try another one.';
	
	$_ERR['register']['passc'] = 'The password confirmation is not the same as password.';
	
	
	
	///////////////////////////////////////////////////////////////////////////
	
	function uservarification()
	
	{
	
		if(empty($_SESSION['userrecord']))
	
		{
	
		
	
		}
	
	}
	
	function dayofweek($selecteddate)//accept date in YYYY-MM-DD format
	
	{
	
		//This function consider 'sunday' as first day and its numeric value is 0 and last day is saturday and its numeric value is 6
	
		$dayofweek = array('mdays','mday','wday');
	
		list($y,$m,$d) = explode("-",$selecteddate);
	
		$dayofweek[mdays] = $mdays=date("t",mktime(0,0,0,$m,1,$y)); //days in the current month
	
		$dayofweek[mday] = date('w',mktime(0,0,0,$m,1,$y)); // day of the week the month started with
	
		$dayofweek[wday] = ($d+$first_day-1)%7;
	
		return $dayofweek;
	
	}
	
	
	
	function sendemail($userID,$type,$confirmationLink="")
	
	{
	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
	
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	
		
	
		$user = @mysql_fetch_array(mysql_query("select * from tbl_user where id='".$userID."'"));
	
		$username = $user['username'];
	
		$email = $user['email'];
	
		$pass = $user['password'];
	
		
	
		$admin = @mysql_fetch_array(mysql_query("select * from tbl_admin"));
	
		$adminMail = $admin['admin_email'];
	
		// get mail contents here (e.g. subject,body)
	
		$result = @mysql_query("select * from tbl_emails where type='".$type."'") or die(mysql_error());
	
		$content = @mysql_fetch_array($result);
	
		$subject = $content['subject'];
	
		$body = $content['content'];
	
		
	
		$from = $headers."From: ".$adminMail;
	
		$newmsg = str_replace("{{UserName}}",$username,$body);
	
		$newmsg2 = str_replace("{{Email}}",$email,$newmsg);
	
		$newmsg3 = str_replace("{{Password}}",$pass,$newmsg2);
	
		$message = str_replace("{{ConfirmationLink}}",$confirmationLink,$newmsg3);
	
		//echo "From:".$adminMail.", Subject:".$subject.", Body:".$message;
	
		$mailsent = mail($email,$subject,$message,$from);
	
		//return $mailsent;
	
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	
	
	$_ERR['register']['passg'] = 'The password syntax must contain minimum 6 characters in lowercase, uppercase or numeric.';
	
	function vpparola ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[a-zA-Z0-9]+$#", $valoare) || strlen($valoare) < 6)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	$_ERR['register']['userValidate'] = 'The user name must contain minimum 4 valid characters (a-z, A-Z, 0-9, _).';
	
	function ValidateUsername ($username)
	
	{
	
	
	
		if(!preg_match("#^[a-zA-Z0-9\_]+$#", $username) || strlen($username) < 4)
	
		{
	
			return true;
	
		}	
	
	}
	
	
	
	$_ERR['register']['userVerify'] = 'The user name already exists, please try another one.';
	
	function VerifyDBUsername ($username)
	
	{
	
	
	
		$rsVU =mysql_query("select * from tblusers where username = '".$username."' ");
	
		if ( mysql_num_rows($rsVU) > 0 ) return false; else return true;
	
		
	
	}
	
	
	
	$_ERR['register']['cpname'] = 'The company name must contain minimum 2 valid characters (a-z, A-Z).';
	
	$_ERR['register']['name'] = 'The name must contain minimum 2 valid characters (a-z, A-Z).';
	
	
	
	function verifyName ($str)
	
	{
	
		// Nume
	
		if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function verifyName2($str)
	
	{
	
		// Preume
	
		if (!preg_match("#^[a-zA-Z\s.-]+$#", $str) || strlen($str) < 2)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	
	
	$_ERR['register']['emailg'] = 'The email syntax is not valid.';
	
	function vpemail ($valoare)
	
	{
	
		// Email
	
		if (!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $valoare) || empty($valoare))
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	
	
	
	
	function reducere($text)
	
	{
	
		$a = array("\r", "\t", "\n");
	
		$r = str_replace($a, '', $text);
	
		return $r;
	
	}
	
	
	
	// Functii pregmatch de verificare
	
	
	
	function vState ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[0-9]+$#", $valoare) || strlen($valoare) < 5)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function vpphone ($valoare)
	
	{
	
		// Parola
	
		if (!preg_match("#^[0-9]+$#", $valoare)/* || strlen($valoare) < 6*/)
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function vpparolac ($valoare, $valoarec)
	
	{
	
		// Parola confirmare
	
		if (!($valoare == $valoarec))
	
		{
	
			return true;
	
		}
	
	}
	
	function vpparolav ($tb, $valoare)
	
	{
	
		// Utilizator existent
	
		$parolav	=	selectaren("*", $tb, "and parola = '".md5($valoare)."' and id = ".$_SESSION['sesID']);
	
		if ($parolav != 1)
	
		{
	
			return true;
	
		}
	
	}
	
	function vpemaile ($tb, $valoare)
	
	{
	
		// Email existent
	
		$emaile	=	selectaren("*", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
		if ($emaile > 0)
	
		{
	
			return true;
	
		}
	
	}
	
	function vpemailep ($tb, $valoare)
	
	{
	
		// Email existent profil
	
		$sqlq	=	selectare("email", $tb, "and id = ".$_SESSION['sesid'], 0, 0, 0);
	
		$rand	=	mysql_fetch_array($sqlq);
	
		$email	=	$rand['email'];
	
		if ($email	!=	$valoare)
	
		{
	
			$emaile	=	selectaren("email", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
			if ($emaile > 0)
	
			{
	
				return true;
	
			}
	
		}
	
	}
	
	//------------------------
	
	function vpemailep1 ($tb, $valoare)
	
	{
	
		// Email existent profil
	
		$sqlq	=	selectare("email", $tb, "and id = ".$_SESSION['id_modificare_admin'], 0, 0, 0);
	
		$rand	=	mysql_fetch_array($sqlq);
	
		$email	=	$rand['email'];
	
		if ($email	!=	$valoare)
	
		{
	
			$emaile	=	selectaren("email", $tb, "and lower(email) = '".strtolower($valoare)."'");
	
			if ($emaile > 0)
	
			{
	
				return true;
	
			}
	
		}
	
	}
	
	//-----------------------------
	
	
	
	
	
	function vpemailc ($valoare, $valoarec)
	
	{
	
		// Email confirmare
	
		if (!($valoare == $valoarec))
	
		{
	
			return true;
	
		}
	
	}
	
	
	
	function wordLimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   return count($words = preg_split('/\s+/', ltrim($string), $length + 1)) > $length ?
	
		   rtrim(substr($string, 0, strlen($string) - strlen(end($words)))) . $ellipsis :
	
		   $string;
	
	}
	
	
	
	function stringLimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   return strlen($fragment = substr($string, 0, $length + 1 - strlen($ellipsis))) < strlen($string) + 1 ?
	
		   preg_replace('/\s*\S*$/', '', $fragment) . $ellipsis : $string;
	
	}
	
	function splitlimit($string, $length = 50, $ellipsis = '...')
	
	{
	
	   if (strlen($string) > $length)return substr($string, 0, $length) . ' ' . $ellipsis;
	
	   else return $string;
	
	}
	
	
	
	function getUserName($id){
	
		$rs = mysql_query("SELECT username FROM tbl_user WHERE id = '".$id."'") or die(mysql_error());
	
		$row = mysql_fetch_array($rs);
	
		return $row['username'];
	
	}
	
	function getUserEmail($id){
	
		$rs = mysql_query("SELECT email FROM tbl_users WHERE id = '".$id."'") or die(mysql_error());
	
		$row = mysql_fetch_array($rs);
	
		return $row['email'];
	
	}
	
	function getUserdetails($id){
	
		$rs = mysql_query("SELECT email, id, full_name FROM tbl_users WHERE id = '".$id."'") or die(mysql_error());
	
		$row = mysql_fetch_assoc($rs);
	
		return $row;
	
	}
	
	function isNumber($val)
	{
		if (!preg_match("#^[0-9]+$#", $val))
		{
			return true;
		}
	}
	
	
//This Function is Used for save Sql injection
	function safe_string($value)
	{
		$value = strip_tags(trim($value));
		if (get_magic_quotes_gpc())
		{
			$value = stripslashes($value);
		}
	
		if (!is_numeric($value))
		{
			//$value = "" . mysql_real_escape_string($value) . "";
		}
		return $value;
	}
	
 //This Function is Used for save Sql Text
	function safe_string_text($value)
	{
		$value = strip_tags(trim($value));
		$value = stripslashes($value);

		return $value;
	}    

//create a function to choose a single character at random from a defined set of characters
function getRandomChar()
   {
         $charSet = "123456789abcdefghijklmnpqrstuvwxyz";         //The character set u wanna build passwords from
         $rn = rand (0, strlen ($charSet));                                         //Choose a random position in character set
    return substr ($charSet, $rn, 1);                                          //Return the character at that position
   }


//create function to choose a given length password by using getRandomChar()
function getPassword($length)
{
	 $pass = "";                                        //make pass an empty string
	 
	 //loop for no of time specified by length of password
	 for ($idx = 0; $idx < $length; $idx++)
		{
		  $pass .= getRandomChar();         //add a random character to pass
		 }
	 return $pass;                           
}

function timediff($data_ref_end)
{
	$r_c = mysql_query("SELECT TIMEDIFF('$data_ref_end',NOW()) as tdiff");
	$rec_time = mysql_fetch_array($r_c);
	$data_ref_end = $rec_time['tdiff'];
	
	$arr_dtime = explode(':', $data_ref_end);
	if($arr_dtime[0] > 1){
		if($arr_dtime[0] >= 24){
			$time = floor($arr_dtime[0]/24);
			$hr = $arr_dtime[0]-($time*24);
			$time = $time.'d '.$hr. 'hr ';
		}else{
			$time = $arr_dtime[0].'hr ';
		}	
	}elseif($arr_dtime[0] == 1){
		$time = $arr_dtime[0].' hr';
	}elseif($arr_dtime[0] == 0 && $arr_dtime[1] > 0){
		if($arr_dtime[0] >= 0){
		if($arr_dtime[1] >= 30 && $arr_dtime[0] == 0){
			$time = 'Less than 1 hr';
		}elseif($arr_dtime[1] < 30 && $arr_dtime[0] == 0){
			$time = $arr_dtime[1].'min';
		}
		}elseif($arr_dtime[0] < 0){
			$time = 'Ended';
		}	
	}elseif($arr_dtime[0] < 0){
		$time = 'Ended';
	}
	elseif($arr_dtime[1] <= 0){
		if($arr_dtime[2] > 1){
			$time = $arr_dtime[2].' sec';
		}elseif($arr_dtime[2] <= 1){
			$time = 'Ended';
		}elseif($arr_dtime[0] < 0 && $arr_dtime[1] < 0){
			$time = 'Ended';
		}	
	}
	return $time;
}


function getTimeAgo($datefrom,$dateto=-1)
{
	// Defaults and assume if 0 is passed in that
	// its an error rather than the epoch
	
	if($datefrom<=0) { return "Unknown Time Formate"; }
	if($dateto==-1) { $dateto = time(); }
	
	// Calculate the difference in seconds betweeen
	// the two timestamps
	
	$difference =  $datefrom - $dateto;
	
	// If difference is less than 0 ,
	// The question is expired now.
	
	if($difference < 0)
	{
		$interval = "x";
	}
	
	// If difference is less than 60 seconds,
	// seconds is a good interval of choice
	
	elseif($difference < 60)
	{
		$interval = "s";
	}
	
	// If difference is between 60 seconds and
	// 60 minutes, minutes is a good interval
	elseif($difference >= 60 && $difference<60*60)
	{
		$interval = "n";
	}
	
	// If difference is between 1 hour and 24 hours
	// hours is a good interval
	elseif($difference >= 60*60 && $difference<60*60*24)
	{
		$interval = "h";
	}
	
	// If difference is between 1 day and 7 days
	// days is a good interval
	elseif($difference >= 60*60*24 && $difference<60*60*24*7)
	{
		$interval = "d";
	}
	
	// If difference is between 1 week and 30 days
	// weeks is a good interval
	elseif($difference >= 60*60*24*7 && $difference <
	60*60*24*30)
	{
		$interval = "ww";
	}
	
	// If difference is between 30 days and 365 days
	// months is a good interval, again, the same thing
	// applies, if the 29th February happens to exist
	// between your 2 dates, the function will return
	// the 'incorrect' value for a day
	elseif($difference >= 60*60*24*30 && $difference <
	60*60*24*365)
	{
		$interval = "m";
	}
	
	// If difference is greater than or equal to 365
	// days, return year. This will be incorrect if
	// for example, you call the function on the 28th April
	// 2008 passing in 29th April 2007. It will return
	// 1 year ago when in actual fact (yawn!) not quite
	// a year has gone by
	elseif($difference >= 60*60*24*365)
	{
		$interval = "y";
	}
	
	// Based on the interval, determine the
	// number of units between the two dates
	// From this point on, you would be hard
	// pushed telling the difference between
	// this function and DateDiff. If the $datediff
	// returned is 1, be sure to return the singular
	// of the unit, e.g. 'day' rather 'days'
	
	switch($interval)
	{
	case "m":
	$months_difference = floor($difference / 60 / 60 / 24 /
	29);
	while (mktime(date("H", $datefrom), date("i", $datefrom),
	date("s", $datefrom), date("n", $datefrom)+($months_difference),
	date("j", $dateto), date("Y", $datefrom)) < $dateto)
	{
		$months_difference++;
	}
	$datediff = $months_difference;
	
	// We need this in here because it is possible
	// to have an 'm' interval and a months
	// difference of 12 because we are using 29 days
	// in a month
	
	if($datediff==12)
	{
		$datediff--;
	}
	
	$res = ($datediff==1) ? "$datediff month " : "$datediff
	months ";
	break;
	
	case "y":
	$datediff = floor($difference / 60 / 60 / 24 / 365);
	$res = ($datediff==1) ? "$datediff year " : "$datediff
	years ";
	break;
	
	case "d":
	$datediff = floor($difference / 60 / 60 / 24);
	$res = ($datediff==1) ? "$datediff day " : "$datediff
	days ";
	break;
	
	case "ww":
	$datediff = floor($difference / 60 / 60 / 24 / 7);
	$res = ($datediff==1) ? "$datediff week " : "$datediff
	weeks ";
	break;
	
	case "h":
	$datediff = floor($difference / 60 / 60);
	$res = ($datediff==1) ? "$datediff hour " : "$datediff
	hours ";
	break;
	
	case "n":
	$datediff = floor($difference / 60);
	$res = ($datediff==1) ? "$datediff minute " :
	"$datediff minutes ";
	break;
	
	case "s":
	$datediff = $difference;
	$res = ($datediff==1) ? "$datediff second " :
	"$datediff seconds ";
	break;
	
	
	case "x":
	$datediff = $difference;
	$res = ($datediff<=1) ? " Time Out " :
	" Time Out ";
	break;
	}
	
return $res;
}

// Change the Date Format
function dateformat($target_date)
{
	$timeformat_qry = mysql_query("SELECT DATE_FORMAT('$target_date','%d.%c.%Y') as tdiff");
	$rec_time = mysql_fetch_array($timeformat_qry);
	$timeformat = $rec_time['tdiff'];
	return $timeformat;
}

function dateformat_stnd($target_date)
{
	$timeformat_qry = mysql_query("SELECT DATE_FORMAT('$target_date','%Y-%m-%d') as tdiff");
	$rec_time = mysql_fetch_array($timeformat_qry);
	$timeformat = $rec_time['tdiff'];
	return $timeformat;
}


//SELECT DATE_FORMAT(postdate, '%Y-%m-%d') 

//This Function is To ADD day in date 
function adddate($target_date)
{
	$adddays_qry = mysql_query("SELECT DATE_ADD('$target_date', INTERVAL 14 DAY) as adddays");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['adddays']; 
}

//This Function is To SUB date day in date 
function sub_date($target_date, $days)
{
	$adddays_qry = mysql_query("SELECT DATE_SUB('$target_date', INTERVAL $days DAY) as adddays");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['adddays']; 
}

// this function is used to get the first day of the month
 
 function firstOfMonth() 
 {
    
	return date("m/d/Y", strtotime(date('m').'/01/'.date('Y').' 00:00:00'));
	
 }
 
function last_dates($days)
{
 
    $m= date("m");
    $de= date("d");
    $y= date("Y");
    for($i=0; $i<=$days; $i++){
     echo date('Y-m-d,',mktime(0,0,0,$m,($de-$i),$y)); 
    }
 
}

//This Function is To ADD day in date 
function adddoneday($target_date)
{

    $adddays_qry = mysql_query("SELECT DATE_ADD('$target_date', INTERVAL 1 DAY) as adddays");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['adddays']; 
}

//This Function is To ADD months in Current date 
function addmonth($target_date)
{
	$adddays_qry = mysql_query("SELECT CURDATE() + INTERVAL '$target_date' MONTH AS expiredate");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['expiredate']; 
}

function addmonthdatetime($target_date)
{
	$adddays_qry = mysql_query("SELECT Now() + INTERVAL '$target_date' MONTH AS expiredate");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['expiredate']; 
}


//This Function is Used for get all categories 
function get_all_categories()
{
  $q_categories = "select * from tblcategories where parent_id =0 and active_status = '1'";
  $res_categories = mysql_query($q_categories);
  return $res_categories;
}

//This Function is Used for get sub categories 
function get_subcategories($parent_id)
{
  $q_categories = "select * from tblcategories where parent_id ='".$parent_id."'";
  $res_categories = mysql_query($q_categories);
  return $res_categories;
}
//This Function is Used for get sub categories 
function get_category($category_id)
{
   $q_categories = "select * from tblcategories where category_id ='".$category_id."'";
   $res_categories = mysql_query($q_categories);
   $row_category = @mysql_fetch_array($res_categories);
   return $row_category;
}

//This Function is Used for get sub categories 
function get_email_template($type)
{
	$q_template_type= "SELECT * from `tbl_emails` where type  = '".$type."'";
	$res_email_template_type = mysql_query($q_template_type);
    $row_email_template_type = mysql_fetch_array($res_email_template_type); 
    return $row_email_template_type;
}

//This Function is Used for get sub categories 
function get_search_jobs($type)
{
	$q_template_type= "SELECT * from `tbl_emails` where type  = '".$type."'";
	$res_email_template_type = mysql_query($q_template_type);
    $row_email_template_type = mysql_fetch_array($res_email_template_type); 
    return $row_email_template_type;
}

//this function is used for difference between tow dates 
function days_left($start_date,$today)
{
$q_diff_date = "SELECT DATEDIFF('$today','$start_date')";
	$res_diff_date = mysql_query($q_diff_date);
	$a = mysql_fetch_array($res_diff_date);
	$days_left = $a[0];
    return $days_left;
}

//this functiopn is used for get languatute 
function get_lang_location($postcode,$location,$country)
{
	define("MAPS_HOST", "maps.google.com");
	//define("KEY", "ABQIAAAAGYi_VWvHrP7q8kyAPPpJURQZAhASWZqEbxJshqfP5akMdtQzzhRnXmdswJkHNO0PiXfmTj2aDhXibA");
	$delay = 0;
	$base_url = "http://" . MAPS_HOST . "/maps/geo?output=xml" . "&key=" . KEY;
	// Iterate through the rows, geocoding each address
	  $geocode_pending = true;
	  $full_address = $postcode.' '.$location.','.$country;

		$address = $full_address;

		//$id = $propdata_map["location_id"];
		$request_url = $base_url . "&q=" . urlencode($address);
		$xml = simplexml_load_file($request_url) or die("url not loading");
	
		$status = $xml->Response->Status->code;
		if (strcmp($status, "200") == 0) 
		{
		  // Successful geocode
		  $geocode_pending = false;
		  $coordinates = $xml->Response->Placemark->Point->coordinates;
		  $coordinatesSplit = split(",", $coordinates);
		  // Format: Longitude, Latitude, Altitude
		  $lat = $coordinatesSplit[1];
		  $lng = $coordinatesSplit[0];
	      $latt['lat'] = $lat;
		  $latt['lang'] = $lng;
		  //return $latt;  
		} 
		else 
		{
		  // failure to geocode
		  /*$geocode_pending = false;
		  echo "Address " . $address . " failed to geocoded. ";
		  echo "Received status " . $status . " \n";*/
		  $latt['lat'] = "";
		  $latt['lang'] = "";
		}
		//usleep($delay);
		 return $latt;  
}

//This Function is used for Convert document Into a Pdf fromat 
function fnURL2PDF($varURL, $varFileName = "pdf.pdf", $varSavePath = "")
{
	$varSocket = fsockopen("www.easysw.com", 80, $errno, $errstr, 1000);
	if (!$varSocket) die("$errstr ($errno)\n");
			
	fwrite($varSocket, "GET /htmldoc/pdf-o-matic.php?URL=" . $varURL . "&FORMAT=.pdf HTTP/1.0\r\n");
	fwrite($varSocket, "Host: www.easysw.com\r\n");
	fwrite($varSocket, "Referer: http://www.easysw.com/htmldoc/pdf-o-matic.php\r\n");
	fwrite($varSocket, "\r\n");
			
	$varHeaders = "";
	while ($varStr = trim(fgets($varSocket, 4096)))
	$varHeaders .= "$varStr\n";
	$varBody = "";
	while (!feof($varSocket))
	$varBody .= fgets($varSocket, 4096);
	
	if ($varSavePath != '')
	{
	// Save the File
	$varFileHandle = @fopen($varSavePath,'w');
	$varBytes = @fwrite($varFileHandle, $varBody);
	}
	else
	{
	//Download file
	if(isset($HTTP_SERVER_VARS['HTTP_USER_AGENT']) and strpos($HTTP_SERVER_VARS['HTTP_USER_AGENT'],'MSIE'))
	Header('Content-Type: application/force-download');
	else
	Header('Content-Type: application/octet-stream');
	if(headers_sent())
	die('Some data has already been output to browser, can\'t send PDF file');
	Header('Content-Length: '.strlen($varBody));
	Header('Content-disposition: attachment; filename='.$varFileName);
	echo $varBody;
	}
	return(true);
}

function get_banner_info($banner_type)
{
   $q_get_qulification = "select * from tblbanners where  banner_category= '".$banner_type."' and banner_status = '1' order by banner_id desc";
   $res_get_qulification = mysql_query($q_get_qulification);
   $row_get_qulification =  mysql_fetch_array($res_get_qulification);
   return $row_get_qulification;


}

function genRandomPassword($length = 8)
	{
		$salt = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
		$len = strlen($salt);
		$makepass = '';

		$stat = @stat(__FILE__);
		if(empty($stat) || !is_array($stat)) $stat = array(php_uname());

		mt_srand(crc32(microtime() . implode('|', $stat)));

		for ($i = 0; $i < $length; $i ++) {
			$makepass .= $salt[mt_rand(0, $len -1)];
		}

		return $makepass;
	}
	
function toInteger(&$array, $default = null)
	{
		if (is_array($array)) {
			foreach ($array as $i => $v) {
				$array[$i] = (int) $v;
			}
		} else {
			if ($default === null) {
				$array = array();
			} elseif (is_array($default)) {
				JArrayHelper::toInteger($default, null);
				$array = $default;
			} else {
				$array = array( (int) $default );
			}
		}
	}


function getValue(&$array, $name, $default=null, $type='')
	{
		// Initialize variables
		$result = null;

		if (isset ($array[$name])) {
			$result = $array[$name];
		}

		// Handle the default case
		if (is_null($result)) {
			$result = $default;
		}

		// Handle the type constraint
		switch (strtoupper($type))
		{
			case 'INT' :
			case 'INTEGER' :
				// Only use the first integer value
				@ preg_match('/-?[0-9]+/', $result, $matches);
				$result = @ (int) $matches[0];
				break;

			case 'FLOAT' :
			case 'DOUBLE' :
				// Only use the first floating point value
				@ preg_match('/-?[0-9]+(\.[0-9]+)?/', $result, $matches);
				$result = @ (float) $matches[0];
				break;

			case 'BOOL' :
			case 'BOOLEAN' :
				$result = (bool) $result;
				break;

			case 'ARRAY' :
				if (!is_array($result)) {
					$result = array ($result);
				}
				break;

			case 'STRING' :
				$result = (string) $result;
				break;

			case 'WORD' :
				$result = (string) preg_replace( '#\W#', '', $result );
				break;

			case 'NONE' :
			default :
				// No casting necessary
				break;
		}
		return $result;
	}
	/**
 	 * Mail function (uses phpMailer)
 	 *
 	 * @param string $from From e-mail address
 	 * @param string $fromname From name
 	 * @param mixed $recipient Recipient e-mail address(es)
 	 * @param string $subject E-mail subject
 	 * @param string $body Message body
 	 * @param boolean $mode false = plain text, true = HTML
 	 * @param mixed $cc CC e-mail address(es)
 	 * @param mixed $bcc BCC e-mail address(es)
 	 * @param mixed $attachment Attachment file name(s)
 	 * @param mixed $replyto Reply to email address(es)
 	 * @param mixed $replytoname Reply to name(s)
 	 * @return boolean True on success
  	 */
	function sendMail($from, $fromname, $recipient, $subject, $body, $mode=0, $cc=null, $bcc=null, $attachment=null, $replyto=null, $replytoname=null )
	{
	 	// Get a JMail instance
		$mail =& JFactory::getMailer();

		$mail->setSender(array($from, $fromname));
		$mail->setSubject($subject);
		$mail->setBody($body);

		// Are we sending the email as HTML?
		if ( $mode ) {
			$mail->IsHTML(true);
		}

		$mail->addRecipient($recipient);
		$mail->addCC($cc);
		$mail->addBCC($bcc);
		$mail->addAttachment($attachment);

		// Take care of reply email addresses
		if( is_array( $replyto ) ) {
			$numReplyTo = count($replyto);
			for ( $i=0; $i < $numReplyTo; $i++){
				$mail->addReplyTo( array($replyto[$i], $replytoname[$i]) );
			}
		} elseif( isset( $replyto ) ) {
			$mail->addReplyTo( array( $replyto, $replytoname ) );
		}

		return  $mail->Send();
	}

	/**
	 * Sends mail to administrator for approval of a user submission
 	 *
 	 * @param string $adminName Name of administrator
 	 * @param string $adminEmail Email address of administrator
 	 * @param string $email [NOT USED TODO: Deprecate?]
 	 * @param string $type Type of item to approve
 	 * @param string $title Title of item to approve
 	 * @param string $author Author of item to approve
 	 * @return boolean True on success
 	 */
	function sendAdminMail( $adminName, $adminEmail, $email, $type, $title, $author, $url = null )
	{
		$subject = JText::_( 'User Submitted' ) ." '". $type ."'";

		$message = sprintf ( JText::_( 'MAIL_MSG_ADMIN' ), $adminName, $type, $title, $author, $url, $url, 'administrator', $type);
		$message .= JText::_( 'MAIL_MSG') ."\n";

	 	// Get a JMail instance
		$mail =& JFactory::getMailer();
		$mail->addRecipient($adminEmail);
		$mail->setSubject($subject);
		$mail->setBody($message);

		return  $mail->Send();
	}


	function __construct($date = 'now', $tzOffset = 0)
	{
		if ($date == 'now' || empty($date))
		{
			$this->_date = strtotime(gmdate("M d Y H:i:s", time()));
			return;
		}

		$tzOffset *= 3600;
		if (is_numeric($date))
		{
			$this->_date = $date - $tzOffset;
			return;
		}

		if (preg_match('~(?:(?:Mon|Tue|Wed|Thu|Fri|Sat|Sun),\\s+)?(\\d{1,2})\\s+([a-zA-Z]{3})\\s+(\\d{4})\\s+(\\d{2}):(\\d{2}):(\\d{2})\\s+(.*)~i',$date,$matches))
		{
			$months = Array(
				'jan' => 1, 'feb' => 2, 'mar' => 3, 'apr' => 4,
				'may' => 5, 'jun' => 6, 'jul' => 7, 'aug' => 8,
				'sep' => 9, 'oct' => 10, 'nov' => 11, 'dec' => 12
			);
			$matches[2] = strtolower($matches[2]);
			if (! isset($months[$matches[2]])) {
				return;
			}
			$this->_date = mktime(
				$matches[4], $matches[5], $matches[6],
				$months[$matches[2]], $matches[1], $matches[3]
			);
			if ($this->_date === false) {
				return;
			}

			if ($matches[7][0] == '+') {
				$tzOffset = 3600 * substr($matches[7], 1, 2)
					+ 60 * substr($matches[7], -2);
			} elseif ($matches[7][0] == '-') {
				$tzOffset = -3600 * substr($matches[7], 1, 2)
					- 60 * substr($matches[7], -2);
			} else {
				if (strlen($matches[7]) == 1) {
					$oneHour = 3600;
					$ord = ord($matches[7]);
					if ($ord < ord('M')) {
						$tzOffset = (ord('A') - $ord - 1) * $oneHour;
					} elseif ($ord >= ord('M') && $matches[7] != 'Z') {
						$tzOffset = ($ord - ord('M')) * $oneHour;
					} elseif ($matches[7] == 'Z') {
						$tzOffset = 0;
					}
				}
				switch ($matches[7]) {
					case 'UT':
					case 'GMT': $tzOffset = 0;
				}
			}
			$this->_date -= $tzOffset;
			return;
		}
		if (preg_match('~(\\d{4})-(\\d{2})-(\\d{2})[T\s](\\d{2}):(\\d{2}):(\\d{2})(.*)~', $date, $matches))
		{
			$this->_date = mktime(
				$matches[4], $matches[5], $matches[6],
				$matches[2], $matches[3], $matches[1]
			);
			if ($this->_date == false) {
				return;
			}
			if (isset($matches[7][0])) {
				if ($matches[7][0] == '+' || $matches[7][0] == '-') {
					$tzOffset = 60 * (
						substr($matches[7], 0, 3) * 60 + substr($matches[7], -2)
					);
				} elseif ($matches[7] == 'Z') {
					$tzOffset = 0;
				}
			}
			$this->_date -= $tzOffset;
			return;
		}
        $this->_date = (strtotime($date) == -1) ? false : strtotime($date);
		if ($this->_date) {
			$this->_date -= $tzOffset;
		}
	}

	/**
	 * Set the date offset (in hours)
	 *
	 * @access public
	 * @param float The offset in hours
	 */
	function setOffset($offset) {
		$this->_offset = 3600 * $offset;
	}

	/**
	 * Get the date offset (in hours)
	 *
	 * @access public
	 * @return integer
	 */
	function getOffset() {
		return ((float) $this->_offset) / 3600.0;
	}

	/**
	 * Gets the date as an RFC 822 date.
	 *
	 * @return a date in RFC 822 format
	 * @link http://www.ietf.org/rfc/rfc2822.txt?number=2822 IETF RFC 2822
	 * (replaces RFC 822)
	 */
	function toRFC822($local = false)
	{
		$date = ($local) ? $this->_date + $this->_offset : $this->_date;
		$date = ($this->_date !== false) ? date('D, d M Y H:i:s', $date).' +0000' : null;
		return $date;
	}

	/**
	 * Gets the date as an ISO 8601 date.
	 *
	 * @return a date in ISO 8601 (RFC 3339) format
	 * @link http://www.ietf.org/rfc/rfc3339.txt?number=3339 IETF RFC 3339
	 */
	function toISO8601($local = false)
	{
		$date   = ($local) ? $this->_date + $this->_offset : $this->_date;
		$offset = $this->getOffset();
        $offset = ($local && $this->_offset) ? sprintf("%+03d:%02d", $offset, abs(($offset-intval($offset))*60) ) : 'Z';
        $date   = ($this->_date !== false) ? date('Y-m-d\TH:i:s', $date).$offset : null;
		return $date;
	}

	/**
	 * Gets the date as in MySQL datetime format
	 *
	 * @return a date in MySQL datetime format
	 * @link http://dev.mysql.com/doc/refman/4.1/en/datetime.html MySQL DATETIME
	 * format
	 */
	function toMySQL($local = false)
	{
		$date = ($local) ? $this->_date + $this->_offset : $this->_date;
		$date = ($this->_date !== false) ? date('Y-m-d H:i:s', $date) : null;
		return $date;
	}

	/**
	 * Gets the date as UNIX time stamp.
	 *
	 * @return a date as a unix time stamp
	 */
	function toUnix($local = false)
	{
		$date = null;
		if ($this->_date !== false) {
			$date = ($local) ? $this->_date + $this->_offset : $this->_date;
		}
		return $date;
	}

	/**
	 * Gets the date in a specific format
	 *
	 * Returns a string formatted according to the given format. Month and weekday names and
	 * other language dependent strings respect the current locale
	 *
	 * @param string $format  The date format specification string (see {@link PHP_MANUAL#strftime})
	 * @return a date in a specific format
	 */
	function toFormat($format = '%Y-%m-%d %H:%M:%S')
	{
		$date = ($this->_date !== false) ? $this->_strftime($format, $this->_date + $this->_offset) : null;

		return $date;
	}

	/**
	 * Translates needed strings in for JDate::toFormat (see {@link PHP_MANUAL#strftime})
	 *
	 * @access protected
	 * @param string $format The date format specification string (see {@link PHP_MANUAL#strftime})
	 * @param int $time Unix timestamp
	 * @return string a date in the specified format
	 */
	function _strftime($format, $time)
	{
		if(strpos($format, '%a') !== false)
			$format = str_replace('%a', $this->_dayToString(date('w', $time), true), $format);
		if(strpos($format, '%A') !== false)
			$format = str_replace('%A', $this->_dayToString(date('w', $time)), $format);
		if(strpos($format, '%b') !== false)
			$format = str_replace('%b', $this->_monthToString(date('n', $time), true), $format);
		if(strpos($format, '%B') !== false)
			$format = str_replace('%B', $this->_monthToString(date('n', $time)), $format);
		$date = strftime($format, $time);
		return $date;
	}

	/**
	 * Translates month number to string
	 *
	 * @access protected
	 * @param int $month The numeric month of the year
	 * @param bool $abbr Return the abreviated month string?
	 * @return string month string
	 */
	function _monthToString($month, $abbr = false)
	{
		switch ($month)
		{
			case 1:  return $abbr ? JText::_('JANUARY_SHORT')   : JText::_('JANUARY');
			case 2:  return $abbr ? JText::_('FEBRUARY_SHORT')  : JText::_('FEBRUARY');
			case 3:  return $abbr ? JText::_('MARCH_SHORT')     : JText::_('MARCH');
			case 4:  return $abbr ? JText::_('APRIL_SHORT')     : JText::_('APRIL');
			case 5:  return $abbr ? JText::_('MAY_SHORT')       : JText::_('MAY');
			case 6:  return $abbr ? JText::_('JUNE_SHORT')      : JText::_('JUNE');
			case 7:  return $abbr ? JText::_('JULY_SHORT')      : JText::_('JULY');
			case 8:  return $abbr ? JText::_('AUGUST_SHORT')    : JText::_('AUGUST');
			case 9:  return $abbr ? JText::_('SEPTEMBER_SHORT')  : JText::_('SEPTEMBER');
			case 10: return $abbr ? JText::_('OCTOBER_SHORT')   : JText::_('OCTOBER');
			case 11: return $abbr ? JText::_('NOVEMBER_SHORT')  : JText::_('NOVEMBER');
			case 12: return $abbr ? JText::_('DECEMBER_SHORT')  : JText::_('DECEMBER');
		}
	}

	/**
	 * Translates day of week number to string
	 *
	 * @access protected
	 * @param int $day The numeric day of the week
	 * @param bool $abbr Return the abreviated day string?
	 * @return string day string
	 */
	function _dayToString($day, $abbr = false)
	{
		switch ($day)
		{
			case 0: return $abbr ? JText::_('SUN') : JText::_('SUNDAY');
			case 1: return $abbr ? JText::_('MON') : JText::_('MONDAY');
			case 2: return $abbr ? JText::_('TUE') : JText::_('TUESDAY');
			case 3: return $abbr ? JText::_('WED') : JText::_('WEDNESDAY');
			case 4: return $abbr ? JText::_('THU') : JText::_('THURSDAY');
			case 5: return $abbr ? JText::_('FRI') : JText::_('FRIDAY');
			case 6: return $abbr ? JText::_('SAT') : JText::_('SATURDAY');
		}
	}


function loginUser_Cooke($userid)
{
	$timeunit = 3600;
	$time_duration = 48;
	$domain = SERVER_PATH;
	if(!empty($userid))
	{
	
		$qry_user = "select * from tbl_artist where id = '".$userid."' and status = 'a'";
		$res_user = mysql_query($qry_user);
		
		if(mysql_num_rows($res_user)==1)
		{
			$row_user = mysql_fetch_array($res_user);
			if($row_user['status'] == 'a')
			{
				if($remember == 'no')
				{
					//Until the session
					$exp_time = 0;
				}else{
					//one year
					$exp_time = time()+(60*60*24*365);
				}
				
				$_SESSION["fglogin"]["userid"] = $row_user['id'];
				$_SESSION["fglogin"]["fname"] = $row_user['fname'];
				$_SESSION["fglogin"]["usertype"] = $row_user['usertype'];
				$_SESSION["fglogin"]["email"] = $row_user['email'];
				$_SESSION["fglogin"]["IsLogin"] = 'yes';
				
				$_SESSION['fglogin']["succss"] = "You are Loged In Successfully.";
				
				$message['status'] = 'Success';
				$message['user_name'] = $userName;
				
				if(isset($_SESSION['wotlogin']['redecurl'])){
					//header("Location:".$_SESSION['wotlogin']['redecurl']);
					
				}
	
			}

			
		}else{
			$message['status'] = 'InvalidInfo';
		}
	}else{
		$message['status'] = 'InvalidInfo';
	}
	
}

function loginUser($userName,$password,$remember='no')
{
	$timeunit = 3600;
	$time_duration = 48;
	$domain = SERVER_PATH;
	
	if(ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $userName))
	{
		$qry_user = "select * from tbl_artist where email = '".$userName."' AND password = '".md5($password)."' AND status = 'a'";
		//$qry_user = "select * from tbl_users where email = '".$userName."' AND password = '".md5($password)."'";

		$res_user = mysql_query($qry_user);
		
		if(mysql_num_rows($res_user)==1)
		{
			$row_user = mysql_fetch_array($res_user);
			if($row_user['status'] == 'a')
			{
			
			
//========================== insert Twitter value in tbl_user ======================================

		if( isset($_SESSION["twitter"]["new"]) )
		{	
		
		 
		 //check twitter info store in corrsponding user record
		  $query = "SELECT * FROM tbl_social_info WHERE username = '".$_SESSION["twitter"]["username"]."'"; 
			$res = mysql_query($query);
			$count = mysql_num_rows($res);
					
		  // if record exists
		  if($count > 0)
		  {
		   // Update tbl_user with twitter respond	
		   $sqlquery = "UPDATE tbl_artist
						set
						 oauth_provider ='twitter',
						 username_tw = '".$_SESSION["twitter"]["oauth_uid"]."',
						 username='".$_SESSION["twitter"]["username"]."'
						 where username_tw = '".$_SESSION["twitter"]["username"]."'
						  AND email ='".$userName."'";
		
			$res = mysql_query($sqlquery) or die("Recrod not insert in tbl_social_info" . mysql_error());
			
			// Update twitter response into tbl_social_info 	
			$sql_social = "UPDATE tbl_social_info
						  set
						   oauth_provider ='twitter',
						   oauth_uid = '".$_SESSION["twitter"]["oauth_uid"]."',
						   user_id ='".$row_user['id']."',
						   name = '".$_SESSION["twitter"]["name"]."',
						   username ='".$_SESSION["twitter"]["username"]."',
						   pict ='".$_SESSION["twitter"]["profile_image_url"]."',
						   email ='".$userName."'
						   where username = '".$_SESSION["twitter"]["username"]."'
							AND email ='".$userName."'";
						   
			  $res = mysql_query($sql_social) or die("Recrod not insert in tbl_social_info" . mysql_error());
			}
			// if record NOT exists
			else
			{
			
			   //First check twitter respons ALREADY EXISTs in tbl_social_info 
			   $query = "SELECT * FROM tbl_social_info WHERE oauth_provider = 'twitter' AND oauth_uid = ".$_SESSION["twitter"]["oauth_uid"]." AND email = '".$userName."'";  
			  
			   $res = mysql_query($query);
			   $count = mysql_num_rows($res);
			   while ($row = mysql_fetch_array($res))
			   $row['oauth_uid'];
					
			   // if record exists
			   if($count > 0)
			   {
				  // Update twitter response into tbl_social_info			
				  $sql_social = "UPDATE tbl_social_info
						  set
						   oauth_provider ='twitter',
						   oauth_uid = '".$_SESSION["twitter"]["oauth_uid"]."',
						   user_id ='".$row_user['id']."',
						   name = '".$_SESSION["twitter"]["name"]."',
						   username ='".$_SESSION["twitter"]["username"]."',
						   pict ='".$_SESSION["twitter"]["profile_image_url"]."',
						   email ='".$userName."'";
						   
				  $res = mysql_query($sql_social) or die("Recrod not insert in tbl_social_info" . mysql_error());
			   }
			   //if record not exists
			   else
			   {
				 // Insert twitter response into tbl_social_info			
				 $sql_social = "INSERT INTO tbl_social_info
						  set
						   oauth_provider ='twitter',
						   oauth_uid = '".$_SESSION["twitter"]["oauth_uid"]."',
						   user_id ='".$row_user['id']."',
						   name = '".$_SESSION["twitter"]["name"]."',
						   username ='".$_SESSION["twitter"]["username"]."',
						   pict ='".$_SESSION["twitter"]["profile_image_url"]."',
						   email ='".$userName."'";
						   
				 $res = mysql_query($sql_social) or die("Recrod not insert in tbl_social_info" . mysql_error());
			  } 
			
			  // Update twitter response into tbl_user in corrponding user
			  $sqlquery = "UPDATE tbl_users
						set
						 oauth_provider ='twitter',
						 oauth_uid = '".$_SESSION["twitter"]["oauth_uid"]."',
						 username_tw='".$_SESSION["twitter"]["username"]."'
						 where email ='".$userName."'";
		
			  $res = mysql_query($sqlquery) or die("Recrod not insert in tbl_social_info" . mysql_error());   
			}
		}
//========================== End insert Twitter value in tbl_user ==================================


				if($remember == 'yes')
				{
					//one year
					$exp_time = time()+(60*60*24*365);
					
					setcookie('FGIsLogin','yes',$exp_time,'/');
					setcookie('FGUserId',$row_user["id"],$exp_time,'/');
					setcookie('FGUserName',$row_user["email"],$exp_time,'/');
					
				}else{
					//Until the session
					$exp_time = 0;
				} 
				//echo "SELECT * FROM tbl_artist WHERE id ='".$row_user['id']."'"; exit;
			
				$refercode=getPassword(8);
				//echo "SELECT refrencecode FROM tbl_artist WHERE id ='".$row_user['id']."' and refrencecode!=''"; exit;
				$que_ref_code=mysql_query("SELECT refrencecode FROM tbl_artist WHERE id ='".$row_user['id']."' and refrencecode!=''");
				if(mysql_num_rows($que_ref_code)>0)
				{
				
				}else{
				
					mysql_query("update tbl_artist set refrencecode='$refercode' where id='".$row_user['id']."'");
				}
				
				//$row_ref_cod = mysql_fetch_array($que_ref_code);
				//echo $row_ref_cod['refrencecode']; exit;
				
				mysql_query("update tbl_users set lastlogin=NOW() where id=".$row_user['id']);
				
				$_SESSION["fglogin"]["userid"] = $row_user['id'];
				$_SESSION["fglogin"]["fname"] = $row_user['fname'];
				$_SESSION["fglogin"]["usertype"] = $row_user['usertype'];
				$_SESSION["fglogin"]["email"] = $row_user['email'];
				$_SESSION["fglogin"]["usercity"] = $row_user['city'];
				$_SESSION["fglogin"]["IsLogin"] = 'yes';
				
				$_SESSION['fglogin']["succss"] = "You are Loged In Successfully.";
				//setcookie("evsuserlogin", $login, time()+ 60*60*24*30, "/");
				
				if($row_user['usertype']=='4' && !empty($row_user['city']))
				{
				    $qry_city=mysql_query("select category_id from tbl_categories where category_name='".$row_user['city']."'");
					$row_city=mysql_fetch_array($qry_city);
					
				   $exp_time = time()+(60*60*24*365);
				 	setcookie('fgcityid',$row_city['category_id'],$exp_time,'/');
					
					//$stateid = Get_StateID($row_user['state']);
					//$statecity = Get_Statecity_ID($stateid['RegionID'],$row_user['city']);
					//print_r($statecity);exit;
					if(!empty($row_user['city']) && !empty($row_user['state']) ){
						$stateid = Get_State($row_user['state']);
						
						$message['URL'] = "studies/cities/".mystr($stateid['Region'])."/".mystr($row_user['city']);
						//$message['URL'] = "dashboard";
					}else{
						$message['URL'] = "updateprofilenew/";
					}
					$_SESSION['study_milies_temp_1st'] = 'yes';
					
					if($row_user['paymentstatus'] == '1'){
						$sqlqry_country=mysql_query("SELECT * from tbl_pay WHERE user_id = '".$row_user['id']."' ORDER BY id DESC  ");
						if(mysql_num_rows($sqlqry_country) > 0)
						{
							$row_country = mysql_fetch_assoc($sqlqry_country);
							$today = date('Y-m-d');
							
							$diff = days_left($today, $row_country['exp_date']);
							if($diff < 0)
							{
								$querygroupcod="update tbl_artist set pay_type = '' , paymentstatus = '0' where id = '".$_SESSION["fglogin"]["userid"]."'";
								mysql_query($querygroupcod);
							}
						}
					
					}
				}
				
								
				$today = date('Y-m-d');
				$diff_expiry = days_left($today, $row_user['sub_exp_date']);
				//echo '-'.$diff_expiry.'-<br>' ;exit;
				if(($row_user['sub_exp_date'] != '0000-00-00' && $diff_expiry == '') || $diff_expiry != '' && $diff_expiry <=0)
				{
					$querygroupcod="update tbl_users set pay_type = '' , paymentstatus = '0', sub_exp_date = '0000-00-00' where id = '".$_SESSION["fglogin"]["userid"]."'";
					mysql_query($querygroupcod);
				}
				
				$UserInfo_Code = Get_UserInfo($_SESSION["fglogin"]["userid"]);
				$InvitaionInfoAll = Get_InvitaionInfoAll($UserInfo_Code['refrencecode']);
				
				//$mosConfig_paidpar_basic  = 	5;
				//$mosConfig_paidpar_full = 		10;
				$mosConfig_paidpar_basic  = 	4;
				$mosConfig_paidpar_full = 		5;

				if($InvitaionInfoAll['refcount'] > $mosConfig_paidpar_basic && $row_user['pay_type'] != 'premium_full' && $row_user['pay_type'] != 'premium_basic' && $row_user['usertype']=='4'){
					$querygroupcode="update tbl_artist set pay_type = 'premium_basic' , paymentstatus = '0' where id = '".$_SESSION["fglogin"]["userid"]."'";
					mysql_query($querygroupcode);
				}
				
				if($InvitaionInfoAll['refcount'] > $mosConfig_paidpar_full && $row_user['pay_type'] != 'premium_full' && $row_user['usertype']=='4'){
					$querygroupcode="update tbl_artist set pay_type = 'premium_full' , paymentstatus = '0' where id = '".$_SESSION["fglogin"]["userid"]."'";
					mysql_query($querygroupcode);
				}
				
				
				
				$message['status'] = 'Success';
				$message['usertype'] = $row_user['usertype'];
				$message['user_name'] = $userName;			
			}
			
		}else{
			$qry_user = "select * from tbl_artist where email = '".$userName."' AND password = '".md5($password)."' AND status = 'p'";
			$res_user = mysql_query($qry_user);
			if(mysql_num_rows($res_user)==1)
			{
				$message['status'] = 'Info_pending';
			}else{
				$message['status'] = 'InvalidInfo';
			}
		}
	}
	else{
		$message['status'] = 'InvalidInfo';
	}
	
	return $message;
}

function validate_username_joinfgglobal($username)
{
	global $_ERR;
	if($username == '')
	{
		$response = 'empty';
	}
	else
	{
		if(preg_match('/(\s)/',$username))
		{
			$response = 'invalid';
		}		
		elseif(preg_match('/[[:punct:]]/',$username))
		{
			$response = 'invalidChar';
		}
		elseif(preg_match('/(.*)admin(.*)/i',$username))
		{			
			$response = 'invalidAdmin';
		}
		elseif(strlen($username) > 20)
		{
			$response = 'tooLong';
		}
		else
		{
			$qry_user = "select * from tbl_artist where username = '".$username."' ";
			$res_user = mysql_query($qry_user);
			
			if(mysql_num_rows($res_user) > 0)
			{
				$user_ret_val = true;
			}else{
				$user_ret_val = false;
			}
			//$user_ret_val = getUserId($username);
			if($user_ret_val == true)
			{
				$response = 'isTaken';
			}
			else
			{
				$response = 'available';
			}
		}
	}
	return $response;
}

function email_validation_joinfgglobal($email)
{
	global $_ERR;
	if($email == '')
	{
		$response = 'empty';
	}
	else
	{
		if( strlen($email) > 50)
		{
			 $response='tooLong';
	    }
		elseif(!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
		{
			$response = 'invalid';
		}
		else
		{
			$qry_count_email = mysql_query("select count(id) from tbl_artist where email = '".$email."'");
			$row_count_email = mysql_fetch_array($qry_count_email);
			if($row_count_email[0] > 0)
			{
				$response = 'used';
			}
			else
			{
				$response = 'success';
			}			
		}
	}
	return $response;
}

function sign_up_user($username,$realname,$emailaddress,$password,$invitecode,$invitationCount)
{ 

	$qry_reg = "insert into tbl_artist set full_name = '".strip_tags(trim($realname))."', username = '".strip_tags(trim($username))."', 
	email = '".strip_tags(trim($emailaddress))."', password = '".md5(strip_tags(trim($password)))."', status = 'a', add_date = CURDATE()"; 

	if(mysql_query($qry_reg))
	{
		$user_id = mysql_insert_id();
		
		$_SESSION["fglogin"]["userid"] = $user_id;
		$_SESSION["fglogin"]["fname"] = $_POST["full_name"];
		$_SESSION["fglogin"]["username"] = $_POST["email"];
		$_SESSION["fglogin"]["email"] = $_POST['email'];
		$_SESSION["fglogin"]["IsLogin"] = 'yes';
		
		$_SESSION['signup_process'] = 'yes';
		$_SESSION['sinuptime'] = 48;

		$time = time();
		unset($_SESSION["FIELDS"]);
		
		return true;
	}
	else
	{
		return false;
	}
	
}


function buildAltBody( $recipient ) {
    /* using global to avoid touching parameters on sendmail_? functions */
    global $newsletter_id;
$newsletter_id="RKFLR11";
    $body = <<<BODY
******************************  NewsLetter *****************************
If you can see this text, then you are not using an HTML enabled
email client or your email client could not interpret this HTML.

             Please read the following instructions!

This is a posting from FGGlobal for $recipient.
To manage your profile, click on the following link:
            http://www.bbb.com/login

You can modify or delete your profile there. You may also forward this
email to unsubscribe@fgglobal.com stating that you wish to be removed
from FGglobal. Please include this text section in your email.

Read this newsletter online by visiting


Please disregard all the text below as it is HTML formatted text
******************************  NewsLetter *****************************
BODY;
    return $body;
}

function sendMail_Notic($from, $fromname, $recipient, $recipientname, $subject, $body)
{ 
//echo $from.'<br>'.$fromname.'<br>'. $recipient.'<br>'. $recipientname.'<br>'. $subject.'<br>'. $body ; exit;

		$msg = $body;
		$mail             = new PHPMailer();
		$mail->Sender = $from;
		//$mail->IsSendmail(true);
		$mail->IsHTML(true);
	
		$mail->SetFrom($from, $fromname);
		$mail->AddReplyTo($from,$fromname);
		$mail->Subject    = $subject;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
		$mail->MsgHTML($msg);
		$address = $recipient;
		$mail->AddAddress($address, $recipientname);
		
		 $mail->Send();
		
	
}

function sendMail_Notic_SMTP($from, $fromname, $recipient, $recipientname, $subject, $body)
{

		/*$msg = $body;
		$mail             = new PHPMailer();
		//$body             = file_get_contents('contents.html');
		//$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = "smtp.1and1.com"; // SMTP server
		$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->Host       = "smtp.1and1.com"; // sets the SMTP server
		$mail->Port       = 587;                    // set the SMTP port for the GMAIL server
		$mail->Username   = "support@fgglobal.com"; // SMTP account username
		$mail->Password   = "test123";        // SMTP account password
		
		$mail->SetFrom($from, $fromname);
		$mail->AddReplyTo($from,$fromname);
		$mail->Subject    = $subject;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($msg);
		$address = $recipient;
		$mail->AddAddress($address, $recipientname);
		
		//$mail->AddAttachment("images/phpmailer.gif");      // attachment
		//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
		
		$mail->Send();
		//$mail->ErrorInfo;*/
		
		$msg = $body;
		// instantiate the class and send email to user
		$mailer = new PHPMailer();
		// Set the subject
		$mailer->Subject = $subject;
		// Body
		$mailer->Body = $msg;
		// Add an address to send to.
		$mailer->AddAddress( $recipient , $recipientname);
		
		$mailer->FromName = $fromname;
		$mailer->From = $from;
		$mailer->IsHTML(true);
		$mailer->Send();
}


function uploadimage($imagename, $ext, $pathdir, $old_imagename, $filesize){
	
	$photo_filename = $imagename['name'];
	$photo_tmpname  = $imagename['tmp_name'];
	$photo_type 	= $imagename['type'];
	$photo_size 	= $imagename['size'];
	
	$explode_photo_image 	= explode(".",$photo_filename);
	$explode_photo_image[1] = strtolower($explode_photo_image[1]);
	
	if(in_array($explode_photo_image[1], $ext) && $photo_size < $filesize){
		
		$photo_image = str_replace(".","",str_replace(" ","",date("YmdHis").microtime())).".".$explode_photo_image[1];	
		
		//@chmod($pathdir,0777);
		$photo_valid = move_uploaded_file($photo_tmpname,$pathdir.$photo_image);
		
		if($photo_valid){
			$nameimage = $photo_image;
			if(!empty($old_imagename) && $old_imagename != 'default.gif'){
				@unlink($pathdir.$old_imagename);
			}
		}else{
			$nameimage = '';
		}
	}else{
		$nameimage = $old_imagename;
	}
	
	return $nameimage;
}

function Get_Venue_CategoryCount($catid)
{
	$sqlqry_venue=mysql_query("SELECT Count(id) AS categorycount from tbl_venue WHERE category = '$catid' AND status = '1' ");
	$row_venue = mysql_fetch_assoc($sqlqry_venue);

	return $row_venue;
}

function Get_Countries($id)
{
	$sqlqry_country=mysql_query("SELECT * from tbl_countries WHERE CountryId = '$id'");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
	
}


function Get_State_ID($id)
{
	$sqlqry_country=mysql_query("SELECT * from tbl_state WHERE Region = '$id'");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_Statecity_ID($id,$cityname)
{

	$sqlqry_country=mysql_query("SELECT * from tbl_city WHERE RegionID = '$id' AND City = '$cityname'");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_Statecity_CoutID($cityname)
{
	$sqlqry_country=mysql_query("SELECT * from tbl_city WHERE CountryID = '254' AND City = '$cityname'");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

/*function Get_State($id)
{
	$sqlqry_country=mysql_query("SELECT * from tbl_state WHERE RegionID = '$id' ");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}*/

function Get_StateID($name)
{

	$sqlqry_country=mysql_query("SELECT * from tbl_state WHERE Region = '$name' AND CountryID= '254' ");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_State_Code($code)
{
	$sqlqry_country=mysql_query("SELECT * from tbl_state WHERE  CountryID = '254' AND Code = '$code' ");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_UserInfo($id)
{
	 $sqlqry_user=mysql_query("SELECT * from tbl_artist WHERE id = '$id'"); 
	if(mysql_num_rows($sqlqry_user) > 0)
	{
		$row_user = mysql_fetch_assoc($sqlqry_user);
		return $row_user;
	}
	
}

function Get_FacilityInfoAll()
{
	$sqlqry_user=mysql_query("SELECT Count(id) AS cmscount from tbl_cms  where (showon='1' OR showon='3') and status='1'");
	if(mysql_num_rows($sqlqry_user) > 0)
	{
		$row_user = mysql_fetch_assoc($sqlqry_user);
		return $row_user;
	}
	
}

function Get_InvitaionInfoAll($ref)
{
	$sqlqry_user=mysql_query("SELECT Count(id) AS refcount from tbl_invitation  where refrelcode='$ref' ");
	if(mysql_num_rows($sqlqry_user) > 0)
	{
		$row_user = mysql_fetch_assoc($sqlqry_user);
		return $row_user;
	}
	
}

function Get_CategoryInfo($id)
{ 

	$sqlqry=mysql_query("SELECT * from  tbl_categories  WHERE category_id = '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}

}

function Get_CategoryInfo_name($cityname, $statename)
{
	$sqlqry=mysql_query("SELECT * from  tbl_categories  WHERE category_name	= '$cityname' AND state_name = '$statename'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}

}

function Get_PaymentInfo($id)
{
	$sqlqry=mysql_query("SELECT * from  tbl_setting_package  WHERE package_name = '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}
}


function addcustom_day($days)
{
	$adddays_qry = mysql_query("SELECT NOW() + INTERVAL '$days' DAY AS expiredate");
	$addeddays = mysql_fetch_array($adddays_qry);
    return $addeddays['expiredate']; 
}

function Get_Ads($pos, $type, $city, $page_b )
{



//echo "SELECT * from  tbl_banners  WHERE banner_category = '$type' AND (city = '$city' OR city = 'nationwide')  AND page = '$page_b' AND study_position = '$pos' AND banner_status='1'  order by rand() LIMIT 0, 1 ";

	$sqlqry=mysql_query("SELECT * from  tbl_banners  WHERE banner_category = '$type' AND (city = '$city' OR city = 'nationwide')  AND page = '$page_b' AND study_position = '$pos' AND banner_status='1'  order by rand() LIMIT 0, 1 ");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}
}


function Get_StudyInfo($id)
{
	$sqlqry=mysql_query("SELECT * from  tbl_poststudy  WHERE id = '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}

}


function mystr($title)
{          
	$title=str_replace(" ","_",trim(stripslashes($title)));			 
	$title=str_replace('&','and', $title);
	$title=str_replace('/','_', $title);		
	$title=str_replace("'",'_', $title);
	$title=str_replace("-",'_', $title);
	$title=str_replace(",",'_', $title);
	$title=str_replace("__",'_', $title); 
	$title=str_replace("__",'_', $title); 
	$title=str_replace("__",'_', $title); 
	
	return $title;
}
function mystr_url($title)
{      

	/*$title=strtolower($title);
$code_entities_match = array(' ','&quot;','!','@','#','$','%','^','&','*','(',')','_','+','{','}','|',':','"','<','>','?','[',']','\\',';',"'",',','.','/','*','+','~','`','=','--');
$code_entities_replace = array('-','','','','','','','','','','','','','','','','','','','','','','','','','','-');
$title = str_replace($code_entities_match, $code_entities_replace, $title); */   
	$title=strtolower($title);
	$title=str_replace(' ','-',trim(stripslashes($title)));			 
	$title=str_replace('/','', $title);	
	$title=str_replace('&','', $title);		
	$title=str_replace("'",'', $title);
	$title=str_replace(",",'', $title);
	$title=str_replace("__",'', $title); 
	$title=str_replace("__",'', $title); 
	$title=str_replace("__",'', $title);
	$title=str_replace("!",'', $title); 
	$title=str_replace("@",'', $title);
	$title=str_replace("#",'', $title);
	$title=str_replace("$",'', $title);
	$title=str_replace("%",'', $title);
	$title=str_replace("^",'', $title);
	$title=str_replace("*",'', $title);
	$title=str_replace("(",'', $title);
	$title=str_replace(")",'', $title);
	$title=str_replace("+",'', $title);
	$title=str_replace("=",'', $title);
	$title=str_replace("{",'', $title);
	$title=str_replace("}",'', $title);
	$title=str_replace("[",'', $title);
	$title=str_replace("]",'', $title);
	$title=str_replace(":",'', $title);
	$title=str_replace(";",'', $title);
	$title=str_replace("|",'', $title);
	$title=str_replace('&lt','', $title);
	$title=str_replace('&gt','', $title);
	$title=str_replace(",",'', $title);
	$title=str_replace(".",'', $title);
	$title=str_replace('?','', $title);
	$title=str_replace("_",'', $title);
	$title=str_replace("`",'', $title);
	$title=str_replace("~",'', $title);
	$title=str_replace("--",'-', $title);
	$title=str_replace('&amp','', $title);
	$title=str_replace('&quot','', $title);
	$title=str_replace('&nbsp','', $title);
	$title=str_replace('&euro','', $title);
	$title=str_replace('&divide','', $title);
	$title=str_replace('&deg','', $title);
	$title=str_replace('&para','', $title);
	$title=str_replace('&plusmn','', $title);
	$title=str_replace('&lsquo','', $title);
	$title=str_replace('&rsquo','', $title);
	$title=str_replace('&ldquo','', $title);
	$title=str_replace('&rdquo','', $title);
	$title=str_replace('&bdquo','', $title);
	$title=str_replace('&lsaquo','', $title);
		
	return $title;
}

function mystr_rec($title)
{          
	$title=str_replace("_"," ",trim(stripslashes($title)));			 
	//$title=str_replace('and','&', $title);
	$title=str_replace('_','/', $title);		
	
	return $title;
}

function mystr_quot($title)
{          
	
	$title=str_replace('"','&quot;',$title);			 
	return $title;
}

function mystr_quot_rec($title)
{          
	$title=str_replace('&quot;','"',$title);			 
	return $title;
}

if (!function_exists('json_encode'))
{
  function json_encode($a=false)
  {
    if (is_null($a)) return 'null';
    if ($a === false) return 'false';
    if ($a === true) return 'true';
    if (is_scalar($a))
    {
      if (is_float($a))
      {
        // Always use "." for floats.
        return floatval(str_replace(",", ".", strval($a)));
      }

      if (is_string($a))
      {
        static $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"'));
        return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"';
      }
      else
        return $a;
    }
    $isList = true;
    for ($i = 0, reset($a); $i < count($a); $i++, next($a))
    {
      if (key($a) !== $i)
      {
        $isList = false;
        break;
      }
    }
    $result = array();
    if ($isList)
    {
      foreach ($a as $v) $result[] = json_encode($v);
      return '[' . join(',', $result) . ']';
    }
    else
    {
      foreach ($a as $k => $v) $result[] = json_encode($k).':'.json_encode($v);
      return '{' . join(',', $result) . '}';
    }
  }
}


function GetAge($Birthdate)
{
        // Explode the date into meaningful variables

        list($BirthYear,$BirthMonth,$BirthDay) = explode("-", $Birthdate);
        // Find the differences
        $YearDiff = date("Y") - $BirthYear;

        $MonthDiff = date("m") - $BirthMonth;
		
        $DayDiff = date("d") - $BirthDay;

        // If the birthday has not occured this year

        if ($DayDiff < 0 || $MonthDiff < 0)

          $YearDiff--;

        return $YearDiff;
}
//Time differenciation fuction

function get_time_difference( $start, $end )
{

    $uts['start']      =    strtotime( $start );
    $uts['end']        =    strtotime( $end );

    if( $uts['start']!==-1 && $uts['end']!==-1 )
    {
		
        if( $uts['end'] >= $uts['start'] )
        {
            $diff    =    $uts['end'] - $uts['start'];
            if( $days=intval((floor($diff/86400))) )
                $diff = $diff % 86400;
            if( $hours=intval((floor($diff/3600))) )
                $diff = $diff % 3600;
            if( $minutes=intval((floor($diff/60))) )
                $diff = $diff % 60;
            $diff    =    intval( $diff );       
		
            return( array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff) );
        }
        else
        {
		
            trigger_error( "Ending date/time is earlier than the start date/time", E_USER_WARNING );
        }
    }
    else
    {
        trigger_error( "Invalid date/time data detected", E_USER_WARNING );
    }
    return( false );
}

//Days difference
function daysDifference($endDate, $beginDate){
   $date_parts1=explode("-", $beginDate);
   $date_parts2=explode("-", $endDate);
   $start_date=gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
   $end_date=gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
   return $end_date - $start_date;
}

//Count Studies for companies
function studyCountComp($id, $stdyId){
	$sql = "SELECT * FROM tbl_poststudy WHERE user_id='".$id."' AND id='".$stdyId."' AND status != '2' ";
	$rs_sql = mysql_query($sql) or die('Oppps! some thing went wrong with query');
	$count = mysql_num_rows($rs_sql);
	return $count;
}
//Count Studies for companies
function studyCountComp_free($id, $stdyId){
	
	$sql = "SELECT * FROM tbl_poststudy WHERE user_id='".$id."' AND id='".$stdyId."' AND status != '2' AND date_exp >='$today' AND usertype='3'";
	$rs_sql = mysql_query($sql) or die('Oppps! some thing went wrong with query');
	$count = mysql_num_rows($rs_sql);
	return $count;
}


function remainingTime($datefrom,$dateto=-1)
{
	// Defaults and assume if 0 is passed in that
	// its an error rather than the epoch
	
	$dateto = strtotime(date("D M j G:i:s"));
	if($datefrom<=0) { return "Unknown Time Formate"; }
	if($dateto==-1) { $dateto = $dateto; }
	
	// Calculate the difference in seconds betweeen
	// the two timestamps
	
	$difference =  $datefrom - $dateto;
	
	// If difference is less than 0 ,
	// The question is expired now.
	
	if($difference < 0)
	{
		$interval = "x";
	}
	
	// If difference is less than 60 seconds,
	// seconds is a good interval of choice
	
	elseif($difference < 60)
	{
		$interval = "s";
	}
	
	// If difference is between 60 seconds and
	// 60 minutes, minutes is a good interval
	elseif($difference >= 60 && $difference<60*60)
	{
		$interval = "n";
	}
	
	// If difference is between 1 hour and 24 hours
	// hours is a good interval
	elseif($difference >= 60*60 && $difference<60*60*24)
	{
		$interval = "h";
	}
	
	// If difference is between 1 day and 7 days
	// days is a good interval
	elseif($difference >= 60*60*24 && $difference<60*60*24*7)
	{
		$interval = "d";
	}
	
	// If difference is between 1 week and 30 days
	// weeks is a good interval
	elseif($difference >= 60*60*24*7 && $difference < 60*60*24*30)
	{
		$interval = "ww";
	}
	
	// If difference is between 30 days and 365 days
	// months is a good interval, again, the same thing
	// applies, if the 29th February happens to exist
	// between your 2 dates, the function will return
	// the 'incorrect' value for a day
	elseif($difference >= 60*60*24*30 && $difference <
	60*60*24*365)
	{
		$interval = "m";
	}
	
	// If difference is greater than or equal to 365
	// days, return year. This will be incorrect if
	// for example, you call the function on the 28th April
	// 2008 passing in 29th April 2007. It will return
	// 1 year ago when in actual fact (yawn!) not quite
	// a year has gone by
	elseif($difference >= 60*60*24*365)
	{
		$interval = "y";
	}
	
	// Based on the interval, determine the
	// number of units between the two dates
	// From this point on, you would be hard
	// pushed telling the difference between
	// this function and DateDiff. If the $datediff
	// returned is 1, be sure to return the singular
	// of the unit, e.g. 'day' rather 'days'
	
	switch($interval)
	{
	case "m":
	$months_difference = ceil($difference / 60 / 60 / 24 /
	29);
	while (mktime(date("H", $datefrom), date("i", $datefrom),
	date("s", $datefrom), date("n", $datefrom)+($months_difference),
	date("j", $dateto), date("Y", $datefrom)) < $dateto)
	{
		$months_difference++;
	}
	$datediff = $months_difference;
	
	// We need this in here because it is possible
	// to have an 'm' interval and a months
	// difference of 12 because we are using 29 days
	// in a month
	
	if($datediff==12)
	{
		$datediff--;
	}
	
	$res = ($datediff==1) ? "$datediff month " : "$datediff
	months ";
	break;
	
	case "y":
	$datediff = floor($difference / 60 / 60 / 24 / 365);
	$res = ($datediff==1) ? "$datediff year " : "$datediff
	years ";
	break;
	
	case "d":
	$datediff = floor($difference / 60 / 60 / 24);
	$res = ($datediff==1) ? "$datediff day " : "$datediff
	days ";
	break;
	
	case "ww":
	$datediff = floor($difference / 60 / 60 / 24 / 7);
	$res = ($datediff==1) ? "$datediff week " : "$datediff
	weeks ";
	break;
	
	case "h":
	$datediff = ceil($difference / 60 / 60);
	$res = ($datediff==1) ? "$datediff hour " : "$datediff
	hours ";
	break;
	
	case "n":
	$datediff = ceil($difference / 60);
	$res = ($datediff==1) ? "$datediff minute " :
	"$datediff minutes ";
	break;
	
	case "s":
	$datediff = $difference;
	$res = ($datediff==1) ? "$datediff second " :
	"$datediff seconds ";
	break;
	
	
	case "x":
	$datediff = $difference;
	$res = ($datediff<=1) ? " Ended " :
	"Ended";
	break;
	}
	
return $res;
}
function caldiff($data_ref_end)
{
	$arr_dtime = explode(':', $data_ref_end);
	if($arr_dtime[0] > 1){
		if($arr_dtime[0] >= 24){
			$time = floor($arr_dtime[0]/24);
			$hr = $arr_dtime[0]-($time*24);
			$time = $time.' Days and '.$hr. ' hours ';
		}else{
			$time = $arr_dtime[0].' hours';
		}	
	}elseif($arr_dtime[0] == 1){
		$time = $arr_dtime[0].' hour';
	}elseif($arr_dtime[0] == 0 && $arr_dtime[1] > 0){
		if($arr_dtime[0] >= 0){
		if($arr_dtime[1] >= 30 && $arr_dtime[0] == 0){
			$time = 'Less than one hour';
		}elseif($arr_dtime[1] < 30 && $arr_dtime[0] == 0){
			$time = $arr_dtime[1].' minutes';
		}
		}elseif($arr_dtime[0] < 0){
			$time = 'Ended';
		}	
	}elseif($arr_dtime[0] < 0){
		$time = 'Ended';
	}
	elseif($arr_dtime[1] <= 0){
		if($arr_dtime[2] > 1){
			$time = $arr_dtime[2].' seconds';
		}elseif($arr_dtime[2] <= 1){
			$time = 'Ended';
		}elseif($arr_dtime[0] < 0 && $arr_dtime[1] < 0){
			$time = 'Ended';
		}	
	}
	return $time;
}


//Make Study URL
function Get_Study_URL($studyid, $linkfor, $ru, $userid){
	
	$code = new Encryption;
	
	$row_sel = Get_StudyInfo($studyid);
	
	$categoryinfo_shr = Get_CategoryInfo($row_sel['city']); 
	if($categoryinfo_shr){ $categorname_shr = $categoryinfo_shr['category_name']; }else{ $categorname_shr = 'Nationwide'; }
	
	if($row_sel['nation'] == 1){ //$categorname_shr == 'Nationwide' && 
		$studyy_url = $ru.'research/'.$row_sel['id'].'/{{sociallink}}/Nationwide/'.mystr_url(stripslashes($row_sel['study_title']));
	}else{
		$studyy_url = $ru.'research/'.$row_sel['id'].'/{{sociallink}}/'.mystr($categoryinfo_shr['state_name'])."/".mystr($categoryinfo_shr['category_name']).'/'.mystr_url(stripslashes($row_sel['study_title']));
	}
	

	if($linkfor == 'twitter'){
		$link 	= $code->encode("twitter^".$userid);
		$link 	= str_replace('{{sociallink}}', $link , $studyy_url); 
	}else if($linkfor == 'mailto'){
		$link 	= $code->encode("mailto^".$userid);
		$link 	= str_replace('{{sociallink}}', $link , $studyy_url);
	}else if($linkfor == 'digg'){		
		$link 	= $code->encode("digg^".$userid);
		$link 	= str_replace('{{sociallink}}', $link , $studyy_url);
	}else if($linkfor == 'facebook'){		
		$link 	= $code->encode("facebook^".$userid);
		$link 	= str_replace('{{sociallink}}', $link , $studyy_url);
	}else if($linkfor == 'google'){		
		$link 	= $code->encode("google^".$userid);
		$link 	= str_replace('{{sociallink}}', $link , $studyy_url);
	}else{
		$link 	= str_replace('{{sociallink}}/', '' , $studyy_url);
	}

	return $link;
}

function export2excel(){

//$conn = mysql_connect("localhost","evsof3_evs","evs2007");
//$db = mysql_select_db("fgglobal",$conn);
$dat = date("Y-m-d"); 
//echo $_SESSION['upd_list']; exit;
//$sql = "SELECT date_of_perticipation ,fname as first_name,phone as Phone_number, email FROM tbl_artist  ";
$sql = "SELECT county_name, email, add_date, ip FROM  tbl_international_user";
$rec = mysql_query($sql) or die (mysql_error());
   
    $num_fields = mysql_num_fields($rec);
   
    for($i = 0; $i < $num_fields; $i++ )
    {
        $header .= mysql_field_name($rec,$i)."\t";
    }
   
    while($row = mysql_fetch_row($rec))
    {
        $line = '';
        foreach($row as $value)
        {                                           
            if((!isset($value)) || ($value == ""))
            {
                $value = "\t";
            }
            else
            {
                $value = str_replace( '"' , '""' , $value );
                $value = '"' . $value . '"' . "\t";
            }
            $line .= $value;
        }
        $data .= trim( $line ) . "\n";
    }
   
    $data = str_replace("\r" , "" , $data);
   
    if ($data == "")
    {
        $data = "\n No Record Found!n";                       
    }
	
    $filename = "fgglobal_int_".date("Y-m-d_H-i",time());
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=".$filename.".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    print "$header\n$data";
}

function export2csv(){


$file = 'export';

$result = mysql_query("SHOW COLUMNS FROM tbl_international_user WHERE Field NOT IN ('id', 'county_id', 'STATUS');");
$i = 0;
if (mysql_num_rows($result) > 0) {
	while ($row = mysql_fetch_assoc($result)) {
		$csv_output .= $row['Field'].", ";
		$i++;
	}
}
$csv_output .= "\n";

$values = mysql_query("SELECT county_name, email, add_date, ip FROM tbl_international_user");
while ($rowr = mysql_fetch_row($values)) {
	for ($j=0;$j<$i;$j++) {
	$csv_output .= $rowr[$j].", ";
	}
	$csv_output .= "\n";
}

$filename = "fgglobal_int_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;

}
function exportuser2csv($cityname, $p_type){
//echo "<pre>";print_r($_POST);exit;

$file = 'export';
$where = "";

if($cityname == 'Nationwide'){

	if($p_type == 'sub'){
		$where = " usertype = '4' AND (study_perweek = '1' OR study_perweek = '3' OR study_perweek = '5') ";
	}elseif($p_type == 'unsub'){
		$where = " usertype = '4' AND study_perweek = '0' AND usertype = '4'";
	}else{
		$where = " usertype = '4'";
	}
}else{
	if($p_type == 'sub'){
		$where = " usertype = '4' AND city ='".$cityname."' AND (study_perweek = '1' OR study_perweek = '3' OR study_perweek = '5')";
	}elseif($p_type == 'unsub'){
		$where = " usertype = '4' AND  city ='".$cityname."' AND study_perweek = '0' ";
	}else{
		$where = " usertype = '4' AND city ='".$cityname."' ";
	}
}


$result = mysql_query("SHOW COLUMNS FROM tbl_artist WHERE Field IN ('email', 'city');");
$i = 0;
if (mysql_num_rows($result) > 0) {
	while ($row = mysql_fetch_assoc($result)) {
		$csv_output .= $row['Field'].", ";
		$i++;
	}
}
$csv_output .= "\n";
//echo "SELECT fname, lname,email,city FROM tbl_artist where city ='Chicago'"; exit;
//echo "SELECT city, email FROM tbl_artist where $where";exit;
$values = mysql_query("SELECT city, email FROM tbl_artist where $where");
while ($rowr = mysql_fetch_row($values)) {
	for ($j=0;$j<$i;$j++) {
	$csv_output .= $rowr[$j].", ";
	}
	$csv_output .= "\n";
}

$filename = "fgglobal_".mystr($cityname).'_'.$p_type.'_'.date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;

}


		
function getemail_icontact($userid,$fromemail,$fromname,$to,$subject,$msgg){

	// icontact username
	$user = "fgglobal";
	// application password
	$pass = "sheraz125dAn";
	// API Key
	$key    = "iPIEBJk3CbZsQGD2HS3T3vtt3uCsbMBj";
//=============================================================================
	// Build iContact Header(iContact authentication)
	//=============================================================================
	
	$headers = array(
	'Accept: text/xml',
	'Content-Type: text/xml',
	'Api-Version: 2.0',
	'Api-AppId: ' . $key,
	'Api-Username: ' . $user,
	'Api-Password: ' . $pass
	);
	$account_id      	= "808237";
	$client_folder_id 	= "5417";
	$list_id			= "27407";
	//$list_id			= "27451";
	//$contact_id="201910_66246357";
	//$list_id="202149";
	// icontact username


	$SQL	= "select * from tbl_artist where id='".$userid."'";
	$result	= mysql_query($SQL);
	$ROW	= mysql_fetch_array($result);

	$email=$ROW['email'];
	$fname=$ROW['fname'];
	$lname=$ROW['lname'];
	$phone=$ROW['phone'];
	$address=$ROW['address'];
	$city=$ROW['city'];
	$state=$ROW['state'];
	$address=$ROW['address'];
	$zip=$ROW['zip'];
	
	
	
	
		$data = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n<contacts>\r\n";
		$data.= "<contact>\r\n";
		$data.= "<email>$email</email>\r\n";
		$data.= "<firstName>$fname</firstName>\r\n";
		$data.= "<lastName>$lname</lastName>\r\n";
		$data.= "<status>normal</status>\r\n";
		$data.= "<street>$address</street>\r\n";
		$data.= "<phone>$phone</phone>\r\n";
		$data.= "<address>$address</address>\r\n";
		$data.= "<city>$city</city>\r\n";
		$data.= "<state>$country</state>\r\n";
		$data.= "</contact>\r\n</contacts>";
		
		//=============================================================================
		// Add contact
		//=============================================================================
	
		$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/contacts/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$buf = curl_exec($ch);
		curl_close($ch);
		$contact_id = "";
		if (($pos=strpos($buf,"<contactId>"))!==false)
		{
		$contact_id = substr($buf, $pos+strlen("<contactId>"));
		if (($pos=strpos($contact_id,"<"))!==false)
		{
		 $contact_id = substr($contact_id,0,$pos);
		}
		}
		$contact_id;
		
		$QUERY="update tbl_artist set contact_id='".$contact_id."' where id='".$userid."'";
		$result=mysql_query($QUERY);
	
		//update of tbl_queue
		$QUERY="update tbl_queue set contact_id='".$contact_id."' where to_email='".$email."'";
		$result=mysql_query($QUERY);

	//
//=============================================================================
		//  Build subscriptions
		//=============================================================================
		
		$detail = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
		$detail.= "<subscriptions>\r\n";
		$detail.= "<subscription>\r\n";
		$detail.= "<contactId>$contact_id</contactId>\r\n";
		$detail.= "<listId>$list_id</listId>\r\n";
		$detail.= "<status>normal</status>\r\n";
		$detail.= "</subscription>\r\n</subscriptions>";
		$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/subscriptions");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$buf = curl_exec($ch);
		curl_close($ch);
		//=============================================================================
		//  Build Campaign
		//=============================================================================
	
		$detail="<campaigns>
		   <campaign>
			   <name>Study Campaign</name>
			   <description>Campaign For Study</description>
			   <fromEmail>$fromemail</fromEmail>
			   <fromName>$fromname</fromName>
			   <forwardToFriend>1</forwardToFriend>
			   <clickTrackMode>1</clickTrackMode>
			   <subscriptionManagement>1</subscriptionManagement>
			   <useAccountAddress>1</useAccountAddress>
			   <street>PO Box 1384</street>
			   <city>Chicago</city>
			   <state>NC</state>
			   <zip>60690</zip>
			   <country>USA</country>
			   <archiveByDefault>1</archiveByDefault>
		  </campaign>
		  </campaigns>";
		
	
		$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/campaigns/");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$buf = curl_exec($ch);
		curl_close($ch);
		$contact_id = "";
		if (($pos=strpos($buf,"<campaignId>"))!==false)
		{
		$contact_id = substr($buf, $pos+strlen("<campaignId>"));
		if (($pos=strpos($contact_id,"<"))!==false)
		{
		 $contact_id = substr($contact_id,0,$pos);
		}
		}
	   $contact_id;
	  
//=============================================================================
		//  Build Massage
		//=============================================================================
	
		$detail ="<messages>
			 <message>
				<campaignId>$contact_id</campaignId>
				<subject>FGGLOBAL NewsLetter Evsoft</subject>
				<messageType>normal</messageType>
				<messageName>News Letter From Fgglobal</messageName>
				<htmlBody><![CDATA[<p>$msgg</p>]]></htmlBody>
				<textBody></textBody>
				
			</message>
			</messages>";

		$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/messages");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$buf = curl_exec($ch);
		curl_close($ch);
		
		
		
		$message_id = "";
		if (($pos=strpos($buf,"<messageId>"))!==false)
		{
		$message_id = substr($buf, $pos+strlen("<messageId>"));
		if (($pos=strpos($message_id,"<"))!==false)
		{
		 $message_id = substr($message_id,0,$pos);
		}
		}
		$message_id;
		//exit;
		//=============================================================================
		//  Build to send
		//=============================================================================
		
		
		$detail = "<sends>
			<send>
				<messageId>$message_id</messageId>
				<includeListIds>$list_id</includeListIds>
				</send>
		</sends>";
		
		$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/sends");
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$buf = curl_exec($ch);
		curl_close($ch);
		$t=$detail;
		return $t;
		


}



//*****************************************************************************
// iContact Functions
//*****************************************************************************
function Create_iContactList(){
	
		$user = "fgglobal";
		// application password
		$pass = "sheraz125dAn";
		// API Key
		$key    = "iPIEBJk3CbZsQGD2HS3T3vtt3uCsbMBj";
		
		//=============================================================================
		// Build iContact Header(iContact authentication)
		//=============================================================================
		
		$headers = array(
		'Accept: text/xml',
		'Content-Type: text/xml',
		'Api-Version: 2.0',
		'Api-AppId: ' . $key,
		'Api-Username: ' . $user,
		'Api-Password: ' . $pass
		);
		$account_id      = "808237";
		$client_folder_id = "5417";
	
		$res=mysql_query("select category_id,category_name from tbl_categories WHERE active_status = '1' AND list_id = 0 ");
		if(mysql_num_rows($res)){
			while($row=mysql_fetch_assoc($res))
			{
				$name = $row['category_name'].'_fgglobal_list';
			
				//=============================================================================
				// Add List
				//=============================================================================
		
				$data = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n<lists>\r\n";
				$data.= "<list>\r\n";
				$data.= "<name>$name</name>\r\n";
				$data.= "</list>\r\n</lists>";
				
				//=============================================================================
				// Add contact
				//=============================================================================
			
				$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/lists/");
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				$buf = curl_exec($ch);
				curl_close($ch);
				
				$list_id = "";
				if (($pos=strpos($buf,"<listId>"))!==false)
				{
				$list_id = substr($buf, $pos+strlen("<listId>"));
				if (($pos=strpos($list_id,"<"))!==false)
				{
				 $list_id = substr($list_id,0,$pos);
				}
				}
				
				$update_listid = mysql_query("UPDATE tbl_categories SET list_id='".$list_id."' WHERE category_id = '".$row['category_id']."' ");
				
			}
		}
	}
	
function Add_ToiContact_list(){
	$user = "fgglobal";
	// application password
	$pass = "sheraz125dAn";
	// API Key
	$key    = "iPIEBJk3CbZsQGD2HS3T3vtt3uCsbMBj";
	
	//=============================================================================
	// Build iContact Header(iContact authentication)
	//=============================================================================
	
	$headers = array(
	'Accept: text/xml',
	'Content-Type: text/xml',
	'Api-Version: 2.0',
	'Api-AppId: ' . $key,
	'Api-Username: ' . $user,
	'Api-Password: ' . $pass
	);
	$account_id      = "808237";
	$client_folder_id = "5417";
	$list_id = '27765';
	
	//=============================================================================
	// Add User
	//=============================================================================
	
	$DS_SUB = mysql_query("SELECT * FROM tbl_admin WHERE Id=1") or die(mysql_error());
	$row_DSUB = mysql_fetch_assoc($DS_SUB);
	$study_duration = stripslashes($row_DSUB['study_duration']);
	
	
	//echo "select id,fname,lname,email,address,phone,city,state from tbl_artist WHERE usertype='4' AND status = 'a' AND study_perweek != '0' and contact_id = 0 and date_of_perticipation <= DATE_SUB(CURDATE(), INTERVAL $study_duration DAY)";exit;
	$qry_userinfo=mysql_query("select id,fname,lname,email,address,phone,city,state from tbl_artist WHERE usertype='4' AND status = 'a' AND study_perweek != '0' and contact_id = 0 and date_of_perticipation <= DATE_SUB(CURDATE(), INTERVAL $study_duration DAY)");//AND (pay_type = '' OR pay_type = 'free') 
	if(mysql_num_rows($qry_userinfo)){

		while($row=mysql_fetch_array($qry_userinfo))
		{
			
			$userid=$row['id'];
			$email=$row['email'];
			$fname=$row['fname'];
			$lname=$row['lname'];
			$address=$row['address'];
			$age=$row['age'];
			$phone=$row['phone'];
			$city=$row['city'];
			$state=$row['state'];

			$data = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n<contacts>\r\n";
			$data.= "<contact>\r\n";
			$data.= "<email>$email</email>\r\n";
			$data.= "<firstName>$fname</firstName>\r\n";
			$data.= "<lastName>$lname</lastName>\r\n";
			$data.= "<status>normal</status>\r\n";
			$data.= "<street>no street</street>\r\n";
			$data.= "<phone>$phone</phone>\r\n";
			$data.= "<address>$address</address>\r\n";
			$data.= "<city>$city</city>\r\n";
			$data.= "<state>$state</state>\r\n";
			$data.= "</contact>\r\n</contacts>";
			
			//=============================================================================
			// Add contact
			//=============================================================================
		
			$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/contacts/");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$buf = curl_exec($ch);
			curl_close($ch);
			
			$contact_id = "";
			if (($pos=strpos($buf,"<contactId>"))!==false)
			{
				$contact_id = substr($buf, $pos+strlen("<contactId>"));
				if (($pos=strpos($contact_id,"<"))!==false)
				{
					$contact_id = substr($contact_id,0,$pos);
				}
			}
			
			//=============================================================================
			//  Build subscriptions
			//=============================================================================
			
			$detail = '<?xml version="1.0" encoding="UTF-8"?>'."\r\n";
			$detail.= "<subscriptions>\r\n";
			$detail.= "<subscription>\r\n";
			$detail.= "<contactId>$contact_id</contactId>\r\n";
			$detail.= "<listId>$list_id</listId>\r\n";
			$detail.= "<status>normal</status>\r\n";
			$detail.= "</subscription>\r\n</subscriptions>";
			
			$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/subscriptions");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			$buf = curl_exec($ch);
			curl_close($ch);
			//update contact id in user table
			$update_listid = mysql_query("UPDATE tbl_artist SET contact_id='".$contact_id."' WHERE id = '".$userid."' ");
			
		}
	}
}

function Send_iContat_message($frmemail,$frmname,$subject,$body,$list_id){
	$user = "fgglobal";
	// application password
	$pass = "sheraz125dAn";
	// API Key
	$key    = "iPIEBJk3CbZsQGD2HS3T3vtt3uCsbMBj";
	
	//=============================================================================
	// Build iContact Header(iContact authentication)
	//=============================================================================
	
	$headers = array(
	'Accept: text/xml',
	'Content-Type: text/xml',
	'Api-Version: 2.0',
	'Api-AppId: ' . $key,
	'Api-Username: ' . $user,
	'Api-Password: ' . $pass
	);
	$account_id      = "808237";
	$client_folder_id = "5417";
	
	
	$detail="<campaigns>
			   <campaign>
				   <name>Fgglobal weekly newsletter</name>
				   <description>Fgglobal weekly newsletter</description>
				   <fromEmail>".$frmemail."</fromEmail>
				   <fromName>".$frmname."</fromName>
				   <forwardToFriend>3</forwardToFriend>
				   <clickTrackMode>1</clickTrackMode>
				   <subscriptionManagement>1</subscriptionManagement>
				   <useAccountAddress>1</useAccountAddress>
				   <street>2635 Meridian Parkway</street>
				   <city>Chicago</city>
				   <state>NC</state>
				   <zip>27713</zip>
				   <country>USA</country>
				   <archiveByDefault>1</archiveByDefault>
			  </campaign>
			</campaigns>";
	
	
	$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/campaigns/");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$buf = curl_exec($ch);
	curl_close($ch);
	$contact_id = "";
	if (($pos=strpos($buf,"<campaignId>"))!==false)
	{
	$contact_id = substr($buf, $pos+strlen("<campaignId>"));
	if (($pos=strpos($contact_id,"<"))!==false)
	{
	 $contact_id = substr($contact_id,0,$pos);
	}
	}
	$contact_id;
	
	//=============================================================================
	//  Build Massage
	//=============================================================================
	
	$detail ="<messages>
		 <message>
			<campaignId>$contact_id</campaignId>
			<subject>".$subject."</subject>
			<messageType>normal</messageType>
			<messageName>News Letter From Fgglobal MOEEZ</messageName>
			<htmlBody><![CDATA[<p>".$body."</p>]]></htmlBody>
			<textBody></textBody>
		</message>
		</messages>";
	
	$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/messages");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$buf = curl_exec($ch);
	curl_close($ch);
	
	
	
	$message_id = "";
	if (($pos=strpos($buf,"<messageId>"))!==false)
	{
	$message_id = substr($buf, $pos+strlen("<messageId>"));
	if (($pos=strpos($message_id,"<"))!==false)
	{
	 $message_id = substr($message_id,0,$pos);
	}
	}
	$message_id;
	//exit;
	//=============================================================================
	//  Build to send
	//=============================================================================
	
	
	$detail = "<sends>
		<send>
			<messageId>$message_id</messageId>
			<includeListIds>$list_id</includeListIds>
			</send>
	</sends>";
	
	$ch=curl_init("https://app.icontact.com/icp/a/$account_id/c/$client_folder_id/sends");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $detail);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	$buf = curl_exec($ch);
	//echo " ".$buf."<br>";
	curl_close($ch);
	
	
}


function Send_NewsLetter($categoryinfo,$newlettertitle,$sendtype,$mosConfig_live_site){
	
	$DS_SUB = mysql_query("SELECT * FROM tbl_admin WHERE Id=1") or die(mysql_error());
	$row_DSUB = mysql_fetch_array($DS_SUB);
	$study_duration = stripslashes($row_DSUB['study_duration']);
	
	$queryedit= mysql_query("select * from tbl_newsletters where newsletters_id=$newlettertitle");
	$row_title=mysql_fetch_assoc($queryedit);
	
	$qry_mail_setting = mysql_query("Select * from tbl_admin");
	$row_mail_setting=mysql_fetch_assoc($qry_mail_setting);

	$mail_setting = $row_mail_setting['email_queue'];
	$today = date('Y-m-d H:i:s', time());
	$formateddate = date("F j, Y");
	
	$studfree_tbl = '
					<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
					<td width="10"></td>
					<td align="left" height="43" style="border-bottom: solid 2px #eeeed7; background-color:#f0f0ee; padding-left:10px;"><span style=" font-family:Arial; font-size:18px; color:#333333; font-weight:bold;">Free Stuff</span> </td>
					</tr>
					<tr>
					<td width="10">
					</td>
					<td align="left" height="43" style=" background-color:#f0f0ee; padding-left:10px;">
					<table cellpadding="0" cellspacing="0" width="100%">
					<tr>
					<td width="120"  height="43">
					<table cellpadding="0" cellspacing="0" width="120">
					<tr>
					
					<td width="10"></td>
					<td height="25" align="left" valign="top" style="padding-left:5px;">
					<span style="font-family:Arial; color:#000; font-size:13px; font-weight:bold; line-height:15px;">Recruiting Until</span>
					</td>
					</tr>
					</table>
					</td>
					<td style="padding-left:15px; padding-top:4px;" valign="top" width="325">
					<span style="font-family:Arial; color:#000; line-height:22px; font-size:13px; font-weight:bold; ">Title of Free Offers</span>
					</td>
					<td>

					</td>
					</tr>
					</table>
					</td>
					</tr>
					';
				
	$qry_stdy=mysql_query("select * from tbl_poststudy where usertype='3' AND status='1' and date_exp >='$today'");
	if(mysql_num_rows($qry_stdy) >0)
	{

		while($rowstdy=mysql_fetch_assoc($qry_stdy))
		{
			//print_r($row_stdy);exit;
								
			$catname = 'Nationwide';
			$url = $mosConfig_live_site.'readfreestuff/'.$rowstdy['id'];//.'/'.$catname
			$url_study = $mosConfig_live_site.'freestuff/'.$catname;
			$formateddate_short = date("M j",strtotime($rowstdy['add_date']));
			$formateddate_exp = date("M j",strtotime($rowstdy['date_exp']));
			//echo $formateddate_exp = wordwrap($formateddate_exp,15,"<br />\n");
			$today_chk = date('Y-m-d H:i:s', time());
			$time_difference = get_time_difference($today_chk,$rowstdy['date_exp']);
			
			$hours = $time_difference['hours'];
			$h1 = $time_difference['days']*24;
			$h2 = $h1+$hours;
			
			//echo $h2; exit;
			if($h2 > 12){
		
			$studfree_tbl .=  '
				<tr>
				<td width="10"> </td>
				<td align="left" height="43" style=" background-color:#f0f0ee; padding-left:10px;">
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
				<td width="120"  height="43">
				<table cellpadding="0" cellspacing="0" width="120">
				<tr>
				<td width="10"></td>
				<td height="25" align="left" >
				<span style="font-family:Arial; color:#4c4c4c; font-size:13px; font-weight:bold; line-height:25px;padding-left:10px">'.$formateddate_exp.'</span>
				</td>
				</tr>
				</table>
				</td>
				<td style="padding-left:15px;" valign="top" width="325">
				<span style="font-family:Arial; color:#0197e5; line-height:22px; font-size:13px; font-weight:bold; "><a href="'.$url.'" style="text-decoration:none; color:#1961b3;">'.stripslashes($rowstdy['study_title']).'</a></span><br />
				<span style="font-family:Arial; font-size:12px; color:#333333; line-height:12px;"><a href="'.$url_study.'" style="text-decoration:none; color:#333333;">'.$catname.'</a> </span>
				</td>
				<td>
				<span style="font-family:Arial; font-size:13px; font-weight:bold; color:#d36100;"><a href="'.$url.'/'.mystr_url(stripslashes($rowstdy['study_title'])).'" style="color:#d36100; text-decoration:none;">Learn More</a></span>
				</td>
				</tr>
				</table>
				</td>
				</tr>
				';
				}
		}
	}else{
		$studfree_tbl .=  '<tr><td colspan="2"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No Free study found in your selected city.</p></td></tr>';
	}
	$studfree_tbl .=  '</table>'  ;

	$body_main = stripslashes($row_title['content']);
	$distance=50*1.609344;

	$studie_tbl = '<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td width="10"></td>
		<td align="left" height="43" style="border-bottom: solid 2px #eeeed7; background-color:#f2f2e5; padding-left:10px;"><span style=" font-family:Arial; font-size:18px; color:#333333; font-weight:bold;">Upcoming Studies</span> </td>
		</tr>
		<tr>
		<td width="10">
		</td>
		<td align="left" height="43" style=" background-color:#f0f0ee; padding-left:10px;">
		<table cellpadding="0" cellspacing="0" width="100%">
		<tr>
		<td width="120"  height="43">
		<table cellpadding="0" cellspacing="0" width="120">
		<tr>
		
		<td width="10"></td>
		<td height="25" align="left" valign="top" style="padding-left:5px;">
		<span style="font-family:Arial; color:#000; font-size:13px; font-weight:bold; line-height:15px;">Recruiting Until</span>
		</td>
		</tr>
		</table>
		</td>
		<td style="padding-left:15px; padding-top:4px;" valign="top" width="325">
		<span style="font-family:Arial; color:#000; line-height:22px; font-size:13px; font-weight:bold; ">Title of Upcoming Studies</span>
		</td>
		<td>

		</td>
		</tr>
		</table>
		</td>
		</tr>

		';

	if($categoryinfo['category_id'] && $sendtype == 'Cities'){
		$qry_stdy=mysql_query("select * from tbl_poststudy where ((nation='1' or (((acos(sin((".$categoryinfo['Latitude']."*pi()/180)) * sin((`lit`*pi()/180))+cos((".$categoryinfo['Latitude']."*pi()/180)) * cos((`lit`*pi()/180)) * cos(((".$categoryinfo['Longitude']."- `lng`)*pi()/180))))*180/pi())*60*1.1515*1.609344) <= $distance ) and date_exp >='$today' and status='1') and (usertype='1' OR usertype='2') AND send_newsletter_status='0' order by id desc");	
		$list_id = $categoryinfo['list_id'];
		$category_name = $categoryinfo['category_name'];
		$state_name = $categoryinfo['state_name'];
	}elseif($sendtype == 'Test'){
		$qry_stdy=mysql_query("select * from tbl_poststudy where nation='1' AND (usertype='1' OR usertype='2') AND status='1' and date_exp >='$today' AND send_newsletter_status='0'");
		$list_id = '27816';
		$category_name = 'Nationwide';
		$state_name = '';
	}else{
		$qry_stdy=mysql_query("select * from tbl_poststudy where nation='1' AND (usertype='1' OR usertype='2') AND status='1' and date_exp >='$today' AND send_newsletter_status='0'");
		$list_id = '27791';
		$category_name = 'Nationwide';
		$state_name = '';
	}

	if(@mysql_num_rows($qry_stdy) >0)
	{
		
		while($rowstdy=mysql_fetch_assoc($qry_stdy))
		{

			//echo "<pre>";print_r($rowstdy);exit;
			if(empty($rowstdy['city'])){
				$catname = 'Nationwide';
				$url = $mosConfig_live_site.'research/'.$rowstdy['id'].'/'.$catname;
				$url_study = $mosConfig_live_site.'studies/all';
			}else{
				$categoryinfo_url = Get_CategoryInfo($rowstdy['city']);
				$catname = $categoryinfo_url['category_name'];
				$url = $mosConfig_live_site.'research/'.$rowstdy['id'].'/'.mystr($categoryinfo_url['category_name']);
				$url_study = $mosConfig_live_site.'studies/'.mystr($categoryinfo_url['state_name']).'/'.mystr($categoryinfo_url['category_name']);
			}
			
			$formateddate_short = date("M j",strtotime($rowstdy['add_date']));
			$formateddate_exp = date("M j",strtotime($rowstdy['date_exp']));
			//echo "<pre>";print_r($url_study);exit;

			$today_chk = date('Y-m-d H:i:s', time());
			$time_difference = get_time_difference($today_chk,$rowstdy['date_exp']);
			
			$hours = $time_difference['hours'];
			$h1 = $time_difference['days']*24;
			$h2 = $h1+$hours;
			//echo $h2; exit;
			if($h2 > 12){
				$studie_tbl .=  '
				<tr>
				<td width="10"> </td>
				<td align="left" height="43" style=" background-color:#f0f0ee; padding-left:10px;">
				<table cellpadding="0" cellspacing="0" width="100%">
				<tr>
				<td width="120"  height="43">
				<table cellpadding="0" cellspacing="0" width="120">
				<tr>
				<td width="10"></td>
				<td height="25" align="left" >
				<span style="font-family:Arial; color:#4c4c4c; font-size:13px; font-weight:bold; line-height:25px;padding-left:20px;">'.$formateddate_exp.'</span>
				</td>
				</tr>
				</table>
				</td>
				<td style="padding-left:15px;" valign="top" width="325">
				<span style="font-family:Arial; color:#0197e5; line-height:22px; font-size:13px; font-weight:bold; "><a href="'.$url.'" style="text-decoration:none; color:#1961b3;">'.stripslashes($rowstdy['study_title']).'</a></span><span style="font-family:Arial; color:#000; line-height:22px; font-size:13px; font-weight:bold; "> $'.stripslashes($rowstdy['compensation_stdy']).'</span><br />
				<span style="font-family:Arial; font-size:12px; color:#333333; line-height:12px;"><a href="'.$url_study.'" style="text-decoration:none; color:#333333;">'.$catname.'</a> </span>
				</td>
				<td>
				<span style="font-family:Arial; font-size:13px; font-weight:bold; color:#d36100;"><a href="'.$url.'/'.mystr_url(stripslashes($rowstdy['study_title'])).'" style="color:#d36100; text-decoration:none;">Learn More</a></span>
				</td>
				</tr>
				</table>
				</td>
				</tr>
				';
				}
		// Update sent studies more then 1 times
			$qry_check_status= mysql_query("select * from tbl_check_stduy_status WHERE study_id = '".$rowstdy['id']."'");
			if(mysql_num_rows($qry_check_status) < 1){
				$qry_check_status=mysql_query("INSERT INTO tbl_check_stduy_status (study_id) VALUES ('".$rowstdy['id']."')");
			}

		}
		}else{
		$studie_tbl .=  '<tr><td colspan="2"><p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;No study found in your selected city.</p></td></tr>';
	}
	$studie_tbl .=  '</table>'  ;
	////////////////////////////////////////////////////////////////////

	if($row_userinfo){ $fnameuser = $row_userinfo['fname'];}else{ $fnameuser = 'Participants'; }

	$body = $body_main;
	$body = str_replace('{{FREEBIES}}' ,  $studfree_tbl , $body );
	$body = str_replace('{{STUDY}}' ,  $studie_tbl , $body );

	$body = str_replace('{{DATETIME}}' ,  $formateddate , $body );
	$body = str_replace('{{CITYTOP}}' ,  $category_name , $body );
	
	if($category_name == 'Nationwide'){
		$body = str_replace('{{CITY}}' ,  '' , $body );
		$body = str_replace('{{STATE}}' ,  'all' , $body );
	}else{
		$body = str_replace('{{CITY}}' ,  mystr($category_name) , $body );
		$body = str_replace('{{STATE}}' ,  mystr($state_name) , $body );
	}
	$body = str_replace('{{FIRSTNAME}}' ,  $fnameuser , $body );
	$body = str_replace('{{USEREMAIL}}' ,  $visitor_emailaddress , $body );
	$body = str_replace('{{unsubscribeLink}}' , $mosConfig_live_site.'unsubscribe/'.base64_encode($row_userinfo['id']) , $body );
	$body = str_replace('{{NOMORELETTERS}}' , $mosConfig_live_site.'process/already_partcipate/'.base64_encode($row_userinfo['id']), $body);

	//echo $categoryinfo['category_name'].' - '.$categoryinfo['list_id'].'<br>';
	//echo $category_name.' - '.$list_id.' --> ';
	
	Send_iContat_message($row_title['frmemail'],$row_title['frmname'],stripslashes($row_title['title']),$body,$list_id);

}
						
function Get_Statecity_ID_iC($id,$cityname){
	$sqlqry_country=mysql_query("SELECT RegionID, City from tbl_city WHERE RegionID = '$id' AND City = '$cityname'");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_State_iC($id){
	$sqlqry_country=mysql_query("SELECT RegionID, Region from tbl_state WHERE RegionID = '$id' ");
	if(mysql_num_rows($sqlqry_country) > 0)
	{
		$row_country = mysql_fetch_assoc($sqlqry_country);
		return $row_country;
	}
}

function Get_CategoryInfo_name_iC($cityname, $statename)
{
	$sqlqry=mysql_query("SELECT category_name, state_name, list_id from  tbl_categories  WHERE category_name	= '$cityname' AND state_name = '$statename'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}

}	

function Get_Space_fee()
{
	$sqlqry=mysql_query("SELECT space_fee from  tbl_site_settings  WHERE setting_id	= '1'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		
		return $row['space_fee'];
	}

}	

function Get_User_info($id)
{
	$sqlqry=mysql_query("SELECT * from  tbl_users WHERE id	= '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		
		return $row;
	}

}
function sum_of_admin_fees()
{
	$sqlqry=mysql_query("select sum(o.amount) as total_amount  from tbl_retailer_payemnt o, tbl_retailer r where o.retailer_id = r.id  $where_order order by  o.id desc ");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		$sum = $row['total_amount'];
		
	}
	return $sum;
}

function retailer_payment_status($id)
{
	$sqlqry=mysql_query("select payment_status  from  tbl_retailer  where id = '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		$payment_status = $row['payment_status'];
		
	}
	return $payment_status;
}

function Get_rental_period($id)
{
	$sqlqry=mysql_query("SELECT name from  tbl_setting_rental_period  WHERE id	= '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		
		return stripslashes($row['name']);
	}

}

function Get_shared_spaces($id)
{
	
	$spaces_arr = explode(',',$id);
	foreach ($spaces_arr as $key => $val) {
		$sqlqry=mysql_query("SELECT name from  tbl_setting_spaces  WHERE id	= '$val'");
		if(mysql_num_rows($sqlqry) > 0)
		{
			$row 		= mysql_fetch_assoc($sqlqry);
			$row_arr[] 	= stripslashes($row['name']);
		}
	}
	
	return implode(', ', $row_arr);

}

function Get_payment_interval($id)
{
	$sqlqry=mysql_query("SELECT name from  tbl_setting_payment_interval  WHERE id	= '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		
		return stripslashes($row['name']);
	}

}

function Get_expenses($id)
{
	$sqlqry=mysql_query("SELECT name from  tbl_setting_expenses  WHERE id	= '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		
		return stripslashes($row['name']);
	}

}


function pagination($query, $per_page = 10,$page = 1, $url){        
    	$query = "SELECT COUNT(*) as num FROM {$query}";
		$row = mysql_fetch_array(mysql_query($query));
    	$total = $row['num'];
        $adjacents = "2"; 

    	$page = ($page == 0 ? 1 : $page);  
    	$start = ($page - 1) * $per_page;								
		
    	$prev = $page - 1;							
    	$next = $page + 1;
        $lastpage = ceil($total/$per_page);
    	$lpm1 = $lastpage - 1;
    	
    	$pagination = "";
    	if($lastpage > 1)
    	{	
    		$pagination .= "<ul class='pagination'>";
                    $pagination .= "<li class='details'>Page $page of $lastpage</li>";
    		if ($lastpage < 7 + ($adjacents * 2))
    		{	
    			for ($counter = 1; $counter <= $lastpage; $counter++)
    			{
    				if ($counter == $page)
    					$pagination.= "<li><a class='current'>$counter</a></li>";
    				else
    					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    			}
    		}
    		elseif($lastpage > 5 + ($adjacents * 2))
    		{
    			if($page < 1 + ($adjacents * 2))		
    			{
    				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>...</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>...</li>";
    				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    				$pagination.= "<li class='dot'>..</li>";
    				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
    				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";		
    			}
    			else
    			{
    				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
    				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
    				$pagination.= "<li class='dot'>..</li>";
    				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
    				{
    					if ($counter == $page)
    						$pagination.= "<li><a class='current'>$counter</a></li>";
    					else
    						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";					
    				}
    			}
    		}
    		
    		if ($page < $counter - 1){ 
    			$pagination.= "<li><a href='{$url}page=$next'>Next</a></li>";
                $pagination.= "<li><a href='{$url}page=$lastpage'>Last</a></li>";
    		}else{
    			$pagination.= "<li><a class='current'>Next</a></li>";
                $pagination.= "<li><a class='current'>Last</a></li>";
            }
    		$pagination.= "</ul>";		
    	}
    
    
        return $pagination;
    } 

// Email verfy by Briteerfy API	
function verify_email($email,$api)
{
   // $api = "7fdbae29-f384-4d1c-b7d7-bd787b489b3e";
  if($email!="" && $api!="")
   {
   		require_once("includes/XML2Array.php");
		$url = "https://api.briteverify.com/emails/verify.xml?email[address]=$email&apikey=$api";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_FAILONERROR,1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		  
		curl_setopt($ch, CURLOPT_TIMEOUT, 15);
		$retValue = curl_exec($ch);           
		//echo curl_error($ch);           
		curl_close($ch);
		if(!empty($retValue))
		{
		   $xml = $retValue;
		   $array = XML2Array::createArray($xml);
		// echo '<pre>';print_r($array);
		  
			  $valid = $array['email']['status']['@value'];
			  if($valid=='valid')
			  {
				 $valid = 'valid';
			  }
		 }else{
		   $valid = 'Invalid';
		 }
	}else{
		$valid = 'Invalid Information';
	}
	
	return $valid;
}




   



 
////////////	Limited word show but complete word  //////////////////////
	function cut_text($text, $len)
    {
		for ($i = 0; $i < 10; ++$i)
        {
        	$c 	= $text[$len + $i];
            if ($c == ' ' || $c == "\t" || $c == "\r" || $c == "\n" || $c == '-')
            	break;
       	}
		if ($i == 10) $i = 0;
			return rtrim(substr($text, 0, $len + $i));
    }
	
	
	function csbystdid($sid)
	{
	    $array_sc = array();
		$qry = "select id,city from tbl_poststudy where id='".$sid."'";
		$r   = mysql_query($qry);
		$res = mysql_fetch_assoc($r);
		return $res;
	}
	function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }
	function selfURL(){
	 if(!isset($_SERVER['REQUEST_URI']))
	 { 
	   $serverrequri = $_SERVER['PHP_SELF'];
	 }
	 else{
	 $serverrequri = $_SERVER['REQUEST_URI'];
	 }
	   $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
	   $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
	   $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
	   return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
	 }
	 
	 
	 
	 function Get_CityInfo($id)
{ 

	$sqlqry=mysql_query("SELECT * from  tbl_city  WHERE CityId = '$id'");
	if(mysql_num_rows($sqlqry) > 0)
	{
		$row = mysql_fetch_assoc($sqlqry);
		return $row;
	}

}


	/**
	* GetServerTime
	* Uses the ConvertDate object to turn "now" server time into gmt time.
	* This is a misnomer ...... the function actually returns GMT time NOT server time.
	*
	* @return Int Returns the new 'timestamp' in gmt time.
	*/
	// MY function
	
	function GetServerTime_inter()
	{
		$user_hours = $user_mins = 0;	
		$user_offset = str_replace('GMT', '', $user_timezone);
		if (strpos($user_offset, ':') !== false) {
			list($user_hours, $user_mins) = explode(':', $user_offset);
		}
                $user_timezone = $user_hours . $user_mins;

		$server_hours = $server_mins = 0;
		$server_offset = str_replace('GMT', '', $server_timezone);
		if (strpos($server_offset, ':') !== false) {
			list($server_hours, $server_mins) = explode(':', $server_offset);
		}
		//$server_timezone = $server_hours . $server_mins;
//		$server_timezone = '+500';
		
		$timenow = getdate();
		//print_r($timenow);exit;
		
		$hr = $timenow['hours'];
		$min = $timenow['minutes'];
		$sec = $timenow['seconds'];
		$mon = $timenow['mon'];
		$day = $timenow['mday'];
		$yr = $timenow['year'];
		
		//$args = func_get_args();
		//print_r($args);exit;
		//list($hr, $min, $sec, $mon, $day, $yr) = array_map('intval', $args);
		$timestamp = mktime($hr, $min, $sec, $mon, $day, $yr);
		//$offset = date('Z',$timestamp); // Seconds from GMT
		//$timestamp = $timestamp - $offset;
		//return $timestamp;
		//echo $timestamp;exit;
		

		// TODO GetServerTime
		return gmdate('U');
		
	
	
	}
	
	function download_csv_search()
	{
	

$file = 'export';
$where = "";



$result = mysql_query("SHOW COLUMNS FROM tbl_users WHERE Field IN ('fname', 'lname' , 'email', 'add_date' , 'user_ip');");
$i = 0;
if (mysql_num_rows($result) > 0) {
	while ($row = mysql_fetch_assoc($result)) {
		$csv_output .= $row['Field'].", ";
		$i++;
	}
}
$csv_output .= "\n";
//echo "SELECT fname, lname,email,city FROM tbl_users where city ='Chicago'"; exit;
//echo "SELECT city, email FROM tbl_users where $where";exit;
//$values = mysql_query("SELECT city, email FROM tbl_users where $where");
$values = mysql_query($_SESSION['qry_download_emailSrch']);
while ($rowr = mysql_fetch_row($values)) {
	for ($j=0;$j<$i;$j++) {
	$csv_output .= $rowr[$j].", ";
	}
	$csv_output .= "\n";
}

$filename = "fgglobal_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header( "Content-disposition: filename=".$filename.".csv");
print $csv_output;
exit;


	 }
function getRealIpAddr()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
	{
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}
	elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
	{
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else
	{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

  $skey 	= "EVSEncKey2011"; // you can change it
function safe_b64encode($string) {
 
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }

function encode_data($value){ 

 
	    if(!$value){return false;}
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim(safe_b64encode($crypttext)); 
    }

function safe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

function decode_date($value){
 
        if(!$value){return false;}
        $crypttext = safe_b64decode($value); 
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }
	function generateRandomString($length = 6, $letters = '234567890abcdefghijkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
  {
	  $s = '';
	  $lettersLength = strlen($letters)-1;
	 
	  for($i = 0 ; $i < $length ; $i++)
	  {
	  $s .= $letters[rand(0,$lettersLength)];
	  }
	 
	  return $s;
  }
  
  function get_states(){
	global $db;
  	$qry ="SELECT Code from tbl_state where  CountryID = 254 and Code !='AO' order by Code asc";
	$arr = $db->get_results($qry,ARRAY_A);
	return $arr;
}
function get_time_format($time){
return date("g:i A", strtotime($time));
}
// organizer booked slots
function get_organizer_booked_slots($concert_id,$id){
		global $db;
		$qry = "select count(*) as total from tbl_slots where artist_id='".$id."' AND concert_id='".$concert_id."'";
		$arr = $db->get_row($qry,ARRAY_A);
		return $arr['total'];	
		
}
function get_concert_booked_slots($concert_id){
		global $db;
		$qry = "select count(*) as total from tbl_slots where artist_id<>0 AND concert_id='".$concert_id."'";
		$arr = $db->get_row($qry,ARRAY_A);
		return $arr['total'];	
}

  //get sold tickets against a slot
function sold_tickets($bright_id,$ticket_id,$bright_token){
	$url = 'https://www.eventbriteapi.com/v3/events/'.$bright_id.'/ticket_classes/'.$ticket_id.'/?token='.$bright_token;
	$header = array();
	$header[]="Content-Type: application/json";
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($ch,CURLOPT_HEADER, false); 
	$output=curl_exec($ch);
	$values = json_decode($output);
	$sold = $values->quantity_sold;
	curl_close($ch);
	if(trim($sold)==""){
		$sold = 0;
	}	
	return $sold;
}

function getUserIP()
{
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = $_SERVER['REMOTE_ADDR'];

	if(filter_var($client, FILTER_VALIDATE_IP))
	{
		$ip = $client;
	}
	elseif(filter_var($forward, FILTER_VALIDATE_IP))
	{
		$ip = $forward;
	}
	else
	{
		$ip = $remote;
	}

	return $ip;
}

function email_validation($email)
{
	global $_ERR;
	if($email == '')
	{
		$response = 'empty';
	}
	else
	{
		if( strlen($email) > 50)
		{
			 $response='tooLong';
	    }
		elseif(!ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
		{
			$response = 'invalid';
		}
		else
		{
			$qry_count_email = mysql_query("select count(id) from tbl_users where email = '".$email."'");
			$row_count_email = mysql_fetch_array($qry_count_email);
			if($row_count_email[0] > 0)
			{
				$response = 'used';
			}
			else
			{
				$response = 'success';
			}			
		}
	}
	return $response;
}
function time_format($val)
{
	return date("h:i a", strtotime($val));
}

function mydate_format($val)
{
	return date("Y-m-d", strtotime($val));
}


function curr_format($val)
{
	return number_format($val,2);
}

function Get_Escrow_Staus($PartnerID, $escrow_userpwd, $trans_id)
{
	$url = 'https://stgsecureapi.Escrow.com/api/Status?partnerID='.$PartnerID.'&escrowUniqueIdentifier='.$trans_id;
	$header = array();
	$header[]="Content-Type: application/json";
	
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($ch,CURLOPT_HEADER, false); 
	CURL_SETOPT($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	CURL_SETOPT($ch, CURLOPT_USERPWD, $escrow_userpwd);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);   
	$output=curl_exec($ch);
	$values =  json_decode($output);
	$Code =  $values->Code;
	$Description = $values->Description;
	$EscrowUniqueIdentifier = $values->EscrowUniqueIdentifier;
	//echo $Code.'-'.$Description.'-'.$EscrowUniqueIdentifier;
	curl_close($ch);
	
	if($Description!=""){
		$value  = str_replace('Buyer' , 'Seeker'  ,$Description );
		$value  = str_replace('Seller' , 'Retailer with extra space'  ,$value );
		$value  = str_replace('Accepted' , 'Accepted Payment Terms'  ,$value );
	}else{
		$value  = "Transaction Cancelled";
	}
	
	return $value;
}

function Get_Escrow_Staus_new($PartnerID, $escrow_userpwd, $trans_id)
{
	$url = 'https://stgsecureapi.Escrow.com/api/Status?partnerID='.$PartnerID.'&escrowUniqueIdentifier='.$trans_id;
	$header = array();
	$header[]="Content-Type: application/json";
	
	$ch = curl_init();  
	curl_setopt($ch,CURLOPT_URL,$url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
	//curl_setopt($ch,CURLOPT_HEADER, false); 
	CURL_SETOPT($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	CURL_SETOPT($ch, CURLOPT_USERPWD, $escrow_userpwd);
	curl_setopt ($ch, CURLOPT_HTTPHEADER, $header);   
	$output=curl_exec($ch);
	$values =  json_decode($output);
	$Code =  $values->Code;
	$Description = $values->Description;
	$EscrowUniqueIdentifier = $values->EscrowUniqueIdentifier;
	//echo $Code.'-'.$Description.'-'.$EscrowUniqueIdentifier;
	curl_close($ch);
	
	if($Description!=""){
		$value  = str_replace('Buyer' , 'Seeker'  ,$Description );
		$value  = str_replace('Seller' , 'Retailer with extra space'  ,$value );
		$value  = str_replace('Accepted' , 'Accepted Payment Terms'  ,$value );
	}else{
		$value  = "Transaction Cancelled";
	}
	
	return $Code;
}

function state_name($country_id, $state_id)
{
	 global $db;
	 $query		=	"select * from tbl_state where CountryId = '$country_id' AND RegionID = '$state_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function country_name($country_id)
{
	 global $db;
	 $query		=	"select * from tbl_countries where CountryId = '$country_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}


function city_name($country_id, $state_id, $city_id)
{
	 global $db;
	 
	 $query		=	"select * from tbl_city where CountryID = $country_id AND RegionID = '$state_id' AND CityId = '$city_id'";	
	 $list_arr	=	$db->get_row($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_job_main_categories_list()
{
	 global $db;
	 $query		=	"select c.category_name, c.category_id, c.category_image from tbl_categories c, tbl_jobs j where c.category_id = j.job_category AND c.active_status = 1 AND j.job_status = 1 group by c.category_id order by  c.sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

function get_job_main_sub_categories_list($id)
{
	 global $db;
	 $query		=	"select * from tbl_categories where parent_id=$id AND active_status = 1 group by category_id order by  sortorder asc";	
	 $list_arr	=	$db->get_results($query,ARRAY_A);		
	 
	 return $list_arr;
	
}

?>
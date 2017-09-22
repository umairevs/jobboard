<?php
$serverpathroot	=	"http://".$_SERVER['HTTP_HOST']."/jobboard/";	//	set site server path
define(SERVER_ROOTPATH, $serverpathroot);							//	save path in constant value

define(SITE_TITLE, ' Job Portal');
//================================================================
define(SQL_INJECTION_SECURITY_ENABLED, true);
$email_onoff = 1; //0 - 1 (0 off, 1 On)
?>
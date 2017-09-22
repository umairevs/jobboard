<html>
<head>
<title>PHPMailer - Mail() basic test</title>
</head>
<body>

<?php
require_once('../class.phpmailer.php');



//function sendMail_Notic($from, $fromname, $recipient, $recipientname, $subject, $body)
		
		$from			= 'sheraz@evsoft.pk';
		$fromname		= 'Sheraz Falak';
		$recipient		= 'moeez@evsoft.pk';
		$recipientname	= 'Moeez Iqbal';
		$subject		= 'Foodvalet Testing email';
		$body			= 'PHPMailer Test Subject via mail(), basic';


		$msg = $body;
		$mail             = new PHPMailer();
		//echo "<pre>";print_r($mail);exit;
		$mail->Sender = $from;
		///$mail->IsSendmail(true);
		$mail->IsHTML(true);
	
		$mail->SetFrom($from, $fromname);
		$mail->AddReplyTo($from,$fromname);
		$mail->Subject    = $subject;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);
		$address = $recipient;
		$mail->AddAddress($address, $recipientname);
		
		
		
		/*require_once('../class.phpmailer.php');

		$mail             = new PHPMailer(); // defaults to using php "mail()"
		$mail->AddReplyTo("sheraz@evsoft.pk","First Last");
		$mail->SetFrom('sheraz@evsoft.pk', 'First Last');
		$mail->AddReplyTo("sheraz@evsoft.pk","First Last");
		$address = "moeez@evsoft.pk";
		$mail->AddAddress($address, "Moeez");
		$mail->Subject    = "PHPMailer Test Subject via mail(), basic";
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->MsgHTML($body);*/
		
		//$mail->Send();
	


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>

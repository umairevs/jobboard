<html>
<head>
<title>PHPMailer - Mail() basic test</title>
</head>
<body>

<?php

/*$to      = 'moeez@evsoft.pk';
$subject = 'the subject';
$message = ' Link: <a href="http://www.learnsmart.com.ng/login">Click here</a>';
$headers = 'From: sheraz@evsoft.pk' . "\r\n" .
    'Reply-To: sheraz@evsoft.pk' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($to, $subject, $message, $headers, "-f sheraz@evsoft.pk");

die();*/

require_once('../class.phpmailer.php');

$mail             = new PHPMailer(); // defaults to using php "mail()"

//$body             = file_get_contents('contents.html');
$body             = 'Link: <a href="http://www.learnsmart.com.ng/login">Click here</a>';

$body             = eregi_replace("[\]",'',$body);

$mail->AddReplyTo("customercare@learnsmart.com.ng","First Last");

$mail->SetFrom('customercare@learnsmart.com.ng', 'First Last');

$mail->AddReplyTo("customercare@learnsmart.com.ng","First Last");

//$address = "moeez@evsoft.pk";
$address = "moeez.evs@gmail.com";
$mail->AddAddress($address, "Moeez");

$mail->Subject    = "PHPMailer Test Subject via mail(), basic";

$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

$mail->MsgHTML($body);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>

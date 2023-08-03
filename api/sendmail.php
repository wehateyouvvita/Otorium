<?php
ini_set("include_path", '/home/otoriumx/php:' . ini_get("include_path") );
require_once "Mail.php";

$from = "Otorium Verification <kjf@otorium.xyz>";
$to = "Recipient <".$_GET['to'].">";
$subject = "Verify user KJF on Otorium";
$body = $_GET['body'];

$host = "smtp.zoho.com";
$port = "25";
$username = "kjf@otorium.xyz";
$password = "12341234IDKSO5678";

$headers = array ('From' => $from,
  'To' => $to,
  'Subject' => $subject);
$smtp = Mail::factory('smtp',
  array ('host' => $host,
    'port' => $port,
    'auth' => true,
    'username' => $username,
    'password' => $password));

$mail = $smtp->send($to, $headers, $body);

if (PEAR::isError($mail)) {
  echo("<p>" . $mail->getMessage() . "</p>");
 } else {
  echo("<p>Message successfully sent!</p>");
 }
 ?>
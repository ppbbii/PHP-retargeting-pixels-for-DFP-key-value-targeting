<?php header('Content-Type: application/x-javascript');
/* 
	Cookie name must be identical to name set in CookieCreator.php and used in cookieMuncher.js
	This example assumes all values are held under Retargeting key
*/
$CookieKey = 'Retargeting';?>
document.cookie = '<?php echo $CookieKey; ?>=' + '<?php echo $_COOKIE[$CookieKey]; ?>';

<?php
header("Cache-Control: no-cache, no-store, must-revalidate, private, max-age=0"); // don't cache my cookies!
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type, *");

$CookieKey = 'Retargeting'; // set name cookie used for audience retargeting. Cookie name must be identical to name used in cookieMuncher.js
$CookieArray = []; // Container for cookie value; To be prepopulated and changed, as necessary
$Path = '/'; // defaults to global. Can be changed as needed

if (isset($_COOKIE[$CookieKey])) {
	$CookieArray = explode("|", base64_decode($_COOKIE[$CookieKey]));
	$now = time();
	// evaluate dead cookies, remove dead keys
	for ($i = 0; $i < count($CookieArray); $i += 2) { if ($CookieArray[$i + 1] <= $now) { unset($CookieArray[$i + 1], $CookieArray[$i]); } }
	
	if (isset($_GET['ttl'], $_GET['id']) && $_GET['id'] !== '' && (int)($_GET['ttl']) !== 0) {
		$RetargetingKeys = explode(",", $_GET['id']); // catch and prepopulate array with passed keys
		if($_GET['ttl'] == -1){
			// time to live is negative, remove passed keys from a cookie value
			for ($i = 0; $i < count($RetargetingKeys); $i++) {
				if ((array_search($RetargetingKeys[$i], $CookieArray) !== false)) {
					unset($CookieArray[array_search($RetargetingKeys[$i], $CookieArray) + 1], $CookieArray[array_search($RetargetingKeys[$i], $CookieArray)]);
				}
			}
		} elseif($_GET['ttl'] > 0 ){
			// add / replace cookie keys with provided non negative time to live [TTL]
			$Ttl = time() + 86400 * $_GET['ttl']; // Time to live for a particular key
			for ($i = 0; $i < count($RetargetingKeys); $i++) {
				if ((array_search($RetargetingKeys[$i], $CookieArray) !== false)) {
					// key is already set. Update found key with new TTL
					$CookieArray[array_search($RetargetingKeys[$i], $CookieArray) + 1] = $Ttl;
				} else {
					// new keys to be set
					array_push($CookieArray, $RetargetingKeys[$i], $Ttl);
				}
			}
		}
	}
} elseif (isset($_GET['ttl'], $_GET['id']) && (int)($_GET['ttl']) !== 0 && $_GET['id'] !== '') {
	// create new cookie
	$Ttl = time() + 86400 * $_GET['ttl']; // Time to live for a particular key
	foreach (explode(",", $_GET['id']) as $key => $value) {
		array_push($CookieArray, $value, $Ttl);
	}
} else {return;}
// create cookie here
setcookie($CookieKey, base64_encode(implode("|", $CookieArray)), time() + 86400 * 14, $Path);
?>

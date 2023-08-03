<?php
$guestsAllowed = false;
if(!(defined('user'))) {
	define('user', 'otorium_system_o');
	define('pass', 'G_3G(.DEK9YB');
	define('host', 'localhost');
	define('database', 'otorium_database_ok');
}
$pdoOptions = array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
	PDO::ATTR_EMULATE_PREPARES => false
);
$pdo = new PDO(
	"mysql:host=".host.";dbname=".database,
	user,
	pass,
	$pdoOptions
);
if(isset($_SESSION['session'])) {
	$DBpageCheckIFUserBanned = $pdo->prepare("SELECT id FROM users WHERE id=:id");
	$DBpageCheckIFUserBanned->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
	$DBpageCheckIFUserBanned->execute();
	
	if ($DBpageCheckIFUserBanned->rowCount() > 0) {
		$DBpageCheckIFUserBannedresult = $DBpageCheckIFUserBanned->fetch(PDO::FETCH_OBJ);
		$DBpageCheckIFUserBanneduserID = $DBpageCheckIFUserBannedresult->id;
		$DBpageCheckIFUserBannedquery2 = $pdo->prepare("SELECT * from bans WHERE uid=:uid ORDER BY id DESC LIMIT 1");
		$DBpageCheckIFUserBannedquery2->bindParam("uid", $DBpageCheckIFUserBanneduserID, PDO::PARAM_STR);
		$DBpageCheckIFUserBannedquery2->execute();
		if($DBpageCheckIFUserBannedquery2->rowCount() == 1) {
			$DBpageCheckIFUserBannedquery2inf = $DBpageCheckIFUserBannedquery2->fetch(PDO::FETCH_OBJ);
			if($DBpageCheckIFUserBannedquery2inf->activated == false) {
				if($headerpresent == true) {
					if(!(isset($banstuff))) {
						//die();
						//echo '<div id="message">You are BANNED. You CANNOT access this page. PLEASE understand that.</div><div id="success">very false</div>';
					}
				}
			}
		}
	}
	
}
//get site settings
$gss = $pdo->prepare("SELECT * FROM settings WHERE id=1");
$gss->execute();
$sitesettings = $gss->fetch(PDO::FETCH_OBJ);

/*if(isset($_COOKIE['token'])) {
	$query = $pdo->prepare("SELECT * FROM logged_in_sessions WHERE token = :tk");
	$query->bindParam(":tk", $_COOKIE['token'], PDO::PARAM_STR);
	$query->execute();
	
	if ($query->rowCount() > 0) {
		$result2 = $query->fetch(PDO::FETCH_OBJ);
		$_SESSION['session'] = $result2->uid;
	}
}*/
?>
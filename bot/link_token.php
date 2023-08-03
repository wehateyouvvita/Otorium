<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM discord_tokens WHERE token = :tk AND valid = 1");
$cft->bindParam(":tk", $_POST['token'], PDO::PARAM_STR);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	//if($ti->type == 1) {
		
		//Check if Discord User ID already has an account linked:did");
        $ciDUI = $pdo->query("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = :did");
        $ciDUI->bindParam(":did", $_POST['userid'], PDO::PARAM_STR);
        $ciDUI->execute();
		if($ciDUI->rowCount() > 0) {
			echo ':anger: You already have an Otorium account linked to your discord account!;0';
		} else {
			if($pdo->query("SELECT * FROM registered_discord_users WHERE valid = 1 AND uid = ".$ti->uid)->rowCount() > 0) { // and allow multiple accounts == false
				echo ':anger: The Otorium account you are trying to link already has an account linked.;0';
			} else {
				$username = $do->getUsername($ti->uid);
				echo ':white_check_mark: Your account has been linked to your Otorium account, '.$username.'.;1;'.$username;
				$pdo->query("UPDATE discord_tokens SET valid = 0 WHERE token = '".$_POST['token']."'");
				$pdo->query("INSERT INTO registered_discord_users(token_used, uid, did, added_on, valid)
							VALUES('".$_POST['token']."', ".$ti->uid.", ".$_POST['userid'].", ".time().", 1)");
				$do->logAction("Linked discord account ".$_POST['userid'], $username, $do->encode($do->getip())); 

			}
		}
	//} else {
	//	echo ':x: Invalid token type used. Make sure you are using the link token instead of the verify token and try again.;0';
	//}
} else {
	echo ':x: The token entered does not exist. Please check the token and try again.;0';
}
?>
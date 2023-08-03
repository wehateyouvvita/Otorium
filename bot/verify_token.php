<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM discord_tokens WHERE token = :tk AND valid = 1");
$cft->bindParam(":tk", $_POST['token'], PDO::PARAM_STR);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	if($ti->type == 0) {
		$username = $do->getUsername($ti->uid);
		echo ':white_check_mark: Succesfully verified, '.$username.'!;1;'.$username;
		$pdo->query("UPDATE discord_tokens SET valid = 0 WHERE token = '".$_POST['token']."'");
		$do->logAction("Verify discord account ".$_POST['userid'], $username, $do->encode($do->getip())); 
	} else {
		echo ':x: Invalid token type used. Make sure you are using the verify token instead of the link token and try again.;0';
	}
} else {
	echo ':x: The token entered does not exist. Please check the token and try again.;0';
}
?>
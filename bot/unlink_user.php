<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = ".$_POST['userid']);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	if($pdo->query("UPDATE registered_discord_users SET valid = 0 WHERE uid = ".$ti->uid)) {
		echo ':white_check_mark: Succesfully unlinked account.;1';
	} else {
		echo ':anger: Error occured.;0';
	}
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
?>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = ".$_POST['uid']);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	if($ti->uid == 1) {
		if($pdo->query("UPDATE registered_discord_users SET valid = 0")) {
			echo 'Success.;1';
		} else {
			echo 'Error occured.;1';
		}
	} else {
		echo ':x: Error occured;0';
	}
	
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
?>
<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = :did");
$cft->bindParam(":did", $_POST['user'], PDO::PARAM_STR);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	echo 'Account balance: <:OT:394189068830769176>'.$do->getUserInfo($do->getUsername($ti->uid), "cash").';1';
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
?>
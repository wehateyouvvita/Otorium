<?php
//error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
}
$do = new functions();
$getTKInfo = $pdo->prepare("SELECT * FROM ingame_players WHERE token_used = :tk");
$getTKInfo->bindParam(":tk", $_GET['token'], PDO::PARAM_STR);
$getTKInfo->execute();
if($getTKInfo->rowCount() > 0) {
	$result = $getTKInfo->fetch(PDO::FETCH_OBJ);
	if($do->ifGameAvailable($result->gid)) {
		$a = $pdo->prepare("UPDATE ingame_players SET last_pinged = ".time()." WHERE token_used=:tk");
		$a->bindParam(":tk", $_GET['token'], PDO::PARAM_STR);
		$a->execute();
		$b = $pdo->query("UPDATE users SET lastseen = ".time()." WHERE id = ".$result->uid);
	}
}
?>
pinged
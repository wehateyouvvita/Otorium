<?php
//error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
}
$do = new functions();
$getTKInfo = $pdo->prepare("SELECT * FROM games WHERE pingtoken = :tk");
$getTKInfo->bindParam(":tk", $_GET['token'], PDO::PARAM_STR);
$getTKInfo->execute();
if($getTKInfo->rowCount() > 0) {
	$result = $getTKInfo->fetch(PDO::FETCH_OBJ);
	$a = $pdo->query("UPDATE games SET lastpingtime = ".time()." WHERE id=".$result->id);
}
?>
pinged
<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
	if(!(isset($pdo))) {
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
	}
	$a = $pdo->prepare("SELECT * FROM custom_assets WHERE aid = :uid");
	$a->bindParam(":uid", $_GET['id'], PDO::PARAM_INT);
	$a->execute();
	if($a->rowCount() > 0) {
		$stuff = $a->fetch(PDO::FETCH_OBJ);
		echo $stuff->xml;
	}
}
?>
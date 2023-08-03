<?php
include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
$gutr = $pdo->query("SELECT * FROM render_user WHERE rendered = 0 ORDER BY `timestamp` ASC LIMIT 1");
if($gutr->rowCount() > 0) {
	$userToRender = $gutr->fetch(PDO::FETCH_OBJ);
	$version = 2010;
	if($userToRender->version == 1) {
		$version = 2008;
	}
	echo $userToRender->uid."|".$userToRender->id."|".$version;
} else {
	echo 'false|0';
}
?>
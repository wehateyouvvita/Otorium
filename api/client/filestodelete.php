<?php

include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
}

echo $pdo->query("SELECT filestodelete FROM client_info WHERE id = 1")->fetch(PDO::FETCH_OBJ)->filestodelete;

?>
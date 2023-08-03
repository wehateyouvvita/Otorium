<?php

if(isset($_POST['clienttoken']) && isset($_POST['a'])) {
	
	require '../cfg/user_session.php';
	$query = $pdo->prepare("SELECT * FROM host_tokens WHERE keyvalue=:kyvl");
	$query->bindParam(":kyvl", $_POST['clienttoken'], PDO::PARAM_STR);
	$query->execute();
	$values1 = $query->fetch(PDO::FETCH_OBJ);
	
	$query2 = $pdo->prepare("SELECT * FROM games WHERE id='".$values1->game_id."'");
	$query2->execute();
	$numOfRows = $query2->rowCount();
	
	if($_POST['a'] == 1) { //make available
		$pdo->query("UPDATE games SET available=1 WHERE id='".$values1->game_id."'");
	}
	
	$pdo->query("DELETE FROM host_tokens WHERE keyvalue='".$_POST['clienttoken']."'");
	
}
else
{
	http_response_code(403);
}

?>
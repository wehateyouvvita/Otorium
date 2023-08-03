<?php

if(isset($_POST['clienttoken'])) {
	
	require '../cfg/user_session.php';
	$query = $pdo->prepare("SELECT * FROM host_tokens WHERE keyvalue=:kyvl");
	$query->bindParam(":kyvl", $_POST['clienttoken'], PDO::PARAM_STR);
	$query->execute();
	$numOfRows = $query->rowCount();
	
	if($numOfRows == 0) {
		die('1');
	}
	
	$values1 = $query->fetch(PDO::FETCH_OBJ);
	
	$query2 = $pdo->prepare("SELECT * FROM games WHERE id='".$values1->game_id."'");
	$query2->execute();
	$numOfRows = $query2->rowCount();
	
	if($numOfRows == 0) {
		die('2');
	}
	
	$values2 = $query2->fetch(PDO::FETCH_OBJ);
	
	//[deprecated] 0 (port), 1 (version), 2 (time_generated), deprecated > 3 (place_link)
	// 0 = version, 1 = time generated
	echo $values2->version.'|'.$values1->time_generated;
	
	if($do->ifUserHasBadge($values2->creator, 4) == false) {
		$a = $do->giveBadge($values2->creator, 4);
	}
}
else
{
	http_response_code(403);
}

?>
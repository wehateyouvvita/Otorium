<?php

if(isset($_POST['clienttoken'])) {
	
	require '../cfg/user_session.php';
	$game_token = $pdo->prepare("SELECT * FROM game_tokens WHERE keyvalue = :kyvl");
	$game_token->bindParam(":kyvl", $_POST['clienttoken'], PDO::PARAM_STR);
	$game_token->execute();
	$numOfRows = $game_token->rowCount();
	if($numOfRows == 0) {
		die('1');
	}
	
	$values1 = $game_token->fetch(PDO::FETCH_OBJ);
	$game_info = $pdo->prepare("SELECT * FROM games WHERE id=:gameid");
	$game_info->bindParam(":gameid", $values1->game_id, PDO::PARAM_INT);
	$game_info->execute();
	$numOfRows = $game_info->rowCount();
	
	if($numOfRows == 0) {
		die('2');
	}
	
	$values2 = $game_info->fetch(PDO::FETCH_OBJ);
	
	//(deprecated) 0 (username), 1 (ip), 2 (port), 3 (game name), 4 (creator), 5 (thumbnail), 6 (version),` 7 (time_generated), 8 (loopback enabled), 9 (creator), 10 (id)
	//0 = thumbnail, 1 = time generated, 2 = version, 3 = name, 4 = username, 5 = game id
	echo $values2->image.'|'.$values1->time_generated.'|'.$values2->version.'|'.$values2->name.'|'.$values1->username.'|'.$values2->id;
	
	if($do->ifUserHasBadge($do->getUserInfo($values1->username, "id"), 7) == false) {
		$a = $do->giveBadge($do->getUserInfo($values1->username, "id"), 7);
	}
}
else
{
	http_response_code(403);
}

?>
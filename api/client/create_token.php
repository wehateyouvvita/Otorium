<?php
if(isset($_POST['gameid'])) {
	require '../cfg/user_session.php';
	//if(!($rank == 2)) {
	//	die('<a id="tid">f</a><a id="err">Only administrators can launch games at this moment.</a>');
	//}
	$allowedNewsCasterPeople = array("papa muscheln","rat dog","Freddy","dell","Zahh","pranked");
	if($_POST['gameid'] == 59 && !(in_array($user, $allowedNewsCasterPeople))) {
		die('<a id="tid">f</a><a id="err">Only news reporters can launch this game.</a>');
	}
	$token = $do->random_str(64);
	if($loggedin == true) {
		if($do->checkIfBanned($userID) == false) {
			//if($do->ifGameAvailable($_POST['gameid'])) {
				$createGame = $pdo->prepare("INSERT INTO game_tokens(keyvalue, username, game_id, time_generated, used)
											VALUES('".$token."', '".$user."', :game_id, ".(time()+30).", 0);");
				$createGame->bindParam(":game_id", $_POST['gameid'], PDO::PARAM_INT);
				if($createGame->execute()) {
					echo '<a id="tid">'.$token.'</a>';
				} else {
					echo '<a id="tid">f</a><a id="err"></a>';
				}
			//} else {
			//	echo '<a id="tid">f</a><a id="err">Game not online.</a>';
			//}
		} else {
			echo '<a id="tid">f</a><a id="err">You\'re banned, just accept that fact.</a>';
		}
	} else {
		
		$createGame = $pdo->prepare("INSERT INTO game_tokens(keyvalue, username, game_id, time_generated, used)
									VALUES('".$token."', 'Guest".random_int(1,9999)."', :game_id, ".time().", 0);");
		$createGame->bindParam(":game_id", $_POST['gameid'], PDO::PARAM_INT);
		if($createGame->execute()) {
			echo '<a id="tid">'.$token.'</a>';
		} else {
			echo '<a id="tid">f</a><a id="err"></a>';
		}
		//die('<a id="tid">f</a><a id="err">Guests are not allowed to join games at this moment.</a>');
	}
}
else
{
	http_response_code(404);
}
?>
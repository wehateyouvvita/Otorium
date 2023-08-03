<?php

if(isset($_POST['gameid'])) {
	
	require '../cfg/user_session.php';
	
	$token = $do->random_str(32);
	
	//$placeLocation = str_replace(substr_replace('\ ', '', -1),"?",$_POST['placepath']); //change this
	//$placeLocation = str_replace('>',":",$placeLocation);
	$hostToken = $pdo->prepare("INSERT INTO host_tokens(keyvalue, game_id, time_generated)
								VALUES('".$token."', :gameid, ".time().");");
	$hostToken->bindParam(":gameid", $_POST['gameid'], PDO::PARAM_INT);
	if($hostToken->execute()) {
		echo '<a id="tid">'.$token.'//host</a>';
	} else {
		echo '<a id="tid">f</a><a id="err">'.$con->error.'</a>';
	}
}
else
{
	http_response_code(403);
}
?>
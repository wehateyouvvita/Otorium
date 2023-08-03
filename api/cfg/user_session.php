<?php
//only to be used in situations that header.php isnt able to be used
session_start();
require '../core/db/connect.php';
require '../core/siteFunctions.php';
$do = new functions();
if(isset($_SESSION['session'])) {
	$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id,theme FROM users WHERE id=:id");
	$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
	$query->execute();
	
	if ($query->rowCount() > 0) {
		$result = $query->fetch(PDO::FETCH_OBJ);
		$userID = $result->id;
		$loggedin = true;
		$cash = $result->cash;
		$user = $result->username;
		$pwhashyoushouldntbeabletofindthis = $result->password;
		$rank = $result->rank;
		$betaTester = $result->betatester; //beta testers should have acess to beta features
		$staffMember = false;
		$updateLastseen = $pdo->query("UPDATE users SET lastseen=".time()." WHERE id=".$userID);
		if($rank == 1 || $rank == 2) {
			$staffMember == true;
		}
	}
	else
	{
		$staffMember = false;
		$rank = -1;
		$loggedin = false;
	}
	
}
else
{
	$staffMember = false;
	$rank = -1;
	$loggedin = false;
}
?>
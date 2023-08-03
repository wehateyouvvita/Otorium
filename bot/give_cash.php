<?php
if(is_float($_POST['amount'])) {
    die("Try giving decimals one more time and get -25,000 Otobux you noob;0");
}
//die (':angry: Command disabled due to over-use.;0');
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = :did");
$cft->bindParam(":did", $_POST['user'], PDO::PARAM_STR);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	if($ti->uid == 1 || $ti->uid == 2 || $ti->uid == 4) {
		//dont forget ratelimits
		if($do->getUserInfo($do->getUsername($ti->uid), "rank") == 2) {
			if(is_numeric($_POST['amount'])) {
				if(!($_POST['amount'] < 1) && !($_POST['amount'] > 5000)) {
					if($_POST['user'] == "all") {
						if($pdo->query("UPDATE users SET cash = cash + ".$_POST['amount'])) {
							echo ':white_check_mark: <:OT:394189068830769176>'.$_POST['amount'].' has been sent to all users..;1';
							$do->logAction("given ".$_POST['amount']. " to ".$user, $ti->uid." did ".$_POST['userid'], $username, $do->encode($do->getip()));
						} else {
							echo ':x: Error giving.;0';
						}
					} else {
						$user = $do->getUserInfo($_POST['user'], "id"); //User to donate to
						if(!($user == false)) {
							if(!($ti->uid== $user)) {
								GetDonation:
								//ratelimit of 10 minutes
								//limit on donations at one day
								if($pdo->query("UPDATE users SET cash = cash + ".$_POST['amount']." WHERE id = ".$user)) {
									echo ':white_check_mark: <:OT:394189068830769176>'.$_POST['amount'].' has been sent to '.$_POST['user'].'.;1';
									$do->logAction("given ".$_POST['amount']. " to ".$user, $ti->uid." did ".$_POST['userid'], $username, $do->encode($do->getip()));
								} else {
									echo ':x: Error giving.;0';
								}
							} else {
								if($do->getUserInfo($do->getUsername($ti->uid), "rank") == 2) {
									goto GetDonation;
								} else {
									echo ':x: Cant send money to yourself.;0';
								}
							}
						} else {
							echo ':x: User "'.$_POST['user'].'" does not exist.;0';
						}
					}
				} else {
					echo ':x: Please send more than 1 bux and less than 10000 bux.;0';
				}
			} else {
				echo ':x: Cash has to be numeric.;0';
			}
		} else {
			echo ':anger: You must be an Otorium administrator to perform this command. You literally are not an Otorium Administrator, your rank is '.$do->getUserInfo($do->getUsername($ti->uid), "rank").';0';
		}
	} else {
		die (':angry: Command disabled due to over-use.;0');
		echo ':anger: You must be an Otorium administrator to perform this command.;0';
	}
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
echo 'what;1';
?>
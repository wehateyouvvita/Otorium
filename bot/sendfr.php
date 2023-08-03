<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = ".$_POST['user']);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	$usertosend = $do->getUserInfo($_POST['usertosend'], "id");
	$user_sending = $ti->uid;
	if($usertosend == false) {
		echo 'The username entered to send friend requests to does not exist.;0';
	} else {
		if($do->checkIfBanned($_POST['user'])) {
			echo 'Cannot send friend requests to banned users.;0';
		} else {
			if(!($do->checkIfBlocked($user_sending, $user) == false)) {
				echo 'Cannot send friend requests to blocked users.;0';
			} else {
				if($cash < $_POST['amount']) {
					echo 'You do not have enough cash to send friend requests. Current balance: '.$cash.' Otobux.;0';
				} else {
					if($do->checkIfFriends($user_sending, $usertosend) == false) {
						if(!($do->AmountOfFriends($usertosend) > 99)) {
							$sntfr = $do->hasFriendRequest($user_sending, $usertosend);
							if($sntfr == false) {
								if(!($usertosend == $user_sending)) {
									if($pdo->query("INSERT INTO friend_requests (uid, sid, time_added) VALUES(".$user_sending.", ".$usertosend.", ".time().")")) {
										if($usertosend == 3) { //remove this
											echo ':smiley: Succesfully sent friend request ;);1';
										} else {
											echo ':smiley: Succesfully sent friend request! ;1';
										}
									} else {
										echo ':anger: Error occured while sending friend request.;0';
									}
								} else {
									echo ':sob: Cannot send yourself a friend request!;0';
								}
							} else {
								if($sntfr == 1) {
									//You sent
									echo ':x: You have already sent a friend request to this user!;0';
								} else {
									echo ':x: This user has already sent a friend request to you!;0';
								}
							}
						} else {
							echo ':x: This user has 100 friends!;0';
						}
					} else {
						echo ':x: You are already friends with this user!;0';
					}
				}
			}
		}
	}
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
?>
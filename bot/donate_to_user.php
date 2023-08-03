<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = :did");
$cft->bindParam(":did", $_POST['user'], PDO::PARAM_STR);
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	//die('You have an account linked.;1');
	$user = $do->getUserInfo($_POST['user'], "id");
	$cash = $do->getUserInfo($do->getUsername($ti->uid), "cash");
	if($user == false) {
	    if(strpos($_POST['user'], "<@") !== false) {
        	$user_id = str_replace("<@","",$_POST['user']);
        	$user_id = str_replace(">","",$user_id);
        	$user_id = str_replace("!","",$user_id);
        	$cihde = $pdo->prepare("SELECT * FROM registered_discord_users WHERE did = :uid AND valid = 1 ORDER BY `id` ASC LIMIT 1");
        	$cihde->bindParam(":uid",$user_id, PDO::PARAM_STR);
        	$cihde->execute();
        	if($cihde->rowCount() > 0) {
        		$rduss = $cihde->fetch(PDO::FETCH_OBJ);
        		$_POST['user'] = $do->getUsername($rduss->uid);
        		$user = $rduss->uid;
        		goto GetOtherDonateToUserStuff;
        	} else {
        	    echo ':x: Discord user does not have an account linked;0';
        	}
        } else {
            echo ':x: The username entered to donate to does not exist.;0';
        }
	} else {
	    GetOtherDonateToUserStuff:
		if($do->checkIfBanned($_POST['user'])) {
			echo ':x: Cannot donate to banned users.;0';
		} else {
			if(!($do->checkIfBlocked($ti->uid, $user) == false)) {
				echo ':x: Cannot donate to blocked users.;0';
			} else {
				if($cash < $_POST['amount']) {
					echo ':x: You do not have enough cash to donate. Current balance: '.$cash.' Otobux.;0';
				} else {
					if(!($_POST['amount'] < 1) && !($_POST['amount'] > 100000)) {
						if(!($ti->uid == $user)) {
							if(is_numeric($_POST['amount'])) {
								//ratelimit of 10 minutes
								//limit on donations at one day
								if($pdo->query("UPDATE users SET cash = cash + ".$_POST['amount']." WHERE id = ".$user)) {
									echo ':white_check_mark: A donation of '.$_POST['amount'].' has been sent to '.$_POST['user'].'.
Your balance: '.($cash - $_POST['amount']).'
'.$_POST['user'].'\'s balance: '.$do->getUserInfo($_POST['user'], "cash").';1';
									$pdo->query("UPDATE users SET cash = cash - ".$_POST['amount']." WHERE id = ".$ti->uid);
									$do->logAction("send donation ".$_POST['amount']. " to ".$user, $ti->uid." did ".$_POST['userid'], $username, $do->encode($do->getip()));
								}
							} else {
								echo ':x: Cash has to be numeric..;0';
							}
						} else {
							echo ':x: Cant send money to yourself.;0';
						}
					} else {
						echo ':x: Please send more than 1 bux and less than 100,000 bux.;0';
					}
				}
			}
		}
	}
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0';
}
?>
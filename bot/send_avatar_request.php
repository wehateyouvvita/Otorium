<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$cft = $pdo->prepare("SELECT * FROM registered_discord_users WHERE valid = 1 AND did = ".$_POST['userid']);
$cft->execute();
if($cft->rowCount() > 0) {
	$ti = $cft->fetch(PDO::FETCH_OBJ);
	if($pdo->query("SELECT * FROM render_user WHERE uid = ".$ti->uid." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
		if($pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$ti->uid.", 0, ".time().")")) {
			$logAction = $do->logAction("sendRenderReqs", $ti->uid, "discordbot");
			echo '<:ot_update:401794811671216129>Sent render request!;1;';
		} else {
			echo ':x: Error while sending render request;0;';
		}
	} else {
		echo ':warning: A render request is already pending!;0;';
	}
} else {
	echo ':x: You do not have an account linked to your discord. Please link an account and try again.;0;';
}
?>
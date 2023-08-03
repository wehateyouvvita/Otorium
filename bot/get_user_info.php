<?php
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$do = new functions();
$userID = $do->getUserInfo($_POST['user'], "id");
if($userID == false) {
    if(strpos($_POST['user'], "<@") !== false) {
    	$user_id = str_replace("<@","",$_POST['user']);
    	$user_id = str_replace(">","",$user_id);
    	$user_id = str_replace("!","",$user_id);
    	$cihde = $pdo->prepare("SELECT * FROM registered_discord_users WHERE did = :uid AND valid = 1 ORDER BY `id` ASC LIMIT 1");
    	$cihde->bindParam(":uid",$user_id, PDO::PARAM_STR);
    	$cihde->execute();
    	if($cihde->rowCount() > 0) {
    		$rduss = $cihde->fetch(PDO::FETCH_OBJ);
    		$userID = $rduss->uid;
    		$username = $do->getUsername($userID);
    		goto DoGetUserInfo;
    	} else {
    	    echo ':x: Discord user does not have an account linked;0;0;0;0;0;0;0;0;0';
    	}
    } elseif(strpos($_POST['user'], "uid:") !== false) {
        $userID = str_replace("uid:", "", $_POST['user']);
    	$username = $do->getUsername($userID);
        if($do->getUsername($userID) == "????") {
        	echo ':x: User with that id does not exist;0;0;0;0;0;0;0;0;0';
        } else {
            goto DoGetUserInfo;
        }
    } elseif($do->ifUsernameExists($_POST['user']) == true) {
        $getUInfoOfOldUsername = $pdo->prepare("SELECT * FROM old_usernames WHERE username = :username");
        $getUInfoOfOldUsername->bindParam(":username", $_POST['user'], PDO::PARAM_STR);
        $getUInfoOfOldUsername->execute();
        if($getUInfoOfOldUsername->rowCount() > 0) {
            $OldUsernameInfo = $getUInfoOfOldUsername->fetch(PDO::FETCH_OBJ);
            $userID = $OldUsernameInfo->uid;
            $username = $do->getUsername($userID);
            goto DoGetUserInfo;
        } else {
             echo ':x: Error occured while getting user information;0;0;0;0;0;0;0;0;0';
        }
    } else {
        echo ':x: User does not exist;0;0;0;0;0;0;0;0;0';
    }
} else {
	$username = $_POST['user'];
	$username = $do->getUserInfo($username, "username");
	DoGetUserInfo:
	//blurb;success(if user exist);joindate;lastseen(true or false);user_avatar;discord;username;oldusernames;rank;
	echo str_replace(";","<>|<>",$do->getUserInfo($username, "blurb")).';1;'.date("M d, Y g:i A", $do->getUserInfo($username, "joindate")).';';
	if(($do->getUserInfo($username, "lastseen")) + 300 > time()) {
		echo '1';
	} else {
		echo '0';
	}
	echo ';https://cdn.otorium.xyz/assets/users/'.$userID.'.png?tick='.time();
	$cihda = $pdo->query("SELECT * FROM registered_discord_users WHERE uid = ".$userID." AND valid = 1 ORDER BY `id` ASC LIMIT 1");
	if($cihda->rowCount() > 0) {
		$rdus = $cihda->fetch(PDO::FETCH_OBJ);
		echo ';<@'.$rdus->did.'>';
	} else {
		echo ';0';
	}
	echo ';'.$username.';';
	$oldusernames = $do->old_usernames($userID);
	if(!($oldusernames == false)) {
		echo $oldusernames;
	} else {
		echo 'None';
	}
	echo ';';
	$userRank = $do->getUserInfo($username, "rank");
	if($userID == 3) {
		echo 'Official Otorium Test Account';
	} elseif($userRank == 1 && $do->getUserInfo($username, "com_manager") == true) {
		echo 'Community Manager';
	} elseif($userRank == 1) {
		echo 'Moderator';
	} elseif($userRank == 2 && !($userID == 3)) {
		echo 'Administrator';
	} elseif($do->getUserInfo($username, "betatester") == true) {
		echo 'Beta Tester';
	} else {
		echo 'No';
	}
	echo ';';
	if($pdo->query("SELECT * FROM render_user WHERE uid = ".$userID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
		echo '0';
	} else {
		echo '1';
	}
	echo ';';
}
?>
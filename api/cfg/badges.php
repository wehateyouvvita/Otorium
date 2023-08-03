<?php
if(!(isset($_SESSION['check_badges']))) {
	$_SESSION['check_badges'] = time() - 301;
}
if(($_SESSION['check_badges'] + 300) < time()) {
	//earn badges
	//Administrator Badge (1)
	if($rank == 2 && $do->ifUserHasBadge($userID, 1) == false) {
		$giveAdminBadge = $do->giveBadge($userID, 1);
	}
	//First 50 Members Badge (2)
	if($userID < 51 && $do->ifUserHasBadge($userID, 2) == false) {
		$give50MmbrsBadge = $do->giveBadge($userID, 2);
	}
	//Community Manager Badge (5)
	if($com_manager == 1 && $do->ifUserHasBadge($userID, 5) == false) {
		$giveCommunitMangBadge = $do->giveBadge($userID, 5);
	}
	//Security Analyst Badge (6)
	//if($userID < 51 && $do->ifUserHasBadge($userID, 2) == false) {
	//	$give50MmbrsBadge = $do->giveBadge($userID, 2);
	//}
	//Moderator Badge (8)
	if(($rank == 1 || $rank == 2) && $do->ifUserHasBadge($userID, 8) == false) {
		$giveModerBadge = $do->giveBadge($userID, 8);
	}
	//Verified Hoster Badge (11)
	if($verified_hoster == 1 && $do->ifUserHasBadge($userID, 11) == false) {
		$giveVerifiedHoster = $do->giveBadge($userID, 11);
	}
	//Veteran Badge (12)
	if(($joindate + 31556926) > time() && $do->ifUserHasBadge($userID, 12) == false) {
		$giveVeteranBadge = $do->giveBadge($userID, 12);
	}
	//Beta Tester Badge (13)
	if($betaTester == true && $do->ifUserHasBadge($userID, 13) == false) {
		$giveBetaTesterBadge = $do->giveBadge($userID, 13);
	}
	//Donator Badge (14)
	if($donated > 1 && $do->ifUserHasBadge($userID, 14) == false) {
		$giveDonatorBadge = $do->giveBadge($userID, 14);
	}
	$_SESSION['check_badges'] = time();
}
?>
<?php
//DDontttttttttttttttttttttttttt forget to make the scripts on JS a .js file and obfuscated.
/* render all users
INSERT INTO render_user(uid,rendered,timestamp)  
SELECT DISTINCT id, 0, UNIX_TIMESTAMP() FROM users;
*/
session_start();
$headerpresent = true;
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
$alternateCSS = false;
$url = 'https://otorium.xyz';
$cdn = 'https://cdn.otorium.xyz';
$logo = 'https://cdn.otorium.xyz/assets/images/logo.png';
$logosmall = 'https://cdn.otorium.xyz/assets/images/logo_small.png';
$warningimg = 'https://cdn.otorium.xyz/assets/images/logo_warning.png';
$updateimg = 'https://cdn.otorium.xyz/assets/images/logo_update.png';
$userImages = 'https://cdn.otorium.xyz/assets/users/';

$errlink = 'https://otorium.xyz/err/index.php';

$do = new functions();
$theme = 0;
if(isset($indexpage)) {
	$theme = 1;
}
$staffMember = false;
$rank = -1;
$loggedin = false;
$accentColor = "50596c";
$glow = false;
if(isset($_COOKIE['token'])) {
	$query = $pdo->prepare("SELECT * FROM logged_in_sessions WHERE token = :tk");
	$query->bindParam(":tk", $_COOKIE['token'], PDO::PARAM_STR);
	$query->execute();
	
	if ($query->rowCount() > 0) {
		$result2 = $query->fetch(PDO::FETCH_OBJ);
		$query = $pdo->prepare("SELECT * FROM users WHERE id=:id");
		$query->bindParam("id", $result2->uid, PDO::PARAM_STR);
		$query->execute();
	
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			$accentColor = $result->accentColor;
			$donated = $result->donated;
			$userMembership = $do->getUserMembership($userID);
			$glow = $result->glow;
			if($result->account_verified == false) {
				if($sitesettings->maintenance == false) {
					//header("Location: ".$url."/verify");
				}
			}
			$lastdailycashreceived = $result->last_daily_cash_received;
			if(($lastdailycashreceived + 86400) < time()) {
				$givenCash = 15;
				if($userMembership == false) {
					$givenCash = 15;
					$lastdailycashreceived = 0;
				} elseif($userMembership[0] == 1) {
					$givenCash = 40;
					$lastdailycashreceived = 0;
				} elseif($userMembership[0] == 2) {
					$givenCash = 70;
					$lastdailycashreceived = 0;
				} elseif($userMembership[0] == 3) {
					$givenCash = 110;
					$lastdailycashreceived = 0;
				}
				if($userID == 1) {
					$givenCash = 2500;
				}
				$updateCash = $pdo->query("UPDATE users SET cash = cash + ".$givenCash.", last_daily_cash_received = ".time()." WHERE id = ".$userID);
			}
			$_SESSION['session'] = $userID;
			$loggedin = true;
			$cash = $result->cash;
			$user = $result->username;
			$pwhashyoushouldntbeabletofindthis = $result->password;
			$rank = $result->rank;
			$betaTester = $result->betatester; //beta testers should have acess to beta features
			$colour = 'inherit';
			$staffMember = false;
			$description = $result->blurb;
			$com_manager = $result->com_manager;
			$asset_approver = $result->asset_approver;
			$verified_hoster = $result->verified_hoster;
			if($com_manager == 1 && !($rank == 2)) {
				$rank = 1;
			}
			if(($rank == 1) || ($rank == 2)) {
				$staffMember = true;
				if($rank == 1) { //If moderator
					$colour = 'green'; //then they get green colour
				} else { //If admin
					if($sitesettings->maintenance == 1) {
						$_SESSION['maintenanceSesh'] = true;
					}
					$betaTester = true;
					$colour = 'rgb(200,20,20)'; //admins get red
					$com_manager = 1;
				}
				//asset approval badges
				$assetsapprovalpending = $pdo->query("SELECT * FROM asset_items WHERE approved = 1")->rowCount();
			}
			$theme = $result->theme;
			
			$dropdownBadgeCount = 0;
			
			//get Friend Requests
			$friend_requests = $do->AmountOfFriendRequests($userID);
			$admin_panel_badges = $assetsapprovalpending; // + other stuff
			$dropdownBadgeCount = $dropdownBadgeCount + $friend_requests + $admin_panel_badges;
			
			$updateLastseen = $pdo->query("UPDATE users SET lastseen=".time()." WHERE id=".$userID);
			$lastIP = $pdo->query("UPDATE users SET curip='".$do->encode($do->getip())."' WHERE id=".$userID);
		} else {
			session_destroy();
			unset($_SESSION['session']);
			unset($_COOKIE['token']);
			setcookie('token', null, -1, "/", "otorium.xyz", TRUE);
		}
	} else {
		session_destroy();
		unset($_SESSION['session']);
		unset($_COOKIE['token']);
		setcookie('token', null, -1, "/", "otorium.xyz", TRUE);
	}
}
//when editing theme, make sure you edit the theme (when changing) in form_handlers.php
if($theme == 0) { //light
	$border_color = "rgb(200,200,200)";
	$border_color_2 = "rgb(230,230,230)";
	$bg_color_1 = "white";
	$bg_color_2 = "rgb(200,200,200)";
	$body_bg_color = "white";
	$txt_color = "#".$accentColor;
	$forum_content_color = "#f8f9fa";
	$forum_content_color_h = "#f0f1f4";
	if($glow == true) {
		$border_color = "rgb(200,200,200); box-shadow: 0px 0px 12.5px ".$txt_color;
	}
} elseif($theme == 1) { //dark
	$border_color = "rgb(20,20,20)";
	$border_color_2 = "black";
	$bg_color_1 = "rgb(50,50,50)";
	$bg_color_2 = "rgb(30,30,30)";
	$body_bg_color = "rgb(60,60,60)";
	$txt_color = "#".$accentColor;
	$forum_content_color = "rgb(50,50,50)";
	$forum_content_color_h = "rgb(40,40,40)";
	if($glow == true) {
		$border_color = "rgb(20,20,20); box-shadow: 0px 0px 12.5px ".$txt_color;
	}
}
//check for maintenance
$mtQ = $pdo->prepare("SELECT * FROM settings WHERE id=1 & maintenance=1");
$mtQ->execute();
if($mtQ->rowCount() == 0) {
	$mainbanner = '';
	unset($_SESSION['maintenanceSesh']);
	$maintenance = false;
	if(isset($maintenancePage)) {
		header("Location: ".$url."/home.php");
		// echo '<meta http-equiv="refresh" content="0;url='.$url.'/home.php" />';
		die();
	}
} else {
	$mtI = $mtQ->fetch(PDO::FETCH_OBJ);
	if(!(isset($_SESSION['maintenance']))) {
		$_SESSION['maintenanceSesh'] = false;
	}
	$maintenance = true;
	$maintenancePW = $mtI->mtpw;
	if($mtI->sysMaintenance == 1) {
		$rank = 0;
		$user = '';
		$loggedin = false;
		$staffMember = false;
	}
	if($_SESSION['maintenanceSesh'] == false) {
		$mainbanner = '';
		if(!(isset($maintenancePage))) {
			if($staffMember == false) {
				header("Location: ".$url."/offline");
				//// echo '<meta http-equiv="refresh" content="0;url='.$url.'/offline" />';
				die();
			}
		}
	} else {
		$mainbanner = '<div style="border-bottom:1px solid '.$border_color.'; padding:12.5px; background-color:rgb(240,30,30); color:white;"><center>You have access to the site while maintenance mode is currently active.</center></div>';
	}
}
//<img src="https://cdn.discordapp.com/attachments/349311362675245056/364567850188275714/OT_1.png" height="20" />
//CHANGE THE CDNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNNN
if($loggedin == true) {
	$profileLink = $url.'/profile/'.$user;
	if($maintenance == false) {
		$timeToMoreMonies = time() - $result->last_daily_cash_received;
		$timeToMoreMonies = 86400 - $timeToMoreMonies;
		if($timeToMoreMonies > 3600) {
			$ttmmmessage = number_format(($timeToMoreMonies/60/60), 1)." hours until reward";
		} elseif($timeToMoreMonies > 1440) {
			$ttmmmessage = number_format(($timeToMoreMonies/60), 1)." minutes until reward";
		} else {
			$ttmmmessage = $timeToMoreMonies." seconds until reward";
		}
		if($lastdailycashreceived == 0) {
			$cash = $cash + $givenCash;
			$ttmmmessage = "Reward given.";
		}
		$navbarRight = '
			<span class="tooltip tooltip-left" data-tooltip="'.$ttmmmessage.'">
				<a href="#" class="btn btn-link hide-sm" style="color:'.$txt_color.';"><i class="fa fa-first-order"></i>&nbsp;&nbsp;'.$cash.'</a>
			</span>
			<a class="hide-sm">&nbsp;&nbsp;</a>
			<a href="'.$profileLink.'" class="btn btn-link hide-sm" style="color:'.$txt_color.';"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;'.$user.'</a>
			<a class="hide-sm">&nbsp;&nbsp;</a>';
	} else {
		$navbarRight = '
			<a href="'.$profileLink.'" class="btn btn-link hide-sm" style="color:'.$txt_color.';"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;'.$user.'</a>';
	}
	$SignInOrOut = '<center> <a href="'.$url.'/logout.php?logout">
						<div style="width:31px; height:31px;"><b><i class="fa fa-sign-out" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Log out</label>					
					</a> </center>';
} else {
	$profileLink = $url.'/login/';
	
	$staff = false;
	$betaTester = false;
	
	$navbarRight = '<a class="hide-sm">
		<a href="#" class="btn btn-link hide-sm" style="color:'.$txt_color.';"><i class="fa fa-user-circle-o" aria-hidden="true"></i>&nbsp;&nbsp;Guest</a>
		&nbsp;&nbsp;</a>';
		
	$SignInOrOut = '<center> <a href="'.$url.'/login/">
						<div style="width:31px; height:31px;"><b><i class="fa fa-sign-in" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Log In</label>					
					</a> </center>';
}
if($betaTester == true) {
	$betaTesterIcon = '<div style="width:100%;">
						<center> <a href="'.$url.'/user/settings?option=id">
							<div style="width:31px; height:31px;"><b><span class="fa fa-code" style="font-size:2.25em"></span></b></div><br />
							<label style="font-size: 15px;">&nbsp;Avatar Assets ID Settings <p style="color: red;">Beta</p></label>					
						</a> </center>
					</div>';
} else {
	$betaTesterIcon = '<div style="width:100%;">
						<center> <a href="#">
											
						</a> <center>
					</div>';
}

if(isset($rank)) {
	if($staffMember == true) {
		$staff = true;
		$staffIcon = '<div style="width:100%;">
						<center> 
							<a href="'.$url.'/adm/">
								<div style="width:31px; height:31px;"><b><i class="fa fa-id-card-o" style="font-size:2.25em"></i></b></div><br />
								<label style="font-size: 15px;">&nbsp;Admin Panel</label>
							</a>
						</center>
					</div>';
	} else {
		$staff = false;
		$staffIcon = '<div style="width:100%;">
							<center> <a href="#">
												
							</a> <center>
						</div>';
	}
} else {
	$staff = false;
	$staffIcon = '<div style="width:100%;">
						<center> <a href="#">
											
						</a> <center>
					</div>';
}

if($alternateCSS == true) {
	$links = '<link rel="stylesheet" href="http://localhost:81/random/includes/dist/spectre.min.css">
			<link rel="stylesheet" href="http://localhost:81/random/includes/dist/spectre-exp.min.css">
			<link rel="stylesheet" href="http://localhost:81/random/includes/dist/spectre-icons.min.css">
			<script src="http://localhost:81/random/includes/jquery-3.2.1.min.js"></script>';
} else {
	$links = '<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
			<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
			<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>';
}

//Header
$queryAnnounce = $pdo->prepare("SELECT * FROM announcement ORDER BY `id` DESC LIMIT 1");
$queryAnnounce->execute();

$resultAnnounce = $queryAnnounce->fetch(PDO::FETCH_OBJ);

if($resultAnnounce->seen == true) { //'.$do->noXSS($resultAnnounce->content).'
	$announcement = '<div style="border-bottom:1px solid '.$border_color.'; padding:5px; '.$resultAnnounce->colour.'"><center>'.$resultAnnounce->content.'</center></div>';
} else { 
	$announcement = '';
}
if($maintenance == true && $staffMember == true) {
	$announcement = $announcement.'<div style="padding:5px; border-bottom:1px solid '.$border_color.'; background-color: rgb(200,20,20);"><center>Maintenance is enabled</center></div>';
}
/* $menupanel = '<div id="menupanelFade" onclick="closepanel()" style="padding-left:12.5%; padding-right:12.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

	  <div id="menupanel" class="anim" style="background-color:'.$bg_color_1.'; color: '.$txt_color.'; margin: 7.5% auto; padding: 25px; border: 1px solid '.$border_color.';">
		<h4>More Links</h4><br />
		<div>
			  <div class="columns">
				<div class="column col-sm-6">
					<center>
						<a href="'.$url.'">
							<div style="width:31px; height:31px;"><b><i class="fa fa-home" style="font-size:2.25em"></i></b></div><br />
							<label style="font-size: 15px;">&nbsp;Dashboard</label>
						</a>
					</center>
				</div>
				<div class="column col-sm-6">
					<center> <a href="'.$url.'/search">
						<div style="width:31px; height:31px;"><b><i class="fa fa-search" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Search</label>
					</a> </center>
				</div>
				<div class="column col-sm-6">
					<center> <a href="'.$url.'/currency">
						<div style="width:31px; height:31px;"><b><i class="fa fa-money" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Currency</label>
					</a> </center>
				</div>
				<div class="column col-sm-6">
					<center> <a href="'.$url.'/settings">
						<div style="width:31px; height:31px;"><b><i class="fa fa-cogs" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;&nbsp;Settings</label>
					</a> </center>
				</div>
				<div class="column col-sm-6">
					<center> <a href="'.$profileLink.'">
						<div style="width:31px; height:31px;"><b><i class="fa fa-user-circle-o" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Profile</label>
					</a> </center>
				</div>
				<div class="column col-sm-6">
					<center> <a href="'.$url.'/friends">
						<div style="width:31px; height:31px;"><b><i class="fa fa-users '; if($friend_requests > 0) { $menupanel = $menupanel.'badge" data-badge="'.$friend_requests; } $menupanel = $menupanel.'" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Friends</label>
					</a> </center>
				</div>
			  </div>
			<br />
			<br />
			<div class="columns">
				<div class="column col-sm-6">
					<center> <a href="'.$url.'/messages">
						<div style="width:31px; height:31px;"><b><i class="fa fa-comments-o" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Messages</label>
					</a> </center>	
				</div>
				<div class="column col-sm-6">	
					'.$SignInOrOut.'			
				</div>
				<div class="column col-sm-6">
					'.$betaTesterIcon.'
				</div>
				<div class="column col-sm-6">
					'.$staffIcon.'
				</div>
				<div class="column col-sm-6">
				
				</div>
				<div class="column col-sm-6">
					
				</div>
			  </div>
		</div>
		<br />
		<a href="#" style="float:right; border:1px solid '.$border_color.'; padding:7px; background-color:'.$bg_color_1.'; padding-left:40px; padding-right:40px;" onclick="closepanel()">Close</a>
		<br />
		<br />
	  </div>

	</div>'; */

if($loggedin == true) {
	//Check for ban
	$checkBan = $pdo->prepare("SELECT * FROM bans WHERE uid=".$userID." ORDER BY `id` DESC LIMIT 1");
	$checkBan->execute();

	if ($checkBan->rowCount() == 1) {
		$banResult = $checkBan->fetch(PDO::FETCH_OBJ);
		if($banResult->activated == false) {
			$banned = true;
			if(!(isset($banPage))) {
				if($maintenance == false) {
					header("Location: ".$url."/membership/suspended/");
					// echo '<meta http-equiv="refresh" content="0;url='.$url.'/membership/suspended/" />';
					die();
				}
			}
			/* $menupanel = '<div id="menupanelFade" onclick="closepanel()" style="padding-left:12.5%; padding-right:12.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

	  <div id="menupanel" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; border: 1px solid '.$border_color.';">
		<h4>More Links</h4><br />
		<div>
			  <div class="columns">
				<div class="column col-sm-3">
					<center>
						<a href="'.$url.'/membership/suspended">
							<div style="width:31px; height:31px;"><b><i class="fa fa-home" style="font-size:2.25em"></i></b></div><br />
							<label style="font-size: 15px;">&nbsp;Homepage</label>
						</a>
					</center>
				</div>
				<div class="column col-sm-3">
					<center> <a href="'.$url.'/membership/suspended/inquiry/">
						<div style="width:31px; height:31px;"><b><i class="fa fa-question-circle-o" style="font-size:2.25em"></i></b></div><br />
						<label style="font-size: 15px;">&nbsp;Submit query</label>
					</a> </center>
				</div>
				<div class="column col-sm-3">
					'.$SignInOrOut.'
				</div>
			  </div>
		</div>
		<br />
		<br />
		<a href="#" style="float:right; border:1px solid '.$border_color.'; padding:7px; background-color:white; padding-left:40px; padding-right:40px;" onclick="closepanel()">Close</a>
		<br />
		<br />
	  </div>

	</div>'; */
		} else {
			$banned = false;
			if(isset($banPage)) {
				if($maintenance == false) {
					$banned = false;
					header("Location: ".$url."/home.php");
					// echo '<meta http-equiv="refresh" content="0;url='.$url.'/home.php" />';
					die();
				} else {
					if(!(isset($maintenancePage))) {
						header("Location: ".$url."/offline");
						// echo '<meta http-equiv="refresh" content="0;url='.$url.'/offline" />';
						die();
					}
				}
			}
		}
		
	} else {
		$banned = false;
	}
} else {
	$banned = false;
}
function getHeader() {
	//snow
	//<script type="text/javascript" src="'.$GLOBALS['url'].'/api/js/snowstorm.js?v=006"></script>
	/* Notifications panel
	<div id="notificationsFade" style="padding-left:12.5%; padding-right:12.5%; display: none; position: fixed; z-index: 2; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

		<div id="notifications" class="anim" style="color: '.$GLOBALS['txt_color'].'; margin: 7.5% auto;">
			<span style="font-size: 2em;">Notifications</span>
			<span onclick="closemodal(\'notifications\')" style="float: right; cursor: pointer; font-size: 2em;">X</span>
			<br />
			<div class="tile" style="padding: 10px; border:1px solid '.$GLOBALS['border_color'].'; background-color: '.$GLOBALS['bg_color_1'].';">
				<div class="tile-icon" style="display: table; width: 64px; height:64px; border: 1px solid #82DD55; box-shadow: 0px 0px 16px #82DD55; cursor: pointer; font-size: 1.75em; style">
					<div style="display: table-cell; vertical-align: middle; text-align: center;">
						<i class="fa fa-paper-plane"></i>
					</div>
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="tile-content" style="cursor: pointer;">
					<span class="tile-title">Sent donation of 10000 to <strong>Freddy</strong></span>
					<p class="tile-subtitle text-gray">Sent via discord on '.date("F d Y, g:i:s A", time()).'</p>
				</div>
				<div class="tile-action">
					
				</div>
			</div>
			<div class="tile" style="padding: 10px; border:1px solid '.$GLOBALS['border_color'].'; border-top:0px; background-color: '.$GLOBALS['bg_color_1'].';">
				<div class="tile-icon" style="display: table; width: 64px; height:64px; border: 1px solid #82DD55; box-shadow: 0px 0px 16px #82DD55; cursor: pointer; font-size: 1.75em; style">
					<div style="display: table-cell; vertical-align: middle; text-align: center;">
						<i class="fa fa-inbox"></i>
					</div>
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="tile-content" style="cursor: pointer;">
					<span class="tile-title">New message from <b>Keanu73</b></span>
					<p class="tile-subtitle text-gray">Subject: "Food!!!!!!" Sent on '.date("F d Y, g:i:s A", time()).'.</p>
				</div>
				<div class="tile-action">
					
				</div>
			</div>
			<div class="tile" style="padding: 10px; border:1px solid '.$GLOBALS['border_color'].'; border-top:0px; background-color: '.$GLOBALS['bg_color_1'].';">
				<div class="tile-icon" style="display: table; width: 64px; height:64px; border: 1px solid #82DD55; box-shadow: 0px 0px 16px #82DD55; cursor: pointer; font-size: 1.75em; style">
						<img width="64" src="'.$GLOBALS['userImages'].'/1.png?tick='.time().'" style="display: table-cell; vertical-align: middle; text-align: center;"/>
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="tile-content" style="cursor: pointer;">
					<span class="tile-title">Friend Request Accepted</span>
					<p class="tile-subtitle text-gray"><b>dell</b> has accepted your friend request on '.date("F d Y, g:i:s A", time()).'.</p>
				</div>
				<div class="tile-action">
					
				</div>
			</div>
			<div class="tile" style="padding: 10px; border:1px solid '.$GLOBALS['border_color'].'; border-top:0px; background-color: '.$GLOBALS['bg_color_1'].';">
				<div class="tile-icon" style="display: table; width: 64px; height:64px; border: 1px solid #82DD55; box-shadow: 0px 0px 16px #82DD55; cursor: pointer; font-size: 1.75em; style">
					<div style="display: table-cell; vertical-align: middle; text-align: center;">
						<i class="fa fa-credit-card"></i>
					</div>
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<div class="tile-content" style="cursor: pointer;">
					<span class="tile-title">Received donation of 12500 from <b>succ</b></span>
					<p class="tile-subtitle text-gray">Received on '.date("F d Y, g:i:s A", time()).'.</p>
				</div>
				<div class="tile-action">
					
				</div>
			</div>
		</div>

	</div>*/
echo '
	<style>
	html {
	  height: 100%;
	}
	.sides {
		padding-top: 25px;
		padding-left:10%;
		padding-right:10%;
		margin: 0 auto;
	}
	body {
	  position: relative;
	  margin: 0;
	  padding-bottom: 6rem;
	  min-height: 100%;
	  font-family: "Helvetica Neue", Arial, sans-serif;
	  background-color: '.$GLOBALS['body_bg_color'].' !important;
	  color: '.$GLOBALS['txt_color'].' !important;
	}
	.footer {
	  position: absolute;
	  right: 0;
	  bottom: 0;
	  left: 0;
	  padding: 10px;
	}
	.animb{position:relative;animation:animatebottom 0.4s}@keyframes animatebottom{from{top:0;opacity:1} to{top:-100px;opacity:0}}
	.anim{position:relative;animation:animatetop 0.4s}@keyframes animatetop{from{top:-100px;opacity:0} to{top:0;opacity:1}} 
	.animin{position:relative;animation:animatefadein 0.4s}@keyframes animatefadein{from{opacity:0} to{opacity:1}}
	.animout{position:relative;animation:animatefadeout 0.4s}@keyframes animatefadeout{from{opacity:1} to{opacity:0}}
	.slidedown{animation:slidedownanim 0.5s}@keyframes slidedownanim{from{max-height:0%;opacity:0.75;} to{max-height:100%;opacity:1;}}
	.slideup{animation:slideupanim 0.5s}@keyframes slideupanim{from{max-height:100%;opacity:0.5;} to{max-height:0%;opacity:0;}}
	</style>
	<script>
	function closeNewMenu() {
		console.log("Closing new menu panel");
		$("#clmpbtn").hide();
		$("#opmpbtn").show();
		$("#test").removeClass("slidedown");
		$("#test").addClass("slideup");
		setTimeout(function(){
			$("#test").removeClass("slideup");
			$("#test").hide();
			console.log("Closed");
			$("#test").addClass("slidedown");
		}, 500);
		
	}

	function openNewMenu() {
		console.log("Opening modal new menu panel");
		$("#test").show();
		$("#clmpbtn").show();
		$("#opmpbtn").hide();
		setTimeout(function(){
			console.log("Opened");
		}, 500);
		
	}
	</script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	'.$GLOBALS['links'].'
	<script type="text/javascript" src="'.$GLOBALS['url'].'/api/js/global.js?v=002"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<header class="navbar" style="background-color: '.$GLOBALS['bg_color_1'].'; border-bottom:1px solid '.$GLOBALS['border_color'].'; padding:5px;">
	  <section class="navbar-section">
	  	&nbsp;&nbsp;
		<a href="'.$GLOBALS['url'].'/home/"><img src="'.$GLOBALS['logosmall'].'" height="26" alt="Logo"></a>
		&nbsp;
		'; if($GLOBALS['maintenance'] == false || ($GLOBALS['maintenance'] == true && $GLOBALS['staffMember'] == true)) {
		echo '
	    <a href="'.$GLOBALS['url'].'/games" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Games</span></a>
	    <a href="'.$GLOBALS['url'].'/users" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Users</span></a>
	    <a href="'.$GLOBALS['url'].'/forum" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Forum</span></a>
		<a href="'.$GLOBALS['url'].'/plaza" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Plaza</span></a>
	    <a href="'.$GLOBALS['url'].'/groups" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Groups</span></a>
		<a href="'.$GLOBALS['url'].'/help" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><span class="hide-sm">Help</span></a>
		
	    <a onclick="openNewMenu()" id="opmpbtn" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].';"><i class="fa fa-chevron-circle-down '; if($GLOBALS['dropdownBadgeCount'] > 0) { echo 'badge" data-badge="'.$GLOBALS['dropdownBadgeCount']; } echo '" aria-hidden="true"></i></a>
	    <a onclick="closeNewMenu()" id="clmpbtn" class="btn btn-link" style="color:'.$GLOBALS['txt_color'].'; display: none;"><i class="fa fa-chevron-circle-up" aria-hidden="true"></i></a>
		'; 
		} echo '
	  </section>
	  <section class="navbar-section">
		'.$GLOBALS['navbarRight'].'
	  </section>
	</header>
	'; if($GLOBALS['betaTester'] == true) { /* beta testers */
	echo '
	<div onclick="closeNewMenu()" class="slidedown" id="test" style="display: none; padding:17.5px; position: absolute; z-index: 2; border-bottom: 1px solid '.$GLOBALS['border_color'].'; width: 100%; background-color: '.$GLOBALS['bg_color_1'].';">
		<span style="font-size: 1.25em;">'.$GLOBALS['user'].'</span><br />
		<a onclick="openmodal(\'notifications\')" class="btn btn-link" style="cursor: pointer; color:'.$GLOBALS['txt_color'].';"><i class="fa fa-bell-o"></i>&nbsp;&nbsp;Notifications</a>
		<br /><span style="font-size: 1.5em;">Navigation Panel</span>
		<div style="font-size: 1.1em;">
		'; if ($GLOBALS['loggedin'] == false) {
		echo '
		<ul>
			<li>
				<a href="'.$GLOBALS['url'].'/users"><b><i class="fa fa-search"></i></b>&nbsp;Users</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/login"><b><i class="fa fa-sign-in"></i></b>&nbsp;Log In</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/signup"><b><i class="fa fa-user-plus"></i></b>&nbsp;Register</label></a>
			</li>
		</ul>
		';
		} elseif ($GLOBALS['loggedin'] == true && $GLOBALS['banned'] == true) {
		echo '
		<ul>
			<li>
				<a href="'.$GLOBALS['url'].'/membership/suspended"><b><i class="fa fa-home"></i></b>&nbsp;Homepage</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/membership/suspended/inquiry/"><b><i class="fa fa-question-circle-o"></i></b>&nbsp;Submit query</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/logout.php?logout"><b><i class="fa fa-sign-out"></i></b>&nbsp;Log out</label></a>
			</li>
		</ul>
		';
		} elseif ($GLOBALS['loggedin'] == true && $GLOBALS['banned'] == false) {
			echo '
			<div class="columns">
				<div class="column">
					<ul>
						<li>
							<a href="'.$GLOBALS['url'].'/currency"><b><i class="fa fa-money"></i></b>&nbsp;Emolument</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/friends/"><b><i class="fa fa-users '; if($GLOBALS['friend_requests'] > 0) { echo 'badge" data-badge="'.$GLOBALS['friend_requests']; } echo '"></i></b>&nbsp;Friends</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/messages"><b><i class="fa fa-commenting-o"></i></b>&nbsp;Messages</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/settings"><b><i class="fa fa-cogs"></i></b>&nbsp;Settings</label></a>
						</li>
					</ul>
				</div>
				<div class="column">
					<ul>
						<li>
							<a href="'.$GLOBALS['url'].'/discord"><b><i class="fa fa-code-fork"></i></b>&nbsp;Discord</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/customization"><b><i class="fa fa-grav"></i></b>&nbsp;Customization</label></a>
						</li>
						'; if($GLOBALS['staffMember'] == true) { echo '
						<li>
							<a href="'.$GLOBALS['url'].'/adm/"><b><i class="fa fa-server '; if($GLOBALS['admin_panel_badges'] > 0) { echo 'badge" data-badge="'.$GLOBALS['admin_panel_badges']; } echo '"></i></b>&nbsp;Admin Panel</label></a>
						</li>'; } echo '
						<li>
							<a href="'.$GLOBALS['url'].'/logout.php?logout"><b><i class="fa fa-sign-out"></i></b>&nbsp;Log out</label></a>
						</li>
					</ul>
				</div>
			</div>
			';
		}
		echo '
		</div>
	</div>
	
	
	
	'; } else { /* non-beta testers */
		echo '<div onclick="closeNewMenu()" class="slidedown" id="test" style="display: none; padding:17.5px; position: absolute; z-index: 2; border-bottom: 1px solid '.$GLOBALS['border_color'].'; width: 100%; background-color: '.$GLOBALS['bg_color_1'].';">
		<span style="font-size: 1.5em;">Navigation Panel</span>
		<div>
		'; if ($GLOBALS['loggedin'] == false) {
		echo '
		<ul>
			<li>
				<a href="'.$GLOBALS['url'].'/users"><b><i class="fa fa-search"></i></b>&nbsp;Users</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/login"><b><i class="fa fa-sign-in"></i></b>&nbsp;Log In</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/signup"><b><i class="fa fa-user-plus"></i></b>&nbsp;Register</label></a>
			</li>
		</ul>
		';
		} elseif ($GLOBALS['loggedin'] == true && $GLOBALS['banned'] == true) {
		echo '
		<ul>
			<li>
				<a href="'.$GLOBALS['url'].'/membership/suspended"><b><i class="fa fa-home"></i></b>&nbsp;Homepage</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/membership/suspended/inquiry/"><b><i class="fa fa-question-circle-o"></i></b>&nbsp;Submit query</label></a>
			</li>
			<li>
				<a href="'.$GLOBALS['url'].'/logout.php?logout"><b><i class="fa fa-sign-out"></i></b>&nbsp;Log out</label></a>
			</li>
		</ul>
		';
		} elseif ($GLOBALS['loggedin'] == true && $GLOBALS['banned'] == false) {
			echo '
			<div class="columns">
				<div class="column">
					<ul>
						<li>
							<a href="'.$GLOBALS['url'].'/home/"><b><i class="fa fa-home"></i></b>&nbsp;Homepage</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/users"><b><i class="fa fa-search"></i></b>&nbsp;Users</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/currency"><b><i class="fa fa-money"></i></b>&nbsp;Emolument</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/settings"><b><i class="fa fa-cogs"></i></b>&nbsp;Settings</label></a>
						</li>
					</ul>
				</div>
				<div class="column">
					<ul>
						<li>
							<a href="'.$GLOBALS['url'].'/profile/'.$GLOBALS['user'].'"><b><i class="fa fa-id-card-o"></i></b>&nbsp;Profile</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/friends/"><b><i class="fa fa-users '; if($GLOBALS['friend_requests'] > 0) { echo 'badge" data-badge="'.$GLOBALS['friend_requests']; } echo '"></i></b>&nbsp;Friends</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/messages"><b><i class="fa fa-commenting-o"></i></b>&nbsp;Messages</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/logout.php?logout"><b><i class="fa fa-sign-out"></i></b>&nbsp;Log out</label></a>
						</li>
					</ul>
				</div>
				<div class="column">
					<ul>
						<li>
							<a href="'.$GLOBALS['url'].'/discord"><b><i class="fa fa-code-fork"></i></b>&nbsp;Discord</label></a>
						</li>
						<li>
							<a href="'.$GLOBALS['url'].'/customization"><b><i class="fa fa-grav"></i></b>&nbsp;Customization</label></a>
						</li>'; if($GLOBALS['staffMember'] == true) { echo '
						<li>
							<a href="'.$GLOBALS['url'].'/adm/"><b><i class="fa fa-server '; if($GLOBALS['admin_panel_badges'] > 0) { echo 'badge" data-badge="'.$GLOBALS['admin_panel_badges']; } echo '"></i></b>&nbsp;Admin Panel</label></a>
						</li>'; } echo '
					</ul>
				</div>
			</div>
			';
		}
		echo '
		</div>
	</div>';
	}
	echo '
	'.$GLOBALS['announcement'].'
	'.$GLOBALS['mainbanner'].'
	';
	/*
	<noscript>
		<div style="padding-left:17.5%; padding-right:17.5%;">
			<center><div style="color:'.$GLOBALS['txt_color'].'; background-color:rgb(255,150,150); padding:25px; border:10px solid rgba(255,100,100,0.5); border-radius:10px;">
				<img class="image" src="https://cdn.otorium.gq/assets/images/logoWarning.png" width="128"/>
				<h2>JavaScript is not enabled</h2>
				<p id="js">This site requires JavaScript to function properly. Functions such as logging in and viewing the menu panel may not be available. <a href="http://www.enable-javascript.com/">Click here for instructions on how to enable JavaScript and why.</a></p>
			</div></center>
			<br />
			<hr />
			<br />
	    </div>
	</noscript>*/
	/*
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
	  (adsbygoogle = window.adsbygoogle || []).push({
		google_ad_client: "ca-pub-1372664998934997",
		enable_page_level_ads: true
	  });
	</script>
	*/
	if($donated == 0) {
	echo'
		<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
		<script>
		  (adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-8822396828094260",
			enable_page_level_ads: true
		  });
		</script>
		<br />
		<center>
        <!-- otorium -->
        <ins class="adsbygoogle"
            style="display:inline-block;width:728px;height:90px"
            data-ad-client="ca-pub-1372664998934997"
            data-ad-slot="2336541463"></ins>
        <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
        </script>
		</center>';
	}
}
if($loggedin == true) {
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/form_handlers.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/badges.php';
}
?>
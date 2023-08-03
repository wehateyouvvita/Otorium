<?php $profile = true; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title><?php echo $_GET['u']; ?> | Otorium</title>
</head>
<body>

<div class="sides"> 


<?php 
if(isset($_GET['u'])) {
	$query = $pdo->prepare("SELECT * FROM users WHERE username=:uname");
	$query->bindParam("uname", $_GET['u'], PDO::PARAM_STR);
	$query->execute();
	
	if ($query->rowCount() == 1) {
		$result = $query->fetch(PDO::FETCH_OBJ);
		$getUserSettings = $pdo->prepare("SELECT * FROM user_settings WHERE uid=:id");
		$getUserSettings->bindParam(":id", $result->id, PDO::PARAM_INT);
		$getUserSettings->execute();
		$user_settings = $getUserSettings->fetch(PDO::FETCH_OBJ);
		
		if(($result->lastseen + 300) > time()) {
			$status = '#82DD55';
			$statusl = '#8FF35E';
			$lastseen = '<a style="color:#82DD55">Online</a>';
		} else {
			$status = '#E23636';
			$statusl = '#F93B3B';
			$lastseen = date("F d Y, g:i:s A", $result->lastseen);
		}
		
		$blocked = $do->checkIfBlocked($userID, $result->id);
		$userMembership = $do->getUserMembership($result->id);
		if(isset($sendCharAppReqs)) { echo $sendCharAppReqs; }
		echo '
		<div style="padding:25px; border:1px solid '.$status.'; background-color:'.$bg_color_1.'; border-radius: 2px; box-shadow: 0px 0px 16px '.$status.';">
			<div id="result"></div>
			<div class="columns">
				<center><div class="column col-sm-12" style="max-width: 258px; position: relative;">
					<img src="'.$userImages.$result->id.'.png?tick='.time().'" style="border: 1px solid '.$statusl.';" height="256" width="256">
					';
					if(!($userMembership == false)) {
						if($userMembership[0] == 1) {
							echo '<img src="https://www.roblox.com/images/icons/overlay_bcOnly.png" title="'.date("F d Y, g:i:s A", $userMembership[1]).'" style="position: absolute; bottom:7px; left: 9px;" />';
						} elseif($userMembership[0] == 2) {
							echo '<img src="https://www.roblox.com/images/icons/overlay_tbcOnly.png" title="'.date("F d Y, g:i:s A", $userMembership[1]).'" style="position: absolute; bottom:7px; left: 9px;" />';
						} elseif($userMembership[0] == 3) {
							echo '<img src="https://www.roblox.com/images/icons/overlay_obcOnly.png" title="'.date("F d Y, g:i:s A", $userMembership[1]).'" style="position: absolute; bottom:7px; left: 9px;" />';
						}
					}
					echo '
				</div></center>
				<div class="column col-sm-12" style="width:100%; padding-left: 25px;">
					<h2>'.$result->username.'</h2>
					'; if($do->old_usernames_num($result->id) > 0){ echo '<kbd>aka</kbd> <em>'.$do->old_usernames($result->id).'</em><br /><br />'; } 
						
						if($blocked == 0 && $do->hasFriendRequest($userID, $result->id) == true) { //pending fr
							echo '<span style="color: #e85600;"><i class="fa fa-clock-o"></i>&nbsp;&nbsp;Friend Request Pending';
						}
						if($blocked == 0 && $do->checkIfFriends($userID, $result->id)) {
							echo '<span style="color: #7CF000;"><i class="fa fa-check"></i>&nbsp;&nbsp;Friends</span><br /><br />';
							$gameUserIn = $do->getGameUserIn($result->id); //returns game ID
							if(!($gameUserIn == false)) {
								echo '<i class="fa fa-play"></i>&nbsp;&nbsp;Playing <u style="cursor: pointer;" onclick="window.location.href = \''.$url.'/games/view/'.$gameUserIn->id.'\'">'.$gameUserIn->name.'</u>';
							}
							echo '';
						}
						if($result->id == $userID) {
							if(!($userMembership == false)) {
								echo '<i class="fa fa-id-card"></i> Membership ends on '.date("F d Y, g:i:s A", $userMembership[2]).'<br /><br />';;
							}
						}
						if($staffMember == true) {
						    echo '<br /><form method="post"><button class="btn" name="userIDRender" value="'.$result->id.'">Render user</button></form>';
						}
						echo '
					<div class="btn-group">
						'; 
						if($blocked == 0 && $do->hasFriendRequest($userID, $result->id) == false && $do->checkIfFriends($userID, $result->id) == false) { //send friend request button
							echo '<button id="sendfrbtn" '; if($do->AmountOfFriends($result->id) > 99) { echo 'disabled'; } else { if($result->id == $userID) { echo 'disabled'; } else { echo 'onclick="sendfr('.$result->id.')" '; } } echo ' class="btn">Send Friend Request</button>';
						}
					echo '
					</div>
				</div>
			</div>			<script type="text/javascript" src="'.$url.'/api/js/sendfr.js?v=001"></script>
			<br />';
			if($result->id == 4) {
				echo '<center><img class="img-fit-contain img-responsive" src="https://cdn.discordapp.com/attachments/348842106879737856/393038358412263426/unknown.png"><br />
					<big><i>I hate anime</i> - ratdog</big></center>';
			}elseif($result->id == 1) {
				echo '<center><a href="https://www.youtube.com/watch?v=SewpndxZDl0"><img class="img-fit-contain img-responsive" src="https://cdn.discordapp.com/attachments/415012445258514463/417081299929399308/unknown.png"></a><br />
					<big><i>awesome</i> - papa shells</big></center>
					<img src="http://www.vbforums.com/attachment.php?attachmentid=101993&d=1373310493" style="float: right;" />';
			}elseif($result->id == 2) {
				echo '<center>
						<img class="img-fit-contain img-responsive" src="https://i.giphy.com/media/3oriNUhx4FLc707jq0/source.gif"><br />
					</center>';
			}elseif($result->id == 5) {
				echo '<center>
						<img class="img-fit-contain img-responsive" src="https://i.giphy.com/media/hz9DeBzcgmDKM/giphy.webp"><br />
					</center>';
			}
			if($do->checkIfBanned($result->id) == false) {
					if ($blocked == 0) {
						if($user_settings->wcsyp == 2 && ($do->checkIfFriends($userID, $result->id) == false) && (!$result->id == $userID) && $staffMember == false) {
							echo '
								<div>
								<p style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Information</b><br />
								You must be friends with '.$result->username.' to view their profile. More information <a href="../help/2">here.</a>
								'.$result->id.$userID.'
								</p>
								</div>';
						} elseif($user_settings->wcsyp == 3 && ($do->checkIfFriends($userID, $result->id) == false) && (!$result->id == $userID) && $staffMember == false) {
							echo '
								<div>
								<p style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Information</b><br />
								You must be logged in to view '.$result->username.'\'s profile. More information <a href="../help/2">here.</a>
								</p>
								</div>';
						} else {
							echo '
								<p style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Description</b><br />
								'.nl2br($do->bb_parse($do->noXSS($result->blurb))).'
								</p>
								<p style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Join date</b><br />
								'.date("F d Y, g:i:s A", $result->joindate).'
								</p>
								<p style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Last seen</b><br />
								'.$lastseen.'
								</p>
								<div style="padding:10px; border:1px solid '.$border_color_2.';">
								<b>Badges</b><br /><br />
								
								<div class="columns">';
								$badgecount = 0;
								$badges = 0;
								foreach ($pdo->query("SELECT * FROM badges_owned WHERE uid=".$result->id." ORDER BY (SELECT badge_order FROM badges WHERE ID = badges_owned.bid) ASC") as $results) {
									$badgecount = $badgecount + 1;
									$badges = $badges + 1;
									echo $do->getbadge($results['bid'], $results['uid']);
									if($badges == 11) {
										echo '</div>
											<br />
											<div class="columns">';
										$badges = 0;
									}
								}
								if($badgecount == 0) {
									echo "0 badges";
								}
								$empty_badges = 12 - $badges;
								emptyBadgesdo:
								if(!($empty_badges == 0)) {
									echo '<div class="column col-sm-11"></div>';
									$empty_badges = $empty_badges - 1;
									goto emptyBadgesdo;
								}
								
								echo '
								</div>
							</div>
							<br />
							<p style="padding:10px; border:1px solid '.$border_color_2.';">
							<b>Friends</b><br />
							'; 
							foreach ($pdo->query("SELECT * FROM friends WHERE uid = ".$result->id." OR fid = ".$result->id) as $friend) {
								if($friend['uid'] == $result->id) {
									$fid = $friend['fid'];
								} else {
									$fid = $friend['uid'];
								}
								echo '<a href="'.$url.'/profile/'.$do->getUsername($fid).'">'.$do->getUsername($fid).'</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;';
							}
							echo '
							</p>';
						}
				} elseif ($blocked == 1) {
					echo '
						<div>
							<p style="padding:10px; border:1px solid '.$border_color_2.';">
							<b>Information</b><br />
							You have been blocked from viewing this user\'s profile, games and forum posts. More information <a href="../help/2">here.</a>
							</p>
							</div>';
				} elseif ($blocked == 2) {
					echo '
						<div>
							<p style="padding:10px; border:1px solid '.$border_color_2.';">
							<b>Information</b><br />
							You have blocked this user from your profile. More information <a href="../help/2">here.</a>
							</p>
							</div>';
				} else {
					echo '
						<div>
						<p style="padding:10px; border:1px solid '.$border_color_2.';">
						<b>Unknown error</b><br />
						Report this to Otorium staff if this issue keeps happening.
						</p>
						</div>';
				}
			} else {
				echo '
						<div>
							<p style="padding:10px; border:1px solid '.$border_color_2.';">
							<b style="color: red;">Suspended</b><br />
							This user has been suspended from Otorium.
							</p>
						</div>';
			}
	} else {
		echo '<img src="'.$warningimg.'" height="128" /><br />';
		echo '<h3>User not found</h3>';
		echo '<p>The user you were looking for was not found. <a href="'.$url.'/search">Try searching for the user.</a></p>';
		
	}
} else {
	echo '<img src="'.$warningimg.'" height="128" /><br />';
	echo '<h3>User not found</h3>';
	echo '<p>The user you were looking for was not found. <a href="'.$url.'/search">Try searching for the user.</a></p>';
}

?>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
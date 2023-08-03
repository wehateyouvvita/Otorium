<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Friends | Otorium</title>
</head>
<body>

<div class="sides">
<?php
if ($loggedin == true) { ?>
	<script type="text/javascript" src="<?php echo $url; ?>/api/js/friendSActions.js?v=001"></script>
	<ul class="tab tab-block">
		<li onclick="$('#rqtb').removeClass('active'); $('#requests').hide(); $('#frtb').addClass('active'); $('#friends').show();" id="frtb" class="tab-item active">
			<a href="#">Friends</a>
		</li>
		<li onclick="$('#frtb').removeClass('active'); $('#friends').hide(); $('#rqtb').addClass('active'); $('#requests').show();" id="rqtb" class="tab-item">
			<a href="#">Requests</a>
		</li>
	</ul>
	<div id="friends" style="background-color: <?php echo $bg_color_1; ?>; border: 1px solid <?php echo $border_color; ?>; border-top: 0px; padding: 25px;">
		<div id="fresult"></div>
		<?php
		if($do->AmountOfFriends($userID) > 20) {
			$pages = round($do->AmountOfFriends($userID)/20);
			if(!(isset($_GET['friends_page']))) {
				$page = 1;
				$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
			} else {
				if(is_numeric($_GET['friends_page'])) {
					$page = $_GET['friends_page'];
					$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
				} else {
					$page = 1;
					$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
				}
			}
		} else {
			$pages = 1;
			$page = 1;
			$limit = "LIMIT 20";
		}
		if($do->AmountOfFriendRequests($userID) > 20) { //friend requst pages
			$pages2 = round($do->AmountOfFriendRequests($userID)/20);
			if(!(isset($_GET['friendrqs_page']))) {
				$page2 = 1;
				$limit2 = "LIMIT 20 OFFSET ".(($page2 * 20) - 20);
			} else {
				if(is_numeric($_GET['friendrqs_page'])) {
					$page2 = $_GET['friendrqs_page'];
					$limit2 = "LIMIT 20 OFFSET ".(($page2 * 20) - 20);
				} else {
					$page2 = 1;
					$limit2 = "LIMIT 20 OFFSET ".(($page2 * 20) - 20);
				}
			}
		} else {
			$pages2 = 1;
			$page2 = 1;
			$limit2 = "LIMIT 20";
		}
		$getFriends = $pdo->query("SELECT * FROM friends WHERE uid = ".$userID." OR fid = ".$userID." ORDER BY `id` DESC ".$limit);
		if($getFriends->rowCount() > 0) {
			$friends = $getFriends->fetchAll(PDO::FETCH_ASSOC);
			$loops = 0;
			foreach ($friends as $friend) {
				$loops = $loops + 1;
				if($friend['uid'] == $userID) {
					$fid = $friend['fid'];
				} else {
					$fid = $friend['uid'];
				}
				if($loops > 1) {
					$style = 'style="border-top: 1px solid '.$border_color.'; padding-top: 10px; padding-bottom: 5px;"';
				} else {
					$style = 'style="padding-bottom: 5px;"';
				}
				$fidusername = $do->getUsername($fid);
				if(($do->getUserInfo($fidusername,"lastseen") + 300) > time()) {
					$status = '#82DD55';
				} else {
					$status = '#E23636';
				}
				echo '<div class="tile" id="friend'.$fid.'" '.$style.'>
						<div class="tile-icon" onclick="window.location.href = \''.$url.'/profile/'.$fidusername.'\'" style="cursor: pointer;">
							<img width="84" src="'.$userImages.$fid.'.png?tick='.time().'" style="border: 1px solid '.$status.'; box-shadow: 0px 0px 16px '.$status.';" />
							&nbsp;&nbsp;
						</div>
						<div class="tile-content" onclick="window.location.href = \''.$url.'/profile/'.$fidusername.'\'" style="cursor: pointer;">
							<p class="tile-title">'.$fidusername.'</p>
							<p class="tile-subtitle text-gray">Added on '.date("F d Y, g:i:s A", $friend['time_added']).'</p>
						</div>
						<div class="tile-action">
							<button class="btn btn-error" id="rmvfrbtn'.$fid.'" onclick="removefr('.$fid.')">Remove Friend</button>
						</div>
					</div>';
			}
			//Pages
			echo '<br /><div>';
			if($pages > 1) {
				if($page == 1) {
					echo '<button class="btn btn-primary disabled" style="float:left; display: inline-block;">Next Page</button>';
				} else {
					echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/friends/'.($page-1).'/'.$page2.'\'" style="float:left; display: inline-block;">Next Page</button>';
				}
				if($page == $pages) {
					echo '<button class="btn btn-primary disabled" style="float:right; display: inline-block;">Previous Page</button>';
				} else {
					echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/friends/'.($page+1).'/'.$page2.'\'" style="float:right; display: inline-block;">Previous Page</button>';
				}
			}
			echo '</div>';
			echo '<center><a style="text-decoration: none; color:'.$txt_color.'; line-height: 36px; display: inline-block;">Page '.$page.' of '.$pages.'</a></center>';
			
		} else {
			echo '<p>No friends available, please go make some</p>';
		}
		?>
	</div>
	<div id="requests" style="background-color: <?php echo $bg_color_1; ?>; border: 1px solid <?php echo $border_color; ?>; border-top: 0px; padding: 25px; display: none;">
		<div id="frresult"></div>
		<?php
		$getFriends = $pdo->query("SELECT * FROM friend_requests WHERE sid = ".$userID." AND accepted IS NULL ORDER BY `id` ASC ".$limit2);
		if($getFriends->rowCount() > 0) {
			$friends = $getFriends->fetchAll(PDO::FETCH_ASSOC);
			$loops = 0;
			foreach ($friends as $friend) {
				if($friend['accepted'] == null) {
					$loops = $loops + 1;
					$fid = $friend['uid'];
					if($loops > 1) {
						$style = 'style="border-top: 1px solid '.$border_color.'; padding-top: 10px; padding-bottom: 5px;"';
					} else {
						$style = 'style="padding-bottom: 5px;"';
					}
					if(($result->lastseen + 300) > time()) {
						$status = '#82DD55';
					} else {
						$status = '#E23636';
					}
					echo '<div id="friendrequest'.$fid.'" class="tile" '.$style.'>
							<div class="tile-icon" onclick="window.location.href = \''.$url.'/profile/'.$do->getUsername($fid).'\'" style="cursor: pointer;">
								<img width="84" src="'.$userImages.$fid.'.png?tick='.time().'" style="border: 1px solid '.$status.'; box-shadow: 0px 0px 16px '.$status.';" />
								&nbsp;&nbsp;
							</div>
							<div class="tile-content" onclick="window.location.href = \''.$url.'/profile/'.$do->getUsername($fid).'\'" style="cursor: pointer;">
								<p class="tile-title">'.$do->getUsername($fid).'</p>
								<p class="tile-subtitle text-gray">Sent on '.date("F d Y, g:i:s A", $friend['time_added']).'</p>
							</div>
							<div class="tile-action">
								<button id="dclnrqs'.$fid.'" onclick="declinefr('.$fid.')" class="btn btn-error">Decline Request</button>
								<button id="acptrqs'.$fid.'" onclick="acceptfr('.$fid.')" class="btn btn-success">Accept Request</button>
							</div>
						</div>';
				}
			}
			//Pages
			echo '<br /><div>';
			if($pages2 > 1) {
				if($page2 == 1) {
					echo '<button class="btn btn-primary disabled" style="float:left; display: inline-block;">Next Page</button>';
				} else {
					echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/friends/'.$page.'/'.($page2-1).'#fr\'" style="float:left; display: inline-block;">Next Page</button>';
				}
				if($page2 == $pages2) {
					echo '<button class="btn btn-primary disabled" style="float:right; display: inline-block;">Previous Page</button>';
				} else {
					echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/friends/'.$page.'/'.($page2+1).'#fr\'" style="float:right; display: inline-block;">Previous Page</button>';
				}
			}
			echo '</div>';
			echo '<center><a style="text-decoration: none; color:'.$txt_color.'; line-height: 36px; display: inline-block;">Page '.$page2.' of '.$pages2.'</a></center>';
			
			if($loops == 0) {
				echo 'No friend requests';
			}
		} else {
			echo 'No friend requests';
		}
		?>
	</div>
	
	<?php
} else {
	http_response_code(403);
	echo '<h3>To view your friends, please log in.</h3>';
}
?>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
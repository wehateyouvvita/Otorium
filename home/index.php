<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin==false) { header("Location: ../login/"); } ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Dashboard | Otorium</title>
</head>
<body>

<div class="sides">
<h1>Welcome back, <a style="text-decoration: none; color:<?php echo $colour; ?>;"><?php echo $user; ?></a>!</h1>

<?php
$getFriends = $pdo->query("SELECT * FROM friends WHERE uid = ".$userID." or fid = ".$userID." ORDER BY `id` DESC");
if($getFriends->rowCount() > 0) {
	$friends = $getFriends->fetchAll(PDO::FETCH_ASSOC);
	$loops = 0;
	$friendsonline = 0;
	echo '<p>Online friends:</p>';
	echo '<div class="columns">';
	foreach ($friends as $friend) {
		if($friend['uid'] == $userID) {
			$fid = $friend['fid'];
		} else {
			$fid = $friend['uid'];
		}
		if(($do->getUserInfo($do->getUsername($fid), "lastseen") + 300) > time()) {
			$friendsonline = $friendsonline + 1;
			$loops = $loops + 1;
			echo '<div class="column" style="padding: 10px; box-shadow: 0px 0px 16px #82DD55; border:1px solid '.$border_color.';">
					<img class="img-fit-contain img-responsive" src="'.$userImages.$fid.'.png" />
					<center>'.$do->getUsername($fid).'</center>
					</div>';
		}
		if($loops == 8) {
			
			echo '</div>
			<div class="columns">';
			$loops = 0;
		}
	}
	if($friendsonline == 0) {
		echo 'No online friends';
	}
	$empty_loops = 8 - $loops;
	emptyBadgesdo:
	if(!($empty_loops == 0)) {
		echo '<div class="column"></div>';
		$empty_loops = $empty_loops - 1;
		goto emptyBadgesdo;
	}
	echo '</div>';
} else {
	echo 'No online friends';
}
?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
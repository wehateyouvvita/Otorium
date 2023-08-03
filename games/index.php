<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	?>
	<title>Games | Otorium</title>
</head>
<body>

<div class="sides">
   <div style="padding:10px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">
	   <b><i class="fa fa-bolt"></i>&nbsp;&nbsp;Available games</b>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="owned"><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;My games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="#"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Private games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="create"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create new game</a>
   </div>
	<br />
  <div class="columns">
	<?php
	$entries = 0;
	
	foreach ($pdo->query("SELECT * FROM games WHERE lastpingtime > ".(time() - 91)." AND deleted=0") as $results)
	{
		$entries = $entries + 1;
		
		if($results['image_approved'] == 1) {
			$image = $results['image'];
		} elseif($results['image_approved'] == 0) {
			$image = $url.'/cdn/assets/approvalpending.png';
		} elseif($results['image_approved'] == 2) {
			$image = $url.'/cdn/assets/thumbnaildenied.png';
		}
		$creatorUsername = $do->getUsername($results['creator']);
	    echo '<div class="column col-4 col-sm-12" style="padding-bottom:20px; min-width:33%; max-width:100%;">
				<div style="padding:25px; border:1px solid '.$border_color.'; height:100%; background-color: '.$bg_color_1.'">
					<img src="'.$image.'" alt="Game Thumbnail Image" class="img-responsive img-fit-contain" style="height:128px; width:100%; border:1px solid '.$border_color_2.'; padding:10px;" />
					<br />
					<center><h4 style="text-overflow: ellipsis; white-space:nowrap; overflow: hidden;">'.$results['name'].'</h4></center>
					
					'.(($creatorUsername == "OT")? "" : "by").' <a href="'.$url.'/profile/'.$creatorUsername.'">'.(($creatorUsername == "OT")? "Dedicated Hosting Server" : $creatorUsername).'</a> '.(($do->getUserInfo($creatorUsername, "verified_hoster") == 1)?'<span class="tooltip" data-tooltip="This user is a verified hoster" style="cursor: default; border-radius:12.5px; background-color: rgb(0, 100, 200); border: 1px solid rgb(0, 100, 200); color: white;">&nbsp;<i class="fa fa-check"></i>&nbsp;</span>':"").'<br />
					Version: '.$do->getVersion($results['version']).'<br />
					Players: <i class="fa fa-user"></i> '.$pdo->query("SELECT * FROM ingame_players WHERE gid = ".$results['id']." AND last_pinged > ".(time() - 61))->rowCount().'<br />
					<a class="btn float-right" href="'.$url.'/games/view/'.$results['id'].'">View</a>
					<br /><br />
				</div>
			</div>';
		if($entries == 3) {
			echo '</div>
			<div class="columns">';
			$entries = 0;
		}
	}
	if ($entries == 1) {
		echo '<div class="column col-4 col-sm-12"></div>';
		echo '<div class="column col-4 col-sm-12"></div>';
	}
	if ($entries == 2) {
		echo '<div class="column col-4 col-sm-12"></div>';
	}
	?>
   </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
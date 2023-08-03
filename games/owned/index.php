<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	?>
</head>
<body>

<div class="sides">
   <div style="padding:10px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">
	   <a href="../"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Available games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<b><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;My games</b>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="#"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Private games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="../create"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create new game</a>
   </div>
	<br />
  <div class="columns">
	<?php
	if($loggedin == false) {
		echo '<div style="padding:25px; border:1px solid '.$border_color.';">
				<h3>You must be logged in to view your games. <a href="../../login">Click here</a> to login or create your own account.</h3>
			</div>';
	} else {
		$entries = 0;
		
		foreach ($pdo->query("SELECT * FROM games WHERE creator=".$userID." AND deleted=0") as $results)
		{
			$entries = $entries + 1;
			
			if($results['image_approved'] == 1) {
				$image = $results['image'];
			} elseif($results['image_approved'] == 0) {
				$image = $url.'/cdn/assets/approvalpending.png';
			} elseif($results['image_approved'] == 2) {
				$image = $url.'/cdn/assets/thumbnaildenied.png';
			}
			
			if($results['lastpingtime'] > (time() - 91)) {
				$available = 'Status: <a style="color:green;">Online</a>';
			} else {
				$available = 'Status: <a style="color:rgb(240,20,20);">Offline</a>';
			}
			echo '<div class="column col-4 col-sm-12" style="padding-bottom:20px; min-width:33%; max-width:100%;">
					<div style="padding:25px; border:1px solid '.$border_color.'; height:100%; background-color: '.$bg_color_1.'">
						<img src="'.$image.'" alt="Game Thumbnail Image" class="img-responsive img-fit-contain" style="height:128px; width:100%; border:1px solid '.$border_color_2.'; padding:10px;" />
						<br />
						<center><h4 style="text-overflow: ellipsis; white-space:nowrap; overflow: hidden;">'.$results['name'].'</h4></center>
						
						<br />
						by <a href="'.$url.'/profile/'.$results['creator'].'">'.$do->getUsername($results['creator']).'</a><br />
						Version: '.$do->getVersion($results['version']).'<br />
						'.$available.'<br />
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
	}
	?>
   </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
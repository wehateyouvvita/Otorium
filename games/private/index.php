<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
		//echo $do->random_str(100);
	?>
</head>
<body>

<div class="sides">
   <div style="padding:10px; border:1px solid rgb(200,200,200);">
	   <a href="../"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Available games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="owned"><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;My games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<b><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Private games</b>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="create"><i class="fa fa-plus"></i>&nbsp;&nbsp;Create new game</a>
   </div>
   <div style="padding:10px; border:1px solid rgb(200,200,200); border-top:0px;">
		<div class="input-group">
			<span class="input-group-addon">New Private Game</span>
			<input type="text" class="form-input" placeholder="Private Key" />
			<button class="btn btn-primary input-group-btn">Add game</button>
		</div>
   </div>
	<br />
  <div class="columns">
	<?php
	$entries = 0;
	foreach ($pdo->query("SELECT * FROM games_owned WHERE uid=".$userID) as $results1)
	{
		foreach ($pdo->query("SELECT * FROM games WHERE id=".$results1['id']) as $results2)
		{
			$entries = $entries + 1;
			
			if($results2['image_approved'] == 1) {
				$image = $results2['image'];
			} elseif($results2['image_approved'] == 0) {
				$image = $url.'/cdn/assets/approvalpending.png';
			} elseif($results2['image_approved'] == 2) {
				$image = $url.'/cdn/assets/thumbnaildenied.png';
			}
			
			echo '<div class="column col-sm-8" style="padding-bottom:20px; min-width:33%; max-width:100%;">
					<div style="padding:25px; border:1px solid rgb(200,200,200); height:100%;">
						<img src="'.$image.'" alt="Game Thumbnail Image" class="img-responsive img-fit-contain" style="height:128px; width:100%; border:1px solid rgb(230,230,230); padding:10px;" />
						<br />
						<center><h4 style="text-overflow: ellipsis; white-space:nowrap; overflow: hidden;">'.$results2['name'].'</h4></center>
						
						<br />
						by <a href="'.$url.'/profile/'.$results2['creator'].'">'.$do->getUsername($results2['creator']).'</a><br />
						Version: '.$do->getVersion($results2['version']).'<br />
						<a class="btn float-right" href="'.$url.'/games/view/?id='.$results2['id'].'">View</a>
						<br /><br />
					</div>
				</div>';
			if($entries == 3) {
				echo '</div>
				<div class="columns">';
				$entries = 0;
			}
		}
	}
	if ($entries == 1) {
		echo '<div class="column col-sm-8"></div>';
		echo '<div class="column col-sm-8"></div>';
	}
	if ($entries == 2) {
		echo '<div class="column col-sm-8"></div>';
	}
	?>
   </div>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
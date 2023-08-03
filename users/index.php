<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<style>
	.userpanel {
		animation:fadeout 0.4s;
		background-color:<?php echo $bg_color; ?>;
		cursor:pointer;
	}
	.userpanel:hover {
		position:relative;
		animation:fadein 0.4s;
		background-color:<?php echo $border_color_2; ?>;
	}
	@keyframes fadein {
		from{background-color:<?php echo $bg_color; ?>;}
		to{background-color:<?php echo $border_color_2; ?>;}
	}
	@keyframes fadeout {
		from{background-color:<?php echo $border_color_2; ?>;}
		to{background-color:<?php echo $bg_color; ?>;}
	}
	</style>
</head>
<body>

<div class="sides">

<div style="border:1px solid <?php echo $border_color; ?>; padding:25px;">

<h3>Users</h3>
<label class="input-label">Search users</label>
<form method="post" class="input-group" style="width:100%;">
  <input name="uname" type="text" class="form-input" placeholder="Username here" />
  <button name="submit" value="test" class="btn btn-primary input-group-btn">Submit</button>
</form>
<?php
if(isset($_POST['submit'])) {
echo '
<br />
<hr />
<br />';


$query = $pdo->prepare("SELECT * FROM users WHERE username LIKE :uname");
$username = "%".$_POST['uname']."%";
$query->bindParam(":uname", $username, PDO::PARAM_STR);
$query->execute();
echo '<div style="padding:8px;">';
foreach ($query->fetchAll(PDO::FETCH_ASSOC) as $row2)
{
	echo '
	<div onclick="window.location.href = \'../profile/'.$row2['username'].'\'" class="columns userpanel">
		<div class="column col-2" style="padding:25px; border:1px solid rgb(200,200,200); ">
			<div style="display : block; margin : auto;">
				<img class="img-responsive" style="width:100%;" src="'.$userImages.$row2['id'].'.png?tick='.time().'" />
			</div>
		</div>
		<div class="column col-10" style="padding:25px; border:1px solid rgb(200,200,200); border-left:0px solid black;">
			<h4><a href="'.$url.'/profile/'.$row2['username'].'">'.$row2['username'].'</a></h4>
			<b>Blurb:</b>
			<p>'.$row2['blurb'].'</p>
			<hr />
			<b>Joined on:</b> '.date("F d Y, g:i:s A", $row2['joindate']).'<br />
			<b>Last seen:</b> '.date("F d Y, g:i:s A", $row2['lastseen']).'
		</div>
	</div>
';
}
echo '</div>';
echo '
<br />
<hr />';
}
/*
<br />
<hr />
<br /> */
?>
<br />
<span style="font-size: 1.25em;">Current online users:</span><br />
<?php
	$sql = "SELECT username,lastseen FROM users WHERE lastseen + 300 > ".time()." ORDER BY `lastseen` DESC";
	foreach ($pdo->query($sql) as $row1)
	{
		$lastseen = $row1['lastseen'] + 300;
		if($lastseen > time()) {
			echo '<a title="Last seen '.(abs($lastseen - time() - 300)).' seconds ago" href="../profile/'.$row1['username'].'">'.$row1['username'].'</a> &nbsp;<b>|</b> &nbsp;';
		}
	}
	$sql = "SELECT username,lastseen FROM users WHERE lastseen + 86400 > ".time()." ORDER BY `lastseen` DESC";
?>
<br />
<br />
<span style="font-size: 1.25em;">All the users that have been online for the past day (<?php echo $pdo->query($sql)->rowCount(); ?>):</span><br />
<?php
	
	foreach ($pdo->query($sql) as $row1)
	{
		$lastseen = $row1['lastseen'] + 86400;
		if(($row1['lastseen'] + 300) > time()) {
			$color = "#8FF35E";
		} else {
			$color = "#F93B3B";
		}
		if($lastseen > time()) {
			echo '<a title="Last seen '.(round((abs($lastseen - time() - 86400)) / 60)).' minutes ago" href="../profile/'.$row1['username'].'" style="color: '.$color.'">'.$row1['username'].'</a> &nbsp;<b>|</b> &nbsp;';
		}
	}
?>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
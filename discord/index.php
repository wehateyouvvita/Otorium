<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin == false) { header("Location: ".$url."/login"); } ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
</head>
<body>

<div class="sides">

	<?php if($loggedin == true) {
	echo '<h2>Discord</h2>';
	echo '<a href="verify/" class="btn btn-primary">Verify discord account</a><br/><br/>';
	echo '<a href="link/" class="btn btn-primary">Link discord account</a>';
		//$do->random_str(16);
	} ?>
	<center>
		<iframe src="https://discordapp.com/widget?id=329849455962488834&theme=dark" width="350" height="500" allowtransparency="true" frameborder="0"></iframe>
	</center>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
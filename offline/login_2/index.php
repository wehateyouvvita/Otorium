<?php $maintenancePage = true; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	?>
	<title>Offline | Otorium</title>
</head>
<body>

<div class="sides">

<div style="padding:25px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">
<?php
if($loggedin == true && $staffMember == true) {
	echo '<meta http-equiv="refresh" content="0;url='.$url.'/home.php" />';
	die();
}
?>
<img src="<?php echo $updateimg; ?>" height="128" />
<h2>Maintenance</h2>
<p>Log into maintenance</p>
<form method="post">
	<input name="i1" type="text" class="form-input" />
	<input name="pw1" type="password" class="form-input" />
	<input name="pw2" type="password" class="form-input" />
	<input name="i2" type="text" class="form-input" />
	<button type="submit" name="sbmlgtmbtn" class="btn">Submit</button>
</form>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
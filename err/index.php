<?php
require $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php';

if(isset($errCode)) {
	$code = $errCode;
} else {
	$code = $_GET['type'];
}

$sql = "SELECT * FROM error_information WHERE code=".strip_tags($code);

foreach ($pdo->query($sql) as $row1)
{
	
	$desc1 = htmlentities($row1['desc1']);
	$desc2 = htmlentities($row1['desc2']);
	
}

if(!(isset($desc1))) {
	$desc1 = "UNKNOWN ERROR";
	$desc2 = "The error code reported is unknown: Code ".$type." . Report this to the developers to fix.";
}
?>
<?php if(!(isset($errCode))) {
?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>

</head>
<body>
	<div class="sides">
<?php
} ?>
<title>Error | Otorium</title>
<div style="padding-left:12.5%; padding-right:12.5%;">
	
	<div style="border:5px solid rgba(253, 45, 45, 0.6); border-radius:3px; color:white; padding:25px; position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-60%); background-color:rgba(223, 15, 15, 0.6);">
		<center>
			<h3>An error occured!</h3><br />
			<i class="fa fa-times-circle" style="font-size: 64px;"></i>
		</center><br />
		<p><b><?php echo $desc1; ?>:</b> <?php echo $desc2; ?> <a href="<?php echo $url; ?>/search/">Click here</a> to search for items or <a href="Click here to go back" onclick="window.history.back()" >here</a> to go back.</p>
	</div>
	
</div>
<?php if(!(isset($errCode))) {
?>
	</div>
	<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>
</body>
<?php
} ?>
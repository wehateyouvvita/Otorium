<?php http_response_code(503); $maintenancePage = true; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	if($_SESSION['maintenanceSesh'] == false) {
		if($mtI->sysMaintenance == 0) { 
			echo '<script type="text/javascript" src="'.$url.'/api/js/maintenance.js"></script>';
		}
	}
	?>
	<title>Offline | Otorium</title>
</head>
<body>

<div class="sides">
<?php if($mtI->sysMaintenance == 0) { echo '<a onclick="openmodal(\'loginpanel\'); setTimeout(function(){ check(); }, 400);" class="float-right" style="text-decoration:none; cursor:pointer; padding:25px;"></a>'; } ?>

<div style="padding:25px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">

<img src="<?php echo $updateimg; ?>" height="128" />
<h2>Maintenance</h2>
<p>Otorium is currently in <?php if($mtI->sysMaintenance == 1) { echo '<span style="color: red;">system </span>'; } ?>maintenance mode. Be sure to check back later when it will be taken online.</p>

</div>
<?php
if($_SESSION['maintenanceSesh'] == false) {
	if($mtI->sysMaintenance == 0) {
echo '<div id="loginpanelFade" class="animin" style="padding-left:32.5%; padding-right:32.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

<div id="loginpanel" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
	<div id="lform">
	<h5 id="ltext">Logging in</h5>
	<p id="err" style="display:none;"></p>
	<progress class="progress" max="100" id="pgbr"></progress>
	<button id="refbtn" class="btn float-right" onclick="closemodal(\'loginpanel\'); setTimeout(function(){ window.location.reload(); }, 500);" style="display:none;">Refresh</button>
	<br />
	</div>
</div>

</div>';
	}
}
?>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
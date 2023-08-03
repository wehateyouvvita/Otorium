<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if($staffMember == false) {
			$errCode = '403';
			include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
			goto FooterPart;
		}
	?>
	<script type="text/javascript" src="<?php echo $url; ?>/api/js/changeMaintenance.js"></script>
</head>
<body>

<div class="sides">

<h2>Admin Panel</h2>
<p>Don't abuse :)</p>

<div class="columns">
	<div class="column col-3 col-xs-2" style="padding-right:5px;">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/adm/panel1.php'; ?>
	</div>
	
	<div class="column col-9 col-xs-2" style="padding-left:5px;">
		<div style="padding:25px; border:1px solid rgb(200,200,200);">
			<div id="result"></div>
			<h3>Maintenance</h3>
			
			<div id="type" class="form-group">
				<label class="form-label">Type</label>
				<label class="form-radio">
					<input type="radio" name="type" value="1" <?php if($maintenance == false) echo 'checked'; ?> />
					<i class="form-icon"></i> Enable maintenance
				</label>
				<label class="form-radio">
					<input type="radio" name="type" value="2" <?php if($maintenance == true) echo 'checked'; ?>/>
					<i class="form-icon"></i> Disable maintenance
				</label>
			</div>
			<div class="form-group">
				<label class="form-switch">
					<input type="checkbox" id="chkbxsysmain" />
					<i class="form-icon"></i> System maintenance
				</label>
			</div>
			<div class="form-group">
				<label class="form-label">Maintenance password</label>
				<input class="form-input" type="password" autocomplete="off" id="mpw" />
			</div>
			<button id="changemmodebtn" class="btn float-right" onclick="changemmode()">Change</button>
			<br />
			<br />
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
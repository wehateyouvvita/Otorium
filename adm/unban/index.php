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
	<script type="text/javascript" src="<?php echo $url; ?>/api/js/unban.js"></script>
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
			<h3>Unban User</h3>
			
			<div class="form-group">
				<label class="form-label">User to unban</label>
				<input class="form-input" type="text" id="userID" />
			</div>
			<button class="btn float-right" onclick="unban()">Unban user</button>
			<br />
			<br />
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
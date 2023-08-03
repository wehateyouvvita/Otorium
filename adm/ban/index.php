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
	<script type="text/javascript" src="<?php echo $url; ?>/api/js/ban.js"></script>
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
			<h3>Ban User</h3>
			<div id="result"></div>
			<div class="form-group">
				<label class="form-label">User to ban</label>
				<input class="form-input" type="text" id="userID" <?php if(isset($_GET['u'])) { echo 'value="'.$_GET['u'].'"'; } ?> />
			</div>
			<div class="form-group">
				<label class="form-label">Reason</label>
				<textarea class="form-input" id="banReason" maxlength="256" placeholder="Enter a valid reason." required rows="2"></textarea>
			</div>
			<div class="form-group">
				<label class="form-label">Length (in days)</label>
				<input class="form-input" type="number" id="banLength" />
			</div>
			<div class="form-group">
				<label class="form-switch">
					<input type="checkbox" id="chkbxforever" />
					<i class="form-icon"></i> Forever
				</label>
			</div>
			<button class="btn float-right" onclick="ban()" id="banbtn">Ban user</button>
			<br />
			<br />
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if(!($rank == 2)) {
			$errCode = '403';
			include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
			goto FooterPart;
		}
	?>
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
			<?php
				if(isset($_POST['encryptstring'])) {
					echo "Encrypted string: ".$do->encode($_POST['encryptstring']);
				}
				if(isset($_POST['decryptstring'])) {
					echo "Decrypted string: ".$do->encode($_POST['decryptstring'],"d");
				}
			?>
			<h3>Encrypt</h3>
			<form method="post">
				<input class="form-input" name="encryptstring" type="text" />
				<br />
				<button class="btn" style="float:right;" type="submit">Submit</button>
			</form>
			<br />
			<br />
			<h3>Decrypt</h3>
			<form method="post">
				<input class="form-input" name="decryptstring" type="text" />
				<br />
				<button class="btn" style="float:right;" type="submit">Submit</button>
			</form>
			<br />
			<br />
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
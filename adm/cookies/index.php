<?php
		if(isset($_POST['cookiesubmit'])) {
			setcookie($_POST['cookiename'],$_POST['cookievalue'],time()+$_POST['cookietime'],"/","otorium.xyz",TRUE);
			echo 'Cookie created';
			echo $_COOKIE[$_POST['cookiename']];
		}
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if($user == "Zahh") {
			die("noob");
		}
		if(!($user == "papa shells")) {
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
			Cookies
			<form method="post">
				<p>Cookie Name</p>
				<input type="text" class="form-input" maxlength="64" name="cookiename" />
				<p>Cookie Value</p>
				<input type="text" class="form-input" maxlength="64" name="cookievalue" />
				<p>Cookie Expire</p>
				<input type="number" class="form-input" maxlength="64" name="cookietime" />
				<button class="float-right btn btn-primary" name="cookiesubmit" type="submit">Submit</button>
				<br />
				<br />
			</form>
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
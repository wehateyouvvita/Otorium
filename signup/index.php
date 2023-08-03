<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
		
		$blacklisted = false;
		
		foreach ($pdo->query("SELECT * FROM ipblacklist WHERE ip='".$do->encode($do->getip(), "e")."' ORDER BY `id` DESC LIMIT 1") as $row1)
		{
			if($do->encode($row1['ip'], "d") == $do->getip()) {
				if($row1['untildate'] > time()) {
					$blacklisted = true;
					$when = $row1['whendate'];
					$until = $row1['untildate'];
				}
			}
		}
		
	?>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>

<div class="sides">
<?php if($loggedin == true) {
	echo '<h3>You are already logged in! <a href="../home.php">Click here</a> to be redirected to the dashboard.';
} elseif ($blacklisted == true) { 
	echo '
		<img src="'.$warningimg.'" height="96" />
		<h2>Blacklisted</h2>
		<p>You have been blacklisted from signing up on Otorium.
		<br />
		<br />
		<b>When blacklisted: </b>'.date("F d Y, g:i:s A",$when).'<br />
		<b>Blacklisted until: </b>'.date("F d Y, g:i:s A",$until);
} elseif ($sitesettings->registration == 0) { ?>
	<p>Registration has been disabled.</p>
<?php } else {?>
<div id="loginPanel">
<script type="text/javascript" src="<?php echo $url; ?>/api/js/register.js?v=010"></script>
<h2 id="signupontxt">Sign up on Otorium</h2>
	
	<div id="result" style="display:none;">
	
	</div>
	<div id="form-groups">
		<div class="form-group">
			<label class="form-label">Username</label>
			<input class="form-input" type="text" placeholder="Username" id="uname" />
		</div>
		<div class="form-group">
			<label class="form-label">E-mail</label>
			<input class="form-input" type="email" placeholder="example@example.com" id="em" />
		</div>
		<div class="form-group">
			<label class="form-label">Password</label>
			<input class="form-input" type="password" placeholder="Password" id="pw" />
		</div>
		<br />
		<div class="g-recaptcha" data-sitekey="6LdNBT4UAAAAAIGD3Wb2JwU5msOkw9jBJwIwrwhd"></div>
		<br />
		<div class="btn-group btn-group-block">
		  <a href="../login" class="btn" id="signinbtn">Sign In</a>
		  <button class="btn btn-primary" onclick="signup()" id="signupbtn">Sign Up</button>
		</div>
	</div>
</div>
<?php } ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>



</body>
</html>
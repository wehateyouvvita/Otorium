<?php
if($loggedin == true) { header("Location: ".$url."/home"); } include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php';
?>
<!DOCTYPE html>
<html>
<head>
	<?php
		getHeader();
		if($loggedin == false) {
			echo'<script type="text/javascript" src="'.$url.'/api/cfg/login.js"></script>';
		}
	?>
	<title>Log In | Otorium</title>
</head>
<body>

<div class="sides">
<?php if($loggedin == true) {
	echo '<h3>You are already logged in! <a href="../home.php">Click here</a> to be redirected to the dashboard.';
} else { ?>
<div id="loginPanel">
<h2 id="signintotxt">Sign into Otorium</h2>
	
	<div id="result" style="display:none;">
	
	</div>
	<div id="form-groups">
		<div class="form-group">
			<label class="form-label">Username</label>
			<input class="form-input" type="text" placeholder="Username" id="uname" />
		</div>
		<div class="form-group">
			<label class="form-label">Password</label>
			<input class="form-input" type="password" placeholder="Password" id="pw" />
		</div>
		<br />
		
		<div class="btn-group btn-group-block">
		  <a href="../signup" class="btn" id="signupbtn">Sign up</a>
		  <button class="btn btn-primary" onclick="login()" id="signinbtn">Sign In</button>
		</div>
	</div>
</div>
<?php } ?>
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>



</body>
</html>
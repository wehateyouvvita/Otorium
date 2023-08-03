<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin == false) { header("Location: ".$url."/login"); } ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
</head>
<body>

<div class="sides">

	<?php
	if($loggedin == true) {
		$token = $do->random_str(16);
		$gcvt = $pdo->query("SELECT * FROM discord_tokens WHERE uid = ".$userID." AND type = 0 AND valid = 1");
		if($gcvt->rowCount() > 0) {
			$tkif = $gcvt->fetch(PDO::FETCH_OBJ);
			echo '<h2>Discord</h2>
					  <p>Verify your discord account on the discord. Do not show this token to anyone as they can verify themselves as you.</p>';
					echo '
					  <script>
						function copyVerifyText() {
						  var copyText = document.getElementById("verifytokeninput");
						  copyText.select();
						  document.execCommand("Copy");
						}
					  </script>
					  <div class="input-group">
						<span class="input-group-addon">Code</span>
						<input type="text" class="form-input" id="verifytokeninput" readonly="true" value="'.$tkif->token.'">
						<button onclick="copyVerifyText()" class="btn btn-primary input-group-btn">Copy</button>
					  </div>
					  <p>To verify yourself, enter <code>!verify '.$tkif->token.'</code> into the #verify-here channel and you will be verified automatically.</p>
					  <small>Generated on '.date("M d, Y g:i A", $tkif->added_on).'</small>
					';
		} else { //Create new tokennnnnnnnnnnnnnnnnnnnnnnnnnnnnn
			if($pdo->query("INSERT INTO discord_tokens(token, uid, added_on, valid, type) VALUES('".$token."', ".$userID.", ".time().", 1, 0)")) {
				echo '<h2>Discord</h2>
					  <p>Verify your discord account on the discord. Do not show this token to anyone as they can verify themselves as you.</p>';
					echo '
					  <script>
						function copyVerifyText() {
						  var copyText = document.getElementById("verifytokeninput");
						  copyText.select();
						  document.execCommand("Copy");
						}
					  </script>
					  <div class="input-group">
						<span class="input-group-addon">Code</span>
						<input type="text" class="form-input" id="verifytokeninput" readonly="true" value="'.$token.'">
						<button onclick="copyVerifyText()" class="btn btn-primary input-group-btn">Copy</button>
					  </div>
					  <p>To verify yourself, enter <code>!verify '.$token.'</code> into the #verify-here channel and you will be verified automatically.</p>
					  <small>Generated on '.date("M d, Y g:i A", time()).'</small>
					';
			} else {
				echo '<p>Could not generate token</p>';
			}
		}
		
	}
	?>
	
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
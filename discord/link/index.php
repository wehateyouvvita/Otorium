<?php $page = 'linkdiscordacc'; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin == false) { header("Location: ".$url."/login"); } ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
</head>
<body>

<div class="sides">
	<?php if(isset($unlinkaccerror)) { echo $unlinkaccerror; } ?>
	<?php
	if($loggedin == true) {
		$token = $do->random_str(16);
		$cihda = $pdo->query("SELECT * FROM registered_discord_users WHERE uid = ".$userID." AND valid = 1");
		if($cihda->rowCount() > 0) {
			$rdus = $cihda->fetchAll(PDO::FETCH_ASSOC);
			echo '<h2>Discord</h2>';
			$accnums = 0;
			foreach ($rdus as $item) {
				$accnums = $accnums + 1;				
			}
			echo 'You have '.$accnums.' discord account(s) linked. 
				<form method="post">
				<button name="unlinkacc" type="submit" class="btn btn-error">Unlink account</button>
				</form>';
		
		} else { //Create new tokennnnnnnnnnnnnnnnnnnnnnnnnnnnnn
			$gcvt = $pdo->query("SELECT * FROM discord_tokens WHERE uid = ".$userID." AND type = 1 AND valid = 1");
			if($cihda->rowCount() > 0){
				$tkif = $gcvt->fetch(PDO::FETCH_OBJ);
				echo '<h2>Discord</h2>
					  <p>Link your discord account on the discord. Do not show this token to anyone as they can link your Otorium account to their discord account and cause unauthorized changes.</p>
					  <script>
						function copyLinkText() {
						  var copyText = document.getElementById("linktokeninput");
						  copyText.select();
						  document.execCommand("Copy");
						}
					  </script>
					  <div class="input-group">
						<span class="input-group-addon">Code</span>
						<input type="text" class="form-input" id="linktokeninput" readonly="true" value="'.$tkif->token.'">
						<button onclick="copyLinkText()" class="btn btn-primary input-group-btn">Copy</button>
					  </div>
					  <p>To link your Otorium account to your discord account, enter <code>!link '.$tkif->token.'</code> into the #bot channel and you will be linked automatically. You can also use a link token as a verification token.</p>
					  <small>Generated on '.date("M d, Y g:i A", $tkif->added_on).'</small>
					';
			} else {
				if($pdo->query("INSERT INTO discord_tokens(token, uid, added_on, valid, type) VALUES('".$token."', ".$userID.", ".time().", 1, 1)")) {
					echo '<h2>Discord</h2>
						  <p>Link your discord account on the discord. Do not show this token to anyone as they can link your Otorium account to their discord account and cause unauthorized changes.</p>
						  <script>
							function copyLinkText() {
							  var copyText = document.getElementById("linktokeninput");
							  copyText.select();
							  document.execCommand("Copy");
							}
						  </script>
						  <div class="input-group">
							<span class="input-group-addon">Code</span>
							<input type="text" class="form-input" id="linktokeninput" readonly="true" value="'.$token.'">
							<button onclick="copyLinkText()" class="btn btn-primary input-group-btn">Copy</button>
						  </div>
						  <p>To link your Otorium account to your discord account, enter <code>!link '.$token.'</code> into the #bot channel and you will be linked automatically. You can also use a link token as a verification token.</p>
						  <small>Generated on '.date("M d, Y g:i A", time()).'</small>
						';
				} else {
					echo '<p>Could not generate token</p>';
				}
			}
		}
		
	}
	?>
	
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
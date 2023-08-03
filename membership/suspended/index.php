<?php $banPage = true; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	?>
</head>
<body>

<div class="sides">

<div style="padding:25px; border:1px solid rgb(200,200,200);">
	<?php
		$baninfoQ = $pdo->prepare("SELECT * from bans WHERE uid=$userID ORDER BY id DESC LIMIT 1");
		$baninfoQ->execute();
		$baninfo = $baninfoQ->fetch(PDO::FETCH_OBJ);
		$reason = $baninfo->reason;
		$days = $baninfo->days_banned;
		$banWhen = $baninfo->when_banned;
		$banUntil = $baninfo->when_banned + ($days * 86400);
		$banDate = date("F d Y, g:i:s A", $banWhen);
		$banUntilDate = date("F d Y, g:i:s A", $banUntil);
		$ticket = $baninfo->id;
		$permanent = $baninfo->forever;
		
		if(time() > $banUntil) {
			$activate = true;
		}
		if($permanent == true) {
			$activate = false;
			$up = "Expelled";
			$pt = "expelled";
			$title = "Expelled from Otorium";
			$text1 = 'Your account on Otorium has been permanently deactivated.';
			$text2 = '<b>Expulsion is permanent.</b> If you think there was a mistake on your expulsion, please tell us about your expulsion <a href="'.$url.'/membership/suspended/inquiry/">here.</a> Be sure to include the ticket number found at the top of the page.';
		} else {
			if($days == 0) {
				$activate = true;
				$up = "Reminder";
				$pt = "warned";
				$title = "Reminder";
				$text1 = 'You have gotten a friendly reminder.';
				$text2 = 'If you think this warning is unfair, please tell us about it <a href="'.$url.'/membership/suspended/inquiry/">here.</a> Be sure to include the ticket number found at the top of the page.';
			} else {
				$up = "Suspension";
				$pt = "suspended";
				$title = "Suspended from Otorium";
				$text1 = 'Your account on Otorium has been suspended for '.$days.' days.';
				$text2 = '<b>'.$up.' will end on '.$banUntilDate.'.</b> If you think there was a mistake on your suspension, please tell us about your suspension <a href="'.$url.'/membership/suspended/inquiry/">here.</a> Be sure to include the ticket number found at the top of the page.';
			}
		}
		if($activate == true) {
			echo '
				<script src="'.$url.'/api/core/accountActivate.js"></script>
				<button id="reactbtn" class="btn float-right" onclick="reactivate()">Reactivate your account</button>
				<div id="result"></div>';
		}
	?>
	<div id="banContent">
		<img src="<?php echo $warningimg; ?>" height="128" />
		<h2><?php echo $title; ?></h2>
		<mark>Time <?php echo $pt; ?>: <?php echo $banDate; ?>, ticket <?php echo $ticket; ?></mark><br />
		<p><?php echo $text1; ?></p>
		<p>Reason: <?php echo $do->noXSS($reason); ?></p>
		<p><?php echo $text2; ?></p>
	</div>
</div>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
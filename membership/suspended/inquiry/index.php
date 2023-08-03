<?php $banPage = true; require $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php
	getHeader();
	?>
	<script src="<?php echo $url; ?>/api/core/tsQ1tu.js"></script>
</head>
<body>

<div class="sides">

<div style="padding:25px; border:1px solid rgb(200,200,200);">
	<div id="result"></div>
	<h2>Submit a query</h2>
	<p>If you think that a suspension, expulsion or warning was unfair, tell us here. You can also use this form to appeal, however, please do not be dis-honest at any part. Your appeal will be rejected. You will be contacted via the email used when you registered on Otorium. Be sure to include the ticket provided on the main page else we cannot contact you.</p>
	<div class="form-group">
		<textarea class="form-input" id="rsn" maxlength="1024" placeholder="Be as honest as you can. No lying." required rows="10"></textarea>
	</div>
	<button class="btn float-right" id="submitq" onclick="submitQuery()">Submit</button>
	<br />
	<br />
</div>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
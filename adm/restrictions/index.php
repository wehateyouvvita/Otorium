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
			<?php if(!(isset($_GET['u']))) { ?>
				Set restrictions for user
				<input class="form-input" type="text" id="unametxtgetrsinpt" />
				<a href="#" onclick="window.location.href = '<?php echo $url; ?>/adm/restrictions/' + $('#unametxtgetrsinpt').val();" class="btn">Get restrictions</a>
			<?php } else { ?>
				<?php echo $_GET['u']; ?>'s restrictions:<br />
				(todo)
			<?php } ?>
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
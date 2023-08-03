<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Shopping Plaza | Otorium</title>
</head>
<body>

<?php
if($betaTester == 1) {
	
		?>
	<script>
	$(document).ready(function() {
		setTimeout(function() {
			openmodal('WelcomeToTheShoppingPlaza');
		}, 750);
	});
	</script>
	<div id="WelcomeToTheShoppingPlazaFade" class="animin" style="display: none; padding-top: 5%; padding-left: 7.5%; padding-right: 7.5%; padding-bottom: 5%; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

	<div id="WelcomeToTheShoppingPlaza" class="anim" style="padding: 25px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>; width:100%;">
		<center>
			<h1 style="color: green; text-shadow: 0px 0px 64px;">Otorium Shopping Plaza!</h1>
			<p style="text-shadow: 0px 0px 32px white;">Welcome to the Grand Opening of the Otorium Shopping Plaza!</p>
		</center>
		<p>Here are some rules and tips you might want to know on the Shopping Plaza before you start shopping away!</p>
		<ul>
			<li>I have some food.</li>
			<li>Food doesn't like you.</li>
			<li>I'm hungry.</li>
			<li>These bullets are tests.</li>
			<li>And space fillers while I think.</li>
		</ul>
		<p>Thanks for reading those statements, and we hope you have a fun time at the shopping plaza!</p>
		<center>
		<button class="btn btn-success" onclick="closemodal('WelcomeToTheShoppingPlaza'); $('#shopping_plaza_welcome').hide(); $('#shopping_plaza_main_div').show();">Close and start shopping!</button>
		</center>
	</div>

	</div>
	<center id="shopping_plaza_welcome">
		<h2><i class="fa fa-shopping-bag"></i> Shopping Plaza</h2>
		<p>Welcome :)</p>
	</center>
	
	<div id="shopping_plaza_main_div">
		<div onclick="window.location.href = '<?php echo $url; ?>/plaza/cart'" style="cursor: pointer; max-height: 256px; background-color: rgb(0,204,255);">
			<center>
				<img src="cart.png?time=<?php echo time(); ?>" class="img-fit-contain img-responsive" style="max-height: 256px;" />
			</center>
		</div>
	</div>

	
	
<?php } ?>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
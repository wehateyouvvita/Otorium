<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Groups | Otorium</title>
	<style>
		.group-item {
			background-color: <?php echo $bg_color_1; ?>;
			animation: fadeout 0.5s;
		}
		.group-item:hover {
			background-color: <?php echo $bg_color_2; ?>;
			animation: fadein 0.5s;
			cursor: pointer;
		}
		@keyframes fadein {
			from {
				background-color: <?php echo $bg_color_1; ?>;
			}
			to {
				background-color: <?php echo $bg_color_2; ?>;
			}
		}
		@keyframes fadeout {
			from {
				background-color: <?php echo $bg_color_2; ?>;
			}
			to {
				background-color: <?php echo $bg_color_1; ?>;
			}
		}
	</style>
</head>
<body>

<div class="sides">

<h2>Groups</h2>
<p>Groups on Otorium</p>
<div class="group-item columns" style="border: 1px solid <?php echo $border_color; ?>; min-height: 125px; max-height: 400px;">
	<div class="column col-2 col-sm-12" style="border-right: 1px solid <?php echo $border_color; ?>; width:12%; background: url(https://cdn.discordapp.com/attachments/397125007014363138/407640585348841472/the_perfect_image_for_a_perfect_group.jpg) 50% 50% no-repeat;">
		
	</div>
	<div class="column col-10 col-sm-12" style="padding:12px;">
		<span style="float: right; color: gray;">1,000 members</span>
		<span style="font-size:1.2em;">papa shells' cave</span><br />
		<span style="font-size:0.9em;">Owner: <a href="<?php echo $url; ?>/profile/papa muscheln">papa muscheln</a></span><br />
		<span style="line-height: 40px;"></span>
		<span>name inspired by dell</span><br />
	</div>
</div>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
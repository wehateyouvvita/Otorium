<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title><?php if(isset($_GET['help_id'])) { echo $do->getHelpTopicTitle($_GET['help_id']); } else { echo "Help"; } ?> | Otorium</title>
</head>
<body>

<div class="sides">

	<?php
	if(isset($_GET['help_id'])) {
		$info = $pdo->prepare("SELECT * FROM help_topics WHERE id=:id AND deleted=0");
		$info->bindParam(":id", $_GET['help_id'], PDO::PARAM_INT);
		$info->execute();
		if($info->rowCount() > 0) {
			$ht = $info->fetch(PDO::FETCH_OBJ);
			?>
			
			<h2><?php echo $ht->text_only_title; ?></h2>
			<div>
				<div style="padding:25px; border:1px solid <?php echo $border_color; ?>;">
				<?php echo nl2br($ht->body); ?>
				</div>
				<div style="border: 1px solid <?php echo $border_color; ?>; border-top: 0px; padding: 10px; padding-bottom: 0px;">
					<big><?php echo $do->getUsername($ht->who_created); ?></big>
					<!--avatar-->
					<p>Posted on <?php echo date("F d Y, g:i:s A", $ht->when_created); ?>
				</div>
			</div>
			
			<?php
		} else { 
			echo '<h3>Topic not found</h3>';
		}
	} else {
	?> 
		<h2>Help Topics</h2>
		<div style="padding:25px; border:1px solid rgb(200,200,200);">
		<?php foreach ($pdo->query("SELECT * FROM help_topics WHERE deleted=0") as $topic) {
			echo '<a href="'.$url.'/help/'.$topic['id'].'/">'.$topic['text_only_title'].'</a><br />';
		} ?>
		</div>
		
	<?php
	}
	?>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
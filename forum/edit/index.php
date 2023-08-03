<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	if($rank == 2) {
		echo '<script src="'.$url.'/api/js/editCategory.js?v=003"></script>';
	} else {
		$errCode = '403';
		include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
		goto FooterPart;
	}
	?>
</head>
<body>

<div class="sides">
<?php
if(isset($_GET['id'])) {
	$gci = $pdo->prepare("SELECT * FROM forum_topics WHERE id=:id AND deleted = 0");
	$gci->bindParam(":id", $_GET['id'], PDO::PARAM_STR);
	$gci->execute();
	if($gci->rowCount() > 0) {
		$cat_info = $gci->fetch(PDO::FETCH_OBJ);
		$lkd = "false";
		if($cat_info->locked == 1) {
			$lkd = "true";
		}
		?>
		<div id="result"></div>
		<h3>Edit forum - <?php echo $cat_info->title; ?></h3>
		<div class="form-group">
			<label class="form-label">Category name</label>
			<input class="form-input" type="text" id="catname" maxlength="32" value="<?php echo $cat_info->title; ?>" required />
		</div>
		<div class="form-group">
			<label class="form-label">Description</label>
			<textarea class="form-input" id="catdesc" maxlength="256" required rows="3"><?php echo $cat_info->body; ?></textarea>
		</div>
		<div class="form-group">
			<label class="form-switch">
				<input name="lckdcatchkbx" type="checkbox" checked="<?php echo $lkd; ?>" id="lckdcatchkbx" />
				<i class="form-icon"></i> Locked
			</label>
		</div>
		<button class="btn float-right" id="cedbtn" onclick="editCategory(<?php echo $_GET['id']; ?>)">Edit</button>
		<?php
	} else {
		echo '<h2>This category does not exist.</h2>';
	}
} else {
	echo 'No forum category specified';
}
?>

</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
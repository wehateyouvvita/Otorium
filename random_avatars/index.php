<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
</head>
<body>

<div class="sides">

<?php
$randUserID = random_int(1,$pdo->query("SELECT count(*) FROM users")->fetchColumn()-1);
echo '<div onclick="'.$url.'/profile/'.$do->getUsername($randUserID).'" style="cursor: pointer;"><center><span style="font-size: 1.5em;">'.$do->getUsername($randUserID).'</span><br /><img src="'.$userImages.$randUserID.'.png?tick='.time().'" /></center></div>';
?>

</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
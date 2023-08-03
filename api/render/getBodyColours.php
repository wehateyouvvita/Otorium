<?php
header("Content-Type: text/xml");
include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
}
$id = 0;
if(isset($_GET['id'])) {
	$id = $_GET['id'];
}
$gbc = $pdo->prepare("SELECT * FROM body_colors WHERE uid = :id");
$gbc->bindParam(":id", $id, PDO::PARAM_INT);
$gbc->execute();
if($gbc->rowCount() > 0) {
	$bodycolors = $gbc->fetch(PDO::FETCH_OBJ);
	$hc = $bodycolors->head;
	$lac = $bodycolors->left_arm;
	$llc = $bodycolors->left_leg;
	$rac = $bodycolors->right_arm;
	$rlc = $bodycolors->right_leg;
	$tc = $bodycolors->torso;
} else {
	$hc = 24; //24 == yellow
	$lac = 24;
	$llc = rand(1001, 1032);
	$rac = 24;
	$rlc = $llc;
	$tc = rand(1001, 1032);
}
?>
<?php echo '<?'; ?>xml version="1.0" encoding="utf-8" ?>
<roblox xmlns:xmime="https://www.w3.org/2005/05/xmlmime" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="https://www.roblox.com/roblox.xsd" version="4">
    <External>null</External>
    <External>nil</External>
    <Item class="BodyColors">
        <Properties>
            <int name="HeadColor"><?php echo $hc; ?></int>
            <int name="LeftArmColor"><?php echo $lac; ?></int>
            <int name="LeftLegColor"><?php echo $llc; ?></int>
            <string name="Name">Body Colors</string>
            <int name="RightArmColor"><?php echo $rac; ?></int>
            <int name="RightLegColor"><?php echo $rlc; ?></int>
            <int name="TorsoColor"><?php echo $tc; ?></int>
            <bool name="archivable">true</bool>
        </Properties>
    </Item>
</roblox>
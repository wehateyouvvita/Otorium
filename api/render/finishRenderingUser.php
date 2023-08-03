<?php
include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
$do = new functions();
$fuar = $pdo->prepare("UPDATE render_user SET rendered = 1, renderedon = ".time()." WHERE id = :id");
$fuar->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
if($fuar->execute()) {
    $info = $pdo->prepare("SELECT * FROM render_user WHERE id = :id");
    $info->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $info->execute();
    $info = $info->fetch(PDO::FETCH_OBJ);
    echo '1';
    $url = 'https://discordapp.com/api/webhooks/411868866285666304/tJMcVP38HFljBEZz8gkI8o_gGprnCJNegCSkLo_bwgCOzRRUT8_Yku6nbw1sjPzKoaZb';
	$data = array('content' => '<:ot_dab:406933327774351361> Rendered '.$do->getUsername($info->uid).'\'s character. <https://cdn.otorium.xyz/assets/users/'.$info->uid.'.png?tick='.time().'>');

	$options = array(
		'http' => array(
			'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
			'method'  => 'POST',
			'content' => http_build_query($data)
		)
	);
	$context  = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
} else {
    echo '2';
}
?>
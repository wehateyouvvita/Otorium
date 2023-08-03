<?php
header("Content-Type: text/html");
require '../core/db/connect.php';
if(isset($_GET['plyrid']) && isset($_GET['usrid'])) {
		
		$query = $pdo->prepare("SELECT * FROM friends WHERE uid=:pid AND fid=:uid");
		$query->bindParam("pid", $_GET['plyrid'], PDO::PARAM_STR);
		$query->bindParam("uid", $_GET['usrid'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			echo '<Value Type="boolean">true</Value>';
		} else {
			echo '<Value Type="boolean">false</Value>';
		}
		
} else {
	echo '<Value Type="boolean">false</Value>';
}

?>
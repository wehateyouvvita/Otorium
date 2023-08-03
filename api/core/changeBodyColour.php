<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
if(isset($_POST['type']) && isset($_POST['color'])) {
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT id,theme FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			
			if($_POST['type'] == 0) {
				$type = "head";
			} elseif($_POST['type'] == 1) {
				$type = "left_arm";
			} elseif($_POST['type'] == 2) {
				$type = "right_arm";
			} elseif($_POST['type'] == 3) {
				$type = "torso";
			} elseif($_POST['type'] == 4) {
				$type = "left_leg";
			} else {
				$type = "right_leg";
			}
			$colors = array(1,208,194,199,26,21,24,226,23,107,102,11,45,135,106,105,141,28,37,119,29,151,38,192,104,9,101,5,153,217,18,125);
			if(in_array($_POST['color'], $colors)) {
				if(is_numeric($_POST['color'])) {
					$pdo->query("UPDATE body_colors SET ".$type." = ".$_POST['color']." WHERE uid = ".$userID);
				} else {
					echo '<div id="message">
							<span style="color:red;">Invalid body color</span>
						</div>';
				}
			} else {
				echo '<div id="message">
						<span style="color:red;">Invalid body color</span>
					</div>';
			}
		} else {
			echo '<div id="message">
					<span style="color:red;">You\'re not logged in.</span>
				</div>';
		}
		
		
		
	} else {
		echo '<div id="message">
				<span style="color:red;">You\'re not logged in.</span>
			</div>';
	}
	
} else {
	echo '<div id="message">
			<span style="color:red;">Unknown error occured.</span>
		</div>';
}
	

?>
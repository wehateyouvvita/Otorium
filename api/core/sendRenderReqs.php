<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
/*type 1 = accept, type 2 = decline*/


	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT id,theme FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			
			$version = 0; //2010
			if(isset($_GET['type'])) {
				if($_GET['type'] == 0) { //2008
					$version = 1;
				}
			}
			
			if($pdo->query("SELECT * FROM render_user WHERE uid = ".$userID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
				if($pdo->query("INSERT INTO render_user(uid, rendered, version, timestamp) VALUES(".$userID.", 0, ".$version.", ".time().")")) {
					$logAction = $do->logAction("sendRenderReqs", $userID, $do->encode($do->getip()));
					$sendCharAppReqs = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Sent render request</div>';
				} else {
					$sendCharAppReqs = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while sending render request</div>';
				}
			} else {
				$sendCharAppReqs = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Render request already pending</div>';
			}
		} else {
			echo '<div id="message">
					<center>
					<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
					You are not logged in.
					</center>
				</div>
				
				';
		}
		
		
		
	} else {
		echo '<div id="message">
				<center>
				<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
				You are not logged in.
				</center>
			</div>';
	}
	

?>
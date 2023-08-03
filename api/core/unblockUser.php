<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['u'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			$BlockedUserID = $_POST['u'];
			if(!($check->checkIfBlocked($userID, $BlockedUserID) == false)) {
				if($pdo->query("DELETE FROM blocked_users WHERE uid = ".$userID." AND pid = ".$BlockedUserID)) {
					echo '<div id="message">
						<div class="toast toast-success">
							&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unblocked user.
						</div>
						</div>
						
						<a id="success">t</a>';
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error occured.
						</div>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;User is not blocked. '.$check->checkIfBlocked($userID, $BlockedUserID).'
					</div>
					</div>
					
					<a id="success">f</a>';
			}
			
		} else {
			echo '<div id="message">
				<div class="toast toast-error">
					&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not logged in.
				</div>
				</div>
				
				<a id="success">f</a>';
		}
		
		
		
	} else {
		echo '<div id="message">
			<div class="toast toast-error">
				&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not logged in.
			</div>
			</div>
			
			<a id="success">f</a>';
	}
		
} else {
	echo '<div id="message">
		<div class="toast toast-error">
			&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error occured.
		</div>
		</div>
		
		<a id="success">f</a>';
}

?>
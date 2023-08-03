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
			
			$BlockedUserID = $check->getUserInfo($_POST['u'], 'id');
			if(!($BlockedUserID == false)) {
				if(!($check->checkIfStaff($BlockedUserID) == true && $rank !== 2)) {
					if($check->checkIfBlocked($userID, $BlockedUserID) == false) {
						if($check->checkIfFriends($userID, $BlockedUserID) == false) {
							if($pdo->query("INSERT INTO blocked_users (uid, pid, time_added) VALUES(".$userID.", ".$BlockedUserID.", ".time().")")) {
								echo '<div id="message">
									<div class="toast toast-success">
										&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully blocked user.
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
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You cant block your friends!
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;User is already blocked.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You cannot block staff members.
						</div>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;User does not exist.
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
<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['u']) && isset($_POST['t'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			$recipientID = $check->getUserInfo($check->getUsername($_POST['u']), 'id');
			if(!($recipientID == false)) {
				if($_POST['t'] == 2) {
					if($check->checkIfFriends($userID, $recipientID) == true) {
						if($pdo->query("DELETE FROM friends WHERE uid = ".$userID." AND fid=".$recipientID)) {
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully removed user from your friends list.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							if($pdo->query("DELETE FROM friends WHERE fid = ".$userID." AND uid=".$recipientID)) {
								echo '<div id="message">
									<div class="toast toast-success">
										&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully removed user from your friends list.
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
						}
						
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not friends with this user.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
					die();
				}
				if($check->checkIfBlocked($userID, $recipientID) == false) {
					if($check->checkIfFriends($userID, $recipientID) == false) {
						$sntfr = $check->hasFriendRequest($userID, $recipientID);
						if($sntfr == false) {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user has not sent you a friend request.
								</div>
								</div>
								
								<a id="success">f</a>';
						} else {
							if($sntfr == 1) {
								//You sent
								echo '<div id="message">
									<div class="toast toast-error">
										&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user did not send you a friend request.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								//accept or decline..... all conditions OK
								if($_POST['t'] == 0) { //accept
									if(!($check->AmountOfFriends($recipientID) > 99)) {
										if($pdo->query("INSERT INTO friends (uid, fid, time_added) VALUES(".$userID.", ".$recipientID.", ".time().")")) {
											$pdo->query("UPDATE friend_requests SET accepted=1 WHERE sid=".$userID." AND uid=".$recipientID);
											echo '<div id="message">
												<div class="toast toast-success">
													&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully accepted friend request.
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
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have 100 friends. Remove some to add friend requests.
											</div>
											</div>
											
											<a id="success">f</a>';
									}
								} else { //decline 
									if($pdo->query("UPDATE friend_requests SET accepted=0 WHERE sid=$userID AND uid=$recipientID")) {
										echo '<div id="message">
											<div class="toast toast-success">
												&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully declined friend request.
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
								}
							}
						}
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are already friends with this user.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Cannot send friend requests to blocked users.
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
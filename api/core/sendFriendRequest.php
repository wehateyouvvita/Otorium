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
			
			//Ratelimits
			if(!(isset($_SESSION['frs']))) {
				$_SESSION['frs'] = 1;
				$_SESSION['frs_time'] = time();
			}
			$_SESSION['frs'] = $_SESSION['frs'] + 1;
			$recipientID = $check->getUserInfo($check->getUsername($_POST['u']), 'id');
			if(!($recipientID == false)) {
				if($check->checkIfBlocked($userID, $recipientID) == false) {
					if($check->checkIfFriends($userID, $recipientID) == false) {
						if(!($check->AmountOfFriends($recipientID) > 99)) {
							$sntfr = $check->hasFriendRequest($userID, $recipientID);
							if($sntfr == false) {
								//Ratelimit
								if(($_SESSION['frs_time'] + 300) > time() && $_SESSION['frs'] > 5) {
									echo '<div id="message">
										<div class="toast toast-error">
											&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are sending way too many friend requests in a short amount of time.. Please try again later.
										</div>
										</div>
										
										<a id="success">f</a>';
								} else {
									if($check->checkIfBanned($recipientID) == false) {
										if(!($recipientID == 3)) {
											if(!($recipientID == -1)) {
												if(!($userID == $recipientID)) {
													if($pdo->query("INSERT INTO friend_requests (uid, sid, time_added) VALUES(".$userID.", ".$recipientID.", ".time().")")) {
														echo '<div id="message">
															<div class="toast toast-success">
																&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully sent friend request.
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
															&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Cannot send friends to yourself!
														</div>
														</div>
														
														<a id="success">f</a>';
												}
											} else {
												echo '<div id="message">
													<div class="toast toast-error">
														&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Cannot send friend requests to the Otorium system account!
													</div>
													</div>
													
													<a id="success">f</a>';
											}
										} else {
											echo '<div id="message">
												<div class="toast toast-error">
													&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Cannot send friend requests to the Otorium test account!
												</div>
												</div>
												
												<a id="success">f</a>';
										}
									} else {
										echo '<div id="message">
											<div class="toast toast-error">
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user is banned.
											</div>
											</div>
											
											<a id="success">f</a>';
									}
								}
							} else {
								if($sntfr == 1) {
									//You sent
									echo '<div id="message">
										<div class="toast toast-error">
											&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have already sent a friend request to this user!
										</div>
										</div>
										
										<a id="success">f</a>';
								} else {
									echo '<div id="message">
										<div class="toast toast-error">
											&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user has already sent a friend request to you!
										</div>
										</div>
										
										<a id="success">f</a>';
								}
							}
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user has 100 friends.
								</div>
								</div>
								
								<a id="success">f</a>';
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
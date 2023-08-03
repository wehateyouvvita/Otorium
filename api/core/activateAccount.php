<?php
session_start();
$banpage = true;
require 'db/connect.php';
if(isset($_POST['activate'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT rank,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			
			$query2 = $pdo->prepare("SELECT * from bans WHERE uid=:uid ORDER BY id DESC LIMIT 1");
			$query2->bindParam("uid", $userID, PDO::PARAM_STR);
			$query2->execute();
			if($query2->rowCount() == 1) {
				$query2inf = $query2->fetch(PDO::FETCH_OBJ);
				if($query2inf->activated == false) {
					if($query2inf->permanent == false) {
						if(($query2inf->when_banned + ($query2inf->days_banned * 86400)) < time()) {
							$query2 = $pdo->prepare("UPDATE bans SET activated=1 WHERE uid=:uid ORDER BY id DESC LIMIT 1");
							$query2->bindParam("uid", $userID, PDO::PARAM_STR);
							$query2->execute();
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-smile-o"></i>&nbsp;&nbsp;Succesfully unbanned, and welcome back to Otorium. Please try not to break the rules again.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your ban has not expired yet.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your ban is permament.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not banned.
						</div>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your account is not suspended.
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
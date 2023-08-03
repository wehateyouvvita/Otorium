<?php
session_start();
require 'db/connect.php';
if(isset($_POST['reason'])) {

	
	
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
					$query3 = $pdo->prepare("SELECT * FROM banQueries WHERE uid=:uid");
					$query3->bindParam("uid", $userID, PDO::PARAM_STR);
					$query3->execute();
					
					if($query3->rowCount() == 1) {
						
						$query3inf = $query3->fetch(PDO::FETCH_OBJ);
						
						if($query3inf->sent > (time() + 3600)) {
							$query4 = $pdo->prepare("INSERT INTO banQueries(uid,content,sent) VALUES (:uid, :content, :time)");
							$query4->bindParam("uid", $userID, PDO::PARAM_STR);
							$query4->bindParam("content", $_POST['reason'], PDO::PARAM_STR);
							$query4->bindParam("time", time(), PDO::PARAM_STR);
							$query4->execute();
							
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Query sent succesfully.
								</div>
								</div>
							
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Please wait an hour before sending another query.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						$query4 = $pdo->prepare("INSERT INTO banQueries(uid,content,sent) VALUES (:uid, :content, :time)");
						$query4->bindParam("uid", $userID, PDO::PARAM_STR);
						$query4->bindParam("content", $_POST['reason'], PDO::PARAM_STR);
						$query4->bindParam("time", time(), PDO::PARAM_STR);
						$query4->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Query sent succesfully.
							</div>
							</div>
						
							<a id="success">t</a>';
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
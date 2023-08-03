<?php
session_start();
require 'db/connect.php';
if(isset($_POST['announcement']) && isset($_POST['color'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			if($rank == 2) {
				$approver = true;
			}
			
			if ($approver == false) {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to change announcements.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				
				if(($_POST['announcement'] == 'null') && ($_POST['color'] == 'null')) {
					
					$chkanncQ = $pdo->prepare("SELECT * FROM announcement ORDER BY `id` DESC LIMIT 1");
					$chkanncQ->execute();
					if ($query->rowCount() > 0) {
						$chkannc = $chkanncQ->fetch(PDO::FETCH_OBJ);
						$seen = $chkannc->seen;
						
						if($seen == true) {
							$query2 = $pdo->prepare("INSERT INTO announcement(user,seen) VALUES(:user, 0)");
							$query2->bindParam("user", $userID, PDO::PARAM_STR);
							$query2->execute();
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully removed announcement.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;There is no announcement to remove.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;There is no announcement to remove.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					
					if(strlen($_POST['announcement']) < 12) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Announcement must be more than 12 characters.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						if($_POST['color'] == '1') {
							$colour = "background-color:rgb(240,30,30); color:white;";
						} elseif($_POST['color'] == '2') {
							$colour = "background-color:rgb(30,144,255); color:white;";
						} elseif($_POST['color'] == '3') {
							$colour = "background-color:rgb(255,165,0); color:white;";
						} elseif($_POST['color'] == '4') {
							$colour = "background-color:rgb(34,139,34); color:white;";
						} elseif($_POST['color'] == '5') {
							$colour = "background-color:rgb(139,0,139); color:white;";
						}
						$query2 = $pdo->prepare("INSERT INTO announcement(content,colour,user,seen) VALUES(:content, :colour, :user, 1)");
						$query2->bindParam("content", $_POST['announcement'], PDO::PARAM_STR);
						$query2->bindParam("colour", $colour, PDO::PARAM_STR);
						$query2->bindParam("user", $userID, PDO::PARAM_STR);
						$query2->execute();
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed announcement.
							</div>
							</div>
							
							<a id="success">t</a>';
					}
				}
				
			}
			
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
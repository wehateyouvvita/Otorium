<?php
session_start();
require 'db/connect.php';
if(isset($_POST['aprv']) && isset($_POST['gid'])) {
	
	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			
			if(($rank == 1) || ($rank == 2)) {
				$approver = true;
			}
			
			if ($approver == false) {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to approve assets.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				
				$query2 = $pdo->prepare("SELECT image_approved FROM games WHERE id=:id");
				$query2->bindParam("id", $_POST['gid'], PDO::PARAM_STR);
				$query2->execute();
				
				if ($query->rowCount() > 0) {
					$result2 = $query2->fetch(PDO::FETCH_OBJ);
					if(($result2->image_approved == 1) || ($result2->image_approved == 2)) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The thumbnail of the game has already been accepted/declined.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						$query3 = $pdo->prepare("UPDATE games SET image_approved=:arg WHERE id=:id");
						$query3->bindParam("id", $_POST['gid'], PDO::PARAM_STR);
						$query3->bindParam("arg", $_POST['aprv'], PDO::PARAM_STR);
						if($query3) {
							$query3->execute();
							if($_POST['aprv'] == '1') {
								$wrd1 = 'approved';
							} else {
								$wrd1 = 'declined';
							}
							
								echo'<div id="message">
									<div class="toast toast-success">
										&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully '.$wrd1.' the game\'s thumbnail!
									</div>
									</div>
									
									<a id="success">t</a>';
						}
						
						
						
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Game does not exist.
						</div>
						</div>
						
						<a id="success">f</a>';
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
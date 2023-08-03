<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['gameid']) && isset($_POST['a'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			if(is_numeric($_POST['gameid'])) {
    			if($check->ifGameExists($_POST['gameid'])) {
    				if($check->whoOwnGame($_POST['gameid'], $userID) == true) {
    					if($_POST['a'] == 1) { //Delete game
    						$pdo->query("UPDATE games SET deleted=1 WHERE id=".$_POST['gameid']);
    						echo '<div id="message">
    							<div class="toast toast-success">
    								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully deleted game.
    							</div>
    							</div>
    							
    							<a id="success">t</a>';
    					} elseif ($_POST['a'] == 2) { //Take game offline
    						$pdo->query("UPDATE games SET available=0 WHERE id=".$_POST['gameid']);
    						echo '<div id="message">
    							<div class="toast toast-success">
    								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully took game offline.
    							</div>
    							</div>
    							
    							<a id="success">t</a>';
    					} else {
    						echo '<div id="message">
    							<div class="toast toast-error">
    								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error
    							</div>
    							</div>
    							
    							<a id="success">f</a>';
    					}
    				} else {
    					echo '<div id="message">
    						<div class="toast toast-error">
    							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You do not own this game.
    						</div>
    						</div>
    						
    						<a id="success">f</a>';
    				}
    			} else {
    				echo '<div id="message">
    					<div class="toast toast-error">
    						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Game does not exist.
    					</div>
    					</div>
    					
    					<a id="success">f</a>';
    			}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error
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
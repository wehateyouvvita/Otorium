<?php
session_start();
require 'db/connect.php';
if(isset($_POST['id']) && isset($_POST['ld']) && isset($_POST['n']) && isset($_POST['d'])) {

	
	
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
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to change categories.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				$cc = $pdo->prepare("UPDATE forum_topics SET title=:t, body=:b, locked=:l WHERE id=:id");
				$cc->bindParam(":id", $_POST['id'], PDO::PARAM_INT);
				$cc->bindParam(":t", $_POST['n'], PDO::PARAM_STR);
				$cc->bindParam(":b", $_POST['d'], PDO::PARAM_STR);
				$cc->bindParam(":l", $_POST['locked'], PDO::PARAM_INT);
				if($cc->execute()) {
					echo '<div id="message">
						<div class="toast toast-success">
							&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully edited category. '.$lk.'
						</div>
						</div>
						
						<a id="success">t</a>';
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;An unknown error occured while editing category.
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
			&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error occured. '.$_POST['id'].':'.$_POST['ld'].':'.$_POST['n'].':'.$_POST['d'].'
		</div>
		</div>
		
		<a id="success">f</a>';
}

?>
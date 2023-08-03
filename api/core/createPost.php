<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['n']) && isset($_POST['b']) && isset($_POST['c'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			if($check->ifcategoryAvailable($_POST['c'])) {
				if($check->ifCategoryLocked($_POST['c']) == true) {
					if(!($rank == 2)) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Category is locked.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						goto createForumPost;
					}
				} else {
					createForumPost:
					if(strlen($_POST['n']) > 32 || strlen($_POST['n']) < 8) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Post name must be more than 8 characters but less than 32.
							</div>
							</div>
							
							<a id="success">f</a>';
					} elseif(strlen($_POST['b']) > 1024 || strlen($_POST['b']) < 16) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Post body must be more than 16 characters but less than 1024.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						//check for post limits FIRST
						if(($check->lastposttime($userID) + 60) > time()) {
							echo '<div id="message">
								<div class="toast toast-warning">
									&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Please wait 60 seconds before posting again.
								</div>
								</div>
								
								<a id="success">f</a>';
							
						} else {
							if($check->checkIfFiltered($_POST['n']) == true) {
								echo '<div id="message">
									<div class="toast toast-warning">
										&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Post title is filtered.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								if($check->checkIfFiltered($_POST['b']) == true) {
									echo '<div id="message">
										<div class="toast toast-warning">
											&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Post content is filtered.
										</div>
										</div>
										
										<a id="success">f</a>';
								} else {
									$query3 = $pdo->prepare("INSERT INTO forum_posts(title,body,poster,time_posted,topics_id,last_post_date) VALUES(:n,:b,".$userID.",".time().",:c,".time().")");
									
									$query3->bindParam("n", $_POST['n'], PDO::PARAM_STR);
									$query3->bindParam("b", $_POST['b'], PDO::PARAM_STR);
									$query3->bindParam("c", $_POST['c'], PDO::PARAM_STR);
									$query3->execute();
									
									echo '<div id="message">
										<div class="toast toast-success">
											&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully posted!
										</div>
										</div>
										
										<a id="success">t</a>';
								}
							}
						}
					}
				}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Category does not exist.
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
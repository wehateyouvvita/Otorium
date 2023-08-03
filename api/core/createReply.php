<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['b']) && isset($_POST['p'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			//if($check->ifPostExists($_GET['p'])) {
				if($check->ifPostLocked($_POST['p']) == true && !($rank == 1 || $rank == 2)) {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Post is locked.
						</div>
						</div>
						
						<a id="success">f</a>';
					
				} else {
					if(strlen($_POST['b']) > 1024 || strlen($_POST['b']) < 8) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Body must be more than 8 characters but less than 1024.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						//check for post limits FIRST
						if(($check->lastreplytime($userID) + 60) > time() && !($rank == 2)) {
							echo '<div id="message">
								<div class="toast toast-warning">
									&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Please wait 60 seconds before posting again.
								</div>
								</div>
								
								<a id="success">f</a>';
							
						} else {
							if($check->checkIfFiltered($_POST['b'])) {
								echo '<div id="message">
									<div class="toast toast-warning">
										&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Post body is filtered.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								$blocked = $check->checkIfBlocked($userID, $check->whoOwnPost($_POST['p']));
								if($blocked == false) {
										
									$query3 = $pdo->prepare("INSERT INTO forum_replies(post_id,poster,message,time_posted) VALUES(:p,".$userID.",:b,".time().")");
									
									$query3->bindParam("p", $_POST['p'], PDO::PARAM_INT);
									$query3->bindParam("b", $_POST['b'], PDO::PARAM_STR);
									$query3->execute();
									$updateLastPostTime = $pdo->prepare("UPDATE forum_posts SET last_post_date = ".time().", last_poster = ".$userID." WHERE id = :p");
									$updateLastPostTime->bindParam("p", $_POST['p'], PDO::PARAM_INT);
									$updateLastPostTime->execute();
									
									echo '<div id="message">
										<div class="toast toast-success">
											&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully replied!
										</div>
										</div>
										
										<a id="success">t</a>';
								} else {
									if($blocked == 1) {
										echo '<div id="message">
											<div class="toast toast-error">
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This user has blocked you. More information <a href="https://otorium.xyz/help/2">here.</a>
											</div>
											</div>
											
											<a id="success">f</a>';
									} else {
										echo '<div id="message">
											<div class="toast toast-error">
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have blocked this user. More information <a href="https://otorium.xyz/help/2">here.</a>
											</div>
											</div>
											
											<a id="success">f</a>';
									}
								}
							}
						}
					}
				}
			/* } else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This post does not exist.
					</div>
					</div>
					
					<a id="success">f</a>';
			} */
			
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
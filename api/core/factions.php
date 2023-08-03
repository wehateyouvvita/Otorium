<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';

$check = new functions;
if(isset($_POST['p']) && isset($_POST['a'])) {
	
	if(isset($_SESSION['session'])) {
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			if(($rank == 1) || ($rank == 2)) {
				$approver = true;
			}
			
			if ($approver == false) {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to moderate posts.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				//check if post exists
				if($check->ifPostExists($_POST['p']) == false) {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This post does not exist.
						</div>
						</div>
						
						<a id="success">f</a>';
				}
				
				
				//check for lock post, unlock post, pin post, unpin post, delete post
				
				if($_POST['a'] == "lp") {
					$postUserID = $check->whoOwnPost($_POST['p']);
					$postUserRank = $check->getRank($postUserID);
					if($postUserRank == 2) {
						if($postUserRank == $rank) {
							$query2 = $pdo->prepare("UPDATE forum_posts SET locked=1, w_d=".$userID." WHERE id=:id");
							$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
							$query2->execute();
							
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully locked post.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This is an administrators post.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						$query2 = $pdo->prepare("UPDATE forum_posts SET locked=1, w_d=".$userID." WHERE id=:id");
						$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
						$query2->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully locked post.
							</div>
							</div>
							
							<a id="success">t</a>';
					}
					
				} elseif($_POST['a'] == "ulp") {
					$postUserID = $check->whoOwnPost($_POST['p']);
					$postUserRank = $check->getRank($postUserID);
					if($postUserRank == 2) {
						if($postUserRank == $rank) {
							$query2 = $pdo->prepare("UPDATE forum_posts SET locked=0, w_d=".$userID." WHERE id=:id");
							$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
							$query2->execute();
							
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unlocked post.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This is an administrators post.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						$query2 = $pdo->prepare("UPDATE forum_posts SET locked=0, w_d=".$userID." WHERE id=:id");
						$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
						$query2->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unlocked post.
							</div>
							</div>
							
							<a id="success">t</a>';
					}
					
					
				} elseif($_POST['a'] == "pp") {
					if($rank == 2) {
						$query2 = $pdo->prepare("UPDATE forum_posts SET pinned=1, w_d=".$userID." WHERE id=:id");
						$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
						$query2->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully pinned post.
							</div>
							</div>
							
							<a id="success">t</a>';
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Only administrators can pin posts.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
					
				} elseif($_POST['a'] == "upp") {
					if($rank == 2) {
						$query2 = $pdo->prepare("UPDATE forum_posts SET pinned=0, w_d=".$userID." WHERE id=:id");
						$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
						$query2->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unpinned post.
							</div>
							</div>
							
							<a id="success">t</a>';
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Only administrators can unpin posts.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
					
					
				} elseif($_POST['a'] == "dp") {
					$postUserID = $check->whoOwnPost($_POST['p']);
					$postUserRank = $check->getRank($postUserID);
					if($postUserRank == 2) {
						if($postUserRank == $rank) {
							$query2 = $pdo->prepare("UPDATE forum_posts SET deleted=1, w_d=".$userID." WHERE id=:id");
							$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
							$query2->execute();
							
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully deleted post.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;This is an administrators post.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						$query2 = $pdo->prepare("UPDATE forum_posts SET deleted=1, w_d=".$userID." WHERE id=:id");
						$query2->bindParam("id", $_POST['p'], PDO::PARAM_STR);
						$query2->execute();
						
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully deleted post.
							</div>
							</div>
							
							<a id="success">t</a>';
					}
					
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Invalid action.
						</div>
						</div>
						
						<a id="success">f</a>';
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
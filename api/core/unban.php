<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
if(isset($_POST['uid'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			$username = $result->username;
			
			if(($rank == 1) || ($rank == 2)) {
				$banner = true;
			}
			
			if ($banner == false) {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to unban users.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				
				$query2 = $pdo->prepare("SELECT username,rank,id FROM users WHERE username=:uname");
				$query2->bindParam("uname", $_POST['uid'], PDO::PARAM_STR);
				$query2->execute();
				
				if ($query2->rowCount() > 0) {
					$userInfo = $query2->fetch(PDO::FETCH_OBJ);
					
					if(($userInfo->rank == 1) || ($userInfo->rank == 2)) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Cannot ban/unban staff members. <i class="fa fa-eye"></i>
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						$query3 = $pdo->prepare("SELECT * FROM bans WHERE uid=:uid ORDER BY `id` DESC LIMIT 1");
						$query3->bindParam("uid", $userInfo->id, PDO::PARAM_STR);
						$query3->execute();
						
						if ($query3->rowCount() == 0) {
							banuser:
							$whb = time();
							$query4 = $pdo->prepare("UPDATE bans SET activated=1, who_unban=:whb WHERE uid=:uid ORDER BY `id` DESC LIMIT 1");
							$query4->bindParam("uid", $userInfo->id, PDO::PARAM_STR);
							$query4->bindParam("whb", $userID, PDO::PARAM_STR);
							$query4->execute();
							
							$url = 'https://discordapp.com/api/webhooks/401227344041476097/AE5OlRAtqx2LVUcIKqwBJSUe2LbUHU4hWw5uSVc5TQ6XWQfj2efCOMWkIwMGBIk4Vx9A';
							$data = array('content' => '**'.$do->getUsername($userInfo->id).'** has been unbanned by '.$username);

							// use key 'http' even if you send the request to https://...
							$options = array(
								'http' => array(
									'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
									'method'  => 'POST',
									'content' => http_build_query($data)
								)
							);
							$context  = stream_context_create($options);
							$result = file_get_contents($url, false, $context);
							
							
							echo '<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unbanned user.
								</div>
								</div>
								
								<a id="success">t</a>';
						} else {
							$baninfo = $query3->fetch(PDO::FETCH_OBJ);
							if($baninfo->activated == true) {
								echo '<div id="message">
									<div class="toast toast-error">
										&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;User is not banned.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								goto banuser;
							}
						}
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;User does not exist.
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
<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['gn']) && isset($_POST['gd']) && isset($_POST['gv']) && isset($_POST['ip']) && isset($_POST['prt']) && isset($_POST['tbn']) && isset($_POST['lb']) && isset($_POST['hg'])) {
	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			$vh = $result->verified_hoster;
			$userMembership = $check->getUserMembership($userID);
			$gameLimit = 4; // +1
			if($userMembership == false) {
				$gameLimit = 9;
			} elseif($userMembership[0] == 1) {
				$gameLimit = 19;
			} elseif($userMembership[0] == 2) {
				$gameLimit = 49;
			} elseif($userMembership[0] == 3) {
				$gameLimit = 79;
			}
			if($vh == 1) {
				$gameLimit = 99; // +1
			}
			$cfgl = $pdo->query("SELECT * FROM games WHERE deleted=0 AND creator=".$userID);
			if($cfgl->rowCount() > $gameLimit) {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You can only have '.($gameLimit+1).' games at once. Edit the description and title of your game or delete them to create more.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				//checks
				$gameTitle = $_POST['gn'];
				$gameDesc = $_POST['gd'];
				// version: 0 = 2009, 1 = 2011
				$version = 0; //$_POST['gv'];
				$ip = $_POST['ip'];
				$port = $_POST['prt'];
				$thumbnail = $_POST['tbn'];
				if($_POST['lb'] == 0) {
					$loopback = 0;
				} else {
					$loopback = 1;
				}
				if($_POST['lb'] == 0) {
					$hostserver = 0;
				} else {
					$hostserver = 1;
				}
				
				if(strlen($gameTitle) < 3 || strlen($gameTitle) > 32) {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The game title must be atleast 3 characters but less than 32.
						</div>
						</div>
						
						<a id="success">f</a>';
				} else {
					if(strlen($gameDesc) > 256) {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The game description cannot be more than 256 characters.
							</div>
							</div>
							
							<a id="success">f</a>';
					} else {
						if(strlen($ip) > 15) {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;IP cannot be more than 16 characters.
								</div>
								</div>
								
								<a id="success">f</a>';
						} else {
							if(strlen($port) > 5) {
								echo '<div id="message">
									<div class="toast toast-error">
										&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Port cannot be more than 5 digits.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								if(strlen($thumbnail) > 256) {
									echo '<div id="message">
										<div class="toast toast-error">
											&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Thumbnail link cannot be more than 256 characters.
										</div>
										</div>
										
										<a id="success">f</a>';
								} else {
									$createGame = $pdo->prepare("INSERT INTO games(name,description,creator,version,image,port,ip,created,updated,loopback)
																VALUES(:nm, :ds, ".$userID.", :ver, :image, :port, :ip, ".time().", 0, ".$loopback.")");
									$createGame->bindParam(":nm", $gameTitle, PDO::PARAM_STR);
									$createGame->bindParam(":ds", $gameDesc, PDO::PARAM_STR);
									$createGame->bindParam(":ver", $version, PDO::PARAM_INT);
									$createGame->bindParam(":image", $thumbnail, PDO::PARAM_STR);
									$createGame->bindParam(":port", $port, PDO::PARAM_INT);
									$createGame->bindParam(":ip", $ip, PDO::PARAM_STR);
									if($createGame->execute()) {
										echo '<div id="message">
											<div class="toast toast-success">
												&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully created game!
											</div>
											</div>
											
											<a id="success">t</a>';
									} else {
										echo '<div id="message">
											<div class="toast toast-error">
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error.
											</div>
											</div>
											
											<a id="success">f</a>';
									}
								}
							}
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
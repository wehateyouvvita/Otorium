<?php
session_start();
require 'db/connect.php';
include 'siteFunctions.php';
$Login = new functions();

if(isset($_POST['1'])) {

	if(isset($_SESSION['session'])) {
		
		$query = $pdo->prepare("SELECT username,rank,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			if($rank == 2) {
				echo'<div id="message">
							The credentials supplied match available accounts on the site.
						</div>';
					
					echo '<a id="success">t</a>';
					
					echo '<a id="form">
						<div id="result"></div>
						<h2>Sign in</h2>
							<div id="form-groups">
								<div class="form-group">
									<label class="form-label">Unique Identifier</label>
									<input class="form-input" type="text" placeholder="UID" id="uniqId" />
								</div>
								<div class="form-group">
									<label class="form-label">Password</label>
									<input class="form-input" type="password" placeholder="Password" id="pw" />
								</div>
								<div class="form-group">
									<label class="form-label">Second Identifier</label>
									<input class="form-input" type="text" maxlength="1" placeholder="2ID" id="secid" />
								</div>
								<br />
								
								<button class="btn btn-primary" onclick="login()" id="signinbtn">Sign In</button>
							  
							</div>
						</a>';
			} else {
				goto ipcheck;
			}
			
		} else {
			ipcheck:
			$query2 = $pdo->prepare("SELECT * FROM ipblacklist WHERE ip='".$Login->encode($Login->getip(), "e")."' ORDER BY `id` DESC LIMIT 1");
			$query2->execute();
			if($query2->rowCount() == 0) {
				ipcheck2:
				$ip = $Login->encode($Login->getip(), "e");
				$query3 = $pdo->prepare("SELECT * FROM users WHERE curIP=:cip OR regIP=:rip AND rank=2");
				$query3->bindParam("cip", $ip, PDO::PARAM_STR);
				$query3->bindParam("rip", $ip, PDO::PARAM_STR);
				$query3->execute();
				
				if($query3->rowCount() == 0) {
					echo'<div id="message">
							The credentials supplied do not match any available accounts..
						</div>';
					
					echo '<a id="success">f</a>';
				} else {
					echo'<div id="message">
							The credentials supplied match available accounts on the site.
						</div>';
					
					echo '<a id="success">t</a>';
					
					echo '<a id="form">
						<div id="result"></div>
						<h2>Sign in</h2>
							<div id="form-groups">
								<div class="form-group">
									<label class="form-label">Unique Identifier</label>
									<input class="form-input" type="text" placeholder="UID" id="uniqId" />
								</div>
								<div class="form-group">
									<label class="form-label">Password</label>
									<input class="form-input" type="password" placeholder="Password" id="pw" />
								</div>
								<div class="form-group">
									<label class="form-label">Second Identifier</label>
									<input class="form-input" type="text" maxlength="1" placeholder="2ID" id="secid" />
								</div>
								<br />
								
								<button class="btn btn-primary" onclick="login()" id="signinbtn">Sign In</button>
							  
							</div>
						</a>';
				}
			} else {
				$res = $query2->fetch(PDO::FETCH_OBJ);
				if($Login->encode($res->ip, "d") == $Login->getip()) {
					if($res->untildate > time()) {
						echo'<div id="message">
								The credentials supplied do not match any on the site...
							</div>';
							
						echo '<a id="success">f</a>';
					} else {
						goto ipcheck2;
					}
				} else {
						goto ipcheck2;
				}
			}
		}
		
		
	} else {
		goto ipcheck;
	}
		
}elseif (isset($_POST['2']) && isset($_POST['uid']) && isset($_POST['pw']) && isset($_POST['id2'])) {

	if(isset($_SESSION['session'])) {
		
		$query = $pdo->prepare("SELECT username,rank,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			if($rank == 2) {
				echo'<div id="message">
							<div class="toast toast-warning">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Please log out before logging in to maintenance mode.
							</div>
					</div>';
				
				echo '<a id="success">f</a>';
			} else {
				goto Aipcheck;
			}
			
		} else {
			Aipcheck:
			$query2 = $pdo->prepare("SELECT * FROM ipblacklist WHERE ip='".$Login->encode($Login->getip(), "e")."' ORDER BY `id` DESC LIMIT 1");
			$query2->execute();
			if($query2->rowCount() == 0) {
				Aipcheck2:
				$ip = $Login->encode($Login->getip(), "e");
				$query3 = $pdo->prepare("SELECT * FROM users WHERE curIP=:cip OR regIP=:rip AND rank=2");
				$query3->bindParam("cip", $ip, PDO::PARAM_STR);
				$query3->bindParam("rip", $ip, PDO::PARAM_STR);
				$query3->execute();
				
				if($query3->rowCount() == 0) {
					echo'<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Credentials supplied do not match any available accounts.
								</div>
						</div>';
					
					echo '<a id="success">f</a>';
				} else {
					$query4 = $pdo->prepare("SELECT id,password,letter,rank FROM users WHERE id = :uid");
					$query4->bindParam("uid", $_POST['uid'], PDO::PARAM_STR);
					$query4->execute();
					if ($query4->rowCount() > 0) {
						$result2 = $query4->fetch(PDO::FETCH_OBJ);
						
						if(password_verify($_POST['pw'], $result2->password) && $_POST['id2'] == $result2->letter && $result2->rank == 2) {
							$token = $Login->random_str(32);
							$ip = $Login->encode($Login->getip());
							$createToken = $pdo->prepare("INSERT INTO logged_in_sessions(token, uid, ip, useragent, when_created) VALUES('".$token."', ".$result2->id.", :ip, :ua, ".time().")");
							$createToken->bindParam(":ip", $ip, PDO::PARAM_STR);
							$createToken->bindParam(":ua", $_SERVER['HTTP_USER_AGENT'], PDO::PARAM_STR);
							$createToken->execute();
							setcookie("token", $token, time() + (86400 * 7), "/", ".otorium.xyz", TRUE);
							$_SESSION['maintenanceSesh'] = true;
							echo'<div id="message">
								<div class="toast toast-success">
									&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully logged in to maintenance mode.
								</div>
							</div>';
							
							echo '<a id="success">t</a>';
						} else {
							echo'<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Credentials supplied do not match the items with the identifier(s).
								</div>
							</div>';
							
							echo '<a id="success">f</a>';
						}
						
					} else {
						echo'<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Account does not exist.
								</div>
							</div>';
							
						echo '<a id="success">f</a>';
					}
				}
			} else {
				$res = $query2->fetch(PDO::FETCH_OBJ);
				if($Login->encode($res->ip, "d") == $Login->getip()) {
					if($res->untildate > time()) {
						echo'<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are blacklisted from Otorium.
								</div>
							</div>';
							
						echo '<a id="success">f</a>';
					} else {
						goto Aipcheck2;
					}
				} else {
						goto Aipcheck2;
				}
			}
		}
		
		
	} else {
		goto Aipcheck;
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
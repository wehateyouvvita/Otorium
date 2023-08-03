<?php
/*
die();*/
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
if(isset($_POST['uname']) && isset($_POST['pw']) && isset($_POST['email'])) {
	
	
	
	if(isset($_SESSION['session'])) {
		
		echo '<div id="message">
			<div class="toast toast-error">
				&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are logged in.
			</div>
			</div>
			
			<a id="success">f</a>';
		
	} else {
		if($sitesettings->registration == 1) {
			if (ctype_alnum($_POST['uname'])) {
				if((strlen($_POST['uname']) > 2) && (strlen($_POST['uname']) < 17)) {
					if(strlen($_POST['pw']) > 8) {
						if(strlen($_POST['email']) > 9) {
							$query = $pdo->prepare("SELECT username FROM users WHERE username=:uname");
							$query->bindParam("uname", $_POST['uname'], PDO::PARAM_STR);
							$query->execute();
							
							if($query->rowCount() > 0 || $do->ifUsernameExists($_POST['uname']) == true) {
								echo '<div id="message">
									<div class="toast toast-error">
										&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;An account with this username already exists.
									</div>
									</div>
									
									<a id="success">f</a>';
							} else {
								$ip = $do->encode($do->getip(), "e");
								$query2 = $pdo->prepare("SELECT username FROM users WHERE curIP=:cip OR regIP=:rip OR email=:email");
								$query2->bindParam("cip", $ip, PDO::PARAM_STR);
								$query2->bindParam("rip", $ip, PDO::PARAM_STR);
								$query2->bindParam("email", $_POST['email'], PDO::PARAM_STR);
								$query2->execute();
								if($query2->rowCount() > 2) {
									echo '<div id="message">
										<div class="toast toast-error">
											&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You can only have 3 accounts at once.
										</div>
										</div>
										
										<a id="success">f</a>';
								} else {
									if($do->checkIfFiltered($_POST['uname']) == true) {
										echo '<div id="message">
											<div class="toast toast-error">
												&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Username is filtered.
											</div>
											</div>
											
											<a id="success">f</a>';
										
									} else {
										//your site secret key
										$secret = '6LdNBT4UAAAAAJE5Z5KwVlBZ1e2T9V5xWY6QIHJ2';
										//get verify response data
										//$verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['grecaptcharesponse']);
										//$responseData = json_decode($verifyResponse);
										//if($responseData->success) {
											$pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
											$email = $do->encode($_POST['email'], "e");
											$query3 = $pdo->prepare("INSERT INTO users(username,password,email,curIP,regIP,joindate,lastseen) VALUES(:uname, :pw, :email, :curIP, :regIP, ".time().", 0)");
											$query3->bindParam("regIP", $ip, PDO::PARAM_STR);
											$query3->bindParam("curIP", $ip, PDO::PARAM_STR);
											$query3->bindParam("pw", $pw, PDO::PARAM_STR);
											$query3->bindParam("uname", $_POST['uname'], PDO::PARAM_STR);
											$query3->bindParam("email", $email, PDO::PARAM_STR);
											$query3->execute();
											//Finishhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh
											$query4 = $pdo->prepare("SELECT id FROM users WHERE username=:uname");
											$query4->bindParam("uname", $_POST['uname'], PDO::PARAM_STR);
											$query4->execute();
											$query4f = $query4->fetch(PDO::FETCH_OBJ);
											$userID = $query4f->id;
											
											$query5 = $pdo->prepare("INSERT INTO user_settings(uid) VALUES(:uname)");
											$query5->bindParam("uname", $userID, PDO::PARAM_STR);
											$query5->execute();
											
											$query6 = $pdo->query("INSERT INTO body_colors(uid) VALUES(".$userID.")");
											$logAction = $do->logAction("register", $userID, $do->encode($do->getip()));
						
											echo '<div id="message">
												<div class="toast toast-success">
													&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully registered on Otorium!
												</div>
												</div>
												
												<a id="success">t</a>';
												
											$renderUser = $pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$userID.", 0, ".time().")");
											
											$url = 'https://discordapp.com/api/webhooks/401433635628253184/c8oReMSsPAtf0xIS7bIEweke5QOjHIe9Zd_NVyRy_Nszx_zExR_iIvZnf6ayVPCUJsGP';
											$data = array('content' => ':newspaper: **'.$_POST['uname'].'** has joined Otorium!');

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
										/*} else {
											echo '<div id="message">
												<div class="toast toast-error">
													&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;reCaptcha was not completed
												</div>
												</div>
												
												<a id="success">f</a>';
										}*/
									}
								}
							}
						} else {
							echo '<div id="message">
								<div class="toast toast-error">
									&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Please enter a valid email.
								</div>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your password must be more than 7 characters.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your username must be from 3 to 16 characters.
						</div>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				echo '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your username can only contain alphanumeric characters (letters and numbers)
					</div>
					</div>
					
					<a id="success">f</a>';
			}
		} else {
			echo '<div id="message">
				<div class="toast toast-warning">
					&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Registration has been disabled.
				</div>
				</div>
				
				<a id="success">f</a>';
		}
	}
		
} else {
	echo '<div id="message">
		<div class="toast toast-error">
			&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error occured. '.$_POST['grecaptcharesponse'].'
		</div>
		</div>
		
		<a id="success">f</a>';
}

?>
<?php
session_start();
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';

//You may change <div id="mesasage">'s CONTENTS only, but DONT TOUCH THE ID NOR <a id="success"> OR ELSE YOU WILL BREAK THE SCRIPT. kthx
$username = $_POST['uname'];
$password = $_POST['pw'];

$Login = new functions();
if(!(isset($_SESSION['attempts']))) {
	if(!(isset($_COOKIE['token']))) {
		loginpart:
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		$query = $pdo->prepare("SELECT * FROM ipblacklist WHERE ip='".$Login->encode($Login->getip(), "e")."' ORDER BY `id` DESC LIMIT 1");
		$query->execute();
		
		if($query->rowCount() == 0) {
			loginpart2:
			if($Login->login($username,$password)) {
				if($username == "p") {
				echo '<div id="message">
					<div class="toast toast-warning">
						&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Account locked.
					</div>
					</div>
					
					<a id="success">f</a>';
				die();
				}
				$logAction = $Login->logAction("login_".$username, 0, $Login->encode($Login->getip()));
				echo'<div id="message">
					<div class="toast toast-success">
						&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully signed in. Redirecting..
					</div>
					</div>
					';
					
				echo '<a id="success">t</a>';
			} else {
				if(!(isset($_SESSION['attempts']))) {
					$_SESSION['attempts'] = $_SESSION['attempts'] + 1;
				}
				
				echo'<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Incorrect username or password.
					</div>
					</div>';
					
				echo '<a id="success">f</a>';
				
				$_SESSION['attempts'] = $_SESSION['attempts'] + 1;
				$_SESSION['attempts_t'] = time() + 300;
			}
		} else {
			$res = $query->fetch(PDO::FETCH_OBJ);
			if($Login->encode($res->ip, "d") == $Login->getip()) {
				if($res->untildate > time()) {
					echo'<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have been blacklisted from Otorium.
						</div>
						</div>';
						
					echo '<a id="success">f</a>';
				} else {
					goto loginpart2;
				}
			} else {
					goto loginpart2;
			}
		}
	} else {
		echo'<div id="message">
			<div class="toast toast-warning">
				&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are already logged in!
			</div>
			</div>
			<meta http-equiv="refresh" content="5;url=../home.php" />';
			
		echo '<a id="success">f</a>';
	}
} else {
	if ($_SESSION['attempts'] > 10) {
		if ($_SESSION['attempts'] > 25) {
			if($_SESSION['attempts'] > 50) {
				if(($_SESSION['attempts_t'] + 1800) > time()) {
					//Add to blacklist
					$wd = time();
					$ud = $wd + 86400;
					include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
					$ip = $Login->encode($Login->getip(), "e");
					$query = $pdo->prepare("INSERT INTO ipblacklist(ip,whendate,untildate,whoUserid,whyb) VALUES(:ip,:wd,:ud,0,'Too many login attempts in a short amount of time (spam detected)')");
					$query->bindParam("ip", $ip, PDO::PARAM_STR);
					$query->bindParam("wd", $wd, PDO::PARAM_STR);
					$query->bindParam("ud", $ud, PDO::PARAM_STR);
					$query->execute();
					
					echo'<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have been blacklisted from Otorium.
						</div>
						</div>';
					unset($_SESSION['attempts_t']);
					unset($_SESSION['attempts']);
				}
			} else {
				if(($_SESSION['attempts_t'] + 1800) > time()) {
					$seconds = $_SESSION['attempts_t'] + 1800 - time();
					echo'<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Spamming detected; Login has been disabled for '.$seconds.' seconds.
						</div>
						</div>';
						
					echo '<a id="success">f</a>';
					$_SESSION['attempts'] = $_SESSION['attempts'] + 1;
				} else {
					unset($_SESSION['attempts_t']);
					$_SESSION['attempts'] = 0;
					goto loginpart;
				}
			}
		} else {
			if($_SESSION['attempts_t'] > time()) {
				$seconds = $_SESSION['attempts_t'] - time();
				echo'<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You have tried to log in 10 times. Try again in the next '.$seconds.' seconds.
					</div>
					</div>';
					
				echo '<a id="success">f</a>';
				$_SESSION['attempts'] = $_SESSION['attempts'] + 1;
			} else {
				unset($_SESSION['attempts_t']);
				$_SESSION['attempts'] = 0;
				goto loginpart;
			}
		}
	} else {
		goto loginpart;
	}
}
?>
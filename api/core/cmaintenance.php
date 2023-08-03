<?php
session_start();
require 'db/connect.php';
if(isset($_POST['m'])) {

	
	
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
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You are not authorized to enable or disable maintenance.
					</div>
					</div>
					
					<a id="success">f</a>';
			} else {
				
				if($_POST['m'] == 1) {
					$ma = 1;
					$w = "enabled";
					$sysm = 0;
					if($_POST['sysm'] == 1) {
						$sysm = 1;
					}
					$mtpw = password_hash($_POST['mtpw'], PASSWORD_DEFAULT);
				} elseif($_POST['m'] == 2) {
					$ma = 0;
					$w = "disabled";
					$sysm = "null";
					$mtpw = null;
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;400 Bad Request
						</div>
						</div>
						
						<a id="success">f</a>';
					goto skippart;
				}
				$query2 = $pdo->prepare("UPDATE settings SET maintenance=:m, mtpw=:mt AND sysMaintenance=".$sysm." WHERE id=1");
				$query2->bindParam("m", $ma, PDO::PARAM_STR);
				$query2->bindParam("mt", $mtpw, PDO::PARAM_STR);
				$query2->execute();
				$_SESSION['maintenanceSesh'] = true;
				echo '<div id="message">
					<div class="toast toast-success">
						&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully '.$w.' maintenance.
					</div>
					</div>
					
					<a id="success">t</a>';
				skippart:
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
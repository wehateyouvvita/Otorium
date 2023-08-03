<?php
/*die('<div id="message">
											<center>
											<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
											Buying assets has been disabled until further notice.
											</center>
										</div>
										
										<a id="success">f</a>');*/
header('Access-Control-Allow-Origin: *');
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['id'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$cash = $result->cash;
			$rank = $result->rank;
			$userID = $result->id;
			
			//check if asset exists
			$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE id = :rbxid");
			$ciae->bindParam(":rbxid", $_POST['id'], PDO::PARAM_INT);
			$ciae->execute();
			if($ciae->rowCount() > 0) {
				//exists
				$assetinfo = $ciae->fetch(PDO::FETCH_OBJ);
				if($assetinfo->approved == 2) {
					if($assetinfo->onsale == true) {
						if ($cash > $assetinfo->price || $cash == $assetinfo->price) {
							if($pdo->query("SELECT * FROM assets_owned WHERE uid = ".$userID." AND itemid = ".$assetinfo->id)->rowCount() > 0) {
								echo '<div id="message">
										<center>
										<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
										You already own this item.
										</center>
									</div>
									
									<a id="success">f</a>';
							} else {
								if($pdo->query("INSERT INTO assets_owned (uid, itemid, serial, whenbought, price_brought_at) VALUES (".$userID.", ".$assetinfo->id.", ".$assetinfo->cur_serial.", ".time().", ".$assetinfo->price.")")) {
									$pdo->query("UPDATE users SET cash = cash - ".$assetinfo->price." WHERE id=".$userID);
									$pdo->query("UPDATE asset_items SET cur_serial = cur_serial + 1 WHERE id=".$assetinfo->id);
									$check->logAction("purchased asset ".$assetinfo->id, $userID, $check->encode($check->getip()));
									echo '<div id="message">
											<center>
											<img src="https://otorium.xyz/adm/assets/id_beta/checkmark.png" width="96" /><br />
											Successfully purchased item!
											</center>
										</div>
										
										<a id="success">t</a>';
								} else {
									echo '<div id="message">
											<center>
											<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
											Error while buying item.
											</center>
										</div>
										
										<a id="success">f</a>';
								}
							}
						} else {
							echo '<div id="message">
									<center>
									<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
										You do not have enough Otobux.
									</center>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						echo '<div id="message">
								<center>
									<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
									This item is not on sale.
								</center>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
							<center>
							<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
							This item has not been approved.
							</center>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				//does not exist
				echo '<div id="message">
						<center>
						<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
						The asset ID does not exist.
						</center>
					</div>
					
					<a id="success">f</a>';
			}
			
		} else {
			echo '<div id="message">
					<center>
					<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
					You are not logged in.
					</center>
				</div>
				
				<a id="success">f</a>';
		}
		
		
		
	} else {
		echo '<div id="message">
				<center>
				<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
				You are not logged in.
				</center>
			</div>
			
			<a id="success">f</a>';
	}
		
} else {
	echo '<div id="message">
			<center>
			<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
			Unknown error occured.
			</center>
		</div>
		
		<a id="success">f</a>';
}

?>
<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
/*type 1 = accept, type 2 = decline*/
if(isset($_POST['itemID'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT id,theme FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			
			//check if asset exists
			$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE id = :rbxid");
			$ciae->bindParam(":rbxid", $_POST['itemID'], PDO::PARAM_INT);
			$ciae->execute();
			if($ciae->rowCount() > 0) {
				$assetinfo = $ciae->fetch(PDO::FETCH_OBJ);
				//1 hats
				//2 shirts
				//3 pants
				//4 heads
				//5 faces
				//6 gears
				//7 packages
				//8 t-shirts
				if($assetinfo->type == 8 || $assetinfo->type == 41 || $assetinfo->type == 42 || $assetinfo->type == 43 || $assetinfo->type == 44 || $assetinfo->type == 45 || $assetinfo->type == 46 || $assetinfo->type == 8 || $assetinfo->type == 47) {
					$type = "8 OR itemtype = 41 OR itemtype = 42 OR itemtype = 43 OR itemtype = 44 OR itemtype = 45 OR itemtype = 46 OR itemtype = 47";
				} elseif($assetinfo->type == 11) {
					$type = 11;
				} elseif($assetinfo->type == 12) {
					$type = 12;
				} elseif($assetinfo->type == 17) {
					$type = 17;
				} elseif($assetinfo->type == 18) {
					$type = 18;
				} elseif($assetinfo->type == 19) {
					$type = 19;
				} elseif($assetinfo->type == 32) {
					$type = 32;
				} elseif($assetinfo->type == 2) {
					$type = 2;
				}
				$stuff = '<div class="columns"><div class="column">';
				$itemsWearing = $pdo->query("SELECT * FROM wearing_items WHERE uid = ".$userID." AND itemtype = ".$type)->rowCount();
				if($type == "8 OR itemtype = 41 OR itemtype = 42 OR itemtype = 43 OR itemtype = 44 OR itemtype = 45 OR itemtype = 46 OR itemtype = 47") { //hats
					$maxItems = 3;
				} else {
					$maxItems = 1;
				}
				if($do->ifUserHasAsset($userID, $_POST['itemID'])) {
					if($do->ifUserWearingItem($userID, $_POST['itemID'])) {
						//unwear
						if($pdo->query("DELETE FROM wearing_items WHERE uid = ".$userID." AND itemID = ".$assetinfo->id." AND itemtype = ".$assetinfo->type)) {
							//$do->sendRenderRequest($userID);
							echo '<div id="message">
									<center>
									<img src="https://otorium.xyz/adm/assets/id_beta/checkmark.png" width="96" /><br />
									Succesfully unworn item.
									</center>
								</div>
								
								';
						} else {
							echo '<div id="message">
									<center>
									<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
									Error while unwearing item.
									</center>
								</div>
								
								';
						}
					} else {
						echo '<div id="message">
								<center>
								<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
								You are not wearing this item.
								</center>
							</div>
							
							';
					}
				} else {
					echo '<div id="message">
							<center>
							<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
							You do not own this asset.
							</center>
						</div>
						
						';
				}
			} else {
				echo '<div id="message">
						<center>
						<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
						This asset does not exist.
						</center>
					</div>
					
					';
			}
		} else {
			echo '<div id="message">
					<center>
					<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
					You are not logged in.
					</center>
				</div>
				
				';
		}
		
		
		
	} else {
		echo '<div id="message">
				<center>
				<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
				You are not logged in.
				</center>
			</div>';
	}
		
} else {
	echo '<div id="message">
			<center>
			<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
			Unknown error occured.
			</center>
		</div>
		
		';
}

?>
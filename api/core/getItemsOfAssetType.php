<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
/*type 1 = accept, type 2 = decline*/
if(isset($_POST['type'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT id,theme,rank FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			$theme = $result->theme;
			$rank = $result->rank;
			if($theme == 0) { //light
				$border_color = "rgb(200,200,200)";
			} else { //dark
				$border_color = "rgb(20,20,20)";
			}
			$columns = 0;
			$items = 0;
			$titems = 0;
			//1 hats
			//2 shirts
			//3 pants
			//4 heads
			//5 faces
			//6 gears
			//7 packages
			//8 t-shirts
			if($_POST['type'] == 1) {
				$ors = "type = 8 OR type = 41 OR type = 42 OR type = 43 OR type = 44 OR type = 45 OR type = 46 OR type = 47";
				$type = "8 OR itemtype = 41 OR itemtype = 42 OR itemtype = 43 OR itemtype = 44 OR itemtype = 45 OR itemtype = 46 OR itemtype = 47";
			} elseif($_POST['type'] == 2) {
				$ors = "type = 11";
				$type = 11;
			} elseif($_POST['type'] == 3) {
				$ors = "type = 12";
				$type = 12;
			} elseif($_POST['type'] == 4) {
				$ors = "type = 17";
				$type = 17;
			} elseif($_POST['type'] == 5) {
				$ors = "type = 18";
				$type = 18;
			} elseif($_POST['type'] == 6) {
				$ors = "type = 19";
				$type = 19;
			} elseif($_POST['type'] == 7) {
				$ors = "type = 32";
				$type = 32;
			} elseif($_POST['type'] == 8) {
				$ors = "type = 2";
				$type = 2;
			}
			$stuff = '<div class="columns"><div class="column">';
			$itemsWearing = $pdo->query("SELECT * FROM wearing_items WHERE uid = ".$userID." AND (itemtype = ".$type.")")->rowCount();
			if($type == "8 OR itemtype = 41 OR itemtype = 42 OR itemtype = 43 OR itemtype = 44 OR itemtype = 45 OR itemtype = 46 OR itemtype = 47") { //hats
				if($rank == 2) {
					$maxItems = 10;
				} else {
					$maxItems = 4;
				}
			} else {
				$maxItems = 1;
			}
			foreach ($pdo->query("SELECT * FROM assets_owned WHERE itemid in (SELECT id FROM asset_items WHERE ".$ors.") AND uid = ".$userID) as $asset) {
				$items = $items + 1;
				$titems = $titems + 1;
				$stuff = $stuff.'
					<div class="tile tile-centered" style="border-bottom:1px solid '.$border_color.'; padding:10px;">
					  <div class="tile-icon">
						<img src="https://www.roblox.com/Thumbs/Asset.ashx?Width=48&Height=48&AssetID='.$do->getAssetInfo($asset['itemid'], "robloxid").'" height="24" />
					  </div>
					  <div class="tile-content">
						<div class="tile-title">'.$do->getAssetInfo($asset['itemid'], "name").'</div>
						<div class="tile-subtitle text-gray">#'.$asset['serial'].' · '.date("j M, Y", $asset['whenbought']).'</div>
					  </div>
					  <div class="tile-action">
						<button class="btn '.(($do->ifUserWearingItem($userID, $asset['itemid']))? "btn-primary\" onclick=\"unwearItem(".$asset['itemid'].")":(($itemsWearing == $maxItems || $itemsWearing > $maxItems)? "disabled" : "\" onclick=\"wearItem(".$asset['itemid'].")")).'">
						  '.(($do->ifUserWearingItem($userID, $asset['itemid']))? "Unwear" : "Wear").'
						</button>
					  </div>
					</div>';
				if($items == 5) {
					$columns = $columns + 1;
					if($columns == 3) {
						$columns = 1;
						$stuff = $stuff.'</div></div><div class="columns"><div class="column">';
						$items = 0;
					} else {
						$stuff = $stuff.'</div><div class="column" style="border-left:1px solid '.$border_color.';height:100%;">';
					}
					$items = 0;
				}
			}
			if($titems == 0) {
				$stuff = '<p>No items found.</p>';
			}
			echo 
			'<div id="items"><br />
			'; 
			if($type == 19) {
				echo '<span style="color: red;">Notice: </span>Gears have been disabled for now.<br />';
			}
			echo 'Max items you can wear: '.$maxItems.'
				'.$stuff.'
			</div>';
		} else {
			echo '<div id="items">
					<center>
					<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
					You are not logged in.
					</center>
				</div>
				
				';
		}
		
		
		
	} else {
		echo '<div id="items">
				<center>
				<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
				You are not logged in.
				</center>
			</div>';
	}
		
} else {
	echo '<div id="items">
			<center>
			<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
			Unknown error occured.
			</center>
		</div>
		
		';
}

?>
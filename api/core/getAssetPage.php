<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$do = new functions();
/*type 1 = accept, type 2 = decline*/
if(isset($_POST['type']) && isset($_POST['page']) && isset($_POST['search'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT id,theme,rank FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$userID = $result->id;
			$theme = $result->theme;
			if($_POST['type'] == 1) {
				$type = "8 OR type = 41 OR type = 42 OR type = 43 OR type = 44 OR type = 45 OR type = 46 OR type = 47";
				$itemassettype = 1;
			} elseif($_POST['type'] == 2) {
				$itemassettype = 2;
				$type = 17;
			} elseif($_POST['type'] == 3) {
				$itemassettype = 3;
				$type = "11 OR type = 12 OR type = 2";
			} elseif($_POST['type'] == 4) {
				$itemassettype = 4;
				$type = 18;
			} elseif($_POST['type'] == 5) {
				$itemassettype = 5;
				$type = 19;
			} else { //type 6
				$itemassettype = 6;
				$type = 32;
			}
			if($_POST['search'] == "") {
				$gai = $pdo->prepare("SELECT * FROM asset_items WHERE (type = ".$type.") AND approved = 2");
				$gai->execute();
				$PagesAmount = $gai->rowCount();
			} else {
				$gai = $pdo->prepare("SELECT * FROM asset_items WHERE (type = ".$type.") AND name LIKE :search AND approved = 2");
				$searchkeyword = "%".$_POST['search']."%";
				$gai->bindParam(":search", $searchkeyword, PDO::PARAM_STR);
				$gai->execute();
				$PagesAmount = $gai->rowCount();
			}
			
			if($PagesAmount > 20) {
				$pages = round(($PagesAmount+10)/20);
				if(!(isset($_POST['page']))) {
					$page = 1;
					$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
				} else {
					if(is_numeric($_POST['page'])) {
						$page = $_POST['page'];
						$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
					} else {
						$page = 1;
						$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
					}
				}
			} else {
				$pages = 1;
				$page = 1;
				$limit = "LIMIT 20";
			}
			if($theme == 0) { //light
				$border_color = "rgb(200,200,200)";
				$txt_color = "#50596c";
				$bg_color_1 = "white";
			} else { //dark
				$border_color = "rgb(20,20,20)";
				$txt_color = "white";
				$bg_color_1 = "rgb(50,50,50)";
			}
			echo '<div id="items">';
			if($_POST['search'] == "") {
				$gai = $pdo->prepare("SELECT * FROM asset_items WHERE (type = ".$type.") AND approved = 2 ORDER BY `added_on` DESC ".$limit);
				$gai->execute();
				if($gai->rowCount() > 0) {
					$assets = $gai->fetchAll(PDO::FETCH_ASSOC);
					foreach ($assets as $item) {
						if($do->ifUserHasAsset($userID, $item['id'])) {
							$border = "#7CFC00";
							$txt = "<span style='color: #32CD32;'><i class='fa fa-check'></i> Item Owned</span>";
						} else {
							$border = $border_color;
							$txt = "<span style='color: #FA8072;'><i class='fa fa-times'></i> Item Not Owned</span>";
						}
						$onclick = $item['robloxid'];
						$thumbnail = 'https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID='.$item['robloxid'];
						if($item['custom_asset'] == 1) {
							$onclick = $item['id'].", 0";
							$thumbnail = $do->getCustomAssetInfo($item['id'], "thumbnailurl");
						}
						echo '
						<div class="column col-3 col-md-4 col-sm-6 col-xs-12">
							<div class="popover popover-top">
							  <img onclick="getAssetInfo('.$onclick.')" src="'.$thumbnail.'" style="border:1px solid '.$border.'; cursor: pointer;" class="item img-responsive img-fit-contain" />
							  <div class="popover-container">
								<div class="card" style="background-color: '.$bg_color_1.';">
								  <div class="card-header" style="color: '.$txt_color.';">
									'.$item['name'].'
								  </div>
								  <div class="card-body">
									<span style="color: green;"><i class="fa fa-money"></i> '.$item['price'].'</span>
								  </div>
								  <div class="card-footer">
									'.$txt.'
								  </div>
								</div>
							  </div>
							</div>
						</div>
						';
					}
				} else {
					echo 'No items found.';
				}
			} else {
				$gai = $pdo->prepare("SELECT * FROM asset_items WHERE (type = ".$type.") AND approved = 2 AND name LIKE :search ORDER BY `added_on` DESC ".$limit);
				$gai->bindParam(":search", $searchkeyword, PDO::PARAM_STR);
				$gai->execute();
				if($gai->rowCount() > 0) {
					$assets = $gai->fetchAll(PDO::FETCH_ASSOC);
					foreach ($assets as $item) {
						if($do->ifUserHasAsset($userID, $item['id'])) {
							$border = "#7CFC00";
							$txt = "<span style='color: #32CD32;'><i class='fa fa-check'></i> Item Owned</span>";
						} else {
							$border = $border_color;
							$txt = "<span style='color: #FA8072;'><i class='fa fa-cross'></i> Item Not Owned</span>";
						}
						$onclick = $item['robloxid'];
						$thumbnail = 'https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID='.$item['robloxid'];
						if($item['custom_asset'] == 1) {
							$onclick = $item['id'].", 0";
							$thumbnail = $do->getCustomAssetInfo($item['id'], "thumbnailurl");
						}
						echo '
						<div class="column col-3 col-md-4 col-sm-6 col-xs-12">
							<div class="popover popover-top">
							  <img onclick="getAssetInfo('.$onclick.')" src="'.$thumbnail.'" style="border:1px solid '.$border.'; cursor: pointer;" class="item img-responsive img-fit-contain" />
							  <div class="popover-container">
								<div class="card" style="background-color: '.$bg_color_1.';">
								  <div class="card-header" style="color: '.$txt_color.'; background-color: '.$bg_color_1.';">
									'.$item['name'].'
								  </div>
								  <div class="card-body">
									<span style="color: green;"><i class="fa fa-times"></i> '.$item['price'].'</span>
								  </div>
								  <div class="card-footer">
									'.$txt.'
								  </div>
								</div>
							  </div>
							</div>
						</div>
						';
					}
				} else {
					echo 'No items found.';
				}
			}
			echo '</div>';
			echo '<div id="page"><div>';
			if($pages > 1) {
				if($page == 1) {
					echo '<button class="btn btn-primary disabled" style="float:left; display: inline-block;"><</button>';
				} else {
					echo '<button class="btn btn-primary" onclick="openvapage('.$itemassettype.', '.($page-1).')" style="float:left; display: inline-block;"><</button>';
				}
				if($page == $pages) {
					echo '<button class="btn btn-primary disabled" style="float:right; display: inline-block;">></button>';
				} else {
					echo '<button class="btn btn-primary" onclick="openvapage('.$itemassettype.', '.($page+1).')" style="float:right; display: inline-block;">></button>';
				}
			}
			echo '</div><center><span style="line-height: 36px; display: inline-block;">Page '.$page.' of '.$pages.'</span></center></div>';
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
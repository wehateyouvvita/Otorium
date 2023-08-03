<?php
header('Access-Control-Allow-Origin: *');
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_GET['rbxid']) && isset($_GET['asset'])) {

	if($_GET['asset'] == 1) {
		//check if asset exists
		$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE robloxid = :rbxid");
		$ciae->bindParam(":rbxid", $_GET['rbxid'], PDO::PARAM_INT);
		$ciae->execute();
		if($ciae->rowCount() > 0) {
			$assetinfo = $ciae->fetch(PDO::FETCH_OBJ);
			$thumbnail = "";
			if($assetinfo->custom_asset == 1) {
				$thumbnail = $check->getCustomAssetInfo($assetinfo->id, "thumbnailurl");
			}
			echo json_encode(
					array(
						'Id' => $assetinfo->id,
						'Name' => $assetinfo->name,
						'Description' => $assetinfo->description,
						'Approved' => $assetinfo->approved,
						'OnSale' => $assetinfo->onsale,
						'Price' => $assetinfo->price,
						'Type' => $check->getAssetType($assetinfo->type),
						'Thumbnail' => $thumbnail
						)
				);
		} else {
			echo '<div id="message">
				<div class="toast toast-error">
					&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Asset does not exist.
				</div>
				</div>
				
				<a id="success">f</a>';
		}
	} else { //usually means custom asset
		//check if asset exists
		$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE id = :rbxid");
		$ciae->bindParam(":rbxid", $_GET['rbxid'], PDO::PARAM_INT);
		$ciae->execute();
		if($ciae->rowCount() > 0) {
			$assetinfo = $ciae->fetch(PDO::FETCH_OBJ);
			$thumbnail = "";
			if($assetinfo->custom_asset == 1) {
				$thumbnail = $check->getCustomAssetInfo($assetinfo->id, "thumbnailurl");
			}
			echo json_encode(
					array(
						'Id' => $assetinfo->id,
						'Name' => $assetinfo->name,
						'Description' => $assetinfo->description,
						'Approved' => $assetinfo->approved,
						'OnSale' => $assetinfo->onsale,
						'Price' => $assetinfo->price,
						'Type' => $check->getAssetType($assetinfo->type),
						'Thumbnail' => $thumbnail
						)
				);
		} else {
			echo '<div id="message">
				<div class="toast toast-error">
					&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Asset does not exist.
				</div>
				</div>
				
				<a id="success">f</a>';
		}
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
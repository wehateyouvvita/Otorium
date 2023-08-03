<?php
header('Access-Control-Allow-Origin: *');
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
if(isset($_POST['rbxid'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$rank = $result->rank;
			$userID = $result->id;
			
			//check if asset exists
			$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE robloxid = :rbxid");
			$ciae->bindParam(":rbxid", $_POST['rbxid'], PDO::PARAM_INT);
			$ciae->execute();
			if($ciae->rowCount() > 0) {
				//exists
				echo '<div id="message">
					<div class="toast toast-success">
						&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Asset already exists.
					</div>
					</div>
					
					<a id="success">e</a>';
			} else {
				/*die( '<div id="message">
					<div class="toast toast-error">
						&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Adding new assets have been closed for now.
					</div>
					</div>
					
					<a id="success">f</a>' );*/
				//does not exist, create 
				if($_POST['rbxid'] > 300000000) {
					die( '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The asset ID added is too new.
						</div>
						</div>
						
						<a id="success">f</a>');
				}
				//$url = "https://cors-anywhere.herokuapp.com/https://api.roblox.com/marketplace/productinfo/?assetID=".$_POST['rbxid'];
				$url = "https://api.roblox.com/marketplace/productinfo/?assetID=".$_POST['rbxid'];
				/* $opts = array(
				  'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-language: en\r\n" .
							  "Cookie: foo=bar\r\n" .
							  "Access-Control-Allow-Origin: *\r\n"
				  )
				);
				$context = stream_context_create($opts);
				//call api
				$json = file_get_contents($url, false, $context); */
				
				
				$curl_handle=curl_init();
				curl_setopt($curl_handle, CURLOPT_URL,$url);
				curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
				//curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Your application name');
				$json = curl_exec($curl_handle);
				curl_close($curl_handle);
				
				$json = json_decode($json);
				if(!($check->getAssetType($json->AssetTypeId) == "?")) {
					$cnai = $pdo->prepare("INSERT INTO asset_items(name, description, added_on, lastupdated, who_add, who_approve, price, onsale, limited, robloxid, type, approved)
										VALUES(:nm, :dsc, ".time().", 0, ".$userID.", 0, :prc, 1, :lim, :rbxid, :typ, 1)");
					$cnai->bindParam(":nm", $json->Name, PDO::PARAM_STR);
					$cnai->bindParam(":dsc", $json->Description, PDO::PARAM_STR);
					$cnai->bindParam(":prc", $json->PriceInRobux, PDO::PARAM_INT);
					$lim = 0;
					if($json->IsLimited == true || $json->IsLimitedUnique == true) {
						$lim = 1;
					}
					$cnai->bindParam(":lim", $lim, PDO::PARAM_INT);
					$cnai->bindParam(":rbxid", $_POST['rbxid'], PDO::PARAM_INT);
					$cnai->bindParam(":typ", $json->AssetTypeId, PDO::PARAM_STR);
					if($cnai->execute()) {
						echo '<div id="message">
							<div class="toast toast-success">
								&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully added new asset for approval!
							</div>
							</div>
							
							<a id="success">t</a>';
					} else {
						echo '<div id="message">
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while inserting new asset.
							</div>
							</div>
							
							<a id="success">f</a>';
					}
				} else {
					echo '<div id="message">
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Invalid asset type.
						</div>
						</div>
						
						<a id="success">f</a>';
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
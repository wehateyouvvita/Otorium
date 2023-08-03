<?php
if(isset($_GET['id']) && is_numeric($_GET['id'])) {
	//get character appearence
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
	if(!(isset($pdo))) {
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
	}
	$do = new functions();
	echo 'http://api.otorium.xyz/render/getBodyColours.php?id='.$_GET['id'].';';
	$a = $pdo->prepare("SELECT * FROM wearing_items WHERE uid = :uid");
	$a->bindParam(":uid", $_GET['id'], PDO::PARAM_INT);
	$a->execute();
	if($a->rowCount() > 0) {
		$stuff = $a->fetchAll(PDO::FETCH_ASSOC);
		foreach ($stuff as $item) {
		    if(!(isset($_GET['type'])) || !($_GET['type'] == 2008)) {//2010
    			if(!($item['itemtype'] == 32) && !($item['itemtype'] == 19)) {
					if($do->isCustomAsset($item['itemID']) == true) {
						echo 'http://api.otorium.xyz/render/getAsset.php?id='.$item['itemID'].';';
					} else {
						echo 'http://roblox.com/asset/?id='.$do->getAssetInfo($item['itemID'], "robloxid").'&version='.$do->getAssetInfo($item['itemID'], "asset_version").';';
					}
    			} elseif($item['itemtype'] == 19) {//gear
    				if($item['uid'] == 1 || $item['uid'] == 4) {
    					echo 'http://roblox.com/asset/?id='.$do->getAssetInfo($item['itemID'], "robloxid").'&version='.$do->getAssetInfo($item['itemID'], "asset_version").';';
    				}
    			} elseif($item['itemtype'] == 32) {//packages
    				foreach (explode(";", $do->getAssetInfo($item['itemID'], "pkgids")) as $item2) {
    					if (strpos($item2, '&version=') !== false) {
    						echo 'http://roblox.com/asset/?id='.$item2.';AAAAAAAAAAAAAAAAA';
    					} else {
    						echo 'http://roblox.com/asset/?id='.$item2.'&version='.$do->getAssetInfo($item['itemID'], "pkg_version").';';
    					}
    				}
    				/*
    				$pkg_version = $do->getAssetInfo($item['itemID'], "asset_version");
    				$url = 'http://cors-anywhere.herokuapp.com/http://assetgame.roblox.com/asset/?id='.$do->getAssetInfo($item['itemID'], "robloxid").'&version='.$pkg_version;
    				echo $url;
    				$curl_handle=curl_init();
    				curl_setopt($curl_handle, CURLOPT_URL,$url);
    				curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
    				curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
    				curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(
    					'Accept: *//*',
    					'Connection: keep-alive',
    					'Origin: null',
    					/*'Accept-Encoding: gzip, deflate, br',
    					'Host: assetgame.roblox.com',
    					'Accept-Language: en-US,en;q=0.9',
    				));
    				curl_setopt($curl_handle, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.132 Safari/537.36');
    				$packageitems = curl_exec($curl_handle);
    				curl_close($curl_handle);
    				$stuff2 = preg_split(";", $packageitems);
    				echo $packageitems;
    				foreach ($stuff2 as $item2) {
    					echo 'http://roblox.com/asset/?id='.$item.'&version='.$pkg_version.';';
    				}
    				*/
    			}
		    } else {
		        if($item['itemtype'] == 2 || $item['itemtype'] == 8 || $item['itemtype'] == 11 || $item['itemtype'] == 17 || $item['itemtype'] == 18) {
		            echo 'http://roblox.com/asset/?id='.$do->getAssetInfo($item['itemID'], "robloxid").'&version='.$do->getAssetInfo($item['itemID'], "asset_version").';';
		        }
		    }
		}
	}
	/*
	$checkForCharApp = $pdo->prepare("SELECT * FROM custom_char_app WHERE uid = :uid");
	$checkForCharApp->bindParam(":uid", $_GET['id'], PDO::PARAM_INT);
	$checkForCharApp->execute();
	if($checkForCharApp->rowCount() > 0) {
		$CharAppInfo = $checkForCharApp->fetch(PDO::FETCH_OBJ);
		die($CharAppInfo->url);
	} else {
		die(" ");
	}
	*/
} else {
	echo 'http://api.otorium.xyz/render/getBodyColours.php;';
}
?>
<?php header('Access-Control-Allow-Origin: *'); $asset_id_page = "yas"; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; header("Location: ../../../customization"); ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if(!($userID == 1)) {
			$errCode = '404';
			include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
			goto FooterPart;
		}
	?>
	<title>Character Appearence | Otorium</title>
</head>
<body>

<div class="sides">
<?php if(isset($changeCharAppError)) { echo $changeCharAppError; } ?>
<?php if(isset($sendCharAppReqs)) { echo $sendCharAppReqs; } ?>
<script>
	var pg1loaded = true; //hats
	var pg2loaded = false; //shirts
	var pg3loaded = false; //pants
	var pg4loaded = false; //heads
	var pg5loaded = false; //faces
	var pg6loaded = false; //gears
	var pg7loaded = false; //packages
	var pg8loaded = false; //t-shirts
	var curpage = 1;
	function getAssetInfo(id) {
		$("#loadingstuff").show();
		$("#NewItemImage").attr("src","");
		$("#itemImage").attr("src","");
		$("#getassetinfodiv").hide();
		$("#getasseterror").html("");
		$.getJSON('https://cors-anywhere.herokuapp.com/https://api.roblox.com/marketplace/productinfo/?assetID=' + id, function( data ) {
			if(data.hasOwnProperty('code')) {
				$("#getasseterror").html("Item does not exist. Please try again");
				$("#loadingstuff").hide();
				$("#getassetinfodiv").show();
			} else {
				$.getJSON('https://otorium.xyz/api/core/getAssetType.php?type=' + data.AssetTypeId, function (data2) { //check if valid asset type
					if(!(data2.Type == "?")) {
						$.post('https://otorium.xyz/api/core/createNewAsset.php', {rbxid: id}, function (data3) { //check if valid asset type
							var success = $(data3).filter("#success").html();
							if(success == "t") {
								$("#NewItemName").html(data.Name);
								$("#NewItemImage").attr("src","https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + data.AssetId);
								$("#NewItemDescription").html(data.Description);
								if(data.PriceInRobux == null) {
									$("#NewItemPrice").html("<i>Deciding</i>");
								} else {
									$("#NewItemPrice").html(data.PriceInRobux);
								}
								$("#NewItemType").html(data2.Type);
								openmodal("newitempanel");
								$("#loadingstuff").hide();
								$("#getassetinfodiv").show();
							} else if(success == "f") {
								$("#getasseterror").html($(data3).filter("#message").html());
								$("#loadingstuff").hide();
								$("#getassetinfodiv").show();
							} else if(success == "e") {
								//get item info
								$.getJSON('https://otorium.xyz/api/core/getAssetInfo.php?rbxid=' + id, function (data4) {
									$("#itemName").html(data4.Name);
									$("#itemImage").attr("src","https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + id);
									$("#itemDescription").html(data4.Description);
									$("#itemType").html(data4.Type);
									if(data4.Approved == "2") {
										$("#purchaseItemGroup").show();
										$("#itemPrice").html(data4.Price);
										$("#purchaseitembtn").attr("onclick","buyAsset(" + data4.Id + ")");
									} else if (data4.Approved == "3") {
										$("#itemNotApprovedGroup").show();
										$("#itemPrice").html("0");
									} else {
										$("#itemPendingApproval").show();
										$("#itemPrice").html("<i>Deciding</i>");
									}
									openmodal("itempanel");
									$("#loadingstuff").hide();
									$("#getassetinfodiv").show();
								});
							} else {
								$("#getasseterror").html("Something's not right.. success: " + success);
								$("#loadingstuff").hide();
								$("#getassetinfodiv").show();
							}
						});
					} else {
						$("#getasseterror").html("Invalid asset type. Please try again");
						$("#loadingstuff").hide();
						$("#getassetinfodiv").show();
					}
				});
			}
		});
		
	}
	function buyAsset(id) {
		$("#itempanel").hide(500);
		$("#purchasingitem").show(500);
		$.post('https://otorium.xyz/api/core/buyAsset.php',{id:id},
		function(data)
		{
			var message = $(data).filter("#message").html();
			var success = $(data).filter("#success").html();
			$("#purchasingitem").html(message);
			setTimeout(function(){
				if (success == "t") {
					closeItemPanel('itempanel');
					$("#itempanel").show(500);
					$("#purchasingitem").hide(500);
				} else {
					$("#itempanel").show(500);
					$("#purchasingitem").hide(500);
				}
				setTimeout(function(){
					$("#purchasingitem").html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Purchasing...</center>");
				}, 1000);
			}, 1000);
		});
	}
	
	function closeItemPanel(id) {
		closemodal(id);
		setTimeout(function(){
			$("#purchaseItemGroup").hide();
			$("#itemNotApprovedGroup").hide();
			$("#itemPendingApproval").hide();
			$("#itemTooExpensive").hide();
		}, 1000);
	}
	
	function removeAndHideActiveAll() {
		$('#gtas').removeClass('active');
		$('#wras').removeClass('active'); 
		$('#byas').removeClass('active');
		$('#getNewAssets').hide();
		$('#wearItemsdiv').hide();
		$('#buyItemsdiv').hide();
	}
	
	function removeAndHideActiveAll2() {
		$('#pg1tab').removeClass('active');
		$('#pg2tab').removeClass('active');
		$('#pg3tab').removeClass('active');
		$('#pg4tab').removeClass('active');
		$('#pg5tab').removeClass('active');
		$('#pg6tab').removeClass('active');
		$('#pg7tab').removeClass('active');
		$('#pg8tab').removeClass('active');
		$('#pg1body').hide();
		$('#pg2body').hide();
		$('#pg3body').hide();
		$('#pg4body').hide();
		$('#pg5body').hide();
		$('#pg6body').hide();
		$('#pg7body').hide();
		$('#pg8body').hide();
	}
	
	function openNewPage(id) {
		curpage = id;
		removeAndHideActiveAll2();
		$('#pg' + id + 'tab').addClass('active');
		$('#pg' + id + 'body').show();
		if(window['pg'+id+'loaded'] == false) {
			$('#pg' + id + 'body').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Loading items...</center>");
			$.post("https://otorium.xyz/api/core/getItemsOfAssetType.php", {type:id}, function(data) {
				$('#pg' + id + 'body').html($(data).filter("#items").html());
				window['pg'+id+'loaded'] = true;
			});
		}
	}
	function resetPages() {
		$('#pg1body').html("");
		$('#pg2body').html("");
		$('#pg3body').html("");
		$('#pg4body').html("");
		$('#pg5body').html("");
		$('#pg6body').html("");
		$('#pg7body').html("");
		$('#pg8body').html("");
		pg1loaded = false; 
		pg2loaded = false;
		pg3loaded = false;
		pg4loaded = false;
		pg5loaded = false;
		pg6loaded = false;
		pg7loaded = false;
		pg8loaded = false;
		openNewPage(curpage);
	}
	function wearItem(id) {
		$('#wear').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Wearing item...</center>");
		openmodal("wear");
		$.post("https://otorium.xyz/api/core/wearItem.php", {itemID:id}, function(data) {
			$('#wear').html($(data).filter("#message").html());
			setTimeout(function(){
				closemodal("wear");
				window['pg'+curpage+'loaded'] = false;
				openNewPage(curpage);
			}, 1000);
		});
	}
	function unwearItem(id) {
		$('#wear').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Unwearing item...</center>");
		openmodal("wear");
		$.post("https://otorium.xyz/api/core/unwearItem.php", {itemID:id}, function(data) {
			$('#wear').html($(data).filter("#message").html());
			setTimeout(function(){
				closemodal("wear");
				window['pg'+curpage+'loaded'] = false;
				openNewPage(curpage);
			}, 1000);
		});
	}
	function renderCharacter() {
		$('#rdrchrbtn').addClass("disabled");
		$('#rdrchrbtn').html("Sending render request..");
		$.post("https://otorium.xyz/api/core/sendRenderReqs.php", {}, function(data) {
			setTimeout(function(){
				$('#rdrchrbtn').removeClass("disabled");
				$('#rdrchrbtn').html("Render Character");
				$("#avatarimg").attr("src","https://render.otorium.xyz/<?php echo $userID; ?>.png?tick=" + Math.round((new Date()).getTime() / 1000));
			}, 10000);
		});
	}
</script>
<ul class="tab tab-block">
	<li onclick="removeAndHideActiveAll(); $('#gtas').addClass('active'); $('#getNewAssets').show();" id="gtas" class="tab-item active">
		<a href="#">Get Assets</a>
	</li>
	<li onclick="removeAndHideActiveAll(); $('#wras').addClass('active'); $('#wearItemsdiv').show();" id="wras" class="tab-item">
		<a href="#">Wear</a>
	</li>
	<li onclick="removeAndHideActiveAll(); $('#byas').addClass('active'); $('#buyItemsdiv').show();" id="byas" class="tab-item">
		<a href="#">Buy</a>
	</li>
</ul>
<div id="getNewAssets">
	<Br />
	<div id="getassetinfodiv">
	<span style="color: red;" id="getasseterror"></span>
	<input class="form-input" type="number" id="txtassetid" placeholder="1048037" />
	<br />
	<a class="btn btn-primary" onclick="getAssetInfo($('#txtassetid').val());">Submit</a>
	<br />
	Assets available: <?php echo $pdo->query("SELECT * FROM asset_items WHERE approved = 2")->rowCount(); ?>
	<br />
	Assets pending: <?php echo $pdo->query("SELECT * FROM asset_items WHERE approved = 1")->rowCount(); ?>
	<br />
	Assets denied: <?php echo $pdo->query("SELECT * FROM asset_items WHERE approved = 3")->rowCount(); ?>
	</div>
	<div id="loadingstuff" style="display:none;">
	<center>
	<img src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" width="96" /><br />
	Loading...
	</center>
	</div>
</div>
<div id="wearItemsdiv" style="display:none;">
	<div class="panel">
		<div class="panel-header">
			<div style="display: inline-block;">
				<figure class="avatar" style="height: 7.5em; width: 7.5em;">
					<img id="avatarimg" src="https://render.otorium.xyz/<?php echo $userID; ?>.png?tick=<?php echo time(); ?>" alt="Avatar">
				</figure>
			</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
			<div style="display: inline-block;">
				<div class="panel-title h5 mt-10"><?php echo $user; ?></div>
				<div class="panel-subtitle">Last updated <?php echo date("M j, Y", $pdo->query("SELECT * FROM wearing_items ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_OBJ)->when_worn); ?></div>
			</div>
			<i class="fa fa-refresh float-right" onclick="resetPages()" style="font-size: 3em; cursor: pointer;"></i>
		</div>
		<nav class="panel-nav"> 
			<ul class="tab tab-block">
				<li id="pg1tab" onclick="openNewPage(1);" class="tab-item active">
					<a>
						Hats
					</a>
				</li>
				<li id="pg2tab" onclick="openNewPage(2);" class="tab-item">
					<a>
						Shirts
					</a>
				</li>
				<li id="pg3tab" onclick="openNewPage(3);" class="tab-item">
					<a>
						Pants
					</a>
				</li>
				<li id="pg4tab" onclick="openNewPage(4);" class="tab-item">
					<a>
						Heads
					</a>
				</li>
				<li id="pg5tab" onclick="openNewPage(5);" class="tab-item">
					<a>
						Faces
					</a>
				</li>
				<li id="pg6tab" onclick="openNewPage(6);" class="tab-item">
					<a>
						Gears
					</a>
				</li>
				<li id="pg7tab" onclick="openNewPage(7);" class="tab-item">
					<a>
						Packages
					</a>
				</li>
				<li id="pg8tab" onclick="openNewPage(8);" class="tab-item">
					<a>
						T-Shirts
					</a>
				</li>
			</ul>
		</nav>
	  <div id="pg1body" class="panel-body">
		<div class="columns">
		<div class="column">
	<?php
	$columns = 0;
	$items = 0;
	foreach ($pdo->query("SELECT * FROM assets_owned WHERE itemid in (SELECT id FROM asset_items WHERE type = 8 OR type = 41 OR type = 42 OR type = 43 OR type = 44 OR type = 45 OR type = 46 OR type = 47) AND uid = ".$userID) as $asset) {
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
	echo $stuff;
	?>
		</div>
		</div>
	  </div>
	  <div id="pg2body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg3body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg4body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg5body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg6body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg7body" class="panel-body" style="display: none;">
	  </div>
	  <div id="pg8body" class="panel-body" style="display: none;">
	  </div>
		<div class="panel-footer">
		<button class="btn btn-primary btn-block" id="rdrchrbtn" onclick="renderCharacter()">Render Character</button>
		</div>
	</div>
	
</div>
<div id="buyItemsdiv" style="display:none;">
	Buy Items<br />
	All available assets:
	<?php
	foreach ($pdo->query("SELECT * FROM asset_items WHERE approved = 2") as $asset) {
		echo $asset['name'].', Roblox ID '.$asset['robloxid'].', created on '.date("M d Y, g:i:s A", $asset['added_on']).' with current serial #'.$asset['cur_serial'].' and type '.$do->getAssetType($asset['type']).' by '.$do->getUsername($asset['who_add']).'. <a href="#" onclick="$(\'#txtassetid\').val(\''.$asset['robloxid'].'\'); getAssetInfo($(\'#txtassetid\').val()); removeAndHideActiveAll(); $(\'#gtas\').addClass(\'active\'); $(\'#getNewAssets\').show();">Buy</a><br />';
	}
	?>
</div>
<div id="newitempanelFade" onclick="closemodal('newitempanel')" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

  <div id="newitempanel" class="anim" style="background-color:<?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; margin: 7.5% auto; padding: 25px; border: 1px solid <?php echo $border_color; ?>;">
	<big id="NewItemName"></big>
	<div class="columns">
		<div class="column">
			<center><img src="" class="img-fit-contain img-responsive" id="NewItemImage" /></center>
		</div>
		<div class="column">
			<b>Description:</b>
			<p id="NewItemDescription"></p>
		</div>
	</div>
	<div class="columns">
		<div class="column">
			<span style="color: green;">Price:</span><br />
			<span id="NewItemPrice"></span>
		</div>
		<div class="column">
			<span>Type:</span><br />
			<span id="NewItemType"></span>
		</div>
	</div>
	<br />
	<h4>This item will have to be approved before you can buy/wear it.</h4>
	<p>An approval request has been sent. You will get a notification if this asset has been approved or declined. Press anywhere to close panel.</p>
  </div>

</div>
<div id="itempanelFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

  <div id="itempanel" class="anim" style="background-color:<?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; margin: 7.5% auto; padding: 25px; border: 1px solid <?php echo $border_color; ?>;">
	<big id="itemName"></big>
	<div class="columns">
		<div class="column">
			<center><img src="" class="img-fit-contain img-responsive" id="itemImage" /></center>
		</div>
		<div class="column">
			<b>Description:</b>
			<p id="itemDescription"></p>
		</div>
	</div>
	<div class="columns">
		<div class="column">
			<span style="color: green;">Price:</span><br />
			<span id="itemPrice"></span>
		</div>
		<div class="column">
			<span>Type:</span><br />
			<span id="itemType"></span>
		</div>
	</div>
	<br />
	<div id="purchaseItemGroup" style="display:none;">
		<p>Would you like to purchase this item?</p>
		<a onclick="closeItemPanel('itempanel')" class="btn">Cancel</a>
		<a onclick="closemodal('itempanel')" id="purchaseitembtn" class="btn btn-purchase float-right">Purchase</a>
	</div>
	<div id="itemNotApprovedGroup" style="display:none;">
		<p>This item has not been approved to be used on Otorium.</p>
		<a onclick="closeItemPanel('itempanel')" class="btn btn-purchase float-right">Close</a>
		<br />
	</div>
	<div id="itemPendingApproval" style="display:none;">
		<h4>This item will have to be approved before you can buy/wear it.</h4>
		<p>You will get a notification if this asset has been approved or declined.</p>
		<a onclick="closeItemPanel('itempanel')" class="btn btn-purchase float-right">Close</a>
		<br />
	</div>
	<div id="itemTooExpensive" style="display:none;">
		<p>You do not have enough otobux to complete this transaction.</p>
		<a onclick="closeItemPanel('itempanel')" class="btn btn-purchase float-right">Close</a>
		<br />
	</div>
  </div>
  <div id="purchasingitem" style="background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; display: none; border: 1px solid <?php echo $border_color; ?>; position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
	<center>
		<img src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" width="96" /><br />
		Purchasing...
	</center>
  </div>

</div>

<div id="wearFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

  <div id="wear" class="anim" style="background-color:<?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; margin: 7.5% auto; padding: 25px; border: 1px solid <?php echo $border_color; ?>;">
	
  </div>

</div>

<div id="charappstuff" style="display: none;">
<h3>Character appearence</h3>
<textarea class="form-input disabled" type="text" name="charapptxt" maxlength="1024" rows="6" readonly="true"><?php echo $pdo->query("SELECT * FROM custom_char_app WHERE uid = ".$userID)->fetch(PDO::FETCH_OBJ)->url; ?></textarea>
<form method="post">
<button name="sendRenderRequest" style="float:left;" type="submit" class="btn btn-primary">Send render request (dont use this button unless I say so)</button>
</form>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
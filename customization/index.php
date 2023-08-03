<?php header('Access-Control-Allow-Origin: *'); $asset_id_page = "yas"; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin == false) { header("Location: ../login"); }?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Customization | Otorium</title>
</head>
<body>

<div class="sides">
<?php if(1 == 1) { ?>
<?php if(isset($changeCharAppError)) { echo $changeCharAppError; } ?>
<?php if(isset($sendCharAppReqs)) { echo $sendCharAppReqs; } ?>
<script>
	var pg1loaded = false; //hats
	var pg2loaded = false; //shirts
	var pg3loaded = false; //pants
	var pg4loaded = false; //heads
	var pg5loaded = false; //faces
	var pg6loaded = false; //gears
	var pg7loaded = false; //packages
	var pg8loaded = false; //t-shirts
	var viewassettype = 1; //asset type for buy item page
	var curwearpage = 1;
	var curviewassetpage = 1;
	var curviewassetpage2 = 1;
	var curStuff = 1;
	var curBodyPart = 0; //0=head,1=leftarm,2=rightarm,3=torso,4=leftleg,5=rightleg
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
		$('#getNewAssets').hide();
		$('#wearItemsdiv').hide();
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
		curwearpage = id;
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
	
	function openvapage(id, page = 1) {
		curviewassetpage = id;
		var search = $("#keywordSearchBarinpt").val();
		$("#keywordSearchBarinpt").addClass("disabled");
		$("#submitBtn").addClass("disabled");
		resetVAPages();
		var curviewassetpage2 = page;
		$('#vanavitem' + id).addClass('active');
		$('#itemcolumns').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Loading items...</center>");
		$.post("https://otorium.xyz/api/core/getAssetPage.php", {type:id, page:page, search:search}, function(data) {
			$('#itemcolumns').html($(data).filter("#items").html());
			$("#keywordSearchBarinpt").removeClass("disabled");
			$("#submitBtn").removeClass("disabled");
		});
	}
	function resetVAPages() {
		$('#vanavitem1').removeClass('active');
		$('#vanavitem2').removeClass('active');
		$('#vanavitem3').removeClass('active');
		$('#vanavitem4').removeClass('active');
		$('#vanavitem5').removeClass('active');
		$('#vanavitem6').removeClass('active');
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
		openNewPage(curwearpage);
	}
	function wearItem(id) {
		$('#wear').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Wearing item...</center>");
		openmodal("wear");
		$.post("https://otorium.xyz/api/core/wearItem.php", {itemID:id}, function(data) {
			renderCharacter(1000);
			$('#wear').html($(data).filter("#message").html());
			setTimeout(function(){
				closemodal("wear");
				window['pg'+curwearpage+'loaded'] = false;
				openNewPage(curwearpage);
			}, 1000);
		});
	}
	function unwearItem(id) {
		$('#wear').html("<center><img src=\"https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif\" width=\"96\" /><br />Unwearing item...</center>");
		openmodal("wear");
		$.post("https://otorium.xyz/api/core/unwearItem.php", {itemID:id}, function(data) {
			renderCharacter(1000);
			$('#wear').html($(data).filter("#message").html());
			setTimeout(function(){
				closemodal("wear");
				window['pg'+curwearpage+'loaded'] = false;
				openNewPage(curwearpage);
			}, 1000);
		});
	}
	function renderCharacter(wait = 0) {
		$('#renderingavatarbar').show();
		$('#rdrchrbtn').addClass("disabled");
		$('#rdrchrbtn').html("Sending render request..");
		setTimeout(function(){
			$.post("https://otorium.xyz/api/core/sendRenderReqs.php?type=" + curStuff, {}, function(data) {
				setTimeout(function(){
					$('#rdrchrbtn').removeClass("disabled");
					$('#rdrchrbtn').html("Render Character");
					$("#avatarimg").attr("src","<?php echo $userImages.$userID; ?>.png?tick=" + Math.round((new Date()).getTime() / 1000));
					setTimeout(function(){
						$("#avatarimg").attr("src","<?php echo $userImages.$userID; ?>.png?tick=" + Math.round((new Date()).getTime() / 1000));
						setTimeout(function(){
							$("#avatarimg").attr("src","<?php echo $userImages.$userID; ?>.png?tick=" + Math.round((new Date()).getTime() / 1000));
							setTimeout(function(){
								$("#avatarimg").attr("src","<?php echo $userImages.$userID; ?>.png?tick=" + Math.round((new Date()).getTime() / 1000));
								$('#renderingavatarbar').hide();
							}, 3500);
						}, 3500);
					}, 3500);
				}, 3500);
			});
		}, wait);
	}
	function switch2008Style() {
		$("#changeavatarstyletxt").html("");
		if(curStuff == 1) { //Switch to 2008
			$('#pg4tab').hide();
			$('#pg4body').hide();
			$('#pg5tab').hide();
			$('#pg5body').hide();
			$('#pg6tab').hide();
			$('#pg6body').hide();
			$('#pg7tab').hide();
			$('#pg7body').hide();
			curStuff = 0;
		} else {
			$('#pg4tab').show();
			$('#pg4body').show();
			$('#pg5tab').show();
			$('#pg5body').show();
			$('#pg6tab').show();
			$('#pg6body').show();
			$('#pg7tab').show();
			$('#pg7body').show();
			curStuff = 1;
		}
	}
	function mouseOverAvatar() {
		if(curStuff == 1) {
			$("#changeavatarstyletxt").html("Change to 2008");
		} else {
			$("#changeavatarstyletxt").html("Change to 2010");
		}
	}
	function chgBodyPart(part) {
		if(part == 0) {
			curBodyPart = part;
			$("#bdytpslc").html("Head");
		} else if(part == 1) {
			curBodyPart = part;
			$("#bdytpslc").html("Left Arm");
		} else if(part == 2) {
			curBodyPart = part;
			$("#bdytpslc").html("Right Arm");
		} else if(part == 3) {
			curBodyPart = part;
			$("#bdytpslc").html("Torso");
		} else if(part == 4) {
			curBodyPart = part;
			$("#bdytpslc").html("Left Leg");
		} else if(part == 5) {
			curBodyPart = part;
			$("#bdytpslc").html("Right Leg");
		}
	}
	function changeBodyColorhtml(color) {
		if(color == 1) {
			$("#bdyprt" + curBodyPart).css("background-color", "#F2F3F2");
		} else if(color == 208) {
			$("#bdyprt" + curBodyPart).css("background-color", "#E5E4DE");
		} else if(color == 194) {
			$("#bdyprt" + curBodyPart).css("background-color", "#A3A2A4");
		} else if(color == 199) {
			$("#bdyprt" + curBodyPart).css("background-color", "#635F61");
		} else if(color == 26) {
			$("#bdyprt" + curBodyPart).css("background-color", "#1B2A34");
		} else if(color == 21) {
			$("#bdyprt" + curBodyPart).css("background-color", "#C4281B");
		} else if(color == 24) {
			$("#bdyprt" + curBodyPart).css("background-color", "#F5CD2F");
		} else if(color == 226) {
			$("#bdyprt" + curBodyPart).css("background-color", "#FDEA8C");
		} else if(color == 23) {
			$("#bdyprt" + curBodyPart).css("background-color", "#0D69AB");
		} else if(color == 107) {
			$("#bdyprt" + curBodyPart).css("background-color", "#008F9B");
		} else if(color == 102) {
			$("#bdyprt" + curBodyPart).css("background-color", "#6E99C9");
		} else if(color == 11) {
			$("#bdyprt" + curBodyPart).css("background-color", "#80BBDB");
		} else if(color == 45) {
			$("#bdyprt" + curBodyPart).css("background-color", "#B4D2E3");
		} else if(color == 135) {
			$("#bdyprt" + curBodyPart).css("background-color", "#74869C");
		} else if(color == 106) {
			$("#bdyprt" + curBodyPart).css("background-color", "#DA8540");
		} else if(color == 105) {
			$("#bdyprt" + curBodyPart).css("background-color", "#E29B3F");
		} else if(color == 141) {
			$("#bdyprt" + curBodyPart).css("background-color", "#27462C");
		} else if(color == 28) {
			$("#bdyprt" + curBodyPart).css("background-color", "#287F46");
		} else if(color == 37) {
			$("#bdyprt" + curBodyPart).css("background-color", "#4B974A");
		} else if(color == 119) {
			$("#bdyprt" + curBodyPart).css("background-color", "#A4BD46");
		} else if(color == 29) {
			$("#bdyprt" + curBodyPart).css("background-color", "#A1C48B");
		} else if(color == 151) {
			$("#bdyprt" + curBodyPart).css("background-color", "#789081");
		} else if(color == 38) {
			$("#bdyprt" + curBodyPart).css("background-color", "#A05F34");
		} else if(color == 192) {
			$("#bdyprt" + curBodyPart).css("background-color", "#694027");
		} else if(color == 104) {
			$("#bdyprt" + curBodyPart).css("background-color", "#6B327B");
		} else if(color == 9) {
			$("#bdyprt" + curBodyPart).css("background-color", "#E8BAC7");
		} else if(color == 101) {
			$("#bdyprt" + curBodyPart).css("background-color", "#DA8679");
		} else if(color == 5) {
			$("#bdyprt" + curBodyPart).css("background-color", "#D7C599");
		} else if(color == 153) {
			$("#bdyprt" + curBodyPart).css("background-color", "#957976");
		} else if(color == 217) {
			$("#bdyprt" + curBodyPart).css("background-color", "#7C5C45");
		} else if(color == 18) {
			$("#bdyprt" + curBodyPart).css("background-color", "#CC8E68");
		} else if(color == 125) {
			$("#bdyprt" + curBodyPart).css("background-color", "#EAB891");
		}
	}
	function changeBodyColor(color) {
		$("#CBCmessage").html("");
		changeBodyColorhtml(color);
		$("#changingBodyColor").show();
		$.post("https://otorium.xyz/api/core/changeBodyColour.php", {type: curBodyPart, color:color}, function(data) {
			$("#changingBodyColor").hide();
			$("#CBCmessage").html($(data).filter("#message").html());
		});
	}
	function mouseLeftAvatar() {
		$("#changeavatarstyletxt").html("");
	}
	var vaopened = false;
	function openVA() {
		if (vaopened == false) {
			openvapage(1);
			vaopened = true;
		}
	}
</script>
<ul class="tab tab-block">
	<li onclick="removeAndHideActiveAll(); $('#wras').addClass('active'); $('#wearItemsdiv').show();" id="wras" class="tab-item active">
		<a href="#">Wear</a>
	</li>
	<li onclick="removeAndHideActiveAll(); $('#gtas').addClass('active'); $('#getNewAssets').show();" id="gtas" class="tab-item">
		<a href="#">Get Assets</a>
	</li>
</ul>
<div id="wearItemsdiv">
	<div class="panel">
		<div class="panel-header">
			<div style="display: inline-block;">
				<figure class="avatar" style="height: 7.5em; width: 7.5em;">
					<style>
						#changeavatarstyletxt {
							user-select: none;
							cursor:pointer;
							padding:10px;
							border-radius:7.5px;
							background-color: rgba(0,0,0,0);
						}
						#changeavatarstyletxt:hover {
							background-color: rgba(0,0,0,0.7);
						}
						#changeavatarstyletxt:active {
							background-color: rgba(0,0,0,0.5);
						}
					</style>
					<div style="position:relative;">
						<img class="stuff" onclick="switch2008Style()" onmouseover="mouseOverAvatar()" onmouseout="mouseLeftAvatar()" id="avatarimg" src="<?php echo $userImages.$userID; ?>.png?tick=<?php echo time(); ?>" alt="Avatar">
						<span class="stuff" onclick="switch2008Style()" onmouseover="mouseOverAvatar()" onmouseout="mouseLeftAvatar()"  id="changeavatarstyletxt" style="cursor: pointer; margin: 0; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);z-index:2;"></span>
					</div>
					<progress class="progress" max="100" id="renderingavatarbar" style="display:none;"></progress>
				</figure>
			</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
			<div style="display: inline-block;">
				<div class="panel-title h5 mt-10"><?php echo $user; ?></div>
				<button class="btn btn-link" onclick="openmodal('changeBodyColorModal')">Change Body Colors</button>
				<div class="panel-subtitle">Last updated <?php echo date("M j, Y", $pdo->query("SELECT * FROM wearing_items ORDER BY `id` DESC LIMIT 1")->fetch(PDO::FETCH_OBJ)->when_worn); ?></div>
			</div>
			<i class="fa fa-refresh float-right" onclick="resetPages()" style="font-size: 3em; cursor: pointer;"></i>
		</div>
		<nav class="panel-nav"> 
			<ul class="tab tab-block">
				<li id="pg1tab" onclick="openNewPage(1);" class="tab-item">
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
	  <div id="pg1body" class="panel-body" style="display: none;">
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
<div id="getNewAssets" style="display: none;">
	<Br />
	<p>Enter the ID of any ROBLOX asset, and Otorium will get the information for you.</p>
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

<div id="changeBodyColorModalFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

	<div id="changeBodyColorModal" class="anim" style="background-color:<?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; margin: 7.5% auto; padding: 25px; border: 1px solid <?php echo $border_color; ?>;">
		<big>Body Colors</big>
		<br />
		<p>Body type selected: <span id="bdytpslc">NONE</span></p>
		<div class="columns">
			<div class="column">
				<div>
					<div style="width: 66px; clear: both; display: inline-block;"></div>
					<div id="bdyprt0" onclick="chgBodyPart(0)" style="width:48px; height:48px; background-color: yellow; clear:both; display: inline-block;"></div>
				</div>
				<div>
					<div id="bdyprt2" onclick="chgBodyPart(2)" style="width:40px; height:96px; background-color: yellow; clear:both; display: inline-block;"></div>
					<div id="bdyprt3" onclick="chgBodyPart(3)" style="width:96px; height:96px; background-color: blue; clear:both; display: inline-block;"></div>
					<div id="bdyprt1" onclick="chgBodyPart(1)" style="width:40px; height:96px; background-color: yellow; clear:both; display: inline-block;"></div>
				</div>
				<div>
					<div style="width: 40px; clear: both; display: inline-block;"></div>
					<div id="bdyprt5" onclick="chgBodyPart(5)" style="width:40px; height:96px; background-color: green; clear:both; display: inline-block;"></div>
					&nbsp;
					<div id="bdyprt4" onclick="chgBodyPart(4)" style="width:40px; height:96px; background-color: green; clear:both; display: inline-block;"></div>
				</div>
				<?php
				$gbc = $pdo->prepare("SELECT * FROM body_colors WHERE uid = :id");
				$gbc->bindParam(":id", $userID, PDO::PARAM_INT);
				$gbc->execute();
				if($gbc->rowCount() > 0) {
					$bodycolors = $gbc->fetch(PDO::FETCH_OBJ);
					$hc = $bodycolors->head;
					$lac = $bodycolors->left_arm;
					$llc = $bodycolors->left_leg;
					$rac = $bodycolors->right_arm;
					$rlc = $bodycolors->right_leg;
					$tc = $bodycolors->torso;
					echo '<script>
							chgBodyPart(0);
							changeBodyColorhtml('.$hc.');
							chgBodyPart(1);
							changeBodyColorhtml('.$lac.');
							chgBodyPart(2);
							changeBodyColorhtml('.$rac.');
							chgBodyPart(3);
							changeBodyColorhtml('.$tc.');
							chgBodyPart(4);
							changeBodyColorhtml('.$llc.');
							chgBodyPart(5);
							changeBodyColorhtml('.$rlc.');
						</script>';
				}
				?>
			</div>
			<div class="column">
				<center>
					<div id="CBCmessage">
					
					</div>
				</center>
				<style>
				.ColorPickerItem
				{
					border-color: rgb(140,140,140);
					border-style: solid;
					border-width: 2px;
				}
				.ColorPickerItem:hover
				{
					border-color: black;
					border-style: solid;
					border-width: 2px;
				}
				</style>
				<table cellspacing="0" border="0" style="border-width:0px;border-collapse:collapse;background-color: rgb(140,140,140); border:1px solid black; padding:10px;">
					<tr>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(1)" style="display:inline-block;background-color:#F2F3F2;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(208)" style="display:inline-block;background-color:#E5E4DE;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(194)" style="display:inline-block;background-color:#A3A2A4;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(199)" style="display:inline-block;background-color:#635F61;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(26)" style="display:inline-block;background-color:#1B2A34;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(21)" style="display:inline-block;background-color:#C4281B;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(24)" style="display:inline-block;background-color:#F5CD2F;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(226)" style="display:inline-block;background-color:#FDEA8C;height:32px;width:32px;">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(23)" style="display:inline-block;background-color:#0D69AB;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(107)" style="display:inline-block;background-color:#008F9B;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(102)" style="display:inline-block;background-color:#6E99C9;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(11)" style="display:inline-block;background-color:#80BBDB;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(45)" style="display:inline-block;background-color:#B4D2E3;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(135)" style="display:inline-block;background-color:#74869C;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(106)" style="display:inline-block;background-color:#DA8540;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(105)" style="display:inline-block;background-color:#E29B3F;height:32px;width:32px;">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(141)" style="display:inline-block;background-color:#27462C;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(28)" style="display:inline-block;background-color:#287F46;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(37)" style="display:inline-block;background-color:#4B974A;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(119)" style="display:inline-block;background-color:#A4BD46;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(29)" style="display:inline-block;background-color:#A1C48B;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(151)" style="display:inline-block;background-color:#789081;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(38)" style="display:inline-block;background-color:#A05F34;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(192)" style="display:inline-block;background-color:#694027;height:32px;width:32px;">
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(104)" style="display:inline-block;background-color:#6B327B;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(9)" style="display:inline-block;background-color:#E8BAC7;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(101)" style="display:inline-block;background-color:#DA8679;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(5)" style="display:inline-block;background-color:#D7C599;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(153)" style="display:inline-block;background-color:#957976;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(217)" style="display:inline-block;background-color:#7C5C45;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(18)" style="display:inline-block;background-color:#CC8E68;height:32px;width:32px;">
							</div>
						</td>
						<td>
							<div class="ColorPickerItem" onclick="changeBodyColor(125)" style="display:inline-block;background-color:#EAB891;height:32px;width:32px;">
							</div>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<progress class="progress" max="100" id="changingBodyColor" style="display:none;"></progress>
		<br />
		<button class="btn btn-primary float-right" onclick="closemodal('changeBodyColorModal')">Close</button>
		<br />
		<br />
	</div>
<?php } else { ?>
<h2>Maintenance!</h2>
<?php } ?>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
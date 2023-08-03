<?php header('Access-Control-Allow-Origin: *'); $asset_id_page = "yas"; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; if($loggedin == false) { header("Location: ../login"); }?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Catalog Items | Otorium</title>
</head>
<body>

<div class="sides">

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
	function getAssetInfo(id, rbx = 1) {
		$('#itemcolumns').hide(250);
		$('#loadingstuff').show(250);
		$('#ldingtxt').html("Loading item...");
		$("#NewItemImage").attr("src","");
		$("#itemImage").attr("src","");
		$("#getassetinfodiv").hide();
		$("#getasseterror").html("");
		$('#paginationdiv').hide();
		//get item info
		$.getJSON('https://otorium.xyz/api/core/getAssetInfo.php?rbxid=' + id + '&asset=' + rbx, function (data) {
			$("#itemName").html(data.Name);
			if(data.Thumbnail == "") {
				$("#itemImage").attr("src","https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + id);
			} else { 
				$("#itemImage").attr("src",data.Thumbnail);
			}
			$("#itemDescription").html(data.Description);
			$("#itemType").html(data.Type);
			
			$("#purchaseItemGroup").show();
			$("#itemPrice").html(data.Price);
			$("#purchaseitembtn").attr("onclick","buyAsset(" + data.Id + ")");
			
			openmodal("itempanel");
			$("#loadingstuff").hide(250);$("#itemcolumns").show(250);$('#paginationdiv').show();
			$("#getassetinfodiv").show();
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
	}
	
	function removeAndHideActiveAll() {
		$('#gtas').removeClass('active');
		$('#wras').removeClass('active'); 
		$('#byas').removeClass('active');
		$('#getNewAssets').hide();
		$('#wearItemsdiv').hide();
		$('#buyItemsdiv').hide();
	}
	
	function openvapage(id, page = 1) {
		$('#paginationdiv').hide();
		$("#showingresults").hide(100);
		curviewassetpage = id;
		var search = $("#keywordSearchBarinpt").val();
		$("#keywordSearchBarinpt").addClass("disabled");
		$("#submitBtn").addClass("disabled");
		resetVAPages();
		var curviewassetpage2 = page;
		$('#vanavitem' + id).addClass('active');
		$('#itemcolumns').hide(250);
		$('#loadingstuff').show(250);
		$('#ldingtxt').html("Loading items...");
		$.post("https://otorium.xyz/api/core/getAssetPage.php", {type:id, page:page, search:search}, function(data) {
			$('#itemcolumns').html($(data).filter("#items").html());
			$('#paginationdiv').html($(data).filter("#page").html());
			$('#paginationdiv').show();
			$("#keywordSearchBarinpt").removeClass("disabled");
			$("#submitBtn").removeClass("disabled");
			$('#loadingstuff').hide(250);
			$('#itemcolumns').show(250);
			if(search !== "") {
				$("#kywd").html(search);
				$("#showingresults").show(250);
			}
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
	var vaopened = false;
	function openVA() {
		if (vaopened == false) {
			openvapage(1);
			vaopened = true;
		}
	}
</script>

	<a href="../customization" class="float-right" style="color: <?php echo $txt_color; ?>;">Customize your avatar here > ></a>
	<b>Buy Items</b><br /><br />
	<div class="columns">
		<div class="column col-2 col-sm-12">
			<ul class="nav" style="cursor: pointer;">
			  <li id="vanavitem1" class="nav-item active" onclick="openvapage(1)">
				<a href="#">Hats</a>
			  </li>
			  <li id="vanavitem2" class="nav-item" onclick="openvapage(2)">
				<a href="#">Heads</a>
			  </li>
			  <li id="vanavitem3" class="nav-item" onclick="openvapage(3)">
				<a href="#">Clothes</a>
			  </li>
			  <li id="vanavitem4" class="nav-item" onclick="openvapage(4)">
				<a href="#">Faces</a>
			  </li>
			  <li id="vanavitem5" class="nav-item" onclick="openvapage(5)">
				<a href="#">Gears</a>
			  </li>
			  <li id="vanavitem6" class="nav-item" onclick="openvapage(6)">
				<a href="#">Packages</a>
			  </li>
			</ul>
		</div>
		<style>
			.item {
				background-color: <?php echo $bg_color_1; ?>;
				animation: fadeout 0.5s;
			}
			.item:hover {
				background-color: <?php echo $bg_color_2; ?>;
				animation: fadein 0.5s;
			}
			@keyframes fadeout {
				from {
					background-color: <?php echo $bg_color_2; ?>;
				}
				to {
					background-color: <?php echo $bg_color_1; ?>;
				}
			}
			@keyframes fadein {
				from {
					background-color: <?php echo $bg_color_1; ?>;
				}
				to {
					background-color: <?php echo $bg_color_2; ?>;
				}
			}
		</style>
		<div class="column col-10 col-sm-12">
			<div class="input-group">
				<span class="input-group-addon">Search</span>
				<input type="text" class="form-input" id="keywordSearchBarinpt" placeholder="Search for an item">
				<button onclick="openvapage(curviewassetpage)" id="submitBtn" class="btn btn-primary input-group-btn">Submit</button>
			</div>
			<br />
			<div id="showingresults" style="display:none;">
				<i class="fa fa-search"></i> Showing search results for "<span id="kywd">h</span>"
				<br />
				<br />
			</div>
			<div id="loadingstuff" style="display:none;">
				<center>
					<img src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" width="96" /><br /><h4 id="ldingtxt">Loading item...</h4>
					Please be patient!
				</center>
			</div>
			<div id="itemcolumns" class="columns">
			</div>
			<br />
			<div id="paginationdiv">
			</div>
		</div>
	</div>
</div>
<div id="itempanelFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

  <div id="itempanel" class="anim" style="background-color:<?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; margin: 7.5% auto; padding: 25px; border: 1px solid <?php echo $border_color; ?>;">
	<big id="itemName"></big>
	<div class="columns">
		<div class="column">
			<center><img src="" height="250" width="250" class="img-fit-contain img-responsive" id="itemImage" /></center>
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
	<div id="purchaseItemGroup">
		<p>Would you like to purchase this item?</p>
		<a onclick="closeItemPanel('itempanel')" class="btn">Cancel</a>
		<a onclick="closemodal('itempanel')" id="purchaseitembtn" class="btn btn-purchase float-right">Purchase</a>
	</div>
  </div>
  <div id="purchasingitem" style="background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; display: none; border: 1px solid <?php echo $border_color; ?>; position: absolute; top: 50%; left: 50%; transform: translateX(-50%) translateY(-50%);">
	<center>
		<img src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" width="96" /><br />
		Purchasing...
	</center>
  </div>

</div>

<script>
	openvapage(1)
</script>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
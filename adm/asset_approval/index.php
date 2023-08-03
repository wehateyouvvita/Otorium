<?php /*if($rank == 2) { limiteds
					echo '
				<div class="columns">
					<div class="column">
						<div class="form-group">
							<label class="form-switch">
								<input type="checkbox" id="chkbxforever" />
								<i class="form-icon"></i> Limited
							</label>
						</div>
					</div>
					<div class="column">
						<input class="form-input" type="number" placeholder="Stock.." />
					</div>
				</div>
					';
				} */
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if($staffMember == false && $asset_approver == 0) {
			$errCode = '403';
			include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
			goto FooterPart;
		}
	?>
</head>
<body>

<div class="sides">

<h2>Admin Panel</h2>
<p>Don't abuse :)</p>

<div class="columns">
	<div class="column col-3 col-xs-2" style="padding-right:5px;">
		<?php include $_SERVER['DOCUMENT_ROOT'].'/adm/panel1.php'; ?>
	</div>
	
	<div class="column col-9 col-xs-2" style="padding-left:5px;">
		<div style="padding:25px; border:1px solid rgb(200,200,200);">
			<h3>Asset Approval</h3>
			<script>
				function OpenApproveItem(id,rid) {
					openmodal('approveItem');
					$("#aprvitmimage").attr("src", "https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + rid);
					$("#aprvitmname").html($("#itmnm" + id).html());
					$("#aprvingtmimage").attr("src", "https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + rid);
					$("#aprvingitmname").html($("#itmnm" + id).html());
					$("#aprvitmbtn").attr("onclick","approveItem(" + id + ")");
				}
				function approveItem(id) {
					var money = $("#aprvmon").val();
					$("#aprvingmny").html(money);
					$("#approveItem").hide(500);
					$("#approvingItem").show(500);
					$.post('https://otorium.xyz/api/core/changeAssetStatus.php',{itemID: id, type:1, money:money},
					function(data)
					{
						
						var message = $(data).filter("#message").html();
						
						var success = $(data).filter("#success").html();
					
						$("#approveItemMsg").html(message);
						$("#approvingItem").hide(500);
						$("#approveItemMsg").show(500);
						
						setTimeout(function() {
							if(success == "t") {
								closemodal('approveItem');
								$("#item" + id).remove();
								setTimeout(function() {
									$("#approveItem").show();
									$("#approvingItem").hide();
									$("#approveItemMsg").hide();
								}, 1000);
							} else {
								$("#approveItemMsg").hide(500);
								$("#approveItem").show(500);
							}
						}, 1500);
						
					});
				}
				function declineItem(id,rid) {
					$("#dclingitmname").html($("#itmnm" + id).html());
					$("#dclingitmimage").attr("src", "https://www.roblox.com/Thumbs/Asset.ashx?Width=250&Height=250&AssetID=" + rid);
					openmodal('declineItem');
					$.post('https://otorium.xyz/api/core/changeAssetStatus.php',{itemID: id, type:2, money:0},
					function(data)
					{
						
						var message = $(data).filter("#message").html();
						
						var success = $(data).filter("#success").html();
						
						$("#declineItemMsg").html(message);
						$("#declineItem").hide(500);
						$("#declineItemMsg").show(500);
						
						setTimeout(function() {
							if(success == "t") {
								closemodal('declineItem');
								$("#item" + id).remove();
								setTimeout(function() {
									$("#declineItem").show();
									$("#declineItemMsg").hide();
								}, 1000);
							} else {
								closemodal('declineItem');
								setTimeout(function() {
									$("#declineItem").show();
									$("#declineItemMsg").hide();
								}, 1000);
							}
						}, 1500);
						
					});
				}
			</script>
			<div id="approveItemFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

			  <div id="approveItem" class="anim" style="margin: 7.5% auto; background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; border: 1px solid <?php echo $border_color; ?>;">
				<span>Approve <span style="color: rgb(200,200,25);" id="aprvitmname"></span>!</span>
				<div class="columns">
					<div class="column">
						<img width="256" id="aprvitmimage" src="" />
					</div>
					<div class="column">
						<input class="form-input" id="aprvmon" type="number" placeholder="Amount.." /><br />
						<button class="btn btn-primary" id="aprvitmbtn">Approve</button>
						<button class="btn float-right" onclick="closemodal('approveItem')">Cancel</button>
					</div>
				</div>
			  </div>
			  <div id="approvingItem" class="anim" style="display: none; margin: 7.5% auto; background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; border: 1px solid <?php echo $border_color; ?>;">
				<big>Approving <span style="color: rgb(200,200,25);" id="aprvingitmname"></span>!</big>
				<div class="columns">
					<div class="column">
						<img width="256" id="aprvingtmimage" src="" /><br />
					</div>
					<div class="column">
						<span style="color: green; font-size: 1.5em;"><i class="fa fa-money"></i> <span id="aprvingmny"></span></span>
						<img width="224" src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" class="img-fit-contain img-responsive" />
					</div>
				</div>
			  </div>
			  <div id="approveItemMsg" class="anim" style="display: none; margin: 7.5% auto; background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; border: 1px solid <?php echo $border_color; ?>;">
				
			  </div>

			</div>
			<div id="declineItemFade" style="padding-left:20%; padding-right:20%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0,0,0,0.4);">

			  <div id="declineItem" class="anim" style="display: none; margin: 7.5% auto; background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; border: 1px solid <?php echo $border_color; ?>;">
				<big>Declining <span style="color: rgb(200,200,25);" id="dclingitmname"></span>!</big>
				<div class="columns">
					<div class="column">
						<img width="256" id="dclingitmimage" src="" /><br />
					</div>
					<div class="column">
						<img width="224" src="https://www.createwebsite.net/wp-content/uploads/2015/09/GD.gif" class="img-fit-contain img-responsive" />
					</div>
				</div>
			  </div>
			  <div id="declineItemMsg" class="anim" style="display: none; margin: 7.5% auto; background-color: <?php echo $bg_color_1; ?>; color: <?php echo $txt_color; ?>; padding:25px; border: 1px solid <?php echo $border_color; ?>;">
				
			  </div>

			</div>
			<?php
			foreach ($pdo->query("SELECT * FROM asset_items WHERE approved=1") as $item) {
				echo '
			<div id="item'.$item['id'].'" class="tile" style="padding: 10px; border:1px solid '.$GLOBALS['border_color'].'; border-top:0px; background-color: '.$GLOBALS['bg_color_1'].';">
				<div onclick="window.location.href = \'https://roblox.com/catalog/'.$item['robloxid'].'/-\'" class="tile-icon" style="display: table; width: 64px; height:64px; border: 1px solid #82DD55; cursor: pointer; font-size: 1.75em; style">
					<img width="64" src="https://www.roblox.com/Thumbs/Asset.ashx?Width=48&Height=48&AssetID='.$item['robloxid'].'" style="display: table-cell; vertical-align: middle; text-align: center;"/>
				</div>
				&nbsp;&nbsp;&nbsp;&nbsp;
				<div onclick="window.location.href = \'https://roblox.com/catalog/'.$item['robloxid'].'/-\'" class="tile-content" style="cursor: pointer;">
					<span class="tile-title" id="itmnm'.$item['id'].'">'.$item['name'].'</span>
					<p class="tile-subtitle text-gray">
						'.$do->getAssetType($item['type']).'<br />
						Added on '.date("M d Y, g:i:s A", $item['added_on']).'.
					</p>
				</div>
				<div class="tile-action">
					<button class="btn btn-success" onclick="OpenApproveItem('.$item['id'].', '.$item['robloxid'].')">Approve</button>
					<button class="btn btn-error" onclick="declineItem('.$item['id'].', '.$item['robloxid'].')">Decline</button>
				</div>
			</div>
			';
			}
			?>
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
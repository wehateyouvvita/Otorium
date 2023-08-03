<?php $page = 'editgame'; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Editing <?php echo $do->GameName($_GET['id']); ?> | Otorium</title>
</head>
<body>

<div class="sides">

	<?php
	$entries = 0;
	
	if(is_numeric($_GET['id'])) {
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0");
		$query->bindParam("id", $_GET['id'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() == 1) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			if($result->creator == $userID) {
			    if($result->image_approved == 1) {
    				$image = $result->image;
    				$thumbnailManaged = true;
    			} elseif($result->image_approved == 0) {
    				$image = $cdn.'/assets/approvalpending.png';
    				$thumbnailManaged = false;
    			} elseif($result->image_approved == 2) {
    				$image = $cdn.'/assets/thumbnaildenied.png';
    				$thumbnailManaged = true;
    			}
    			$imageUrl = $result->image;
    			$gameName = $result->name;
    			$description = $result->description;
    			$ip = $result->ip;
    			$port = $result->port;
				?>
				<?php if(isset($gameError)) { echo $gameError; } ?>
				<div class="columns">
                    <div class="column col-3 col-12-sm" style="padding-right:0px;">
                        <div style="border:1px solid <?php echo $border_color; ?>; border-right:0px; padding:25px;">
                            <h4>Menu</h4>
                            <button onclick="$('#mnst').show(); $('#gmct').hide();" class="btn btn-link btn-block" style="text-align: left;"><i class="icon icon-link"></i> Main Settings</button>
                            <button onclick="$('#mnst').hide(); $('#gmct').show();" class="btn btn-link btn-block" style="text-align: left;"><i class="icon icon-link"></i> Game Settings</button>
                        </div>
					</div>
					<form method="post" id="mnst" class="column col-9 col-12-sm" style="padding:25px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">
						<h4>Editing <?php echo $do->noXSS($result->name); ?></h4>
                        <div class="form-group">
                            <label class="form-label">Game Name</label>
                            <input class="form-input" type="text" name="gamename" maxlength="32" placeholder="A game name is required" value="<?php echo $do->noXSS($gameName); ?>" required />
                        </div>
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <textarea class="form-input" name="gamedesc" maxlength="256" placeholder="Ok" required rows="2"><?php echo $do->noXSS($description); ?></textarea>
                        </div>
                        <br />
        				<img src="<?php echo $do->noXSS($image); ?>" class="img-responsive img-fit-contain" style="max-height:256px;width:100%;" />
        				<br />
                        <div class="form-group">
                            <label class="form-label">Thumbnail URL:</label>
                            <input class="form-input" type="text" maxlength="256" name="thmburl" value="<?php echo $do->noXSS($imageUrl); ?>" />
                        </div>
        				<br />
        				<button class="btn btn-primary" type="submit" name="editMainGameSettings" style="float:right;">Change</button>
					</form>
					<form method="post" id="gmct" class="column col-9 col-12-sm" style="display: none; padding:25px; border:1px solid <?php echo $border_color; ?>; background-color: <?php echo $bg_color_1; ?>;">
                        <div class="form-group">
                            <label class="form-label">Version</label>
                            <select id="gamever" class="form-select">
                                <option value="1" selected>2010</option>
                                <option value="2">2008</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">IP Address (IPV6 not supported)</label>
                            <input class="form-input" type="text" maxlength="16" required name="gameip" value="<?php echo $ip; ?>" placeholder="IP address used to connect to the game"/>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Port</label>
                            <input class="form-input" type="number" required name="gameport" value="<?php echo $port; ?>" maxlength="6" />
                        </div>
        				<br />
        				<button class="btn btn-primary" type="submit" name="editGame" style="float:right;">Change</button>
					</form>
				</div>
				
				
				<?php
			} else { 
				echo '<h3>You do not own this game. <a href="../">Click here</a> to go back.</h3>';
			}
		
		} else {
			echo '<h3>Game does not exist. <a href="../">Click here</a> to go back.</h3>';
		}
			
	} else {
		echo '<h3>Game does not exist. <a href="../">Click here</a> to go back.</h3>';
	}
	?>
	
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php
		getHeader();
		if($loggedin == true) {
			echo '<script src="'.$url.'/api/js/createGame.js"></script>';
		}
	?>
	<title>Create Game | Otorium</title>
</head>
<body>

<div class="sides">
   <div style="padding:10px; border:1px solid rgb(200,200,200);">
	   <a href="../"><i class="fa fa-bolt"></i>&nbsp;&nbsp;Available games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="../owned"><i class="fa fa-hdd-o"></i>&nbsp;&nbsp;My games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<a href="#"><i class="fa fa-user-secret"></i>&nbsp;&nbsp;Private games</a>&nbsp;&nbsp;<b>|</b>&nbsp;&nbsp;<b><i class="fa fa-plus"></i>&nbsp;&nbsp;Create new game</b>
   </div>
	<br />
  <div id="createServer" style="padding:25px; border:1px solid rgb(200,200,200);">
	<?php if($loggedin == false) {
		echo '<h3>You must be logged in to create a server. <a href="../../login">Click here</a> to login or create your own account.</h3>';
	} else { ?>
	<h3>Create a new game</h3>
	<div id="result"></div>
	<div id="cg-form-inputs">
	  <div class="form-group">
		<label class="form-label">Game name</label>
		<input class="form-input" type="text" id="gamename" maxlength="32" placeholder="E.G. <?php echo $user; ?>'s server of awesomeness" required />
	  </div>
	  <div class="form-group">
		<label class="form-label">Description</label>
		<textarea class="form-input" id="gamedesc" maxlength="256" placeholder="E.G. In <?php echo $user; ?>'s server, you get to build, destroy AND watch movies at the same time! How cool is that?" required rows="2"></textarea>
	  </div>
	  <p>2010 is selected as default</p>
	  <div class="form-group" style="display:none;">
		<label class="form-label">Version</label>
		<select id="gamever" class="form-select">
		  <option value="1" disabled selected>2010</option>
		  <option value="2" disabled>2008</option>
		</select>
	  </div>
	  <div class="form-group">
		<label class="form-label">IP Address (IPV6 not supported)</label>
		<input class="form-input" type="text" maxlength="16" required id="gameip" placeholder="IP address used to connect to the game"/>
	  </div>
	  <div class="form-group">
		<label class="form-label">Port</label>
		<input class="form-input" type="number" required id="gameport" value="53680" maxlength="6" />
	  </div>
	  <div class="form-group">
		<label class="form-label">Thumbnail URL:</label>
		<input class="form-input" type="url" maxlength="256" id="imgthmb" placeholder="E.G. https://otorium.gq/secretimage.png" />
	  </div>
	  <div class="form-group">
		<label class="form-switch">
		  <input type="checkbox" id="lpbk" />
		  <i class="form-icon"></i> Enable loopback
		</label>
	  </div>
	  <div onclick="CheckToHostGame()" class="form-group">
		<label class="form-switch">
		  <input type="checkbox" id="hstgme" />
		  <i class="form-icon"></i> Host server
		</label>
	  </div>
	  <button class="btn float-right" onclick="createGame()">Create game</button>
	  <br />
	  <br />
	</div>
	<?php } ?>
   </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
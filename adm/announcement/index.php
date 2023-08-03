<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if($staffMember == false) {
			$errCode = '403';
			include $_SERVER['DOCUMENT_ROOT'].'/err/index.php';
			goto FooterPart;
		}
	?>
	<script type="text/javascript" src="<?php echo $url; ?>/api/js/cAnnouncement.js"></script>
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
			<div id="result"></div>
			<h3>Change Announcement</h3>
			
			<div id="type" class="form-group">
				<label class="form-label">Type</label>
				<label class="form-radio">
					<input type="radio" onclick="show()" name="type" value="1" checked />
					<i class="form-icon"></i> Change / edit announcement
				</label>
				<label class="form-radio">
					<input type="radio" onclick="hide()" name="type" value="2" />
					<i class="form-icon"></i> Remove announcement
				</label>
			</div>
			<div id="contentinput" class="form-group">
				<label class="form-label">Content</label>
				<input class="form-input" type="text" id="content" />
			</div>
			<div id="colourtype" class="form-group">
				<label class="form-label">Type</label>
				<select id="colour" class="form-select">
					<option value="1">Alert [Red]</option>
					<option value="2">Information [Blue]</option>
					<option value="3">Attention [Orange]</option>
					<option value="4">Neutral [Green]</option>
					<option value="5">Unimportant [Purple]</option>
				</select>
			</div>
			<button id="announcebtn" class="btn float-right" onclick="announcement()">Change announcement</button>
			<br />
			<br />
		</div>
	</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
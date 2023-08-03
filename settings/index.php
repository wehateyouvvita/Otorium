<?php $page = 'settings'; include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title>Settings | Otorium</title>
</head>
<body>

<div class="sides">

<?php if($loggedin == true) { ?>
<h3>Settings</h3>
<p>Change the available Otorium settings to your needs</p>

	<?php if(isset($changePassworderror)) { echo $changePassworderror."<br />"; } ?>
	<?php if(isset($changePrivacySettingsError)) { echo $changePrivacySettingsError."<br />"; } ?>
	<?php if(isset($changeUsernameSettingError)) { echo $changeUsernameSettingError."<br />"; } ?>
	<?php if(isset($changeThemeError)) { echo $changeThemeError."<br />"; } ?>
	<?php if(isset($changeDescriptionError)) { echo $changeDescriptionError."<br />"; } ?>
	
  <div class="accordion">
	<input type="checkbox" id="accordion-1" name="accordion-checkbox" hidden="">
	<label class="accordion-header c-hand" for="accordion-1" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
	  Account
	</label>
	<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
		<div style="padding: 25px;">
			<div class="accordion">
				<input type="checkbox" id="accordion-2" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-2" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
				Username
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<form method="post" style="padding:25px; padding-top:10px;">
						<h4>Account Settings</h4>
						<div class="form-group">
							<label class="form-label">Desired Username</label>
							<input class="form-input" type="text" name="cuduinpt" maxlength="16" autocomplete="off" required />
						</div>
						<div class="form-group">
							<label class="form-label">Password</label>
							<input class="form-input" type="password" name="cupinpt" maxlength="256" autocomplete="off" required />
						</div>
						<a id="chgucnfbtn" onclick="openmodal('changeUsernameModal');" class="btn"><i class="fa fa-money"></i>&nbsp;&nbsp;Confirm</a>
						<button type="submit" style="display: none;" id="chgusnbtn" name="chgusnbtn" class="btn"><i class="fa fa-money"></i>&nbsp;&nbsp;Change username</button>
					</form>
				</div>
			</div>
			<div class="accordion">
				<input type="checkbox" id="accordion-3" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-3" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
				Change Password
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<form style="padding:25px; padding-top:10px;" method="post">
						<h4>Change Password</h4>
						<div class="form-group">
							<label class="form-label">Current Password</label>
							<input class="form-input" type="password" name="curpw" maxlength="256" autocomplete="off" required />
						</div>
						<div class="form-group">
							<label class="form-label">New Password</label>
							<input class="form-input" type="password" name="newpw" maxlength="256" autocomplete="off" required />
						</div>
						<div class="form-group">
							<label class="form-label">Confirm Password</label>
							<input class="form-input" type="password" name="cfmpw" maxlength="256" autocomplete="off" required />
						</div>
						<button type="submit" name="chgusbtn" class="btn float-right">Change Password</button>
						<br />
					</form>
				</div>
			</div>
		</div>
  </div>
  <div class="accordion">
	<input type="checkbox" id="accordion-4" name="accordion-checkbox" hidden="">
	<label class="accordion-header c-hand" for="accordion-4" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
		Users
	</label>
	<div class="accordion-body"  style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
		<div style="padding: 25px;">
			<div class="accordion">
				<input type="checkbox" id="accordion-5" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-5" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
					Blocked Users
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<div style="padding:25px; padding-top:10px;">
						<h4>Blocked Users</h4>
						<div id="buresult"></div>
						<label>Block user</label><br />
						<div class="input-group">
							<input autocomplete="off" id="buinput" type="text" class="form-input">
							<button id="bubtn" onclick="block()" class="btn btn-primary input-group-btn">Submit</button>
						</div>
						<div id="blockedUsers">
						<?php
						foreach ($pdo->query("SELECT * FROM blocked_users WHERE uid=".$userID) as $item) {
							echo '
							<div id="bldv'.$item['pid'].'" style="border-bottom: 1px solid <?php echo $border_color; ?>; padding: 5px;" class="tooltip" data-tooltip="Blocked since '.date("F d Y, g:i:s A", $item['time_added']).'">
								<a style="color: black; text-decoration: none;">'.$do->getUsername($item['pid']).'</a>
								<a style="color: red; text-decoration: none; cursor: pointer; float:right;" onclick="unblock('.$item['pid'].')"><i class="fa fa-times"></i>&nbsp;Unblock User</a>
							</div>';
						}
						?>
						</div>
						<script type="text/javascript" src="<?php echo $url; ?>/api/js/unBlockUser.js?v=001"></script>
					</div>
				</div>
			</div>
			<div class="accordion">
				<input type="checkbox" id="accordion-6" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-6" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
					Privacy
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<form style="padding:25px; padding-top:10px;" method="post">
						<div class="form-group">
							<label class="form-label">Who should be able to see your profile?</label>
							<select name="prvwsbatsyp" class="form-select" style="color: black;">
								<option value="1" <?php if($prvwsbatsyp == 1) { echo 'selected'; } ?>>Everyone</option>
								<option value="3" <?php if($prvwsbatsyp == 3) { echo 'selected'; } ?>>Logged In Users</option>
								<option value="2" <?php if($prvwsbatsyp == 2) { echo 'selected'; } ?>>Friends</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Who should be able to send you messages?</label>
							<select name="prvwsbatsym" class="form-select" style="color: black;">
								<option value="1" <?php if($prvwsbatsym == 1) { echo 'selected'; } ?>>Everyone</option>
								<option value="2" <?php if($prvwsbatsym == 2) { echo 'selected'; } ?>>Friends</option>
							</select>
						</div>
						<small><em>Note: Moderators and Administrators will always be able to see your profile and send you messages.</em></small>
						<button type="submit" name="chgprivstgsbtn" class="btn float-right">Change</button>
						<br />
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
  <div class="accordion">
	<input type="checkbox" id="accordion-7" name="accordion-checkbox" hidden="">
	<label class="accordion-header c-hand" for="accordion-7" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
		Customize
	</label>
	<div class="accordion-body"  style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
		<div style="padding: 25px;">
			<div class="accordion">
				<input type="checkbox" id="accordion-8" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-8" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
					Description
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<form method="post" style="padding:25px; padding-top:10px;">
						<div class="form-group">
							<label class="form-label">Change Description</label>
							<textarea class="form-input" rows="2" name="dscrptintxtbx" type="text"><?php echo $do->noXSS($description); ?></textarea>
						</div>
						<button type="submit" name="chgdscrtnbtn" class="btn float-right">Change</button>
						<br />
					</form>
				</div>
			</div>
			<div class="accordion">
				<input type="checkbox" id="accordion-9" name="accordion-checkbox" hidden="">
				<label class="accordion-header c-hand" for="accordion-9" style="border:1px solid <?php echo $border_color; ?>; border-bottom:0px; padding:10px;">
					Theme
				</label>
				<div class="accordion-body" style="border:1px solid <?php echo $border_color; ?>; border-top:0px;">
					<form style="padding:25px; padding-top:10px;" method="post">
						<div class="form-group">
							<label class="form-label">Change Theme</label>
							<select name="chgthmslctbx" class="form-select" style="color: black;">
								<option value="0" <?php if($theme == 0) { echo 'selected'; } ?>>Light</option>
								<option value="1" <?php if($theme == 1) { echo 'selected'; } ?>>Dark</option>
							</select>
						</div>
						<div class="form-group">
							<label class="form-label">Accent Color</label>
							<input class="form-input" name="accentclr" placeholder="FFFFFF" maxlength="6" value="<?php echo $accentColor; ?>" />
							<label class="form-label">An accent color is the text color on the site. The value must be a hex value and must be atleast 3 or 6 digits.</label>
						</div>
						<div class="form-group">
							<label class="form-checkbox tooltip tooltip-right" data-tooltip="Adds the 'box-shadow' css property using
accent color around border of some elements">
								<input <?php if($glow==true) echo 'checked="true"';?> name="glow" type="checkbox">
								<i class="form-icon"></i> Glow
							</label>
						</div>
						<small><em>Note: The dark theme is not fully optimized. Changing the theme will automatically change the accent color to black or white.</em></small>
						<button type="submit" name="chgthmebtn" class="btn float-right">Change</button>
						<br />
					</form>
				</div>
			</div>
		</div>
	</div>
  </div>
<?php } else { ?>
	<h3>You must be logged in to change account settings!</h3>
<?php } ?>
</div>

<div id="changeUsernameModalFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

<div id="changeUsernameModal" class="anim" style="background-color: <?php echo $bg_color_1; ?>; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid <?php echo $border_color; ?>;">
	<h4>Change username</h4>
	<p>Changing your username will cost 500 Otobux and is irreverisble. Are you sure you want to continue?</p>
	<div class="btn-group float-right">
	  <a class="btn" onclick="closemodal('changeUsernameModal');">Cancel</a>
	  <a class="btn btn-primary" onclick="closemodal('changeUsernameModal'); $('#chgusnbtn').show(); $('#chgucnfbtn').hide();">Change username</a>
	</div>
	<br />
</div>

</div>
</div>
<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
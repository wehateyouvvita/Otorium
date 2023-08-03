<?php

//Form Handlers
if(isset($_POST['chgusbtn'])) {
	if($page == 'settings') {
		if($loggedin == true) {
			if(password_verify($_POST['curpw'], $pwhashyoushouldntbeabletofindthis)) {
				if(strlen($_POST['newpw']) > 7) {
					if(!($_POST['newpw'] == $_POST['curpw'])) {
						if($_POST['newpw'] == $_POST['cfmpw']) {
							$hpw = password_hash($_POST['newpw'], PASSWORD_DEFAULT);
							$updatePassword = $pdo->prepare("UPDATE users SET password = :pw WHERE username = :un");
							$updatePassword->bindParam(":pw", $hpw, PDO::PARAM_STR);
							$updatePassword->bindParam(":un", $username, PDO::PARAM_STR);
							if($updatePassword->execute()) {
								$logAction = $do->logAction("changed_password", $userID, $do->encode($do->getip()));
								$changePassworderror = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed password!</div>';
							}
						} else {
							$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The passwords you have entered do not match.</div>';
						}
					} else {
						$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your new password cannot be the same as your current password.</div>';
					}
				} else {
					$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your password must be more than 7 characters.</div>';
				}
			} else {
				$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The password you entered does not match the password on your account. '.$do->getUserInfo($username, 'password').'</div>';
			}
		} else {
			$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You must be logged in to change your password.</div>';
		}
	} else {
		$changePassworderror = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;?</div>';
	}
}

if(isset($_POST['chgprivstgsbtn'])) {
	if($page == 'settings') {
		if($loggedin == true) {
			if($_POST['prvwsbatsyp'] == 1) {
				$pdo->query("UPDATE user_settings SET wcsyp = 1 WHERE uid = ".$userID);
			} elseif($_POST['prvwsbatsyp'] == 2) {
				$pdo->query("UPDATE user_settings SET wcsyp = 2 WHERE uid = ".$userID);
			} else {
				$pdo->query("UPDATE user_settings SET wcsyp = 3 WHERE uid = ".$userID);
			}
			if($_POST['prvwsbatsym'] == 1) {
				$pdo->query("UPDATE user_settings SET msgs = 1 WHERE uid = ".$userID);
			} else {
				$pdo->query("UPDATE user_settings SET msgs = 2 WHERE uid = ".$userID);
			}
			$logAction = $do->logAction("chng_prvcy_stgs", $userID, $do->encode($do->getip()));
			$changePrivacySettingsError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed privacy settings</div>';
		}
	}
}

if(isset($_POST['chgusnbtn'])) {
	if($page == 'settings') {
		if($loggedin == true) {
			if(password_verify($_POST['cupinpt'], $pwhashyoushouldntbeabletofindthis)) {
				if($do->ifUsernameExists($_POST['cuduinpt']) == false) {
					if($cash > 499) {
						if(!($do->checkIfFiltered($_POST['cuduinpt']) == true)) {
							if (ctype_alnum($_POST['cuduinpt'])) {
								if((strlen($_POST['cuduinpt']) > 2) && (strlen($_POST['cuduinpt']) < 17)) {
									$chgUsname = $pdo->prepare("UPDATE users SET username = :un WHERE id = ".$userID);
									$chgUsname->bindParam(":un", $_POST['cuduinpt'], PDO::PARAM_STR);
									$chgUsname->execute();
									$oldUname = $pdo->query("INSERT INTO old_usernames(username, uid, when_added) VALUES ('".$user."', ".$userID.", ".time().")");
									$removeCash = $pdo->query("UPDATE users SET cash = cash - 500 WHERE id = ".$userID.";");
									$logAction = $do->logAction("changed_username", $userID, $do->encode($do->getip()));
									$changeUsernameSettingError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed username. Refresh page to take effect</div>';
								} else {
									$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your username must be from 3 to 16 characters.</div>';
								}
							} else {
								$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Your username can only contain alphanumeric characters (letters and numbers)</div>';
							}
						} else {
							$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Username is filtered.</div>';
						}
					} else {
						$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;500 cash is required to change your username.</div>';
					}
				} else {
					$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Username entered already exists.</div>';
				}
			} else {
				$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The password you entered does not match.</div>';
			}
		} else {
			$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;You must be logged in to change your username.</div>';
		}
	} else {
		$changeUsernameSettingError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;?</div>';
	}
}
if($page == 'settings') {
	if($loggedin == true) {
		$gus = $pdo->query("SELECT * FROM user_settings WHERE uid=".$userID);
		$gus = $gus->fetch(PDO::FETCH_OBJ);
		$prvwsbatsyp = $gus->wcsyp;
		$prvwsbatsym = $gus->msgs;
		//$gus2 = $pdo->query("SELECT theme,blurb FROM users WHERE id=".$userID);
		//$gus2 = $gus2->fetch(PDO::FETCH_OBJ);
		//$theme = 
	}
}

if(isset($_POST['chgthmebtn'])) {
	if($page == 'settings') {
		if($loggedin == true) {
			$hashtaggedaccntclr = ltrim($_POST['accentclr'], '#');
			$checkIfHexCool = $do->isValidColor($hashtaggedaccntclr);
			if(isset($_POST['accentclr']) && $checkIfHexCool && $accentColor !== $_POST['accentclr']) {
				$changeAccentColor = $pdo->prepare("UPDATE users SET accentColor = :ac WHERE id = ".$userID);
				$changeAccentColor->bindParam(":ac", $hashtaggedaccntclr, PDO::PARAM_STR);
				$changeAccentColor->execute();
				$accentColor = $hashtaggedaccntclr;
			}
			if($_POST['chgthmslctbx'] == 1) {
				if($theme !== 1) {
					$theme = 1;
					$pdo->query("UPDATE users SET theme = 1, accentColor = 'FFFFFF' WHERE id = ".$userID);
				}
			} else {
				if($theme !== 0) {
					$theme = 0;
					$pdo->query("UPDATE users SET theme = 0, accentColor = '50596c' WHERE id = ".$userID);
				}
			}
			if($_POST['glow'] == "on") {
				if($glow == false) {
					$pdo->query("UPDATE users SET glow = 1 WHERE id = ".$userID);
					$glow = 1;
				}
			} else {
				if($glow == true) {
					$pdo->query("UPDATE users SET glow = 0 WHERE id = ".$userID);
					$glow = 0;
				}
			}
			$logAction = $do->logAction("change_theme", $userID, $do->encode($do->getip()));
			$changeThemeError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed theme. Refresh to take effect</div>';
			if ($checkIfHexCool == false) {
				$changeThemeError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Hex code invalid</div>';
			}
		}
	}
}

if(isset($_POST['chgdscrtnbtn'])) {
	if($page == 'settings') {
		if($loggedin == true) {
			if(strlen($_POST['dscrptintxtbx']) > 8 && strlen($_POST['dscrptintxtbx']) < 2048) {
				$updBlurb = $pdo->prepare("UPDATE users SET blurb=:bl WHERE id=".$userID);
				$updBlurb->bindParam(":bl", $_POST['dscrptintxtbx'], PDO::PARAM_STR);
				if($updBlurb->execute()) {
					$logAction = $do->logAction("change_blurb", $userID, $do->encode($do->getip()));
					$changeDescriptionError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully changed description</div>';
				} else {
					$changeDescriptionError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Unknown error while changing blurb</div>';
				}
			} else {
				$changeDescriptionError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Description must be more than 8 characters and less than 256 characters.</div>';
			}
		}
	}
}

if($maintenancePage == true) {
	if(isset($_POST['sbmlgtmbtn'])) {
		$query = $pdo->prepare("SELECT id,password,letter,rank FROM users WHERE id = :uid");
		$query->bindParam("uid", $_POST['i1'], PDO::PARAM_STR);
		$query->execute();
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			
			if(password_verify($_POST['pw1'], $result->password) && $_POST['i2'] == $result->letter && $result->rank == 2 && password_verify($_POST['pw2'], $maintenancePW)) {
				$_SESSION['session'] = $result->id;
				$_SESSION['maintenanceSesh'] = true;
				$logAction = $do->logAction("log_into_mt", $userID, $do->encode($do->getip()));
				echo '<meta http-equiv="refresh" content="0;url='.$url.'/home.php" />';
				die();
			}
		}
	}
}
/*if(isset($asset_id_page)) {
	if($betaTester == true) {
		if(isset($_POST['changeCharApp'])) {
			$rerender = false;
			$query = $pdo->prepare("SELECT * FROM custom_char_app WHERE uid = :uid");
			$query->bindParam("uid", $userID, PDO::PARAM_INT);
			$query->execute();
			if ($query->rowCount() > 0) {
				$changeCharApp = $pdo->prepare("UPDATE custom_char_app SET url = :url, upd_on = ".time()." WHERE uid = ".$userID);
				$changeCharApp->bindParam(":url", $_POST['charapptxt'], PDO::PARAM_STR);
				if($changeCharApp->execute()) {
					$logAction = $do->logAction("changeCharApp", $userID, $do->encode($do->getip()));
					$changeCharAppError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully updated character appearence (rendering in process)</div>';
					$rerender = true;
				} else {
					$changeCharAppError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while updating character appearence</div>';
				}
			} else {
				$insertCharApp = $pdo->prepare("INSERT INTO custom_char_app(uid, url, add_on, upd_on) VALUES(".$userID.", :url, ".time().", 0)");
				$insertCharApp->bindParam(":url", $_POST['charapptxt'], PDO::PARAM_STR);
				if($insertCharApp->execute()) {
					$logAction = $do->logAction("addCharApp", $userID, $do->encode($do->getip()));
					$changeCharAppError = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully added character appearence (rendering in process)</div>';
					$rerender = true;
				} else {
					$changeCharAppError = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while adding character appearence</div>';
				}
			}
			if($rerender == true) {
				if($pdo->query("SELECT * FROM render_user WHERE uid = ".$userID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
					$addCharAppRender = $pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$userID.", 0, ".time().")");
				}
			}
		}
		if(isset($_POST['sendRenderRequest'])) {
			if($pdo->query("SELECT * FROM render_user WHERE uid = ".$userID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
				if($pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$userID.", 0, ".time().")")) {
					$logAction = $do->logAction("sendRenderReqs", $userID, $do->encode($do->getip()));
					$sendCharAppReqs = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Sent render request</div>';
				} else {
					$sendCharAppReqs = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while sending render request</div>';
				}
			} else {
				$sendCharAppReqs = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Render request already pending</div>';
			}
		}
	}
}*/
if($page == 'linkdiscordacc') {
	if(isset($_POST['unlinkacc'])) {
		if($pdo->query("UPDATE registered_discord_users SET valid = 0 WHERE uid = ".$userID)) {
			$unlinkaccerror = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Succesfully unlinked accounts! Please wait upto 1 minute for changes to take effect.</div>';
		} else {
			$unlinkaccerror = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Unknown error occured while unlinking accounts</div>';
		}
	}
}

if($page == 'editgame') {
	if(isset($_POST['editMainGameSettings'])) {
	    if($do->ifGameExists($_GET['id'])) {
	        $gameID = $_GET['id'];
	        if($do->whoOwnGame($gameID, $userID) == true) {
	            $gameTitle = $_POST['gamename'];
	            $gameDesc = $_POST['gamedesc'];
	            $thumbnail = $_POST['thmburl'];
				if(strlen($gameTitle) < 3 || strlen($gameTitle) > 32) {
					$gameError = '
						<div class="toast toast-error">
							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The game title must be atleast 3 characters but less than 32.
						</div>';
				} else {
					if(strlen($gameDesc) > 256) {
						$gameError = '
							<div class="toast toast-error">
								&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;The game description cannot be more than 256 characters.
							</div>';
					} else {
        				if(strlen($thumbnail) > 256) {
        					$gameError = '
        						<div class="toast toast-error">
        							&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Thumbnail link cannot be more than 256 characters.
        						</div>';
        				} else {
        					$createGame = $pdo->prepare("UPDATE games SET name = :n, description = :d, image = :i, image_approved = 0, updated = UNIX_TIMESTAMP() WHERE id = :gmid");
        					$createGame->bindParam(":n", $gameTitle, PDO::PARAM_STR);
        					$createGame->bindParam(":d", $gameDesc, PDO::PARAM_STR);
        					$createGame->bindParam(":i", $thumbnail, PDO::PARAM_STR);
        					$createGame->bindParam(":gmid", $gameID, PDO::PARAM_INT);
        					$createGame->execute();
        		    	}
        	        }
        	    }
	        }
        }
	}
}

if(isset($profile)) {
    if(isset($_POST['userIDRender'])) {
        if($rank == 2) {
            $renderID = $do->getUsername($_POST['userIDRender']);
            if($renderID !== "????") {
               $renderID = $_POST['userIDRender'];
        		if($pdo->query("SELECT * FROM render_user WHERE uid = ".$renderID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
        			if($pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$renderID.", 0, ".time().")")) {
        				$logAction = $do->logAction("sendRenderReqsForUserId", $renderID, $do->encode($do->getip()));
        				$sendCharAppReqs = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Sent render request</div>';
        			} else {
        				$sendCharAppReqs = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while sending render request</div>';
        			}
        		} else {
        			$sendCharAppReqs = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Render request already pending</div>';
        		}
            } else {
    			$sendCharAppReqs = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;User doesn\'t exist</div>';
    		}
        }
    }
}
?>
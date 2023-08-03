<?php

//created by KJF 2017. do not steal or copy this page's contents.
class functions
{
	function checkIfFiltered($string) {
		
		$filters = array("anal","sex","boob","fuck","shit","penis","dick","d1ck","vagina","gay","pussy","vegina","kjf","kys","gtfo","stfu","energycell","faggot");
		foreach ($filters as $filter) {
			if (strpos(strtolower($string), $filter) !== FALSE) {
				return true;
			}
		}
		return false;
		//return in_array(strtolower($string), array_map('strtolower', $filter));
		
	}
	
	public function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
	{
		$str = '';
		$max = mb_strlen($keyspace, '8bit') - 1;
		for ($i = 0; $i < $length; ++$i) {
			$str .= $keyspace[random_int(0, $max)];
		}
		return $str;
	}

    public function login($username, $password)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
            $query = $pdo->prepare("SELECT id,password FROM users WHERE username = :username");
            $query->bindParam("username", $username, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
				
				if(password_verify($password, $result->password)) {
					//create token
					$token = $GLOBALS['Login']->random_str(32);
					$ip = $GLOBALS['Login']->encode($GLOBALS['Login']->getip());
					$createToken = $pdo->prepare("INSERT INTO logged_in_sessions(token, uid, ip, useragent, when_created) VALUES('".$token."', ".$result->id.", :ip, :ua, ".time().")");
					$createToken->bindParam(":ip", $ip, PDO::PARAM_STR);
					$createToken->bindParam(":ua", $_SERVER['HTTP_USER_AGENT'], PDO::PARAM_STR);
					$createToken->execute();
					setcookie("token", $token, time() + (86400 * 7), "/", ".otorium.xyz", TRUE);
					$_SESSION['session'] = $result->id;
					return true;
				} else {
					return false;
				}
				
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	public function getUsername($id)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			if(!(isset($pdo))) {
				include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
			}
			if(is_numeric($id)) {
                $query = $pdo->prepare("SELECT username FROM users WHERE id=:id");
                $query->bindParam(":id", $id, PDO::PARAM_STR);
    			
                $query->execute();
                if ($query->rowCount() > 0) {
                    $result = $query->fetch(PDO::FETCH_OBJ);
    				
    				return $result->username;
    				
                } else {
                    return "????";
                }
			} else {
			    return "????";
			}
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	public function old_usernames($id)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';

            $query = $pdo->prepare("SELECT username FROM old_usernames WHERE uid=:id");
            $query->bindParam(":id", $id, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetchAll(PDO::FETCH_ASSOC);
				$uns = 0;
				foreach ($result as $username) {
					$uns = $uns + 1;
					if($uns == 1) {
						$returnUsernames = $username['username'];
					} else {
						$returnUsernames = $returnUsernames.", ".$username['username'];
					}
				}
				return $returnUsernames;
				
            } else {
                return false;
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	public function old_usernames_num($id)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';

            $query = $pdo->prepare("SELECT username FROM old_usernames WHERE uid=:id");
            $query->bindParam(":id", $id, PDO::PARAM_STR);
            $query->execute();
            return $query->rowCount();
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	public function ifUsernameExists($username)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';

            $query = $pdo->prepare("SELECT username FROM users WHERE username=:id");
            $query->bindParam(":id", $username, PDO::PARAM_STR);
			
            $query->execute();
            if ($query->rowCount() > 0) {
				return true;
            } else {
				$query2 = $pdo->prepare("SELECT * FROM old_usernames WHERE username = :un");
				$query2->bindParam(":un", $username, PDO::PARAM_STR);
				$query2->execute();
				if ($query2->rowCount() > 0) {
					return true;
				} else {
					return false;
				}
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	function getUserInfo($username, $info)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			if(!(isset($pdo))) {
				include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
			}

            $query = $pdo->prepare("SELECT * FROM users WHERE username=:un");
            $query->bindParam(":un", $username, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);				
				return $result->$info;
            } else {
                return false;
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	function getUserMembership($userID)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			if(!(isset($pdo))) {
				include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
			}

            $query = $pdo->prepare("SELECT * FROM users WHERE id=:un");
            $query->bindParam(":un", $userID, PDO::PARAM_INT);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
				$donatedMoney = $result->donated;
				$whenDonated = $result->when_donated;
				if($donatedMoney == 0 || $whenDonated == "") {
					return false;
				} else {
					//membership type,  when donated, when end
					if($donatedMoney < 6) {
						$membershipType = 1;
						$whenEnd = $whenDonated + ((86400 * 4) * $donatedMoney); //86400 seconds = 1day, bc rate = 4 days / $1
					} elseif($donatedMoney < 21) {
						$membershipType = 2;
						$whenEnd = $whenDonated + ((86400 * 3) * $donatedMoney); //86400 seconds = 1day, tbc rate = 3 days / $1
					} elseif($donatedMoney > 21) {
						$membershipType = 3;
						$whenEnd = $whenDonated + ((86400 * 2) * $donatedMoney); //86400 seconds = 1day, obc rate = 2 days / $1
					}
					if(time() > $whenEnd) {
						$pdo->query("UPDATE users SET donated = 0, when_donated = null WHERE id = ".$userID);
						return false;
					} else {
						return array($membershipType, $whenDonated, $whenEnd);
					}
				}
            } else {
                return false;
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	function getAssetInfo($assetID, $info)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			if(!(isset($pdo))) {
				include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
			}

            $query = $pdo->prepare("SELECT * FROM asset_items WHERE id=:id");
            $query->bindParam(":id", $assetID, PDO::PARAM_STR);
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);				
				return $result->$info;
            } else {
                return false;
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	public function logAction($action, $username, $ip)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';

            $query = $pdo->prepare("INSERT INTO actions(action, ip, user_agent, action_time, account_uid) VALUES(:ac, :ip, :ua, ".time().", :uid)");
            $query->bindParam(":ac", $action, PDO::PARAM_STR);
            $query->bindParam(":ip", $ip, PDO::PARAM_STR);
            $query->bindParam(":ua", $_SERVER['HTTP_USER_AGENT'], PDO::PARAM_STR);
            $query->bindParam(":uid", $username, PDO::PARAM_STR);
            if ($query->execute()) {
				return true;
            } else {
                return false;
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	public function getHelpTopicTitle($id)
    {
        try {
			include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';

            $query = $pdo->prepare("SELECT text_only_title FROM help_topics WHERE id=:id");
            $query->bindParam("id", $id, PDO::PARAM_STR);
			
            $query->execute();
            if ($query->rowCount() > 0) {
                $result = $query->fetch(PDO::FETCH_OBJ);
				
				return $result->text_only_title;
				
            } else {
                return "????";
            }
			
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
	
	public function noXSS($text)
    {
		$text2 = nl2br(htmlentities($text));
        return $text2;
    }
	
	function getip()
	{
		if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
		{
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
		{
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}
		else
		{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}
	
	function getVersion($num)
	{
		if ($num == 0) {
			$ver = '2010';
		}
		elseif ($num == 1)
		{
			$ver = '2008';
		}
		else
		{
			$ver = '????';
		}
		return $ver;
	}
	
	function checkIfBanned($userID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query2 = $pdo->prepare("SELECT * from bans WHERE uid=:uid ORDER BY id DESC LIMIT 1");
		$query2->bindParam("uid", $userID, PDO::PARAM_STR);
		$query2->execute();
		if($query2->rowCount() == 1) {
			$query2inf = $query2->fetch(PDO::FETCH_OBJ);
			if($query2inf->activated == false) {
				return true;
			} else {
				return false;
			}
		}
		
	}
	
	function checkIfStaff($userID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT rank FROM users WHERE id=:uid");
		$query->bindParam("uid", $userID, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			//user exists, check rank
			$results = $query->fetch(PDO::FETCH_OBJ);
			if($results->rank == 1 || $results->rank == 2) {
				return true; //user is staff member
			} else {
				return false; //user is not staff
			}
		} else {
			return false; //user does not exist, so is not staff.
		}
	}
	
	function getRank($userID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT rank FROM users WHERE id=:uid");
		$query->bindParam("uid", $userID, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			//user exists, check rank
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->rank;
			
		} else {
			return 0; //user does not exist, so is not staff.
		}
	}
	
	function whoOwnPost($postID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_posts WHERE id=:pid");
		$query->bindParam("pid", $postID, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->poster;
			
		} else {
			return false; //user does not exist
		}
	}
	
	function checkIfBlocked($uID, $bID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM blocked_users WHERE (uid=:uid AND pid=:pid) OR (uid=:apid AND pid=:auid)");
		$query->bindParam("uid", $uID, PDO::PARAM_STR);
		$query->bindParam("pid", $bID, PDO::PARAM_STR);
		$query->bindParam("auid", $uID, PDO::PARAM_STR);
		$query->bindParam("apid", $bID, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			//Blocked, check who blocked
			$results = $query->fetch(PDO::FETCH_OBJ);
			if($results->uid == $uID) {
				return 2; //You blocked user
			} elseif($results->pid == $uID) {
				return 1; //User blocked you
			} else {
				return false; //Unknown error, return not blocked for fallback
			}
		} else {
			return false; //Not Blocked
		}
	}
	function checkIfFriends($uID, $bID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM friends WHERE (uid=:uid AND fid=:pid) OR (uid=:apid AND fid=:auid)");
		$query->bindParam("uid", $uID, PDO::PARAM_STR);
		$query->bindParam("pid", $bID, PDO::PARAM_STR);
		$query->bindParam("auid", $uID, PDO::PARAM_STR);
		$query->bindParam("apid", $bID, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			//Friends, check who added
			$results = $query->fetch(PDO::FETCH_OBJ);
			if($results->uid == $uID) {
				return 2; //You added user
			} elseif($results->fid == $uID) {
				return 1; //User added you
			} else {
				return false; //Unknown error, return not friends for fallback
			}
		} else {
			return false; //Not friends
		}
	}
	
	function getCategoryName($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_topics WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->title;
		} else {
			return "Not Available"; //Not Found
		}
	}
	
	function getCategoryDesc($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_topics WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->body;
		} else {
			return "This category is not available. Please go back and try again."; //Not Found
		}
	}
	
	function getCategoryPosts($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_posts WHERE topics_id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		return $query->rowCount();
	}
	
	function ifcategoryAvailable($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_topics WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true;
		} else {
			return false; //Not Found
		}
	}
	
	function ifPostExists($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_posts WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true;
		} else {
			return false; //Not Found
		}
	}
	
	function ifGameExists($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true;
		} else {
			return false; //Not Found
		}
	}
	
	function GameName($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result->name;
		} else {
			return "Game not found"; //Not Found
		}
	}
	
	function ifGameAvailable($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
			
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0 AND available = 1");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true;
		} else {
			return false;
		}
	}
	
	function getGameUserIn($uid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
			
		$query = $pdo->prepare("SELECT * FROM ingame_players WHERE uid = :uid AND last_pinged > ".(time() - 61)." ORDER BY `id` DESC LIMIT 1");
		$query->bindParam("uid", $uid, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$gameInfo1 = $query->fetch(PDO::FETCH_OBJ);
			return $pdo->query("SELECT * FROM games WHERE id = ".$gameInfo1->gid)->fetch(PDO::FETCH_OBJ);
		} else {
			return false;
		}
	}
	
	function whoOwnGame($id, $userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			if($result->creator == $userid) {
				return true;
			} else {
				return false;
			}
		} else {
			return false; //Not Found
		}
	}
	
	function ifcategoryLocked($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_topics WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			if($results->locked == true) {
				return true;
			} else {
				return false;
			}
		} else {
			return false; //Not Found
		}
	}
	
	function ifPostLocked($id)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_posts WHERE id=:id AND deleted=0");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			if($results->locked == true) {
				return true;
			} else {
				return false;
			}
		} else {
			return false; //Not Found
		}
	}
	
	function lastposttime($userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_posts WHERE poster=:id ORDER BY `id` DESC LIMIT 1");
		$query->bindParam("id", $userid, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->time_posted;
		} else {
			return 0; //Not Found
		}
	}
	
	function AmountOfFriends($userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM friends WHERE uid = :uid OR fid = :fid");
		$query->bindParam("uid", $userid, PDO::PARAM_INT);
		$query->bindParam("fid", $userid, PDO::PARAM_INT);
		$query->execute();
		return $query->rowCount();
	}
	
	function AmountOfFriendRequests($userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query1 = $pdo->prepare("SELECT * FROM friend_requests WHERE sid = :sid AND accepted IS NULL");
		$query1->bindParam("sid", $userid, PDO::PARAM_INT);
		$query1->execute();
		
		if($query1->rowCount() > 0) {
			$results = $query1->fetchAll(PDO::FETCH_ASSOC);
			$friendRequests = 0;
			foreach ($results as $uid) {
				if($uid['accepted'] == null) {
					if($uid['sid'] == $userid) {
						$friendRequests = $friendRequests + 1; //friend send
					}
				}
			}
			return $friendRequests;
		} else {
			return 0; //Not Found
		}
		
	}
	
	function sendRenderRequest($userID) {
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		if($pdo->query("SELECT * FROM render_user WHERE uid = ".$userID." AND rendered = 0 ORDER BY `id` DESC LIMIT 1")->rowCount() == 0) {
			if($pdo->query("INSERT INTO render_user(uid, rendered, timestamp) VALUES(".$userID.", 0, ".time().")")) {
				$logAction = $GLOBALS['do']->logAction("sendRenderReqs", $userID, $GLOBALS['do']->encode($GLOBALS['do']->getip()));
				$sendCharAppReqs = '<div class="toast toast-success">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Sent render request</div>';
			} else {
				$sendCharAppReqs = '<div class="toast toast-error">&nbsp;<i class="fa fa-times"></i>&nbsp;&nbsp;Error while sending render request</div>';
			}
		} else {
			$sendCharAppReqs = '<div class="toast toast-warning">&nbsp;<i class="fa fa-exclamation"></i>&nbsp;&nbsp;Render request already pending</div>';
		}
	}
	
	function hasFriendRequest($userid, $friendid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query1 = $pdo->prepare("SELECT * FROM friend_requests WHERE (uid = :uid OR sid = :sid) AND accepted IS NULL");
		$query1->bindParam("uid", $userid, PDO::PARAM_INT);
		$query1->bindParam("sid", $userid, PDO::PARAM_INT);
		$query1->execute();
		
		if($query1->rowCount() > 0) {
			$results = $query1->fetchAll(PDO::FETCH_ASSOC);
			$hasFriendRequest = false;
			foreach ($results as $uid) {
				if($uid['accepted'] == null) {
					if($uid['uid'] == $userid && $uid['sid'] == $friendid) {
						$hasFriendRequest = 1; //u send
					} elseif ($uid['uid'] == $friendid && $uid['sid'] == $userid) {
						$hasFriendRequest = 2;  //friend send
					}
				}
			}
			return $hasFriendRequest;
		} else {
			return false; //Not Found
		}
		
	}
	
	function lastreplytime($userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM forum_replies WHERE poster=:id ORDER BY `id` DESC LIMIT 1");
		$query->bindParam("id", $userid, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->time_posted;
		} else {
			return 0; //Not Found
		}
	}
	function canApproveItem($itemID, $rank)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM asset_items WHERE id=:id");
		$query->bindParam("id", $itemID, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			$approve = false;
			if($results->type == 2) {
				if($rank == 1) {
					$approve = true;
				}
			} elseif($results->type == 11) {
				if($rank == 1) {
					$approve = true;
				}
			} elseif($results->type == 12) {
				if($rank == 1) {
					$approve = true;
				}
			}
			if($rank == 2) {
				$approve = true;
			} 
			return $approve;
		} else {
			return false; //Not Found
		}
	}
	
	function ifUserHasBadge($userid, $badgeid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("SELECT * FROM badges_owned WHERE uid = :id and bid = :bid");
		$query->bindParam("id", $userid, PDO::PARAM_INT);
		$query->bindParam("bid", $badgeid, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true; // found
		} else {
			return false; //Not Found
		}
	}
	function ifUserWearingItem($userid, $itemid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("SELECT * FROM wearing_items WHERE uid = :id and itemID = :iid");
		$query->bindParam("id", $userid, PDO::PARAM_INT);
		$query->bindParam("iid", $itemid, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true; // found
		} else {
			return false; //Not Found
		}
	}
	function ifUserHasAsset($userid, $itemid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("SELECT * FROM assets_owned WHERE uid = :id and itemid = :iid");
		$query->bindParam("id", $userid, PDO::PARAM_INT);
		$query->bindParam("iid", $itemid, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true; // found
		} else {
			return false; //Not Found
		}
	}
	
	function getCustomAssetInfo($assetID, $info)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("SELECT * FROM custom_assets WHERE aid = :id");
		$query->bindParam("id", $assetID, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			return $result->$info;
		} else {
			return false; //Not Found
		}
	}
	
	function isCustomAsset($assetID)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("SELECT * FROM asset_items  WHERE id = :id AND custom_asset = 1");
		$query->bindParam("id", $assetID, PDO::PARAM_INT);
		$query->execute();
		
		if($query->rowCount() > 0) {
			return true; //custom asset
		} else {
			return false; //not custom asset
		}
	}
	
	function giveBadge($userid, $badgeid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
		if(!(isset($pdo))) {
			include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
		}
		$query = $pdo->prepare("INSERT INTO badges_owned(uid, bid, earnon) VALUES(:id, :bid, ".time().")");
		$query->bindParam("id", $userid, PDO::PARAM_STR);
		$query->bindParam("bid", $badgeid, PDO::PARAM_STR);
		if($query->execute()) {
			return true; // Given
		} else {
			return false; //Error
		}
	}
	
	function getbadge($id, $uid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM badges WHERE id=:id");
		$query->bindParam("id", $id, PDO::PARAM_STR);
		$query->execute();
		if ($query->rowCount() == 1) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			
			$query2 = $pdo->prepare("SELECT * FROM badges_owned WHERE uid=:id AND bid=:bid");
			$query2->bindParam("id", $uid, PDO::PARAM_STR);
			$query2->bindParam("bid", $id, PDO::PARAM_STR);
			$query2->execute();
			
			if ($query2->rowCount() == 1) {
				$result2 = $query2->fetch(PDO::FETCH_OBJ);
				return '
				<div class="popover popover-top column col-sm-11">
				  <img src="'.$GLOBALS['cdn'].'/badges/'.$result->pngname.'.png?v=1" height="64" />
				  <div class="popover-container">
					<div class="card" style="background-color: '.$GLOBALS['bg_color_1'].'; border:1px solid '.$GLOBALS['border_color'].';">
					  <div class="card-header">
						<h4>'.$result->name.'</h4>
					  </div>
					  <div class="card-body">
						'.$result->description.'
					  </div>
					  <div class="card-footer">
						<small>Earned on '.date("F d Y, g:i:s A", $result2->earnon).'</small>
					  </div>
					</div>
				  </div>
				</div>';
			} else {
				return '
				<div class="popover popover-top column col-sm-11">
				  <img src="'.$url.'/cdn/badges/3_question_marks_1.png?v=1" height="64" />
				  <div class="popover-container">
					<div class="card">
					  <div class="card-header">
						<h4>?</h4>
					  </div>
					  <div class="card-body">
						User does not own badge
					  </div>
					</div>
				  </div>
				</div>';
			}
			
		} else {
			return '
			<div class="popover popover-top column col-sm-11">
			  <img src="'.$url.'/cdn/badges/3_question_marks_1.png?v=1" height="64" />
			  <div class="popover-container">
				<div class="card">
				  <div class="card-header">
					<h4>?</h4>
				  </div>
				  <div class="card-body">
					Unknown badge
				  </div>
				</div>
			  </div>
			</div>';
		}
		
	}
	
	function encode( $string, $action = 'e' ) {
		// you may change these values to your own
		$secret_key = 'soZ5oElgxSA6y7iDtIjhbaK7qWDPQR0dfu4MR4z5CyazfThvVQ5kOW7UxMFT76pTZG2TdgDsdVX3EBt9nlhIa2mkWJ95lhSeAEkJ';
		$secret_iv = 'wQ7jogYfJvMNO7189h9EcToOpNYhYwjX6iOa9xeSUUvxnLvmnarDDGf1HPlN5k54ckfJe3IenWL1xKfkndywENCcvLC7wxioKjHj';
	 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
		if( $action == 'e' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	 
		return $output;
	} 
	function isValidColor($colorCode) {
		// If user accidentally passed along the # sign, strip it off
		$colorCode = ltrim($colorCode, '#');

		if (
			  ctype_xdigit($colorCode) &&
			  (strlen($colorCode) == 6 || strlen($colorCode) == 3))
				   return true;

		else return false;
	}
	function getAssetType($assetID) {
		if($assetID == 2) {
			$type = "T-Shirt";
		} elseif($assetID == 8) {
			$type = "Hat";
		} elseif($assetID == 11) {
			$type = "Shirt";
		} elseif($assetID == 12) {
			$type = "Pants";
		} elseif($assetID == 17) {
			$type = "Head";
		} elseif($assetID == 18) {
			$type = "Face";
		} elseif($assetID == 19) {
			$type = "Gear";
		} elseif($assetID == 28) {
			$type = "Right Arm";
		} elseif($assetID == 29) {
			$type = "Left Arm";
		} elseif($assetID == 30) {
			$type = "Left Leg";
		} elseif($assetID == 31) {
			$type = "Right Leg";
		} elseif($assetID == 32) {
			$type = "Package";
		} elseif($assetID == 41) {
			$type = "Hair Accessory";
		} elseif($assetID == 42) {
			$type = "Face Accessory";
		} elseif($assetID == 43) {
			$type = "Neck Accessory";
		} elseif($assetID == 44) {
			$type = "Shoulder Accessory";
		} elseif($assetID == 45) {
			$type = "Front Accessory";
		} elseif($assetID == 46) {
			$type = "Back Accessory";
		} elseif($assetID == 47) {
			$type = "Waist Accessory";
		} else {
			$type = "?";
		}
		return $type;
	}
	function AssetMaxMoney($assetID) {
		if($assetID == 2) {
			$type = 999;
		} elseif($assetID == 8) {
			$type = 9223372036854775807;
		} elseif($assetID == 11) {
			$type = 999;
		} elseif($assetID == 12) {
			$type = 999;
		} elseif($assetID == 17) {
			$type = 9223372036854775807;
		} elseif($assetID == 18) {
			$type = 9223372036854775807;
		} elseif($assetID == 19) {
			$type = 9223372036854775807;
		} elseif($assetID == 28) {
			$type = 9223372036854775807;
		} elseif($assetID == 29) {
			$type = 9223372036854775807;
		} elseif($assetID == 30) {
			$type = 9223372036854775807;
		} elseif($assetID == 31) {
			$type = 9223372036854775807;
		} elseif($assetID == 32) {
			$type = 9223372036854775807;
		} elseif($assetID == 41) {
			$type = 9223372036854775807;
		} elseif($assetID == 42) {
			$type = 9223372036854775807;
		} elseif($assetID == 43) {
			$type = 9223372036854775807;
		} elseif($assetID == 44) {
			$type = 9223372036854775807;
		} elseif($assetID == 45) {
			$type = 9223372036854775807;
		} elseif($assetID == 46) {
			$type = 9223372036854775807;
		} elseif($assetID == 47) {
			$type = 9223372036854775807;
		} else {
			$type = 0;
		}
		return $type;
	}
	function bb_parse($string) { 
		$search = array(
			 '#\[b\](.*?)\[/b\]#',
			 '#\[i\](.*?)\[/i\]#',
			 '#\[u\](.*?)\[/u\]#',
			 '#\[img\](.*?)\[/img\]#',
			 '#\[url=(.*?)\](.*?)\[/url\]#',
			 '#\[code\](.*?)\[/code\]#',
			 '#\[center\](.*?)\[/center\]#',
			 '#\[large\](.*?)\[/large\]#',
			 '#\[small\](.*?)\[/small\]#',
			 '#\[hl\](.*?)\[/hl\]#',
			 '#\[quote=(.*?)\](.*?)\[/quote\]#',
			 '#\[color=(.*?)\](.*?)\[/color\]#',
			 '#\[strike\](.*?)\[/strike\]#',
			 '#\[sup\](.*?)\[/sup\]#',
			 '#\[sub\](.*?)\[/sub\]#',
			 '#\[youtube\](.*?)\[/youtube\]#'
		);
		$replace = array(
			 '<b>\\1</b>',
			 '<i>\\1</i>',
			 '<u>\\1</u>',
			 '<img src="\\1" style="max-height:25%; max-width:25%;">',
			 '<a href="\\1">\\2</a>',
			 '<code>\\1</code>',
			 '<div style="text-align:center;">\\1</div>',
			 '<a style="text-decoration:none; color:inherit; font-size:24px;">\\1</a>',
			 '<a style="text-decoration:none; color:inherit; font-size:10px;">\\1</a>',
			 '<mark>\\1</mark>',
			 '<blockquote><p>\\2</p><cite>\\1</cite></blockquote>',
			 '<span style="color: \\1">\\2</span>',
			 '<s>\\1</s>',
			 '<sup>\\1</sup>',
			 '<sub>\\1</sub>',
			 '<iframe height="220" width="400" src="https://www.youtube.com/embed/\\1" frameborder="0" allowfullscreen></iframe>'
		);
		$bbString = preg_replace($search, $replace, $string);
		$bbString = str_replace("[lb]", "<br />", $bbString);
		return $bbString;
	} 
	//User Setting Functions
	
	function getMessageSetting($userid)
	{
		include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
			
		$query = $pdo->prepare("SELECT * FROM user_settings WHERE uid=:id");
		$query->bindParam("id", $userid, PDO::PARAM_STR);
		$query->execute();
		
		if($query->rowCount() > 0) {
			$results = $query->fetch(PDO::FETCH_OBJ);
			return $results->msgs;
		} else {
			return null; //Not Found
		}
	}
	
	function triggerError($string, $type)
	{
		if($type == 1) {
			$errtype = E_USER_NOTICE;
		} elseif ($type == 2) {
			$errtype = E_USER_WARNING;
		} elseif ($type == 3) {
			$errtype = E_USER_ERROR;
		}
		trigger_error($string, $errtype);
	}
}
?>
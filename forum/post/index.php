<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
			if(($rank == 1) || ($rank == 2)) {
				echo '<script src="'.$url.'/api/js/forumActions.js?v=004"></script>';
			}	?>
</head>
<body>

<div class="sides">
  <?php
$buttons = null;
$post_q = $pdo->prepare("SELECT * FROM forum_posts WHERE id=:id");
$post_q->bindParam("id", $_GET['id'], PDO::PARAM_STR);
$post_q->execute();

if ($post_q->rowCount() == 1) {
	$post = $post_q->fetch(PDO::FETCH_OBJ);
	$icons = null;
	$pagenum = 0;
	$apagenum = 1;
	if($post->deleted == true) {
		echo '<h3>Post not found</h3></div>';
		goto FooterPart;
	}
	if($do->ifcategoryAvailable($post->topics_id) == false) {
		echo '<h3>Post not available</h3></div>';
		goto FooterPart;
	}
	if(isset($_GET['page'])) {
		if(is_numeric($_GET['page'])) {
			$apagenum = $_GET['page'];
			if($_GET['page'] == 0 || $_GET['page'] == 1) {
				$pagenum = 0;
			} else {
				$pagenum = ($_GET['page'] * 10) - 10;
			}
		}
	}
	if($post->locked == true) {
		$icons = '<i class="fa fa-lock" title="This forum topic is locked"></i>&nbsp;&nbsp;';
	}
	if($post->pinned == true) {
		$icons = $icons.'<i class="fa fa-thumb-tack" title="This forum topic is pinned"></i>&nbsp;&nbsp;'; 
	}
	$posterRank = $do->getRank($post->poster);
	//Button Stuff
	if(!($posterRank == 2)) {
		if($post->locked == false) {
			$buttons = '<button class="btn" onclick="openmodal(\'addreply\')">Add Reply</button>';
			if(($rank == 1) || ($rank == 2)) {
				$buttons = $buttons.'<button class="btn" onclick="lockPost('.$post->id.')">Lock Post</button>';
			}
		} else {
			if(($rank == 1) || ($rank == 2)) {
				$buttons = $buttons.'<button class="btn" onclick="unlockPost('.$post->id.')">Unlock Post</button>';
			}
		}
		if($post->pinned == true) {
			if($rank == 2) {
				$buttons = $buttons.'<button class="btn" onclick="unpinPost('.$post->id.')">Unpin Post</button>';
			}
		} else {
			if($rank == 2) {
				$buttons = $buttons.'<button class="btn" onclick="pinPost('.$post->id.')">Pin Post</button>';
			}
		}
		if(($rank == 1) || ($rank == 2)) {
			$buttons = $buttons.'<button class="btn" onclick="deletePost('.$post->id.')">Delete Post</button>';
		}
	} else {
		if($posterRank == $rank) {
			if($post->locked == false) {
				$buttons = '<button class="btn" onclick="openmodal(\'addreply\')">Add Reply</button>';
				if(($rank == 1) || ($rank == 2)) {
					$buttons = $buttons.'<button class="btn" onclick="lockPost('.$post->id.')">Lock Post</button>';
				}
			} else {
				if(($rank == 1) || ($rank == 2)) {
					$buttons = $buttons.'<button class="btn" onclick="unlockPost('.$post->id.')">Unlock Post</button>';
				}
			}
			if($post->pinned == true) {
				if($rank == 2) {
					$buttons = $buttons.'<button class="btn" onclick="unpinPost('.$post->id.')">Unpin Post</button>';
				}
			} else {
				if($rank == 2) {
					$buttons = $buttons.'<button class="btn" onclick="pinPost('.$post->id.')">Pin Post</button>';
				}
			}
			if(($rank == 1) || ($rank == 2)) {
				$buttons = $buttons.'<button class="btn" onclick="deletePost('.$post->id.')">Delete Post</button>';
			}
		} else {
			if($post->locked == false) {
				$buttons = '<button class="btn" onclick="openmodal(\'addreply\')">Add Reply</button>';
			}
		}
	}
	$opposterusername = $do->getUsername($post->poster);
	$opposterlastseen = $do->getUserInfo($opposterusername, "lastseen");
	if(($opposterlastseen + 300) > time()) {
		$status = '#82DD55';
	} else {
		$status = '#E23636';
	}
	echo '<h3>'.$icons.'Post title: '.$do->noXSS($post->title).'</h3>
	
	<h5>Original Post</h5><br /><br />
	<div class="tile" style="padding:7px; padding-bottom:1px; box-shadow: 0px 0px 25px rgba(20,120,240,0.5);">
	  <div onclick="window.location.href = \''.$url.'/profile/'.$opposterusername.'\'" class="tile-icon" style="cursor: pointer; padding:10px;display: table; width: 77px; height:77px; border: 1px solid '.$status.'; box-shadow: 0px 0px 16px '.$status.'; cursor: pointer; font-size: 1.75em; style">
		<img width="64" src="'.$userImages.$post->poster.'.png?tick='.time().'" style="display: table-cell; vertical-align: middle; text-align: center;"/>
	  </div>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	  <div class="tile-content">
		<p class="tile-title"><a href="'.$url.'/profile/'.$opposterusername.'">'.$opposterusername.'</a><a class="float-right" style="text-decoration:none; color:#acb3c2;">at '.date("M d, Y g:i A", $post->time_posted).'</a></p>
		<p class="tile-subtitle" style="color:'.$txt_color.';">'.$do->bb_parse($do->noXSS($post->body)).'</p>
	  </div>
	</div>
	<br />
	<br />
	<div class="btn-group float-right">
		'.$buttons.'
	</div>
	<h5>Replies</h5>
	<br />';
	
	if($post->locked == false) {
		echo '<div id="addreplyFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

		<div id="addreply" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
			<div id="result"></div>
			<h4>New Reply</h4>
			<div class="form-group">
				<label class="form-label">Body</label>
				<textarea class="form-input" id="rbody" maxlength="256" placeholder="I am a shiny apple" required rows="2"></textarea>
			</div>
			<div class="btn-group float-right">
			  <button class="btn" onclick="closemodal(\'addreply\')" id="cancelbtn">Cancel</button>
			  <button class="btn btn-primary" onclick="sendReply('.$post->id.')" id="replybtn">Send Reply</button>
			</div>
			<br />
		</div>

		</div>';
		echo '<script src="'.$url.'/api/js/createReply.js?v=002"></script>';
	}
	echo '<div id="msgFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

		<div id="msg" class="anim" style="margin: 7.5% auto;">
		
		</div>

		</div>';
	$posts_q = $pdo->prepare("SELECT * FROM forum_replies WHERE post_id=:pid ORDER BY `id` ASC LIMIT 10 OFFSET :pagenum");
	$posts_q->bindParam("pid", $post->id, PDO::PARAM_STR);
	$posts_q->bindParam("pagenum", $pagenum, PDO::PARAM_STR);
	$posts_q->execute();
	$posts = $posts_q->fetchAll(PDO::FETCH_ASSOC);

	if ($posts_q->rowCount() > 0) {
		$postsnum = 0;
	  foreach ($posts as $value)
		{
			$postsnum = $postsnum + 1;
			if($postsnum == 1) {
				$border = '';
			} else {
				$border = 'border-top:1px solid rgb(200,200,200); ';
			}
			$rplyposterusername = $do->getUsername($value['poster']);
			$rplyposterlastseen = $do->getUserInfo($rplyposterusername, "lastseen");
			if(($rplyposterlastseen + 300) > time()) {
				$status = '#82DD55';
			} else {
				$status = '#E23636';
			}
			echo '
			<div class="tile" style="padding:10px; '.$border.'padding-bottom:10px;">
			  <div onclick="window.location.href = \''.$url.'/profile/'.$rplyposterusername.'\'" class="tile-icon" style="cursor: pointer; padding:10px;display: table; width: 77px; height:77px; border: 1px solid '.$status.'; box-shadow: 0px 0px 16px '.$status.'; cursor: pointer; font-size: 1.75em; style">
				<img width="64" src="'.$userImages.$value['poster'].'.png?tick='.time().'" style="display: table-cell; vertical-align: middle; text-align: center;"/>
			  </div>
			  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <div class="tile-content">
				<p class="tile-title"><a href="'.$url.'/profile/'.$rplyposterusername.'">'.$rplyposterusername.'</a><a class="float-right" style="text-decoration:none; color:#acb3c2;">at '.date("M d, Y g:i A", $value['time_posted']).'</a></p>
				<p class="tile-subtitle" style="color:'.$txt_color.';">'.$do->bb_parse($do->noXSS($value['message'])).'</p>
			  </div>
			</div>';
		}
		echo '<br /><div class="btn-group">';
		
		$posts_c = $pdo->prepare("SELECT * FROM forum_replies WHERE post_id=:pid");
		$posts_c->bindParam("pid", $post->id, PDO::PARAM_STR);
		$posts_c->execute();
		
		$forumpages = round($posts_c->rowCount() / 10);
		if($forumpages == 0) {
			echo '<a class="float-right" style="text-decoration:none; color:black;">Showing '.$posts_q->rowCount().' post(s)</a>
			</div>';
			goto FooterPart;
		}
		echoPageNumbers:
		if($forumpages > 14) {
			echo '</div><button class="btn" onclick="window.location.href= \''.$url.'/forum/post/?id='.$_GET['id'].'&page='.($apagenum - 1).'\'"><i class="icon icon-arrow-left"></i> Previous Page</button>&nbsp;&nbsp;Page '.$apagenum.'&nbsp;&nbsp;<button class="btn" onclick="window.location.href= \''.$url.'/forum/post/?id='.$_GET['id'].'&page='.($apagenum + 1).'\'">Next Page <i class="icon icon-arrow-right"></i></button>
			<p class="float-right" style="text-decoration:none; color:'.$txt_color.';">Showing '.($pagenum + 1).' - '.($pagenum + $posts_q->rowCount()).' of '.$posts_c->rowCount().'	</p></div>';
			goto FooterPart;
		}
		if($forumpages == $apagenum) {
			echo '
			<button class="btn btn-primary disabled">'.$forumpages.'</button>';
		} else {
			echo '
			<button class="btn" onclick="window.location.href= \''.$url.'/forum/post/?id='.$_GET['id'].'&page='.$forumpages.'\'">'.$forumpages.'</button>';
		}
		$forumpages = $forumpages - 1;
		if($forumpages > 0) {
			goto echoPageNumbers;
		}
		echo '</div>
		<a class="float-right" style="text-decoration:none; color:'.$txt_color.';">Showing '.($pagenum + 1).' - '.($pagenum + $posts_q->rowCount()).' of '.$posts_c->rowCount().'	</a>';
	} else {
		echo '
		<div class="tile" style="padding:7px; padding-bottom:1px;">
		  <div class="tile-icon" style="padding-top:5px; padding-left:10px; padding-right:10px;">
			<figure class="avatar avatar-lg" data-initial="SYS" style="background-color: #5764c6;"></figure>
		  </div>
		  <div class="tile-content">
			<p class="tile-title">System<a class="float-right" style="text-decoration:none; color:#acb3c2;">at '.date("M d, Y g:i A", time()).'</a></p>
			<p class="tile-subtitle" style="color:'.$txt_color.';">There are no posts for this topic yet.</p>
		  </div>
		</div>';
	}
	
} else {
	echo '<h3>Post not found</h3>';
}

	?>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title><?php echo $do->getCategoryName($_GET['id']); ?> | Otorium</title>
</head>
<body>

<div class="sides">
<h3>Forums - <?php echo $do->getCategoryName($_GET['id']); ?></h3>
<p><?php echo $do->getCategoryDesc($_GET['id']); ?></p>
  <?php
if($do->ifcategoryAvailable($_GET['id']) == true) {
	if($do->getCategoryPosts($_GET['id']) > 20) {
		$pages = round(($do->getCategoryPosts($_GET['id'])+10)/20);
		if(!(isset($_GET['forum_page']))) {
			$page = 1;
			$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
		} else {
			if(is_numeric($_GET['forum_page'])) {
				$page = $_GET['forum_page'];
				$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
			} else {
				$page = 1;
				$limit = "LIMIT 20 OFFSET ".(($page * 20) - 20);
			}
		}
	} else {
		$pages = 1;
		$page = 1;
		$limit = "LIMIT 20";
	}
	$posts_q = $pdo->prepare("SELECT * FROM forum_posts WHERE topics_id=:tid AND deleted=0 ORDER BY `last_post_date` DESC ".$limit);
	$posts_q->bindParam("tid", $_GET['id'], PDO::PARAM_STR);
	$posts_q->execute();
	$posts = $posts_q->fetchAll(PDO::FETCH_ASSOC);

	if ($posts_q->rowCount() > 0) {
		if($do->ifcategoryLocked($_GET['id']) == false) {
			echo '<button class="btn btn-primary float-right" onclick="openmodal(\'newpost\')">Add Post</button>
				<div id="newpostFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

				<div id="newpost" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
					<div id="result"></div>
					<h4>New Post</h4>
					<div class="form-group">
						<label class="form-label">Post Name</label>
						<input class="form-input" type="text" id="pname" maxlength="32" placeholder="My new apple!" required />
					</div>
					<div class="form-group">
						<label class="form-label">Body</label>
						<textarea class="form-input" id="pbody" maxlength="1024" placeholder="This is one shiny, red apple." required rows="6"></textarea>
						<br />
						<a href="'.$url.'/help/1">BBcode tags</a>
					</div>
					<div class="btn-group float-right">
					  <button class="btn" id="cancelbtn" onclick="closemodal(\'newpost\')">Cancel</button>
					  <button class="btn btn-primary" id="postbtn" onclick="createPost('.$_GET['id'].')">Create Post</button>
					</div>
					<br />
				</div>

				</div>
				<script src="'.$url.'/api/js/createPost.js?v=003"></script>';
		} else {
			if($rank == 2) {
				echo '<button class="btn btn-primary float-right" onclick="openmodal(\'newpost\')">Add Post</button>
					<div id="newpostFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

					<div id="newpost" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
						<div id="result"></div>
						<h4>New Post</h4>
						<div class="form-group">
							<label class="form-label">Post Name</label>
							<input class="form-input" type="text" id="pname" maxlength="32" placeholder="My new apple!" required />
						</div>
						<div class="form-group">
							<label class="form-label">Body</label>
							<textarea class="form-input" id="pbody" maxlength="1024" placeholder="This is one shiny, red apple." required rows="6"></textarea>
							<br />
							<a href="'.$url.'/help/1">BBcode tags</a>
						</div>
						<div class="btn-group float-right">
						  <button class="btn" id="cancelbtn" onclick="closemodal(\'newpost\')">Cancel</button>
						  <button class="btn btn-primary" id="postbtn" onclick="createPost('.$_GET['id'].')">Create Post</button>
						</div>
						<br />
					</div>

					</div>
					<script src="'.$url.'/api/js/createPost.js?v=003"></script>';
			}
		}
		
		echo '
		<table class="table" style="border:1px solid '.$border_color_2.';">
		  <thead style="background-color: '.$bg_color_1.'">
			<tr>
			  <th>Title</th>
			  <th>Poster</th>
			  <th>Post date</th>
			  <th>Last Poster</th>
			  <th>Last Post Date</th>
			  <th>Replies</th>
			</tr>
		  </thead>
		  <tbody>';
		
		$pinned_posts_q = $pdo->prepare("SELECT * FROM forum_posts WHERE topics_id=:tid AND deleted=0 AND pinned=1");
		$pinned_posts_q->bindParam("tid", $_GET['id'], PDO::PARAM_STR);
		$pinned_posts_q->execute();
		$pinned_posts = $pinned_posts_q->fetchAll(PDO::FETCH_ASSOC);
		
		if ($pinned_posts_q->rowCount() > 0) {
			foreach ($pinned_posts as $value)
			{
				if($value['locked'] == true) {
					$badge = '<i class="fa fa-lock" title="This forum topic is locked"></i>&nbsp;&nbsp;';
				} else {
					$badge = '';
				}
				$posts_num = $pdo->query("SELECT * FROM forum_replies WHERE post_id=".$value['id'])->rowCount();
				
				echo'
				<tr onMouseOver="this.style.backgroundColor=\''.$forum_content_color_h.'\'" onMouseOut="this.style.backgroundColor=\''.$forum_content_color.'\'" style="cursor:pointer;" onclick="window.location.href=\''.$url.'/forum/post/'.$value['id'].'\'">
				  <td><i class="fa fa-thumb-tack" title="This forum topic is pinned"></i>&nbsp;&nbsp;'.$badge.$do->noXSS($value['title']).'</td>
				  <td>'.$do->getUsername($value['poster']).'</td>
				  <td>'.date("F d, Y", $value['time_posted']).'</td>
				  <td>'.$do->getUsername($value['last_poster']).'</td>
				  <td>'.date("F d, Y", $value['last_post_date']).'</td>
				  <td>'.$posts_num.'</td>
				</tr>';
				
			}
		}
		
	  foreach ($posts as $value)
		{
			if($value['pinned'] == false) {
				if($value['locked'] == true) {
					$badge = '<i class="fa fa-lock" title="This forum topic is locked"></i>&nbsp;&nbsp;';
				} else {
					$badge = '';
				}
				
				$posts_num = $pdo->query("SELECT * FROM forum_replies WHERE post_id=".$value['id'])->rowCount();
				
				echo'
				<tr onMouseOver="this.style.backgroundColor=\''.$forum_content_color_h.'\'" onMouseOut="this.style.backgroundColor=\''.$forum_content_color.'\'" style="cursor:pointer;" onclick="window.location.href=\''.$url.'/forum/post/'.$value['id'].'\'">
				  <td>'.$badge.$do->noXSS($value['title']).'</td>
				  <td>'.$do->getUsername($value['poster']).'</td>
				  <td>'.date("F d, Y", $value['time_posted']).'</td>
				  <td>'.$do->getUsername($value['last_poster']).'</td>
				  <td>'.date("F d, Y", $value['last_post_date']).'</td>
				  <td>'.$posts_num.'</td>
				</tr>';
			}
		}
		echo '</tbody></table>';
		
		//Pages
		echo '<br /><div>';
		if($pages > 1) {
			if($page == 1) {
				echo '<button class="btn btn-primary disabled" style="float:left; display: inline-block;">Next Page</button>';
			} else {
				echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/forum/category/'.$_GET['id'].'/'.($page-1).'\'" style="float:left; display: inline-block;">Next Page</button>';
			}
			if($page == $pages) {
				echo '<button class="btn btn-primary disabled" style="float:right; display: inline-block;">Previous Page</button>';
			} else {
				echo '<button class="btn btn-primary" onclick="window.location.href = \''.$url.'/forum/category/'.$_GET['id'].'/'.($page+1).'\'" style="float:right; display: inline-block;">Previous Page</button>';
			}
		}
		echo '</div>';
		echo '<center><a style="text-decoration: none; color:'.$txt_color.'; line-height: 36px; display: inline-block;">Page '.$page.' of '.$pages.'</a></center>';
			
		
	} else {
		
		if($do->ifcategoryLocked($_GET['id']) == false) {
			echo '<button class="btn btn-primary float-right" onclick="openmodal(\'newpost\')">Add Post</button>
				<div id="newpostFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

				<div id="newpost" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
					<div id="result"></div>
					<h4>New Post</h4>
					<div class="form-group">
						<label class="form-label">Post Name</label>
						<input class="form-input" type="text" id="pname" maxlength="32" placeholder="My new apple!" required />
					</div>
					<div class="form-group">
						<label class="form-label">Body</label>
						<textarea class="form-input" id="pbody" maxlength="1024" placeholder="This is one shiny, red apple." required rows="6"></textarea>
						<br />
						<a href="'.$url.'/help/1">BBcode tags</a>
					</div>
					<div class="btn-group float-right">
					  <button class="btn" id="cancelbtn" onclick="closemodal(\'newpost\')">Cancel</button>
					  <button class="btn btn-primary" id="postbtn" onclick="createPost('.$_GET['id'].')">Create Post</button>
					</div>
					<br />
				</div>

				</div>
				<script src="'.$url.'/api/js/createPost.js?v=003"></script>';
		} else {
			if($rank == 2) {
				echo '<button class="btn btn-primary float-right" onclick="openmodal(\'newpost\')">Add Post</button>
					<div id="newpostFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

					<div id="newpost" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
						<div id="result"></div>
						<h4>New Post</h4>
						<div class="form-group">
							<label class="form-label">Post Name</label>
							<input class="form-input" type="text" id="pname" maxlength="32" placeholder="My new apple!" required />
						</div>
						<div class="form-group">
							<label class="form-label">Body</label>
							<textarea class="form-input" id="pbody" maxlength="1024" placeholder="This is one shiny, red apple." required rows="6"></textarea>
							<br />
							<a href="'.$url.'/help/1">BBcode tags</a>
						</div>
						<div class="btn-group float-right">
						  <button class="btn" id="cancelbtn" onclick="closemodal(\'newpost\')">Cancel</button>
						  <button class="btn btn-primary" id="postbtn" onclick="createPost('.$_GET['id'].')">Create Post</button>
						</div>
						<br />
					</div>

					</div>
					<script src="'.$url.'/api/js/createPost.js?v=003"></script>';
			}
		}
		echo '<p>No forum posts yet</p>';
	}
}

	?>
  </tbody>
</table>

</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
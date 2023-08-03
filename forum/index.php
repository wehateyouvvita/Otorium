<?php
$createCategoryModal = '<div id="newCategoryFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

<div id="newCategory" class="anim" style="background-color:white; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid rgb(200,200,200);">
	<h4>New Category</h4>
	<div class="form-group">
		<label class="form-label">Category name</label>
		<input class="form-input" type="text" id="catname" maxlength="32" placeholder="Forum Games!" required />
	</div>
	<div class="form-group">
		<label class="form-label">Description</label>
		<textarea class="form-input" id="desc" maxlength="256" placeholder="This category eats games." required rows="2"></textarea>
	</div>
	<div class="btn-group float-right">
	  <button class="btn" onclick="closemodal(\'newCategory\')">Cancel</button>
	  <button class="btn btn-primary" onclick="createCategory()">Create category</button>
	</div>
	<br />
</div>

</div>

<a class="float-right" style="cursor:pointer;" onclick="openmodal(\'newCategory\')"><i class="fa fa-plus"></i> New Category</a>';
include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); 
	if($rank == 2) {
		echo '<script src="'.$url.'/api/js/categoryActions.js?v=001"></script>';
	}
	?>
	<title>Forums | Otorium</title>
</head>
<body>

<div class="sides">
<h3>Forums</h3>

<p>Welcome to the daily posting place of Otorium</p>
<table class="table" style="border:1px solid <?php echo $border_color_2; ?>;">
  <thead style="background-color: <?php echo $bg_color_1; ?>">
    <tr>
      <th>Category</th>
      <th>Description</th>
      <th>Posts</th>
	  <?php if($rank == 2) { echo '<th>Action</th>'; } ?>
    </tr>
  </thead>
  <tbody>
  <?php
  foreach ($pdo->query("SELECT * FROM forum_topics WHERE deleted=0 ORDER BY `f_order` ASC") as $results)
	{
		$badge = '';
		if($results['locked'] == 1) {
			$badge = '<i class="fa fa-lock" title="This forum topic is locked"></i>&nbsp;&nbsp;';
		}
		echo'
		<tr onMouseOver="this.style.backgroundColor=\''.$forum_content_color_h.'\'" onMouseOut="this.style.backgroundColor=\''.$forum_content_color.'\'" style="cursor:pointer;" onclick="window.location.href=\'category/'.$results['id'].'\'">
		  <td>'.$badge.$results['title'].'</td>
		  <td>'.$results['body'].'</td>
		  <td>'.$do->getCategoryPosts($results['id']).'</td>
		  ';
		  if($rank == 2) {
			echo '
			  <td>
				<div class="popover popover-left">
				  <i class="fa fa-caret-down" style="font-size:24px;"></i>
				  <div class="popover-container">
					<ul class="menu">
					<li class="divider" data-content="ACTIONS"></li>
					<li class="menu-item">
					  <a href="edit/'.$results['id'].'"><i class="fa fa-pencil"></i>&nbsp;&nbsp;Edit</a>
					</li>
				  </ul>
				  </div>
				</div>
			  </td>';
		  }
		  echo '</tr>';
	}
	?>
  </tbody>
</table>
<?php


if($rank == 2) {
	echo '
<div id="editCategoryFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

<div id="editCategory" class="anim" style="background-color:white; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid rgb(200,200,200);">
	<div id="eresult"></div>
	<h4>Edit Category</h4>
	<div class="form-group">
		<label class="form-label">Category name</label>
		<input class="form-input" type="text" id="ecatname" maxlength="32" placeholder="Forum Games!" required />
	</div>
	<div class="form-group">
		<label class="form-label">Description</label>
		<textarea class="form-input" id="ecatdesc" maxlength="256" placeholder="This category eats games." required rows="2"></textarea>
	</div>
	<div class="btn-group float-right">
	  <button id="ecbtn" class="btn" onclick="closemodal(\'newCategory\')">Cancel</button>
	  <button id="eebtn" class="btn btn-primary" onclick="createCategory()">Edit category</button>
	</div>
	<br />
</div>

</div>';
	echo '
<div id="addCategoryFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

<div id="addCategory" class="anim" style="background-color:white; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid rgb(200,200,200);">
	<div id="acresult"></div>
	<h4>Add Category</h4>
	<div class="form-group">
		<label class="form-label">Category name</label>
		<input class="form-input" type="text" id="acatname" maxlength="32" placeholder="Forum Games!" required />
	</div>
	<div class="form-group">
		<label class="form-label">Description</label>
		<textarea class="form-input" id="acatdesc" maxlength="256" placeholder="This category eats games." required rows="2"></textarea>
	</div>
	<div class="btn-group float-right">
	  <button id="acbtn" class="btn" onclick="closemodal(\'newCategory\')">Cancel</button>
	  <button id="aabtn" class="btn btn-primary" onclick="createCategory()">Add category</button>
	</div>
	<br />
</div>

</div>';
}
  
  
?>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
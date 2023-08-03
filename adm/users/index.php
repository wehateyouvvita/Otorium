<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader();
	
		if(!($rank == 2)) {
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
	
<div style="padding:25px; border:1px solid rgb(200,200,200);">
	<h3>Users</h3>
	<table class="table" style="border:1px solid '.$border_color_2.';">
  <thead style="background-color: '.$bg_color_1.'">
	<tr>
	  <th>ID</th>
	  <th>Username</th>
	  <th>Email</th>
	  <th>Join date</th>
	  <th>Register IP</th>
	  <th>Last IP</th>
	  <th>Last seen</th>
	</tr>
  </thead>
  <tbody>
	<?php foreach ($pdo->query("SELECT * FROM users") as $user) {
		echo'
		<tr style="cursor:pointer;" onclick="window.location.href=\''.$url.'/profile/'.$user['username'].'\'">
		  <td>'.$user['id'].'</td>
		  <td '.(($do->checkIfBanned($user['id']) == true)? "style='color: red;'" : "").'>'.$user['username'].'</td>
		  <td>'.$do->encode($user['email'], "d").'</td>
		  <td>'.date("F d, Y", $user['joindate']).'</td>
		  <td>';
		  $regip = explode(",", $do->encode($user['regIP'], "d"));
		  echo $regip[1].'</td>
		  <td>';
		  $curip = explode(",", $do->encode($user['curIP'], "d"));
		  echo $curip[1].'</td>
		  <td>'.date("F d, Y", $user['lastseen']).'</td>
		</tr>';
	} ?>
  </tbody>
  </table>
</div>
</div>

<?php FooterPart: include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
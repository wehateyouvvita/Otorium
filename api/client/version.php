<?php
if(isset($_POST['requestClientInformation'])) {
	require '../cfg/user_session.php';
	
	$query = "SELECT * FROM client_info WHERE id=1";
	
	$doQ1 = $pdo->query($query);

	$values1 = $doQ1->fetch(PDO::FETCH_OBJ);
	//version = 0, 1 = required, updateinfo = 2, update_url = 3, size = 4, 5 = minimalVerRequired
	echo $values1->version.'|'.$values1->required.'|'.$values1->updateinfo.'|'.$values1->update_url.'|'.$values1->size.'|'.$values1->minVerReq;
	
}
else
{
	http_response_code(403);
}
?>
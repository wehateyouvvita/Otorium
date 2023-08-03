<?php
session_start();
require 'db/connect.php';
require 'siteFunctions.php';
$check = new functions();
/*type 1 = accept, type 2 = decline*/
if(isset($_POST['itemID']) && isset($_POST['type']) && isset($_POST['money'])) {

	
	
	if(isset($_SESSION['session'])) {
		
		
		
		$query = $pdo->prepare("SELECT username,password,rank,cash,betatester,id,asset_approver FROM users WHERE id=:id");
		$query->bindParam("id", $_SESSION['session'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() > 0) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			$cash = $result->cash;
			$rank = $result->rank;
			$userID = $result->id;
			$asset_approver = $result->asset_approver;
			//check if asset exists
			$ciae = $pdo->prepare("SELECT * FROM asset_items WHERE id = :rbxid");
			$ciae->bindParam(":rbxid", $_POST['itemID'], PDO::PARAM_INT);
			$ciae->execute();
			if($ciae->rowCount() > 0) {
				//exists
				$assetinfo = $ciae->fetch(PDO::FETCH_OBJ);
				//Check if user is allowed to approve/decline
				if(($rank == 1) || ($rank == 2) || ($asset_approver == 1)) {
					if($_POST['type'] == 1) {
						if(!($assetinfo->approved == 2 || $assetinfo->approved == 3)) {
							//Asset max money limit
							$assetMaxMoney = $check->AssetMaxMoney($assetinfo->type);
							if($_POST['money'] > $assetMaxMoney) {
								echo '<div id="message">
										<center>
										<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
										'.$check->getAssetType($assetinfo->type).'s cannot be more than '.$assetMaxMoney.' otobux.
										</center>
									</div>
									
									<a id="success">f</a>';
							} else {
								if($_POST['money'] < 10) {
									echo '<div id="message">
											<center>
											<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
											No item can be less than 10 Otobux!
											</center>
										</div>
										
										<a id="success">f</a>';
								} else {
									//Check if mods are trying to approve hats.
									if($rank == 1 && $check->canApproveItem($assetinfo->id, $rank) == false && $asset_approver == 0) {
										echo '<div id="message">
												<center>
												<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
												Moderators cannot approve hats, faces, gears or packages.
												</center>
											</div>
											
											<a id="success">f</a>';
									} else {
										//32 = package
										if($assetinfo->type == 32 && !($userID == 1)) {
											die( '<div id="message">
													<center>
													<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
													Cannot approve packages.
													</center>
												</div>
												
												<a id="success">f</a>' );
										}
										//update DB
											$saoi = $pdo->prepare("UPDATE asset_items SET approved = 2, price = :prc, who_approve = ".$userID." WHERE id=".$assetinfo->id);
											$saoi->bindParam(":prc", $_POST['money'], PDO::PARAM_INT);
											if($saoi->execute()) {
												echo '<div id="message">
														<center>
														<img src="https://otorium.xyz/adm/assets/id_beta/checkmark.png" width="96" /><br />
														Succesfully approved item!
														</center>
													</div>
													
													<a id="success">t</a>';
											} else {
												echo '<div id="message">
														<center>
														<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
														Error while approving item.
														</center>
													</div>
													
													<a id="success">f</a>';
											}
									}
								}
							}
						} else {
							echo '<div id="message">
									<center>
									<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
									This asset has already been approved/declined.
									</center>
								</div>
								
								<a id="success">f</a>';
						}
					} else {
						if(!($assetinfo->approved == 2 || $assetinfo->approved == 3)) {
							//Check if mods are trying to decline hats.
							if($rank == 1 && $check->canApproveItem($assetinfo->id, $rank) == false) {
								echo '<div id="message">
										<center>
										<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
										Moderators cannot decline hats, faces, gears or packages.
										</center>
									</div>
									
									<a id="success">f</a>';
							} else {
								if($assetinfo->type == 32 && !($userID == 1)) {
									die( '<div id="message">
											<center>
											<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
											Cannot disapprove packages.
											</center>
										</div>
										
										<a id="success">f</a>' );
								}
								//update DB
								$saoi = $pdo->prepare("UPDATE asset_items SET approved = 3, price = 0, who_approve = ".$userID." WHERE id=".$assetinfo->id);
								if($saoi->execute()) {
									echo '<div id="message">
											<center>
											<img src="https://otorium.xyz/adm/assets/id_beta/checkmark.png" width="96" /><br />
											Succesfully declined item!
											</center>
										</div>
										
										<a id="success">t</a>';
								} else {
									echo '<div id="message">
											<center>
											<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
											Error while declining item.
											</center>
										</div>
										
										<a id="success">f</a>';
								}
							}
						} else {
							echo '<div id="message">
									<center>
									<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
									This asset has already been approved/declined.
									</center>
								</div>
								
								<a id="success">f</a>';
						}
					}
				} else {
					echo '<div id="message">
							<center>
							<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
							You are not authorized to approve/decline assets.
							</center>
						</div>
						
						<a id="success">f</a>';
				}
			} else {
				//does not exist
				echo '<div id="message">
						<center>
						<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
						The asset ID does not exist.
						</center>
					</div>
					
					<a id="success">f</a>';
			}
			
		} else {
			echo '<div id="message">
					<center>
					<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
					You are not logged in.
					</center>
				</div>
				
				<a id="success">f</a>';
		}
		
		
		
	} else {
		echo '<div id="message">
				<center>
				<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
				You are not logged in.
				</center>
			</div>
			
			<a id="success">f</a>';
	}
		
} else {
	echo '<div id="message">
			<center>
			<img src="https://blog.sqlauthority.com/wp-content/uploads/2015/08/erroricon.png" width="96" /><br />
			Unknown error occured.
			</center>
		</div>
		
		<a id="success">f</a>';
}

?>
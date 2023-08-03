<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
}
$do = new functions();
$getUserInfo = $pdo->prepare("SELECT * FROM host_tokens WHERE keyvalue = :ky");
$getUserInfo->bindParam(":ky", $_GET['token'], PDO::PARAM_STR);
$getUserInfo->execute();
if($getUserInfo->rowCount() > 0) {
$result = $getUserInfo->fetch(PDO::FETCH_OBJ);
//get game info
$gameInfo = $pdo->query("SELECT * FROM games WHERE id = ".$result->game_id)->fetch(PDO::FETCH_OBJ);
$port = $gameInfo->port;
$pingGametk = $do->random_str(16);
$pdo->query("UPDATE games SET pingtoken = '".$pingGametk."', lastpingtime = ".time()." WHERE id = ".$result->game_id);
?>
local Port = <?php echo $port; ?> 
Server = game:GetService('NetworkServer') 
RunService = game:GetService('RunService') 
coroutine.resume(coroutine.create(function() while wait(45) do game:HttpGet("http://api.otorium.xyz/client/setGPing.php?token=<?php echo $pingGametk; ?>&tick=" .. tick(),true) end end)) 
Server:start(Port, 5) 
RunService:run() 
function onJoined(newPlayer)
print ("An new connection was accepted.")
newPlayer:LoadCharacter()
while true do 
wait(0.001) 
if newPlayer.Character.Humanoid.Health == 0
then print ("Player died") wait(5) newPlayer:LoadCharacter() print("Player respawned")
elseif newPlayer.Character.Parent == nil then wait(5) newPlayer:LoadCharacter() -- to make sure nobody is deleted.
end
end
end
 
game.Players.PlayerAdded:connect(onJoined) 
 <?php
//Delete token.
$deleteGame = $pdo->prepare("DELETE FROM host_tokens WHERE keyvalue = :ky");
$deleteGame->bindParam(":ky", $_GET['token'], PDO::PARAM_STR);
$deleteGame->execute();
} else {
?>
game:SetMessage("Error occured while hosting, try again (token received: <?php echo $_GET['token']; ?>)")
<?php
}
?>
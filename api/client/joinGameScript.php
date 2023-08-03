<?php
error_reporting(0);
include $_SERVER['DOCUMENT_ROOT'].'/api/core/db/connect.php';
include $_SERVER['DOCUMENT_ROOT'].'/api/core/siteFunctions.php';
if(!(isset($pdo))) {
	include $_SERVER['DOCUMENT_ROOT'].'/core/db/connect.php';
	include $_SERVER['DOCUMENT_ROOT'].'/core/siteFunctions.php';
}
$do = new functions();
$getUserInfo = $pdo->prepare("SELECT * FROM game_tokens WHERE keyvalue = :ky");
$getUserInfo->bindParam(":ky", $_GET['token'], PDO::PARAM_STR);
$getUserInfo->execute();
if($getUserInfo->rowCount() > 0) {
$result = $getUserInfo->fetch(PDO::FETCH_OBJ);
//get game info
$gameInfo = $pdo->query("SELECT * FROM games WHERE id = ".$result->game_id)->fetch(PDO::FETCH_OBJ);
$ip = $gameInfo->ip;
$port = $gameInfo->port;
$userID = $do->getUserInfo($result->username, "id");
if(!(is_numeric($userID))) {
	$userID = 0;
}
$username = $result->username;
if($gameInfo->loopback == 1 && ($userID == $gameInfo->creator)) {
	$ip = "127.0.0.1";
}
$pingGametk = $do->random_str(16);
$pdo->query("INSERT INTO ingame_players(uid,gid,last_pinged,token_used) VALUES(".$userID.",".$gameInfo->id.",".time().",'".$pingGametk."')");
if($gameInfo->version == 0) { // 2010
?>
isInMaintance = false 
ip = "<?php echo $ip; ?>" 
prt = <?php echo $port; ?> 
local suc, err = pcall(function()
    clnt = game:GetService('NetworkClient') 
	plr = game:GetService('Players'):CreateLocalPlayer(<?php echo $userID; ?>) 
	plr.Name = "<?php echo $username; ?>"
	plr.CharacterAppearance = 'http://api.otorium.xyz/render/getCharApp.php?id=<?php echo $userID; ?>&tick=' .. tick(); 
	game.Players:SetChatStyle(Enum.ChatStyle.ClassicAndBubble) 
	plr:SetSuperSafeChat(false) 
end) 
if not suc then 
	game:SetMessage(err) 
	wait(math.huge) 
end 
function stglobalmessage() 
	game:SetMessage('Joining game...') 
	game:GetService('Visit') 
	wait(5) 
	game:ClearMessage() 
end 
function connected(url, replicator) 
	stglobalmessage() 
	local suc, err = pcall(function() 
		local marker = replicator:SendMarker() 
	end) 
	if not suc then 
		game:SetMessage(err) 
	end 
	coroutine.resume(coroutine.create(function() while wait(30) do game:HttpGet("http://api.otorium.xyz/client/setPing.php?token=<?php echo $pingGametk; ?>&tick=" .. tick(),true) end end)) 
	marker.Recieved() 
end 
function faili() 
	game:SetMessage('Connection to the server has been rejected you ding dong!') 
end 
function failed() 
	game:SetMessage('Uh oh, could not find bananas! (Failed to Connect)')
end 
if isInMaintance == false then 
	local suc, err = pcall(function() 
		clnt.ConnectionAccepted:connect(connected)
		clnt.ConnectionRejected:connect(faili) 
		clnt.ConnectionFailed:connect(failed) 
		clnt:Connect(ip, prt, 0, 20) 
		game:GetService("Visit")
	end) 
	if not suc then 
		game:SetMessage(err) 
		wait(math.huge) 
	end 
else 
	plr:SetSuperSafeChat(true) 
end 
<?php
} elseif ($gameInfo->version == 1) { /*2000000000000000000000000000000000000000000000000000000000008 */ ?>
isInMaintance = false 
ip = "<?php echo $ip; ?>" 
prt = <?php echo $port; ?> 
game:SetMessage("Joining server") 
local suc, err = pcall(function() 
plr = game:GetService("Players"):CreateLocalPlayer(<?php echo $userID; ?>) 
plr.Name = "<?php echo $username; ?>" 
plr.Neutral = true 
clnt = game:GetService("NetworkClient") 
plr:SetSuperSafeChat(false) 
end) 
function stglobalmessage() 
game:GetService("Visit") 
wait(5) 
game:ClearMessage() 
end 
function connected(url, replicator) 
stglobalmessage() 
local suc, err = pcall(function() 
local marker = replicator:SendMarker() 
end) 
if not suc then
game:SetMessage(err)
end
coroutine.resume(coroutine.create(function() while wait(30) do game:HttpGet("http://api.otorium.xyz/client/setPing.php?token=<?php echo $pingGametk; ?>&tick=" .. tick(),true) end end)) 
marker.Recieved()
local suc, err = pcall(function()
end)
if not suc then 
game:SetMessage(err) 
end 
end 
function rejected() 
game:SetMessage("Connection rejected") 
end 
function failed() 
game:SetMessage("Could not find apples.. (Failed to Connect)") 
end 
if isInMaintance == false then 
local suc, err = pcall(function() 
clnt.ConnectionAccepted:connect(connected) 
clnt.ConnectionRejected:connect(rejected) 
clnt.ConnectionFailed:connect(failed) 
clnt:Connect(ip, prt, 0, 20) 
end) 
else 
plr:SetSuperSafeChat(true) 
game:SetMessage("Maintenance") 
end 
if not suc then 
game:SetMessage(err) 
wait(math.huge) 
end 
<?php
}
//Delete token.
//--plr.CharacterAppearance = 'http://api.otorium.xyz/render/getCharApp.php?id=$userID;&type=2008&tick=' .. tick(); 
$deleteGame = $pdo->prepare("DELETE FROM game_tokens WHERE keyvalue = :ky");
$deleteGame->bindParam(":ky", $_GET['token'], PDO::PARAM_STR);
$deleteGame->execute();
} else {
?>
game:SetMessage("Error occured while joining game, please try again")
<?php
}
?>
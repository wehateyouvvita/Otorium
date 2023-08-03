<?php
echo '
game:SetMessage("Attempting to connect..")
gameConnected = false
local suc, err = pcall(function()
--client = game:GetService("NetworkClient")
local test = game:GetService("NetworkClient"):PlayerConnect(0, "localhost", '.$_GET['p'].', 0, 20)
game:SetMessage(" ")
gameConnected = true
game:GetService("Visit")
game:GetService("RunService"):run()
--test.Name = [======['.$_GET['u'].']======]
test.CharacterAppearance = "http://api.otorium.xyz/render/getCharApp.php?id=1&tick=" .. tick();
end)

if not suc then
local x = Instance.new("Message")
game:SetMessage(err)
--x.Parent = workspace
if gameConnected == false then
wait(math.huge)
else
wait(5)
game:SetMessage("")
end
end
';
?>

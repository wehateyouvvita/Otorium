<?php
$RequestId = substr(md5(microtime()),rand(0,16),16);
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "<Error>";
echo "<Code>AccessDenied</Code>";
echo "<Message>Access Denied</Message>";
echo "<RequestId>".$RequestId."</RequestId>";
echo "<HostId>";
for ($i=0; $i<76; $i++) { $d=rand(1,30)%2; echo $d ? chr(rand(65,90)) : chr(rand(48,57)); } 
echo "</HostId>";
echo "</Error>";
?>
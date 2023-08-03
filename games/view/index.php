<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
	<?php getHeader(); ?>
	<title><?php echo $do->GameName($_GET['id']); ?> | Otorium</title>
</head>
<body>

<div class="sides">

	<?php
	$entries = 0;
	
	if(is_numeric($_GET['id'])) {
		$query = $pdo->prepare("SELECT * FROM games WHERE id=:id AND deleted=0");
		$query->bindParam("id", $_GET['id'], PDO::PARAM_STR);
		$query->execute();
		
		if ($query->rowCount() == 1) {
			$result = $query->fetch(PDO::FETCH_OBJ);
			
			if($result->image_approved == 1) {
				$image = $result->image;
				$thumbnailManaged = true;
			} elseif($result->image_approved == 0) {
				$image = $cdn.'/assets/approvalpending.png';
				$thumbnailManaged = false;
			} elseif($result->image_approved == 2) {
				$image = $cdn.'/assets/thumbnaildenied.png';
				$thumbnailManaged = true;
			}
			
			if($thumbnailManaged == false) {
				if(($rank == 1) || ($rank == 2)) {
					echo '<script src="'.$url.'/api/js/approveGameThumb.js"></script>';
					$apthmbbtn = '<button class="btn" onclick="openmodal(\'approveThumbnaildialog\')"><i class="icon icon-photo"></i> Approve Thumbnail</button>';
				} else {
					$apthmbbtn = null;
				}
			} else {
				$apthmbbtn = null;
			}
			
			if($result->lastpingtime > (time() - 91)) {
				echo '<script src="'.$url.'/api/js/playgame.js"></script>';
				$available = '<b>Status: </b><a style="color:green;">Online</a>';
				$playBtn = '<a class="btn btn-primary float-right" onclick="LaunchGame('.$result->id.')">Play!</a>';
			} else {
				$available = '<b>Status: </b><a style="color:rgb(240,20,20);">Offline</a>';
				$playBtn = '<a class="btn float-right disabled">Server offline</a>';
			}
			
			if($result->creator == $userID) {
				echo '
				<script>
				var _0x3a74=[\'\x65\x6c\x4e\x34\',\'\x51\x6b\x64\x50\',\'\x53\x6b\x5a\x5a\',\'\x59\x58\x42\x77\x62\x48\x6b\x3d\',\'\x64\x46\x5a\x49\',\'\x63\x6d\x56\x30\x64\x58\x4a\x75\x49\x43\x68\x6d\x64\x57\x35\x6a\x64\x47\x6c\x76\x62\x69\x67\x70\x49\x41\x3d\x3d\',\'\x65\x33\x30\x75\x59\x32\x39\x75\x63\x33\x52\x79\x64\x57\x4e\x30\x62\x33\x49\x6f\x49\x6e\x4a\x6c\x64\x48\x56\x79\x62\x69\x42\x30\x61\x47\x6c\x7a\x49\x69\x6b\x6f\x49\x43\x6b\x3d\',\'\x5a\x55\x64\x4b\',\'\x51\x33\x70\x59\',\'\x59\x55\x5a\x58\',\'\x49\x32\x52\x6c\x62\x46\x4e\x6c\x63\x6e\x5a\x6c\x63\x6d\x4a\x30\x62\x67\x3d\x3d\',\'\x63\x6d\x56\x74\x62\x33\x5a\x6c\x51\x32\x78\x68\x63\x33\x4d\x3d\',\'\x5a\x47\x6c\x7a\x59\x57\x4a\x73\x5a\x57\x51\x3d\',\'\x63\x57\x52\x61\',\'\x5a\x58\x4a\x73\',\'\x5a\x6d\x6c\x73\x64\x47\x56\x79\',\'\x49\x32\x31\x6c\x63\x33\x4e\x68\x5a\x32\x55\x3d\',\'\x61\x48\x52\x74\x62\x41\x3d\x3d\',\'\x49\x33\x4e\x31\x59\x32\x4e\x6c\x63\x33\x4d\x3d\',\'\x5a\x32\x56\x30\x52\x57\x78\x6c\x62\x57\x56\x75\x64\x45\x4a\x35\x53\x57\x51\x3d\',\'\x63\x6d\x56\x7a\x64\x57\x78\x30\',\'\x61\x57\x35\x75\x5a\x58\x4a\x49\x56\x45\x31\x4d\',\'\x5a\x47\x56\x73\x55\x32\x56\x79\x64\x6d\x56\x79\x55\x47\x46\x75\x5a\x57\x77\x3d\',\'\x62\x47\x39\x6a\x59\x58\x52\x70\x62\x32\x34\x3d\',\'\x63\x6d\x56\x73\x62\x32\x46\x6b\',\'\x49\x33\x52\x7a\x62\x32\x4a\x30\x62\x67\x3d\x3d\',\'\x59\x57\x64\x5a\',\'\x59\x31\x64\x6b\',\'\x61\x58\x52\x6c\x62\x51\x3d\x3d\',\'\x59\x58\x52\x30\x63\x6d\x6c\x69\x64\x58\x52\x6c\',\'\x54\x6c\x6c\x5a\',\'\x57\x57\x68\x47\',\'\x52\x6c\x5a\x34\',\'\x5a\x6e\x56\x75\x59\x33\x52\x70\x62\x32\x34\x67\x4b\x6c\x77\x6f\x49\x43\x70\x63\x4b\x51\x3d\x3d\',\'\x58\x43\x74\x63\x4b\x79\x41\x71\x4b\x44\x38\x36\x58\x7a\x42\x34\x4b\x44\x38\x36\x57\x32\x45\x74\x5a\x6a\x41\x74\x4f\x56\x30\x70\x65\x7a\x51\x73\x4e\x6e\x31\x38\x4b\x44\x38\x36\x58\x47\x4a\x38\x58\x47\x51\x70\x57\x32\x45\x74\x65\x6a\x41\x74\x4f\x56\x31\x37\x4d\x53\x77\x30\x66\x53\x67\x2f\x4f\x6c\x78\x69\x66\x46\x78\x6b\x4b\x53\x6b\x3d\',\'\x61\x57\x35\x70\x64\x41\x3d\x3d\',\'\x64\x47\x56\x7a\x64\x41\x3d\x3d\',\'\x59\x32\x68\x68\x61\x57\x34\x3d\',\'\x61\x57\x35\x77\x64\x58\x51\x3d\',\'\x64\x6d\x46\x73\x64\x57\x55\x3d\',\'\x57\x31\x56\x7a\x61\x45\x39\x32\x56\x57\x5a\x59\x53\x6c\x70\x72\x57\x6d\x4a\x52\x53\x46\x4a\x69\x55\x6e\x5a\x6f\x62\x47\x78\x4c\x52\x6b\x46\x72\x56\x32\x4a\x4c\x64\x6c\x68\x6f\x53\x45\x46\x59\x54\x6b\x31\x50\x51\x57\x56\x5a\x51\x30\x6c\x54\x52\x58\x5a\x58\x62\x45\x6c\x72\x5a\x6b\x56\x6d\x57\x45\x4e\x4e\x61\x47\x5a\x46\x54\x56\x64\x6e\x51\x30\x68\x48\x54\x56\x68\x43\x53\x56\x46\x71\x52\x46\x46\x56\x54\x6e\x46\x33\x55\x31\x56\x72\x52\x56\x42\x32\x63\x57\x68\x48\x53\x48\x64\x69\x52\x6b\x56\x6e\x53\x46\x68\x69\x52\x6c\x30\x3d\',\'\x62\x33\x52\x56\x62\x33\x4e\x79\x61\x58\x56\x74\x61\x45\x39\x32\x4c\x6e\x68\x56\x65\x57\x5a\x36\x4f\x31\x68\x4b\x59\x56\x70\x77\x61\x57\x74\x61\x4c\x6d\x39\x69\x64\x47\x39\x52\x63\x6b\x68\x70\x64\x56\x4a\x69\x55\x6e\x5a\x74\x4c\x6e\x68\x35\x65\x6d\x68\x73\x4f\x32\x4e\x73\x5a\x45\x74\x47\x62\x6b\x46\x72\x4c\x6c\x64\x69\x53\x32\x39\x32\x64\x46\x68\x76\x63\x6d\x68\x49\x51\x56\x68\x4f\x61\x55\x31\x50\x51\x58\x56\x74\x4c\x6e\x68\x6c\x65\x58\x70\x5a\x51\x30\x6c\x54\x52\x58\x5a\x58\x62\x45\x6c\x72\x5a\x6b\x56\x6d\x57\x45\x4e\x4e\x61\x47\x5a\x46\x54\x56\x64\x6e\x51\x30\x68\x48\x54\x56\x68\x43\x53\x56\x46\x71\x52\x46\x46\x56\x54\x6e\x46\x33\x55\x31\x56\x72\x52\x56\x42\x32\x63\x57\x68\x48\x53\x48\x64\x69\x52\x6b\x56\x6e\x53\x46\x68\x69\x52\x67\x3d\x3d\',\'\x63\x6d\x56\x77\x62\x47\x46\x6a\x5a\x51\x3d\x3d\',\'\x63\x33\x42\x73\x61\x58\x51\x3d\',\'\x59\x30\x64\x36\',\'\x51\x55\x74\x7a\',\'\x62\x47\x56\x75\x5a\x33\x52\x6f\',\'\x59\x32\x68\x68\x63\x6b\x4e\x76\x5a\x47\x56\x42\x64\x41\x3d\x3d\',\'\x55\x6b\x6c\x6f\',\'\x51\x33\x70\x4b\',\'\x52\x57\x78\x74\',\'\x62\x47\x56\x53\',\'\x63\x6e\x56\x69\',\'\x57\x6d\x78\x49\',\'\x62\x33\x6c\x33\',\'\x55\x32\x4e\x43\',\'\x61\x57\x35\x6b\x5a\x58\x68\x50\x5a\x67\x3d\x3d\',\'\x55\x6d\x52\x61\',\'\x53\x6b\x52\x30\',\'\x52\x6e\x68\x4e\',\'\x57\x57\x4a\x48\',\'\x63\x33\x70\x47\',\'\x51\x6b\x4e\x55\',\'\x64\x48\x68\x4e\',\'\x59\x32\x39\x75\x63\x33\x52\x79\x64\x57\x4e\x30\x62\x33\x49\x3d\',\'\x5a\x47\x56\x69\x64\x51\x3d\x3d\',\'\x5a\x32\x64\x6c\x63\x67\x3d\x3d\',\'\x63\x33\x52\x68\x64\x47\x56\x50\x59\x6d\x70\x6c\x59\x33\x51\x3d\',\'\x63\x6c\x46\x6c\',\'\x55\x31\x42\x6a\',\'\x55\x31\x4a\x42\',\'\x64\x32\x68\x70\x62\x47\x55\x67\x4b\x48\x52\x79\x64\x57\x55\x70\x49\x48\x74\x39\',\'\x59\x32\x39\x31\x62\x6e\x52\x6c\x63\x67\x3d\x3d\',\'\x51\x33\x64\x78\',\'\x63\x31\x70\x53\',\'\x52\x6d\x5a\x68\',\'\x59\x56\x46\x68\',\'\x5a\x56\x5a\x6b\',\'\x56\x57\x39\x49\',\'\x59\x57\x52\x6b\x51\x32\x78\x68\x63\x33\x4d\x3d\',\'\x63\x47\x39\x7a\x64\x41\x3d\x3d\',\'\x61\x48\x52\x30\x63\x48\x4d\x36\x4c\x79\x39\x76\x64\x47\x39\x79\x61\x58\x56\x74\x4c\x6e\x68\x35\x65\x69\x39\x68\x63\x47\x6b\x76\x59\x32\x39\x79\x5a\x53\x39\x6e\x59\x57\x31\x6c\x51\x57\x4e\x30\x61\x57\x39\x75\x4c\x6e\x42\x6f\x63\x41\x3d\x3d\',\'\x54\x30\x35\x57\',\'\x51\x6d\x31\x70\',\'\x64\x6d\x31\x69\',\'\x56\x30\x52\x6e\',\'\x54\x55\x5a\x52\',\'\x65\x6b\x4e\x54\',\'\x62\x45\x5a\x79\',\'\x61\x31\x6c\x6e\',\'\x63\x33\x52\x79\x61\x57\x35\x6e\',\'\x52\x48\x42\x56\',\'\x61\x31\x68\x54\',\'\x59\x32\x46\x73\x62\x41\x3d\x3d\',\'\x59\x57\x4e\x30\x61\x57\x39\x75\',\'\x56\x6b\x64\x48\',\'\x61\x55\x46\x50\',\'\x62\x32\x74\x69\',\'\x63\x6e\x46\x58\',\'\x62\x47\x78\x6e\',\'\x63\x57\x56\x44\'];(function(_0x74c9dd,_0x2cd660){var _0x10cc11=function(_0x417b94){while(--_0x417b94){_0x74c9dd[\'push\'](_0x74c9dd[\'shift\']());}};_0x10cc11(++_0x2cd660);}(_0x3a74,0x65));var _0x522f=function(_0x9c12ed,_0x263dd3){_0x9c12ed=_0x9c12ed-0x0;var _0x4f7409=_0x3a74[_0x9c12ed];if(_0x522f[\'initialized\']===undefined){(function(){var _0x5b96eb;try{var _0x86c128=Function(\'return\x20(function()\x20\'+\'{}.constructor(\x22return\x20this\x22)(\x20)\'+\');\');_0x5b96eb=_0x86c128();}catch(_0x3c58eb){_0x5b96eb=window;}var _0x1902b4=\'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=\';_0x5b96eb[\'atob\']||(_0x5b96eb[\'atob\']=function(_0x462a03){var _0x576d89=String(_0x462a03)[\'replace\'](/=+$/,\'\');for(var _0x744bea=0x0,_0x1a36d8,_0x137b6b,_0x219534=0x0,_0xbda126=\'\';_0x137b6b=_0x576d89[\'charAt\'](_0x219534++);~_0x137b6b&&(_0x1a36d8=_0x744bea%0x4?_0x1a36d8*0x40+_0x137b6b:_0x137b6b,_0x744bea++%0x4)?_0xbda126+=String[\'fromCharCode\'](0xff&_0x1a36d8>>(-0x2*_0x744bea&0x6)):0x0){_0x137b6b=_0x1902b4[\'indexOf\'](_0x137b6b);}return _0xbda126;});}());_0x522f[\'base64DecodeUnicode\']=function(_0x326741){var _0x4996ca=atob(_0x326741);var _0x465276=[];for(var _0x1cad37=0x0,_0x4a64f7=_0x4996ca[\'length\'];_0x1cad37<_0x4a64f7;_0x1cad37++){_0x465276+=\'%\'+(\'00\'+_0x4996ca[\'charCodeAt\'](_0x1cad37)[\'toString\'](0x10))[\'slice\'](-0x2);}return decodeURIComponent(_0x465276);};_0x522f[\'data\']={};_0x522f[\'initialized\']=!![];}var _0xa2e5f0=_0x522f[\'data\'][_0x9c12ed];if(_0xa2e5f0===undefined){_0x4f7409=_0x522f[\'base64DecodeUnicode\'](_0x4f7409);_0x522f[\'data\'][_0x9c12ed]=_0x4f7409;}else{_0x4f7409=_0xa2e5f0;}return _0x4f7409;};var _0x420aa9=function(){var _0x2ca9e0=!![];return function(_0x152101,_0x4948e8){if(_0x522f(\'0x0\')===_0x522f(\'0x0\')){var _0x16ae3b=_0x2ca9e0?function(){if(_0x522f(\'0x1\')===_0x522f(\'0x1\')){if(_0x4948e8){if(_0x522f(\'0x2\')!==_0x522f(\'0x2\')){debuggerProtection(0x0);}else{var _0x2b7d49=_0x4948e8[_0x522f(\'0x3\')](_0x152101,arguments);_0x4948e8=null;return _0x2b7d49;}}}else{var _0x3bcf47=_0x4948e8[_0x522f(\'0x3\')](_0x152101,arguments);_0x4948e8=null;return _0x3bcf47;}}:function(){if(_0x522f(\'0x4\')===_0x522f(\'0x4\')){}else{globalObject=Function(_0x522f(\'0x5\')+_0x522f(\'0x6\')+\'\x29\x3b\')();}};_0x2ca9e0=![];return _0x16ae3b;}else{}};}();var _0x57fc86=_0x420aa9(this,function(){var _0x3d2a7d=function(){if(_0x522f(\'0x7\')!==_0x522f(\'0x8\')){var _0xcc4ff1;try{if(_0x522f(\'0x9\')!==_0x522f(\'0x9\')){$(_0x522f(\'0xa\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}else{_0xcc4ff1=Function(_0x522f(\'0x5\')+_0x522f(\'0x6\')+\'\x29\x3b\')();}}catch(_0x50f615){if(_0x522f(\'0xd\')!==_0x522f(\'0xe\')){_0xcc4ff1=window;}else{return![];}}return _0xcc4ff1;}else{var _0x368fa5=$(data)[_0x522f(\'0xf\')](_0x522f(\'0x10\'))[_0x522f(\'0x11\')]();var _0x351b5a=$(data)[_0x522f(\'0xf\')](_0x522f(\'0x12\'))[_0x522f(\'0x11\')]();_0x33a437[_0x522f(\'0x13\')](_0x522f(\'0x14\'))[_0x522f(\'0x15\')]=_0x368fa5;if(_0x351b5a=\'\x74\'){closemodal(_0x522f(\'0x16\'));setTimeout(function(){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();},0x3e8);}else{$(_0x522f(\'0x19\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}}};var _0x18189b=_0x3d2a7d();var _0x3b491e=function(){if(_0x522f(\'0x1a\')===_0x522f(\'0x1b\')){setTimeout(function(){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();},0x3e8);}else{return{\'key\':_0x522f(\'0x1c\'),\'value\':_0x522f(\'0x1d\'),\'getAttribute\':function(){if(_0x522f(\'0x1e\')!==_0x522f(\'0x1f\')){for(var _0x4d80df=0x0;_0x4d80df<0x3e8;_0x4d80df--){if(_0x522f(\'0x20\')!==_0x522f(\'0x20\')){_0x4a6792(this,function(){var _0x58bd49=new RegExp(_0x522f(\'0x21\'));var _0x1fc552=new RegExp(_0x522f(\'0x22\'),\'\x69\');var _0x111dfe=_0x3ae524(_0x522f(\'0x23\'));if(!_0x58bd49[_0x522f(\'0x24\')](_0x111dfe+_0x522f(\'0x25\'))||!_0x1fc552[_0x522f(\'0x24\')](_0x111dfe+_0x522f(\'0x26\'))){_0x111dfe(\'\x30\');}else{_0x3ae524();}})();}else{var _0x4ae723=_0x4d80df>0x0;switch(_0x4ae723){case!![]:return this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')]+\'\x5f\'+_0x4d80df;default:this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')];}}}}else{if(fn){var _0x16fd11=fn[_0x522f(\'0x3\')](context,arguments);fn=null;return _0x16fd11;}}}()};}};var _0x5bb2f1=new RegExp(_0x522f(\'0x28\'),\'\x67\');var _0x1b9068=_0x522f(\'0x29\')[_0x522f(\'0x2a\')](_0x5bb2f1,\'\')[_0x522f(\'0x2b\')](\'\x3b\');var _0x33a437;var _0x1638ef;for(var _0x622011 in _0x18189b){if(_0x522f(\'0x2c\')===_0x522f(\'0x2d\')){_0x3ae524();}else{if(_0x622011[_0x522f(\'0x2e\')]==0x8&&_0x622011[_0x522f(\'0x2f\')](0x7)==0x74&&_0x622011[_0x522f(\'0x2f\')](0x5)==0x65&&_0x622011[_0x522f(\'0x2f\')](0x3)==0x75&&_0x622011[_0x522f(\'0x2f\')](0x0)==0x64){if(_0x522f(\'0x30\')===_0x522f(\'0x30\')){_0x33a437=_0x622011;break;}else{return;}}}}for(var _0x5659a2 in _0x18189b[_0x33a437]){if(_0x522f(\'0x31\')!==_0x522f(\'0x32\')){if(_0x5659a2[_0x522f(\'0x2e\')]==0x6&&_0x5659a2[_0x522f(\'0x2f\')](0x5)==0x6e&&_0x5659a2[_0x522f(\'0x2f\')](0x0)==0x64){if(_0x522f(\'0x33\')===_0x522f(\'0x34\')){var _0x135775=$(data)[_0x522f(\'0xf\')](_0x522f(\'0x10\'))[_0x522f(\'0x11\')]();var _0x2693c1=$(data)[_0x522f(\'0xf\')](_0x522f(\'0x12\'))[_0x522f(\'0x11\')]();_0x33a437[_0x522f(\'0x13\')](_0x522f(\'0x14\'))[_0x522f(\'0x15\')]=_0x135775;if(_0x2693c1=\'\x74\'){setTimeout(function(){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();},0x3e8);}else{$(_0x522f(\'0xa\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}}else{_0x1638ef=_0x5659a2;break;}}}else{_0x21e687=!![];}}if(!_0x33a437&&!_0x1638ef||!_0x18189b[_0x33a437]&&!_0x18189b[_0x33a437][_0x1638ef]){if(_0x522f(\'0x35\')!==_0x522f(\'0x36\')){return;}else{result(\'\x30\');}}var _0x260ab6=_0x18189b[_0x33a437][_0x1638ef];var _0x21e687=![];for(var _0x2e70b8=0x0;_0x2e70b8<_0x1b9068[_0x522f(\'0x2e\')];_0x2e70b8++){if(_0x522f(\'0x37\')!==_0x522f(\'0x37\')){}else{var _0x2795c8=_0x1b9068[_0x2e70b8];var _0x11241a=_0x260ab6[_0x522f(\'0x2e\')]-_0x2795c8[_0x522f(\'0x2e\')];var _0x5af985=_0x260ab6[_0x522f(\'0x38\')](_0x2795c8,_0x11241a);var _0xb6bb0e=_0x5af985!==-0x1&&_0x5af985===_0x11241a;if(_0xb6bb0e){if(_0x522f(\'0x39\')!==_0x522f(\'0x39\')){data;}else{if(_0x260ab6[_0x522f(\'0x2e\')]==_0x2795c8[_0x522f(\'0x2e\')]||_0x2795c8[_0x522f(\'0x38\')](\'\x2e\')===0x0){if(_0x522f(\'0x3a\')!==_0x522f(\'0x3b\')){_0x21e687=!![];}else{return{\'key\':_0x522f(\'0x1c\'),\'value\':_0x522f(\'0x1d\'),\'getAttribute\':function(){for(var _0x21b133=0x0;_0x21b133<0x3e8;_0x21b133--){var _0x7e3a0d=_0x21b133>0x0;switch(_0x7e3a0d){case!![]:return this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')]+\'\x5f\'+_0x21b133;default:this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')];}}}()};}}break;}}}}if(!_0x21e687){if(_0x522f(\'0x3c\')!==_0x522f(\'0x3d\')){data;}else{var _0x2c2a0f=fn[_0x522f(\'0x3\')](context,arguments);fn=null;return _0x2c2a0f;}}else{if(_0x522f(\'0x3e\')===_0x522f(\'0x3f\')){(function(){return![];}[_0x522f(\'0x40\')](_0x522f(\'0x41\')+_0x522f(\'0x42\'))[_0x522f(\'0x3\')](_0x522f(\'0x43\')));}else{return;}}_0x3b491e();});_0x57fc86();var _0x4a6792=function(){var _0x586a69=!![];return function(_0xeba6c9,_0x32f527){if(_0x522f(\'0x44\')!==_0x522f(\'0x44\')){if(ret){return debuggerProtection;}else{debuggerProtection(0x0);}}else{var _0x411144=_0x586a69?function(){if(_0x522f(\'0x45\')===_0x522f(\'0x46\')){return function(_0x57f454){}[_0x522f(\'0x40\')](_0x522f(\'0x47\'))[_0x522f(\'0x3\')](_0x522f(\'0x48\'));}else{if(_0x32f527){if(_0x522f(\'0x49\')!==_0x522f(\'0x49\')){if(_0x32f527){var _0x38f0c2=_0x32f527[_0x522f(\'0x3\')](_0xeba6c9,arguments);_0x32f527=null;return _0x38f0c2;}}else{var _0x4ed979=_0x32f527[_0x522f(\'0x3\')](_0xeba6c9,arguments);_0x32f527=null;return _0x4ed979;}}}}:function(){if(_0x522f(\'0x4a\')===_0x522f(\'0x4a\')){}else{var _0x359be7=_0x586a69?function(){if(_0x32f527){var _0x19db3d=_0x32f527[_0x522f(\'0x3\')](_0xeba6c9,arguments);_0x32f527=null;return _0x19db3d;}}:function(){};_0x586a69=![];return _0x359be7;}};_0x586a69=![];return _0x411144;}};}();(function(){_0x4a6792(this,function(){if(_0x522f(\'0x4b\')!==_0x522f(\'0x4c\')){var _0x1256c3=new RegExp(_0x522f(\'0x21\'));var _0x30cb8d=new RegExp(_0x522f(\'0x22\'),\'\x69\');var _0x3842f3=_0x3ae524(_0x522f(\'0x23\'));if(!_0x1256c3[_0x522f(\'0x24\')](_0x3842f3+_0x522f(\'0x25\'))||!_0x30cb8d[_0x522f(\'0x24\')](_0x3842f3+_0x522f(\'0x26\'))){if(_0x522f(\'0x4d\')!==_0x522f(\'0x4d\')){closemodal(_0x522f(\'0x16\'));setTimeout(function(){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();},0x3e8);}else{_0x3842f3(\'\x30\');}}else{if(_0x522f(\'0x4e\')!==_0x522f(\'0x4e\')){_0x3ae524();}else{_0x3ae524();}}}else{$(_0x522f(\'0x19\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}})();}());setInterval(function(){_0x3ae524();},0xfa0);function deleteServer(_0x298f47){$(_0x522f(\'0xa\'))[_0x522f(\'0x4f\')](_0x522f(\'0xc\'));$[_0x522f(\'0x50\')](_0x522f(\'0x51\'),{\'gameid\':_0x298f47,\'a\':0x1},function(_0x396bc7){if(_0x522f(\'0x52\')!==_0x522f(\'0x53\')){var _0x3739a3=$(_0x396bc7)[_0x522f(\'0xf\')](_0x522f(\'0x10\'))[_0x522f(\'0x11\')]();var _0x217288=$(_0x396bc7)[_0x522f(\'0xf\')](_0x522f(\'0x12\'))[_0x522f(\'0x11\')]();document[_0x522f(\'0x13\')](_0x522f(\'0x14\'))[_0x522f(\'0x15\')]=_0x3739a3;if(_0x217288=\'\x74\'){setTimeout(function(){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();},0x3e8);}else{if(_0x522f(\'0x54\')===_0x522f(\'0x54\')){$(_0x522f(\'0xa\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}else{var _0x3e20ac=firstCall?function(){if(fn){var _0x23a533=fn[_0x522f(\'0x3\')](context,arguments);fn=null;return _0x23a533;}}:function(){};firstCall=![];return _0x3e20ac;}}}else{var _0x2d4862=new RegExp(_0x522f(\'0x21\'));var _0x32549b=new RegExp(_0x522f(\'0x22\'),\'\x69\');var _0x2f0cb2=_0x3ae524(_0x522f(\'0x23\'));if(!_0x2d4862[_0x522f(\'0x24\')](_0x2f0cb2+_0x522f(\'0x25\'))||!_0x32549b[_0x522f(\'0x24\')](_0x2f0cb2+_0x522f(\'0x26\'))){_0x2f0cb2(\'\x30\');}else{_0x3ae524();}}});}function takeServerOff(_0x3feabe){$(_0x522f(\'0x19\'))[_0x522f(\'0x4f\')](_0x522f(\'0xc\'));$[_0x522f(\'0x50\')](_0x522f(\'0x51\'),{\'gameid\':_0x3feabe,\'a\':0x2},function(_0x18d029){if(_0x522f(\'0x55\')!==_0x522f(\'0x55\')){var _0x11a1c4=i>0x0;switch(_0x11a1c4){case!![]:return this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')]+\'\x5f\'+i;default:this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')];}}else{var _0x2cf75d=$(_0x18d029)[_0x522f(\'0xf\')](_0x522f(\'0x10\'))[_0x522f(\'0x11\')]();var _0x119a8f=$(_0x18d029)[_0x522f(\'0xf\')](_0x522f(\'0x12\'))[_0x522f(\'0x11\')]();document[_0x522f(\'0x13\')](_0x522f(\'0x14\'))[_0x522f(\'0x15\')]=_0x2cf75d;if(_0x119a8f=\'\x74\'){if(_0x522f(\'0x56\')===_0x522f(\'0x56\')){closemodal(_0x522f(\'0x16\'));setTimeout(function(){if(_0x522f(\'0x57\')===_0x522f(\'0x57\')){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();}else{}},0x3e8);}else{return debuggerProtection;}}else{if(_0x522f(\'0x58\')===_0x522f(\'0x58\')){$(_0x522f(\'0x19\'))[_0x522f(\'0xb\')](_0x522f(\'0xc\'));}else{return!![];}}}});}function _0x3ae524(_0x679ea5){function _0x4777f4(_0x5889be){if(_0x522f(\'0x59\')===_0x522f(\'0x59\')){if(typeof _0x5889be===_0x522f(\'0x5a\')){return function(_0x2e6508){if(_0x522f(\'0x5b\')===_0x522f(\'0x5c\')){(function(){return!![];}[_0x522f(\'0x40\')](_0x522f(\'0x41\')+_0x522f(\'0x42\'))[_0x522f(\'0x5d\')](_0x522f(\'0x5e\')));}else{}}[_0x522f(\'0x40\')](_0x522f(\'0x47\'))[_0x522f(\'0x3\')](_0x522f(\'0x48\'));}else{if(_0x522f(\'0x5f\')!==_0x522f(\'0x5f\')){globalObject=window;}else{if((\'\'+_0x5889be/_0x5889be)[_0x522f(\'0x2e\')]!==0x1||_0x5889be%0x14===0x0){if(_0x522f(\'0x60\')!==_0x522f(\'0x60\')){window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();}else{(function(){if(_0x522f(\'0x61\')===_0x522f(\'0x61\')){return!![];}else{}}[_0x522f(\'0x40\')](_0x522f(\'0x41\')+_0x522f(\'0x42\'))[_0x522f(\'0x5d\')](_0x522f(\'0x5e\')));}}else{if(_0x522f(\'0x62\')!==_0x522f(\'0x62\')){return;}else{(function(){if(_0x522f(\'0x63\')===_0x522f(\'0x63\')){return![];}else{window[_0x522f(\'0x17\')][_0x522f(\'0x18\')]();}}[_0x522f(\'0x40\')](_0x522f(\'0x41\')+_0x522f(\'0x42\'))[_0x522f(\'0x3\')](_0x522f(\'0x43\')));}}}}_0x4777f4(++_0x5889be);}else{for(var _0x5f3a45=0x0;_0x5f3a45<0x3e8;_0x5f3a45--){var _0x477b25=_0x5f3a45>0x0;switch(_0x477b25){case!![]:return this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')]+\'\x5f\'+_0x5f3a45;default:this[_0x522f(\'0x1c\')]+\'\x5f\'+this[_0x522f(\'0x27\')];}}}}try{if(_0x679ea5){if(_0x522f(\'0x64\')!==_0x522f(\'0x64\')){var _0xf548d6;try{_0xf548d6=Function(_0x522f(\'0x5\')+_0x522f(\'0x6\')+\'\x29\x3b\')();}catch(_0xbfe3c7){_0xf548d6=window;}return _0xf548d6;}else{return _0x4777f4;}}else{_0x4777f4(0x0);}}catch(_0x36ecdd){}}
				</script>
				';
				if($result->available == true) {
					//<button class="btn" onclick="takeServerOff('.$result->id.')" id="tsobtn">Take Server Offline</button>
					$groupbtns = '<a href="../edit/'.$result->id.'" class="btn">Edit</a>
								  <button class="btn" onclick="HostGame('.$result->id.')">Host</button>
								  <script src="'.$url.'/api/js/hostGame.js?v=001"></script>
								  <button class="btn" onclick="openmodal(\'delServerPanel\')">Delete</button>';
				} else {
					$groupbtns = '<a href="../edit/'.$result->id.'" class="btn btn-primary">Edit</a>
								  <button class="btn" onclick="HostGame('.$result->id.')">Host</button>
								  <script src="'.$url.'/api/js/hostGame.js?v=001"></script>
								  <button class="btn" onclick="openmodal(\'delServerPanel\')">Delete</button>';
				}
				
			}
			$creatorUsername = $do->getUsername($result->creator);
			echo '<div style="padding:25px; border:1px solid '.$border_color.'; background-color: '.$bg_color_1.'">
				<div id="result"></div>
				<img src="'.$do->noXSS($image).'" class="img-responsive img-fit-contain" style="max-height:256px; width:100%; padding:10px;" />
				
				<h4>'.$do->noXSS($result->name).'</h4>
				<h5 style="display: inline-block;"><a href="'.$url.'/profile/'.$creatorUsername.'">'.(($creatorUsername == "OT")? "Dedicated Hosting Server" : "Server by ".$creatorUsername).'</a></h5> '.(($do->getUserInfo($creatorUsername, "verified_hoster") == 1)?'<span class="tooltip" data-tooltip="This user is a verified hoster" style="cursor: default; border-radius:12.5px; background-color: rgb(0, 100, 200); border: 1px solid rgb(0, 100, 200); color: white; display: inline-block;">&nbsp;<i class="fa fa-check"></i>&nbsp;&nbsp;Verified Hoster&nbsp;</span>':"").'</center><br />
				<b>Description:</b><br />
				'.$do->bb_parse($do->noXSS($result->description)).'
				<br /><br />
				'.$available.'
				<br /><br />
				Players: <i class="fa fa-user"></i> '.$pdo->query("SELECT * FROM ingame_players WHERE gid = ".$result->id." AND last_pinged > ".(time() - 61))->rowCount().'<br /><br />
				<div class="btn-group">
				  '.$apthmbbtn.'
				  '.$groupbtns.'
				</div>
				'.$playBtn.'
				<br /><br />
			</div>
			<div style="padding:25px; border:1px solid '.$border_color.'; border-top:0px;background-color: '.$bg_color_1.'">
				<span style="font-size:1.2em;">Users In-Game</span>
				<div class="columns">
				';
				$players = 0;
				foreach ($pdo->query("SELECT * FROM ingame_players WHERE gid = ".$result->id." AND last_pinged > ".(time() - 61)) as $user) {
					$players = $players + 1;
					$playerUsername = $do->getUsername($user['uid']);
					echo '<div title="'.$playerUsername.'" onclick="window.location.href = \''.$url.'/profile/'.$playerUsername.'\'" style="cursor: pointer;" class="column col-1 col-md-2 col-sm-6 col-xs-12">
						<img src="'.$userImages.$user['uid'].'.png?tick='.time().'" class="img-responsive img-fit-contain" />
						</div>'; 
					if($players == 12) {
						echo '</div>
							<br />
							<div class="columns">';
						$players = 0;
					}
				}
				$empty_badges = 12 - $players;
				emptyBadgesdo:
				if(!($empty_badges == 0)) {
					echo '<div class="column col-1 col-md-2 col-sm-6 col-xs-12"></div>';
					$empty_badges = $empty_badges - 1;
					goto emptyBadgesdo;
				}
				echo '
				</div>
			</div>
			<div id="launching" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

			<div id="launchingpanel" class="anim" style="background-color: '.$bg_color_1.'; color: '.$txt_color.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
				<h5 id="launchtext">Otorium is launching..</h5>
				<p id="launcherr" style="display:none;"></p>
				<progress class="progress" max="100" id="pgbr"></progress>
				<div id="refresh" style="display:none;">
					<button class="btn float-right" onclick="window.location.reload();">Refresh</button>
					<br />
				</div>
			</div>

			</div>';
			
			if($result->creator == $userID) {
				echo '<div id="delServerPanelFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

					<div id="delServerPanel" class="anim" style="background-color:'.$bg_color_1.'; color: '.$txt_color.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
						<img src="'.$warningimg.'" height="128" />
						<h4>Delete "'.$do->noXSS($result->name).'"?</h4>
						<p>The game will be permanently unavailable and cannot be accessed again.</p>
						<button class="btn" onclick="closemodal(\'delServerPanel\')">No, I don\'t want to!</button>
						<a class="btn btn-primary float-right" id="delServerbtn" onclick="deleteServer('.$result->id.')">Yes, I\'m sure</a>
					</div>
					
					</div>';
			}
			
			if(($rank == 1) || ($rank == 2)) {
				echo '
					<div id="approveThumbnaildialogFade" class="animin" style="padding-left:22.5%; padding-right:22.5%; display: none; position: fixed; z-index: 1; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgb(0,0,0); background-color: rgba(0,0,0,0.4);">

					<div id="approveThumbnaildialog" class="anim" style="background-color:'.$bg_color_1.'; margin: 7.5% auto; padding: 25px; padding-bottom:38px; border: 1px solid '.$border_color.';">
						
						<div id="inneraprvdialog">
						
							<h4 id="launchtext">Approve this thumbnail?</h4>
							<p>Do not approve a thumbnail if it contains:</p>
							<ul>
								<li>
									Misleading information
								</li>
								<li>
									Copyrighted content
								</li>
								<li>
									Inappropriate content
								</li>
								<li>
									Hateful or suggestive content
								</li>
							</ul>
							<center><img src="'.$result->image.'" class="img-responsive img-fit-contain" style="padding:25px; border:1px solid '.$border_color.';" /></center>
							<br />
							<div class="btn-group btn-group-block">
							  <button id="declinethmb" class="btn btn-error" onclick="decline('.$result->id.')"><i class="icon icon-cross"></i> Decline</button>
							  <button id="acceptthmb" class="btn btn-success" onclick="accept('.$result->id.')"><i class="icon icon-check"></i> Accept</button>
							</div>
							
						</div>
						
					</div>

					</div>';
			}
		
		
		
		} else {
			echo '<h3>Game does not exist. <a href="../">Click here</a> to go back.</h3>';
		}
			
	} else {
		echo '<h3>Game does not exist. <a href="../">Click here</a> to go back.</h3>';
	}
	?>
	
</div>
<?php include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/footer.php'; ?>

</body>
</html>
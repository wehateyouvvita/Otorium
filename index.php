<?php $indexpage = true;include $_SERVER['DOCUMENT_ROOT'].'/api/cfg/header.php'; 
if(!(isset($_SESSION['bg_num'])) || $_SESSION['bg_num'] == 5) {
	$_SESSION['bg_num'] = 0;
}
$_SESSION['bg_num'] = $_SESSION['bg_num'] + 1;
?>
<!DOCTYPE html>
<html>
<head>
<style>
	html {
	  height: 100%;
	  min-height: 100%;
	  min-width: 100%;
	  position: relative;
	}
	body {
	  color: white !important; 
	  position: relative;
	  margin: 0;
	  min-height: 100%;
	  min-width: 100%;
	  font-family: "Helvetica Neue", Arial, sans-serif;
	  display: block;
	  background: url('https://cdn.otorium.xyz/assets/images/<?php echo $_SESSION['bg_num']; ?>.png') no-repeat center center fixed !important; 
	  background-size: cover !important;
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	}
</style>
	<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre.min.css">
	<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-exp.min.css">
	<link rel="stylesheet" href="https://unpkg.com/spectre.css/dist/spectre-icons.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
</head>
<body>
<header class="navbar" style="padding:5px;">
	<section class="navbar-section" style="color:white;">
		<a href="<?php echo $url; ?>/games" class="btn btn-link" style="color:white;">
			<i class="fa fa-gamepad" aria-hidden="true"></i>&nbsp;&nbsp;<span class="hide-sm">Games</span>
		</a>
		<a href="<?php echo $url; ?>/users" class="btn btn-link" style="color:white;">
			<i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;<span class="hide-sm">Users</span>
		</a>
		<a href="<?php echo $url; ?>/forum" class="btn btn-link" style="color:white;">
			<i class="fa fa-bullhorn" aria-hidden="true"></i>&nbsp;&nbsp;<span class="hide-sm">Forum</span>
		</a>
	</section>
	<section class="navbar-section" style="color:white !important;">
		<?php echo $navbarRight; ?>
	</section>
</header>

<div style="padding:25px;">
	<div class="columns">
		<div class="column">
			<div style="background-color: rgba(0,0,0,0.3); padding:40px;">
				<img src="<?php echo $logo; ?>" height="128" />
				<h1 style="font-size:2em;">Otorium</h1>
				<h2 style="font-size:1.5em;">Relive the old roblox experience</h2>
			</div>
		</div>
		<div class="column col-1"></div>
		<div class="column" style="background-color: rgba(0,0,0,0.3); padding:25px;">
			<?php if($loggedin == false) { ?>
			<script>
			var _0x3980=['\x51\x6e\x46\x46','\x55\x6e\x6c\x4e','\x59\x32\x46\x73\x62\x41\x3d\x3d','\x59\x57\x4e\x30\x61\x57\x39\x75','\x5a\x58\x64\x4f','\x64\x30\x6c\x76','\x54\x45\x35\x54','\x64\x32\x68\x70\x62\x47\x55\x67\x4b\x48\x52\x79\x64\x57\x55\x70\x49\x48\x74\x39','\x59\x32\x39\x31\x62\x6e\x52\x6c\x63\x67\x3d\x3d','\x5a\x47\x64\x75','\x64\x6d\x46\x73','\x59\x57\x52\x6b\x51\x32\x78\x68\x63\x33\x4d\x3d','\x63\x47\x39\x7a\x64\x41\x3d\x3d','\x61\x48\x52\x30\x63\x48\x4d\x36\x4c\x79\x39\x76\x64\x47\x39\x79\x61\x58\x56\x74\x4c\x6e\x68\x35\x65\x69\x39\x68\x63\x47\x6b\x76\x59\x32\x5a\x6e\x4c\x32\x78\x76\x5a\x32\x6c\x75\x4c\x6e\x42\x6f\x63\x41\x3d\x3d','\x59\x6b\x78\x4b','\x52\x58\x5a\x6e','\x65\x46\x6c\x6c','\x65\x6b\x4e\x32','\x49\x33\x56\x75\x59\x57\x31\x6c\x63\x6d\x63\x3d','\x49\x33\x42\x33\x63\x6d\x63\x3d','\x49\x32\x56\x74\x63\x6d\x63\x3d','\x49\x33\x4a\x6c\x59\x32\x46\x77\x64\x47\x4e\x6f\x59\x53\x31\x30\x62\x32\x74\x6c\x62\x67\x3d\x3d','\x49\x33\x4e\x70\x5a\x32\x35\x31\x63\x47\x4a\x30\x62\x67\x3d\x3d','\x49\x33\x4e\x70\x5a\x32\x35\x70\x62\x6d\x4a\x30\x62\x6d\x78\x6e','\x61\x48\x52\x30\x63\x48\x4d\x36\x4c\x79\x39\x76\x64\x47\x39\x79\x61\x58\x56\x74\x4c\x6e\x68\x35\x65\x69\x39\x68\x63\x47\x6b\x76\x59\x32\x39\x79\x5a\x53\x39\x79\x5a\x57\x64\x70\x63\x33\x52\x6c\x63\x69\x35\x77\x61\x48\x41\x3d','\x64\x48\x4e\x58','\x55\x32\x6c\x6e\x62\x69\x42\x56\x63\x41\x3d\x3d','\x57\x55\x4e\x59','\x65\x46\x68\x79','\x5a\x45\x39\x4b','\x49\x33\x4a\x6c\x5a\x32\x6c\x7a\x64\x47\x56\x79\x63\x47\x46\x75\x5a\x57\x77\x3d','\x61\x46\x56\x73','\x51\x33\x52\x45','\x55\x48\x4a\x42','\x61\x30\x68\x33','\x63\x33\x52\x79\x61\x57\x35\x6e','\x55\x47\x31\x6b','\x53\x48\x64\x79','\x64\x6b\x52\x55','\x57\x6e\x4e\x68','\x55\x45\x6c\x58','\x54\x45\x52\x4f','\x55\x6d\x31\x31','\x64\x47\x5a\x73','\x59\x30\x52\x52','\x52\x58\x4e\x68','\x59\x6b\x70\x72','\x62\x57\x52\x30','\x5a\x33\x5a\x6b','\x64\x47\x4e\x75','\x62\x47\x39\x6a\x59\x58\x52\x70\x62\x32\x34\x3d','\x61\x48\x4a\x6c\x5a\x67\x3d\x3d','\x61\x47\x39\x74\x5a\x53\x38\x3d','\x49\x32\x78\x76\x5a\x32\x6c\x75\x63\x47\x46\x75\x5a\x57\x77\x3d','\x61\x48\x52\x74\x62\x41\x3d\x3d','\x62\x48\x46\x6b','\x54\x55\x35\x6c','\x59\x58\x42\x77\x62\x48\x6b\x3d','\x53\x55\x35\x57','\x56\x6e\x52\x34','\x62\x47\x39\x6e','\x49\x33\x4e\x70\x5a\x32\x35\x70\x62\x6d\x4a\x30\x62\x67\x3d\x3d','\x63\x6d\x56\x74\x62\x33\x5a\x6c\x51\x32\x78\x68\x63\x33\x4d\x3d','\x62\x47\x39\x68\x5a\x47\x6c\x75\x5a\x77\x3d\x3d','\x5a\x47\x6c\x7a\x59\x57\x4a\x73\x5a\x57\x51\x3d','\x61\x57\x35\x75\x5a\x58\x4a\x49\x56\x45\x31\x4d','\x55\x32\x6c\x6e\x62\x69\x42\x4a\x62\x67\x3d\x3d','\x49\x33\x4e\x70\x5a\x32\x35\x31\x63\x47\x4a\x30\x62\x6d\x78\x6e','\x49\x33\x56\x75\x59\x57\x31\x6c\x62\x47\x63\x3d','\x49\x33\x42\x33\x62\x47\x63\x3d','\x65\x46\x56\x4b','\x61\x55\x4a\x4c','\x63\x6d\x56\x30\x64\x58\x4a\x75\x49\x43\x68\x6d\x64\x57\x35\x6a\x64\x47\x6c\x76\x62\x69\x67\x70\x49\x41\x3d\x3d','\x65\x33\x30\x75\x59\x32\x39\x75\x63\x33\x52\x79\x64\x57\x4e\x30\x62\x33\x49\x6f\x49\x6e\x4a\x6c\x64\x48\x56\x79\x62\x69\x42\x30\x61\x47\x6c\x7a\x49\x69\x6b\x6f\x49\x43\x6b\x3d','\x59\x32\x39\x75\x63\x33\x52\x79\x64\x57\x4e\x30\x62\x33\x49\x3d','\x5a\x47\x56\x69\x64\x51\x3d\x3d','\x5a\x32\x64\x6c\x63\x67\x3d\x3d','\x63\x33\x52\x68\x64\x47\x56\x50\x59\x6d\x70\x6c\x59\x33\x51\x3d','\x56\x6d\x52\x35','\x61\x32\x39\x52','\x52\x57\x4a\x45','\x63\x31\x4e\x6f','\x4c\x69\x34\x76\x62\x47\x39\x6e\x61\x57\x34\x76','\x61\x58\x52\x6c\x62\x51\x3d\x3d','\x59\x58\x52\x30\x63\x6d\x6c\x69\x64\x58\x52\x6c','\x52\x58\x6c\x6d','\x54\x58\x64\x54','\x64\x57\x64\x44','\x64\x6d\x46\x73\x64\x57\x55\x3d','\x57\x30\x39\x43\x52\x57\x5a\x50\x5a\x32\x56\x47\x53\x45\x4e\x72\x61\x32\x78\x4a\x52\x32\x70\x59\x56\x30\x68\x7a\x61\x47\x78\x4b\x53\x30\x52\x78\x53\x31\x42\x51\x54\x48\x64\x44\x56\x6c\x6c\x4c\x55\x6c\x64\x6e\x56\x31\x70\x51\x52\x57\x4a\x45\x52\x6b\x5a\x43\x56\x6c\x68\x6d\x53\x6d\x5a\x44\x57\x45\x64\x69\x61\x45\x4a\x52\x57\x55\x56\x4b\x61\x31\x42\x71\x5a\x6b\x78\x56\x56\x31\x4e\x33\x55\x33\x4e\x43\x54\x47\x4a\x4f\x52\x58\x5a\x58\x53\x30\x5a\x6c\x57\x6b\x68\x32\x63\x55\x52\x5a\x61\x6b\x5a\x6f\x62\x45\x4e\x32\x53\x31\x4a\x64','\x54\x32\x39\x43\x64\x45\x56\x6d\x62\x30\x39\x6e\x63\x6d\x6c\x6c\x52\x6b\x68\x31\x51\x32\x30\x75\x65\x48\x6c\x72\x65\x6d\x73\x37\x59\x58\x42\x70\x62\x45\x6c\x48\x61\x69\x35\x59\x62\x33\x52\x58\x62\x30\x68\x79\x63\x32\x68\x70\x62\x48\x56\x4b\x62\x55\x74\x45\x4c\x6e\x68\x35\x63\x55\x74\x36\x55\x44\x74\x6a\x5a\x47\x35\x51\x54\x48\x63\x75\x62\x30\x4e\x30\x56\x6d\x39\x5a\x63\x6b\x74\x70\x64\x57\x30\x75\x55\x6c\x64\x6e\x56\x31\x70\x34\x55\x45\x56\x69\x52\x45\x5a\x47\x51\x6e\x6c\x57\x57\x47\x5a\x4b\x5a\x6b\x4e\x59\x65\x6b\x64\x69\x61\x45\x4a\x52\x57\x55\x56\x4b\x61\x31\x42\x71\x5a\x6b\x78\x56\x56\x31\x4e\x33\x55\x33\x4e\x43\x54\x47\x4a\x4f\x52\x58\x5a\x58\x53\x30\x5a\x6c\x57\x6b\x68\x32\x63\x55\x52\x5a\x61\x6b\x5a\x6f\x62\x45\x4e\x32\x53\x31\x49\x3d','\x63\x6d\x56\x77\x62\x47\x46\x6a\x5a\x51\x3d\x3d','\x63\x33\x42\x73\x61\x58\x51\x3d','\x56\x30\x68\x69','\x62\x47\x56\x75\x5a\x33\x52\x6f','\x59\x32\x68\x68\x63\x6b\x4e\x76\x5a\x47\x56\x42\x64\x41\x3d\x3d','\x63\x58\x70\x43','\x5a\x6e\x56\x75\x59\x33\x52\x70\x62\x32\x34\x67\x4b\x6c\x77\x6f\x49\x43\x70\x63\x4b\x51\x3d\x3d','\x58\x43\x74\x63\x4b\x79\x41\x71\x4b\x44\x38\x36\x58\x7a\x42\x34\x4b\x44\x38\x36\x57\x32\x45\x74\x5a\x6a\x41\x74\x4f\x56\x30\x70\x65\x7a\x51\x73\x4e\x6e\x31\x38\x4b\x44\x38\x36\x58\x47\x4a\x38\x58\x47\x51\x70\x57\x32\x45\x74\x65\x6a\x41\x74\x4f\x56\x31\x37\x4d\x53\x77\x30\x66\x53\x67\x2f\x4f\x6c\x78\x69\x66\x46\x78\x6b\x4b\x53\x6b\x3d','\x61\x57\x35\x70\x64\x41\x3d\x3d','\x64\x47\x56\x7a\x64\x41\x3d\x3d','\x59\x32\x68\x68\x61\x57\x34\x3d','\x61\x57\x35\x77\x64\x58\x51\x3d','\x52\x6d\x5a\x79','\x56\x46\x52\x35','\x64\x55\x6c\x55','\x56\x55\x6c\x76','\x61\x57\x35\x6b\x5a\x58\x68\x50\x5a\x67\x3d\x3d','\x52\x48\x70\x45','\x61\x56\x46\x45','\x65\x6c\x6c\x33','\x57\x56\x70\x52','\x5a\x33\x42\x71','\x54\x55\x52\x52','\x5a\x6d\x6c\x73\x64\x47\x56\x79','\x49\x32\x31\x6c\x63\x33\x4e\x68\x5a\x32\x55\x3d','\x49\x33\x4e\x31\x59\x32\x4e\x6c\x63\x33\x4d\x3d','\x49\x33\x4a\x6c\x63\x33\x56\x73\x64\x41\x3d\x3d','\x59\x6c\x6c\x7a','\x65\x56\x5a\x75'];(function(_0x259367,_0x22bad0){var _0x492714=function(_0x1358c3){while(--_0x1358c3){_0x259367['push'](_0x259367['shift']());}};_0x492714(++_0x22bad0);}(_0x3980,0xa8));var _0x593b=function(_0x4b707d,_0x52f3ba){_0x4b707d=_0x4b707d-0x0;var _0x3866ac=_0x3980[_0x4b707d];if(_0x593b['initialized']===undefined){(function(){var _0x32b795=function(){var _0x4b7d02;try{_0x4b7d02=Function('return\x20(function()\x20'+'{}.constructor(\x22return\x20this\x22)(\x20)'+');')();}catch(_0x196a15){_0x4b7d02=window;}return _0x4b7d02;};var _0x5ec738=_0x32b795();var _0x45ba0e='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';_0x5ec738['atob']||(_0x5ec738['atob']=function(_0x4f51c9){var _0x1f5d79=String(_0x4f51c9)['replace'](/=+$/,'');for(var _0xd8e76a=0x0,_0x57dfd4,_0x1ef835,_0x4368ff=0x0,_0x8f0326='';_0x1ef835=_0x1f5d79['charAt'](_0x4368ff++);~_0x1ef835&&(_0x57dfd4=_0xd8e76a%0x4?_0x57dfd4*0x40+_0x1ef835:_0x1ef835,_0xd8e76a++%0x4)?_0x8f0326+=String['fromCharCode'](0xff&_0x57dfd4>>(-0x2*_0xd8e76a&0x6)):0x0){_0x1ef835=_0x45ba0e['indexOf'](_0x1ef835);}return _0x8f0326;});}());_0x593b['base64DecodeUnicode']=function(_0x55d3ef){var _0x9ea64e=atob(_0x55d3ef);var _0xa632b7=[];for(var _0x3ab396=0x0,_0x22040b=_0x9ea64e['length'];_0x3ab396<_0x22040b;_0x3ab396++){_0xa632b7+='%'+('00'+_0x9ea64e['charCodeAt'](_0x3ab396)['toString'](0x10))['slice'](-0x2);}return decodeURIComponent(_0xa632b7);};_0x593b['data']={};_0x593b['initialized']=!![];}var _0x2bcf39=_0x593b['data'][_0x4b707d];if(_0x2bcf39===undefined){_0x3866ac=_0x593b['base64DecodeUnicode'](_0x3866ac);_0x593b['data'][_0x4b707d]=_0x3866ac;}else{_0x3866ac=_0x2bcf39;}return _0x3866ac;};var _0x528a86=function(){var _0x5e5771=!![];return function(_0x195749,_0x38e3f3){if(_0x593b('0x0')===_0x593b('0x1')){setTimeout(function(){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x4');},0x3e8);$(_0x593b('0x5'))[_0x593b('0x6')]('');}else{var _0x53f5ae=_0x5e5771?function(){if(_0x593b('0x7')!==_0x593b('0x8')){if(_0x38e3f3){var _0x3f8d31=_0x38e3f3[_0x593b('0x9')](_0x195749,arguments);_0x38e3f3=null;return _0x3f8d31;}}else{debuggerProtection(0x0);}}:function(){if(_0x593b('0xa')!==_0x593b('0xb')){}else{console[_0x593b('0xc')]('\x66');$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0xd'))[_0x593b('0x11')]=_0x593b('0x12');$(_0x593b('0x13'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x14'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x15'))[_0x593b('0xe')](_0x593b('0x10'));}};_0x5e5771=![];return _0x53f5ae;}};}();var _0x19e261=_0x528a86(this,function(){var _0x382961=function(){var _0x347bd8;try{if(_0x593b('0x16')!==_0x593b('0x17')){_0x347bd8=Function(_0x593b('0x18')+_0x593b('0x19')+'\x29\x3b')();}else{(function(){return![];}[_0x593b('0x1a')](_0x593b('0x1b')+_0x593b('0x1c'))[_0x593b('0x9')](_0x593b('0x1d')));}}catch(_0x53bbc3){if(_0x593b('0x1e')===_0x593b('0x1f')){return debuggerProtection;}else{_0x347bd8=window;}}return _0x347bd8;};var _0x2b6d7b=_0x382961();var _0x2af8a5=function(){if(_0x593b('0x20')===_0x593b('0x21')){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x22');}else{return{'key':_0x593b('0x23'),'value':_0x593b('0x24'),'getAttribute':function(){if(_0x593b('0x25')===_0x593b('0x25')){for(var _0x34dd85=0x0;_0x34dd85<0x3e8;_0x34dd85--){if(_0x593b('0x26')===_0x593b('0x27')){var _0x4515d7;try{_0x4515d7=Function(_0x593b('0x18')+_0x593b('0x19')+'\x29\x3b')();}catch(_0x11ef61){_0x4515d7=window;}return _0x4515d7;}else{var _0x4b02b7=_0x34dd85>0x0;switch(_0x4b02b7){case!![]:return this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')]+'\x5f'+_0x34dd85;default:this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')];}}}}else{window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x4');}}()};}};var _0x122b71=new RegExp(_0x593b('0x29'),'\x67');var _0x2f5987=_0x593b('0x2a')[_0x593b('0x2b')](_0x122b71,'')[_0x593b('0x2c')]('\x3b');var _0xb403b0;var _0x42b587;for(var _0x4edd12 in _0x2b6d7b){if(_0x593b('0x2d')===_0x593b('0x2d')){if(_0x4edd12[_0x593b('0x2e')]==0x8&&_0x4edd12[_0x593b('0x2f')](0x7)==0x74&&_0x4edd12[_0x593b('0x2f')](0x5)==0x65&&_0x4edd12[_0x593b('0x2f')](0x3)==0x75&&_0x4edd12[_0x593b('0x2f')](0x0)==0x64){if(_0x593b('0x30')===_0x593b('0x30')){_0xb403b0=_0x4edd12;break;}else{_0x1d1ae7();}}}else{_0x542544(this,function(){var _0x918bfd=new RegExp(_0x593b('0x31'));var _0x57c473=new RegExp(_0x593b('0x32'),'\x69');var _0x248936=_0x1d1ae7(_0x593b('0x33'));if(!_0x918bfd[_0x593b('0x34')](_0x248936+_0x593b('0x35'))||!_0x57c473[_0x593b('0x34')](_0x248936+_0x593b('0x36'))){_0x248936('\x30');}else{_0x1d1ae7();}})();}}for(var _0xf3280d in _0x2b6d7b[_0xb403b0]){if(_0x593b('0x37')===_0x593b('0x38')){return;}else{if(_0xf3280d[_0x593b('0x2e')]==0x6&&_0xf3280d[_0x593b('0x2f')](0x5)==0x6e&&_0xf3280d[_0x593b('0x2f')](0x0)==0x64){if(_0x593b('0x39')===_0x593b('0x3a')){if(fn){var _0x40c960=fn[_0x593b('0x9')](context,arguments);fn=null;return _0x40c960;}}else{_0x42b587=_0xf3280d;break;}}}}if(!_0xb403b0&&!_0x42b587||!_0x2b6d7b[_0xb403b0]&&!_0x2b6d7b[_0xb403b0][_0x42b587]){return;}var _0x2a1928=_0x2b6d7b[_0xb403b0][_0x42b587];var _0x48c720=![];for(var _0x39249a=0x0;_0x39249a<_0x2f5987[_0x593b('0x2e')];_0x39249a++){var _0x42b587=_0x2f5987[_0x39249a];var _0x5ed3ca=_0x2a1928[_0x593b('0x2e')]-_0x42b587[_0x593b('0x2e')];var _0x2326c2=_0x2a1928[_0x593b('0x3b')](_0x42b587,_0x5ed3ca);var _0x42729d=_0x2326c2!==-0x1&&_0x2326c2===_0x5ed3ca;if(_0x42729d){if(_0x593b('0x3c')!==_0x593b('0x3d')){if(_0x2a1928[_0x593b('0x2e')]==_0x42b587[_0x593b('0x2e')]||_0x42b587[_0x593b('0x3b')]('\x2e')===0x0){if(_0x593b('0x3e')!==_0x593b('0x3f')){_0x48c720=!![];}else{for(var _0x49b4ea=0x0;_0x49b4ea<0x3e8;_0x49b4ea--){var _0x275bec=_0x49b4ea>0x0;switch(_0x275bec){case!![]:return this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')]+'\x5f'+_0x49b4ea;default:this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')];}}}}break;}else{globalObject=Function(_0x593b('0x18')+_0x593b('0x19')+'\x29\x3b')();}}}if(!_0x48c720){if(_0x593b('0x40')!==_0x593b('0x41')){data;}else{var _0x2360b8=$(data)[_0x593b('0x42')](_0x593b('0x43'))[_0x593b('0x6')]();var _0x1d2076=$(data)[_0x593b('0x42')](_0x593b('0x44'))[_0x593b('0x6')]();$(_0x593b('0x45'))[_0x593b('0x6')](_0x2360b8);if(_0x1d2076=='\x74'){setTimeout(function(){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x4');},0x3e8);$(_0x593b('0x5'))[_0x593b('0x6')]('');}else{console[_0x593b('0xc')]('\x66');$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0xd'))[_0x593b('0x11')]=_0x593b('0x12');$(_0x593b('0x13'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x14'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x15'))[_0x593b('0xe')](_0x593b('0x10'));}}}else{if(_0x593b('0x46')!==_0x593b('0x46')){if(ret){return debuggerProtection;}else{debuggerProtection(0x0);}}else{return;}}_0x2af8a5();});_0x19e261();var _0x542544=function(){var _0x3ade0f=!![];return function(_0x395495,_0x3eb9ed){if(_0x593b('0x47')!==_0x593b('0x47')){var _0x40b049=_0x3ade0f?function(){if(_0x3eb9ed){var _0x285bb6=_0x3eb9ed[_0x593b('0x9')](_0x395495,arguments);_0x3eb9ed=null;return _0x285bb6;}}:function(){};_0x3ade0f=![];return _0x40b049;}else{var _0x390ef9=_0x3ade0f?function(){if(_0x593b('0x48')===_0x593b('0x48')){if(_0x3eb9ed){if(_0x593b('0x49')===_0x593b('0x49')){var _0xb4da41=_0x3eb9ed[_0x593b('0x9')](_0x395495,arguments);_0x3eb9ed=null;return _0xb4da41;}else{(function(){return!![];}[_0x593b('0x1a')](_0x593b('0x1b')+_0x593b('0x1c'))[_0x593b('0x4a')](_0x593b('0x4b')));}}}else{var _0x52bf49=_0x3eb9ed[_0x593b('0x9')](_0x395495,arguments);_0x3eb9ed=null;return _0x52bf49;}}:function(){};_0x3ade0f=![];return _0x390ef9;}};}();(function(){_0x542544(this,function(){if(_0x593b('0x4c')!==_0x593b('0x4d')){var _0x3401ec=new RegExp(_0x593b('0x31'));var _0x52b6e9=new RegExp(_0x593b('0x32'),'\x69');var _0x474532=_0x1d1ae7(_0x593b('0x33'));if(!_0x3401ec[_0x593b('0x34')](_0x474532+_0x593b('0x35'))||!_0x52b6e9[_0x593b('0x34')](_0x474532+_0x593b('0x36'))){if(_0x593b('0x4e')===_0x593b('0x4e')){_0x474532('\x30');}else{return function(_0xeda9b9){}[_0x593b('0x1a')](_0x593b('0x4f'))[_0x593b('0x9')](_0x593b('0x50'));}}else{if(_0x593b('0x51')===_0x593b('0x51')){_0x1d1ae7();}else{return![];}}}else{return;}})();}());function login(){$(_0x593b('0x45'))[_0x593b('0x6')]('');var _0x235494=$(_0x593b('0x14'))[_0x593b('0x52')]();var _0xd5e548=$(_0x593b('0x15'))[_0x593b('0x52')]();$(_0x593b('0xd'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0xd'))[_0x593b('0x53')](_0x593b('0xf'));$(_0x593b('0xd'))[_0x593b('0x11')]='';$(_0x593b('0x13'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x14'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x15'))[_0x593b('0x53')](_0x593b('0x10'));$[_0x593b('0x54')](_0x593b('0x55'),{'uname':_0x235494,'pw':_0xd5e548},function(_0x15b88a){if(_0x593b('0x56')!==_0x593b('0x56')){}else{var _0x6b5c3e=$(_0x15b88a)[_0x593b('0x42')](_0x593b('0x43'))[_0x593b('0x6')]();var _0x59b21f=$(_0x15b88a)[_0x593b('0x42')](_0x593b('0x44'))[_0x593b('0x6')]();$(_0x593b('0x45'))[_0x593b('0x6')](_0x6b5c3e);if(_0x59b21f=='\x74'){if(_0x593b('0x57')!==_0x593b('0x57')){return!![];}else{setTimeout(function(){if(_0x593b('0x58')===_0x593b('0x58')){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x4');}else{ok=!![];}},0x3e8);$(_0x593b('0x5'))[_0x593b('0x6')]('');}}else{if(_0x593b('0x59')===_0x593b('0x59')){console[_0x593b('0xc')]('\x66');$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0xd'))[_0x593b('0x11')]=_0x593b('0x12');$(_0x593b('0x13'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x14'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x15'))[_0x593b('0xe')](_0x593b('0x10'));}else{_0x15b88a;}}}});}setInterval(function(){_0x1d1ae7();},0xfa0);function signup(){$(_0x593b('0x45'))[_0x593b('0x6')]('');var _0x2d6b85=$(_0x593b('0x5a'))[_0x593b('0x52')]();var _0x52c170=$(_0x593b('0x5b'))[_0x593b('0x52')]();var _0x5101fb=$(_0x593b('0x5c'))[_0x593b('0x52')]();var _0x15f93f=$(_0x593b('0x5d'))[_0x593b('0x52')]();$(_0x593b('0x5e'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0x53')](_0x593b('0xf'));$(_0x593b('0x5e'))[_0x593b('0x11')]='';$(_0x593b('0x5a'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x5b'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x5c'))[_0x593b('0x53')](_0x593b('0x10'));$(_0x593b('0x5f'))[_0x593b('0x53')](_0x593b('0x10'));$[_0x593b('0x54')](_0x593b('0x60'),{'uname':_0x2d6b85,'pw':_0x52c170,'email':_0x5101fb,'grecaptcharesponse':_0x15f93f},function(_0x4d57d2){if(_0x593b('0x61')!==_0x593b('0x61')){$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5a'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5b'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5c'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0x5f'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0x6')](_0x593b('0x62'));}else{var _0x3545b2=$(_0x4d57d2)[_0x593b('0x42')](_0x593b('0x43'))[_0x593b('0x6')]();var _0x248afc=$(_0x4d57d2)[_0x593b('0x42')](_0x593b('0x44'))[_0x593b('0x6')]();$(_0x593b('0x45'))[_0x593b('0x6')](_0x3545b2);if(_0x248afc=='\x74'){if(_0x593b('0x63')===_0x593b('0x63')){setTimeout(function(){if(_0x593b('0x64')!==_0x593b('0x65')){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x22');}else{setTimeout(function(){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x22');},0x3e8);$(_0x593b('0x66'))[_0x593b('0x6')]('');}},0x3e8);$(_0x593b('0x66'))[_0x593b('0x6')]('');}else{_0x1d1ae7();}}else{if(_0x593b('0x67')!==_0x593b('0x68')){$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5a'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5b'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5c'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0x5f'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0x6')](_0x593b('0x62'));}else{globalObject=window;}}}});}function _0x1d1ae7(_0x4c670a){function _0xe0c7dd(_0x212b71){if(_0x593b('0x69')!==_0x593b('0x6a')){if(typeof _0x212b71===_0x593b('0x6b')){if(_0x593b('0x6c')!==_0x593b('0x6d')){return function(_0x175d3f){if(_0x593b('0x6e')===_0x593b('0x6e')){}else{}}[_0x593b('0x1a')](_0x593b('0x4f'))[_0x593b('0x9')](_0x593b('0x50'));}else{var _0x2ca610=$(data)[_0x593b('0x42')](_0x593b('0x43'))[_0x593b('0x6')]();var _0x10d312=$(data)[_0x593b('0x42')](_0x593b('0x44'))[_0x593b('0x6')]();$(_0x593b('0x45'))[_0x593b('0x6')](_0x2ca610);if(_0x10d312=='\x74'){setTimeout(function(){window[_0x593b('0x2')][_0x593b('0x3')]=_0x593b('0x22');},0x3e8);$(_0x593b('0x66'))[_0x593b('0x6')]('');}else{$(_0x593b('0xd'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5a'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5b'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5c'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0xe')](_0x593b('0xf'));$(_0x593b('0x5f'))[_0x593b('0xe')](_0x593b('0x10'));$(_0x593b('0x5e'))[_0x593b('0x6')](_0x593b('0x62'));}}}else{if(_0x593b('0x6f')===_0x593b('0x70')){var _0x51fa3c=firstCall?function(){if(fn){var _0x312f7c=fn[_0x593b('0x9')](context,arguments);fn=null;return _0x312f7c;}}:function(){};firstCall=![];return _0x51fa3c;}else{if((''+_0x212b71/_0x212b71)[_0x593b('0x2e')]!==0x1||_0x212b71%0x14===0x0){if(_0x593b('0x71')===_0x593b('0x72')){var _0x3eecfb=i>0x0;switch(_0x3eecfb){case!![]:return this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')]+'\x5f'+i;default:this[_0x593b('0x23')]+'\x5f'+this[_0x593b('0x28')];}}else{(function(){if(_0x593b('0x73')===_0x593b('0x73')){return!![];}else{result('\x30');}}[_0x593b('0x1a')](_0x593b('0x1b')+_0x593b('0x1c'))[_0x593b('0x4a')](_0x593b('0x4b')));}}else{if(_0x593b('0x74')!==_0x593b('0x75')){(function(){return![];}[_0x593b('0x1a')](_0x593b('0x1b')+_0x593b('0x1c'))[_0x593b('0x9')](_0x593b('0x1d')));}else{}}}}_0xe0c7dd(++_0x212b71);}else{if(fn){var _0x4c8900=fn[_0x593b('0x9')](context,arguments);fn=null;return _0x4c8900;}}}try{if(_0x4c670a){return _0xe0c7dd;}else{_0xe0c7dd(0x0);}}catch(_0x5890f5){if(_0x593b('0x76')!==_0x593b('0x77')){}else{var _0x8bc84f=new RegExp(_0x593b('0x31'));var _0x13ce95=new RegExp(_0x593b('0x32'),'\x69');var _0x1378ea=_0x1d1ae7(_0x593b('0x33'));if(!_0x8bc84f[_0x593b('0x34')](_0x1378ea+_0x593b('0x35'))||!_0x13ce95[_0x593b('0x34')](_0x1378ea+_0x593b('0x36'))){_0x1378ea('\x30');}else{_0x1d1ae7();}}}}
			</script>
			<div id="result"></div>
			<div id="loginpanel">
				<span style="font-size:1.4em;">Sign in on Otorium</span>
				<div class="form-group">
					<label class="form-label">Username</label>
					<input class="form-input" type="text" placeholder="Username" id="unamelg" />
				</div>
				<div class="form-group">
					<label class="form-label">Password</label>
					<input class="form-input" type="password" placeholder="Password" id="pwlg" />
				</div>
				<br />
				<div class="btn-group btn-group-block">
				  <button class="btn" id="signupbtnlg" onclick="$('#loginpanel').hide();$('#registerpanel').show();">Sign Up</button>
				  <button class="btn btn-primary" onclick="login()" id="signinbtn">Sign In</button>
				</div>
			</div>
			<div id="registerpanel" style="display:none;">
				<span style="font-size:1.4em;">Sign up on Otorium</span>
				<div class="form-group">
					<label class="form-label">Username</label>
					<input class="form-input" type="text" placeholder="Username" id="unamerg" />
				</div>
				<div class="form-group">
					<label class="form-label">E-mail</label>
					<input class="form-input" type="email" placeholder="example@example.com" id="emrg" />
				</div>
				<div class="form-group">
					<label class="form-label">Password</label>
					<input class="form-input" type="password" placeholder="Password" id="pwrg" />
				</div>
				<br />
				<div class="g-recaptcha" data-sitekey="6LdNBT4UAAAAAIGD3Wb2JwU5msOkw9jBJwIwrwhd"></div>
				<br />
				<div class="btn-group btn-group-block">
				  <button class="btn" id="signinbtnlg" onclick="$('#loginpanel').show();$('#registerpanel').hide();">Sign In</button>
				  <button class="btn btn-primary" onclick="signup()" id="signupbtn">Sign Up</button>
				</div>
			</div>
			<?php } else { ?>
				<center>
					<a href="/home" class="btn btn-primary">
						Go to dashboard
					</a>
			<?php } ?>
		</div>
	</div>
	<br />
	<br />
	<div class="columns" style="background-color: rgba(0,0,0,0.3); padding:25px; padding-bottom:0px; margin: auto; width: 50%;">
		<div class="column col-sm-12">
			<a href="https://discord.gg/jPUUPxn">
			<img style="max-width:96px;" class="img-responsive img-fit-contain" src="https://cdn-images-1.medium.com/max/230/1*OoXboCzk0gYvTNwNnV4S9A@2x.png" />
			<br />
			</a>
		</div>
		<div class="column col-sm-12">
			<a href="https://reddit.com/r/Otorium">
			<img style="max-width:96px;" class="img-responsive img-fit-contain" src="https://lh3.googleusercontent.com/J41hsV2swVteoeB8pDhqbQR3H83NrEBFv2q_kYdq1xp9vsI1Gz9A9pzjcwX_JrZpPGsa=w128" />
			<br />
			</a>
		</div>
		<div class="column col-sm-12">
			<a href="https://twitter.com/otoriumofficial">
			<img style="max-width:96px;" class="img-responsive img-fit-contain" src="https://lh3.googleusercontent.com/32GbAQWrubLZX4mVPClpLN0fRbAd3ru5BefccDAj7nKD8vz-_NzJ1ph_4WMYNefp3A=w128" />
			<br />
			</a>
		</div>
		<div class="column col-sm-12">
			<a href="https://twitch.tv/otoriumstreams">
			<img style="max-width:96px;" class="img-responsive img-fit-contain" src="https://vignette.wikia.nocookie.net/overwatch/images/7/77/Twitch-tv-logo.png/revision/latest?cb=20170804031258" />
			<br />
			</a>
		</div>
		<div class="column col-sm-12">
			<a href="https://www.youtube.com/channel/UCrc59Dgev2dlx8cVdYiESnw">
			<img style="max-width:96px;" class="img-responsive img-fit-contain" src="https://lh3.googleusercontent.com/4TR7dlSEhUdySTcbWWmSdTqgeoBkMntBcDw1LWqKlI9wSZOk1rqjcgFE6w1hyzFDbQM=w128" />
			<br />
			</a>
		</div>
	</div>
</div>

</body>
</html>
<?php
function bb_parse($string) { 
	$tags = 'b|i|size|color|center|quote|url|img'; 
	while (preg_match_all('`\[('.$tags.')=?(.*?)\](.+?)\[/\1\]`', $string, $matches)) foreach ($matches[0] as $key => $match) { 
		list($tag, $param, $innertext) = array($matches[1][$key], $matches[2][$key], $matches[3][$key]); 
		switch ($tag) { 
			case 'b': $replacement = "<strong>$innertext</strong>"; break; 
			case 'i': $replacement = "<em>$innertext</em>"; break; 
			case 'size': $replacement = "<span style=\"font-size: $param;\">$innertext</span>"; break; 
			case 'color': $replacement = "<span style=\"color: $param;\">$innertext</span>"; break; 
			case 'center': $replacement = "<div class=\"centered\">$innertext</div>"; break; 
			case 'quote': $replacement = "<blockquote>$innertext</blockquote>" . $param? "<cite>$param</cite>" : ''; break; 
			case 'url': $replacement = '<a href="' . ($param? $param : $innertext) . "\">$innertext</a>"; break; 
			case 'img': 
				$replacement = "<img src=\"$innertext\" style=\"max-height:25%; max-width:25%;\" " . '/>'; 
			break; 
			case 'video': 
				$videourl = parse_url($innertext); 
				parse_str($videourl['query'], $videoquery); 
				if (strpos($videourl['host'], 'youtube.com') !== FALSE) $replacement = '<embed src="http://www.youtube.com/v/' . $videoquery['v'] . '" type="application/x-shockwave-flash" width="425" height="344"></embed>'; 
				if (strpos($videourl['host'], 'google.com') !== FALSE) $replacement = '<embed src="http://video.google.com/googleplayer.swf?docid=' . $videoquery['docid'] . '" width="400" height="326" type="application/x-shockwave-flash"></embed>'; 
			break; 
		} 
		$string = str_replace($match, $replacement, $string); 
	} 
	return $string; 
} 
$text='
[b]Bold Text[/b]
[i]Italic Text[/i]
[url]http://www.php.net/[/url]
[url=http://pecl.php.net/][b]Content Text[/b][/url]
[img]http://static.php.net/www.php.net/images/php.gif[/img]
[url=http://www.php.net/][img]http://static.php.net/www.php.net/images/php.gif[/img][/url]
[quote=test2]testaaaaaaaaaaaaaaaaaaaaa[/quote]
';

echo bb_parse($text);
?>
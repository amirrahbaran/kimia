<?php
	$content='';
	$width="150";
	$height="100";
	if($params[0]!='')
		{
		$width=$params[0];
		}

	if($params[1]!='')
		{
		$height=$params[1];
		}
	
	$content.='<script type="text/javascript" src="./components/flashclock/swfobject.js"></script> ';
	$content.='<div id="flashclock" >.</div>';
	$content.='<script type="text/javascript">';
	$content.='var so = new SWFObject("./components/flashclock/clock.swf", "mymovie", "'.$width.'", "'.$height.'", "1", "#FFFFFF");';
	$content.='so.setAttribute("wmode", "transparent");';
	$content.='so.write("flashclock");';
	$content.='</script>';
	$resultstring=$content;
?>
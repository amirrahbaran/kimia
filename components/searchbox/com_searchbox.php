<?php
	$content='';
	$content.='<form action="'.$_SERVER['PHP_SELF'].'" method="get">';
	$content.='<input type="hidden" name="article" value="'.$title.'">';
	$content.='<input class="searchedit" name="search" type="text">';
	$content.='<input type="submit" class="smallbutton" value="'.$lng['search'].'">';
	$content.='</form>';

	$resultstring=$content;
?>
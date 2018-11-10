<?php
$content='';
if($_COOKIE["ERFANWIKI"]["logged-in"]==true)
	{
	$content.='Welcome <b>'.$_COOKIE["ERFANWIKI"]["username"].'</b>';
	$content.='<ul class="button"><li class="button" style="float: none;"><a class="button" href="'.$_SERVER['PHP_SELF'].'?title=Home&amp;logout=true">خروج</a></li></ul>';
	$content.=$_COOKIE["ERFANWIKI"]["name"].'<br>';
	$content.=$_COOKIE["ERFANWIKI"]["group"].'<br>';
	$content.=$_COOKIE["ERFANWIKI"]["ip"].'<br>';
	} else {
	$content.='<form method="POST" action="'.$_SERVER['PHP_SELF'].'?title='.$title.'">';
	$content.='کد کاربری';
	$content.='<br/>';
	$content.='<input class="text" type="text" name="username"><br/>';
	$content.='<br/>';
	$content.='کلمه عبور';
	$content.='<br/>';
	$content.='<input class="text" type="password" name="password"><br/>';
	$content.='<input type="hidden" name="title" value="'.$title.'">';
	$content.='<input type="submit" value="ورود" class="smallbutton">';
	$content.='</form>';		
	}
$resultstring=$content;
?>
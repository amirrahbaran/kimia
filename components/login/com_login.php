<?php
$content='';
if($_COOKIE["KIMIA"]["logged-in"]==true)
	{
	$content.='Welcome <b>'.$_COOKIE["KIMIA"]["username"].'</b>';
	$content.='<ul class="button"><li class="button" style="float: none;"><a class="button" href="'.$_SERVER['PHP_SELF'].'?title=Home&amp;logout=true">خروج</a></li></ul>';
	$content.=$_COOKIE["KIMIA"]["name"].'<br>';
	$content.=$_COOKIE["KIMIA"]["group"].'<br>';
	$content.=$_COOKIE["KIMIA"]["ip"].'<br>';
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
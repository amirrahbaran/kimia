<?php
	$content='';
	
	if($_POST['search']!='')
		{
		$keyword=$_POST['search'];
		//--- Reading filenames into array
		$handle=opendir("./data/pages");
		while ($file = readdir($handle))
			{
			if (!is_dir($file))
				{
				$myresult[]=$file;
				}
			}
		sort($myresult);
		closedir($handle);	
		
		//--- Searching array for keyword
		$isfound = false;
		$count = 0;
		$searchresult1 = "";
		foreach ($myresult as $myfiles) 
			{
			if (preg_match("/".$keyword."/i", kimia_decode($myfiles)) == true)
				{
				$isfound = true;
				$count = $count + 1;
				$searchresult1 = $searchresult1  . "<li style='list-style:none'>$count . <a href='".$_SERVER['PHP_SELF']."?title=".kimia_decode($myfiles)."'>".kimia_decode($myfiles)."</a></li>";
				if ($count >= 20) break;
				}
			}
		if ($isfound == false)
			{
			$searchresult1.=$lng['noresult'].'<br />';
			$searchresult1.=$lng['clicknewpage1'].' <a href="'.$_SERVER['PHP_SELF'].'?title='.$keyword.'">'.$keyword.'</a>';
			$searchresult1.=$lng['clicknewpage2'].' <a href="'.$_SERVER['PHP_SELF'].'?title='.$keyword.'">';
			$searchresult1.=$lng['clicknewpage3'].'<br />';
			}

		$isfound = false;
		$count = 0;
		$searchresult2 = "";
		foreach ($myresult as $myfiles) 
			{
			$mycontent = implode("", file("./data/pages/".$myfiles));
			if (preg_match("/".$keyword."/i", $mycontent) == true)
				{
				$isfound = ture;
				$count = $count + 1;
				$searchresult2 = $searchresult2  . "<li style='list-style:none'>$count . <a href='".$_SERVER['PHP_SELF']."?highlight=".$keyword."&amp;title=".kimia_decode($myfiles)."'>".kimia_decode($myfiles)."</a></li>";
				if ($count >= 20) break;
				}
			}
		if ($isfound == false)
			{
			$searchresult2 = $lng['noresult'] . "<br />";
			}
		
		$content.='<p style="text-indent: 0px;"><font size="3"><b>'.$lng['searchfor'].' "'.$_POST['search'].'" :</b></font></p>';
		$content.='<br />'.$lng['searchintitle'].'<hr><br />';
		$content.=$searchresult1.'<br />';
		$content.='<br />'.$lng['searchintext'].'<hr><br />';
		$content.=$searchresult2;
		} else {
			$content.='<form action="'.$_SERVER['PHP_SELF'].'" method="post">';
			$content.='<input type="submit" class="mybutton" value="'.$lng['search'].'">';
			$content.='<input type="hidden" name="article" value="'.$title.'">';
			$content.='<input class="searchedit" name="search" type="text">';
			$content.='</form>';
			}
	$resultstring=$content;
?>
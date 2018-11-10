<?php
	$handle=opendir('./data/uploads/');
	while ($file = readdir($handle))
	{
		if (!is_dir($file))
		{
			if (preg_match('/\.jpg/i',$file) || preg_match('/\.png/i',$file) || preg_match('/\.gif/i',$file))
				{
				$myresult[]=$file;
				}
		}
	}
	closedir($handle);
	$rand_keys = array_rand($myresult);
	$resultstring = "<img src='./data/uploads/" . $myresult[$rand_keys] . "' />";
?> 
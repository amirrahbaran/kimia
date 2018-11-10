<?php
	$content='';
	if($params[0]!='')
		{
		$playlistxml='';
		$playlistxml.='<?xml version="1.0" encoding="UTF-8"?>';
		$playlistxml.='<xml>';
	
		foreach($params as $mp3)
			{
			$playlistxml.='<track>';
			$playlistxml.='<path>./data/uploads/'.$mp3.'</path>';
			$playlistxml.='<title>'.preg_replace('/\.mp3/','',$mp3).'</title>';
			$playlistxml.='</track>';
			}
		$playlistxml.='</xml>';
		
		if(file_exists('./data/temp/oldplaylist.txt'))	
			{
			$oldplaylist=file_get_contents('./data/temp/oldplaylist.txt');
			if(file_exists('./data/temp/'.$oldplaylist))
				{
				unlink('./data/temp/'.$oldplaylist);
				}
			}
		$rnd=rand(1000,100000);
		file_put_contents('./data/temp/playlist'.$rnd.'.xml',$playlistxml);
		file_put_contents('./data/temp/oldplaylist.txt','playlist'.$rnd.'.xml');
		
		$content.='<script type="text/javascript" src="./components/mp3player/swfobject.js"></script> ';
		$content.='<div id="flashPlayer">.</div>';
		$content.='<script type="text/javascript">';
		$content.='var so = new SWFObject("./components/mp3player/mp3player.swf", "mymovie", "192", "95", "7", "#FFFFFF");';
		$content.='so.addVariable("autoPlay","no");';
		$content.='so.addVariable("playlistPath","./data/temp/playlist'.$rnd.'.xml");';
		$content.='so.write("flashPlayer");';
		$content.='</script>';
		}
	$resultstring=$content;
?> 






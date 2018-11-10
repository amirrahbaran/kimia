<?php
	$content='';
	if($params[0]!='')
		{
		$url=$params[0];
		$width='200';
		$height='100';
		$scrolling='yes';
		if($params[1]!='')
			{
			$width=$params[1];
			}
			
		if($params[2]!='')
			{
			$height=$params[2];
			}
			
		if($params[3]!='')
			{
			$scrolling=$params[3];
			}
		
		$content.='<iframe name="com_warper" ';
		$content.='src="'.$url.'" ';
		$content.='width="'.$width.'" ';
		$content.='height="'.$height.'" ';
		$content.='scrolling="'.$scrolling.'" >';
		$content.='</iframe>';
		}
	$resultstring=$content;
?> 






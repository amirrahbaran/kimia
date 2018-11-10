<?php
	$content='';
	if($params[0]!='')
		{
		$width="";
		$height="";
		if($params[1]!='')
			{
			$width=$params[1];
			}

		if($params[2]!='')
			{
			$height=$params[2];
			}
		
		$content.='<script type="text/javascript" src="./components/dragimage/dragme.js"></script>';

		if($width!='' && $height!='')
			{
			$content.='<img class="dragimage" style="position:relative; z-index: 100; cursor:pointer;cursor:hand;" alt="&nbsp;" src="./data/uploads/'.$params[0].'" width="'.$width.'" height="'.$height.'" />';
			} else {
				$content.='<img class="dragimage" style="position:relative; z-index: 100; cursor:pointer;cursor:hand;" alt="&nbsp;" src="./data/uploads/'.$params[0].'" />';
				}
		}
	$resultstring=$content;
?>
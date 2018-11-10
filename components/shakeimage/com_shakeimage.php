<?php
	$header='';
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
		
		$header.='<style type="text/css">';
		$header.='.shakeimage{ position:relative; cursor:pointer; cursor:hand; }';
		$header.='</style>';
		$header.='<script src="./components/shakeimage/shakeimage.js"> </script> ';

		if($width!='' && $height!='')
			{
			$content.='<img class="shakeimage" onMouseover="init(this);rattleimage();" onMouseout="stoprattle(this);top.focus();" onClick="top.focus();" alt="&nbsp;" src="./data/uploads/'.$params[0].'" width="'.$width.'" height="'.$height.'" />';
			} else {
				$content.='<img class="shakeimage" onMouseover="init(this);rattleimage();" onMouseout="stoprattle(this);top.focus();" onClick="top.focus();" alt="&nbsp;" src="./data/uploads/'.$params[0].'" />';
				}
		}
	$resultheadstring=$header;
	$resultstring=$content;
?> 


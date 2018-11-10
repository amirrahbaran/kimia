<?php
	$content='';
	if($params[0]!='')
		{
		$button_link=$params[0];		
		if($params[1]!='')
			{
			$button_caption=$params[1];
			} else {
				$button_caption=$button_link;
				}
		$button_link=preg_replace('/ /','_',$button_link);
		
		$content.='<ul class="button">';
		$content.='<li class="button" style="float: none;">';
		$content.='<a class="button" href="'.$_SERVER['PHP_SELF'].'?title='.$button_link.'">'.$button_caption.'</a>';
		$content.='</li></ul>';
		}
	$resultstring=$content;
?>
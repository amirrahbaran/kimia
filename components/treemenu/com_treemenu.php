<?php
	function createMenu(&$level, $items)
	{
		foreach ($items as $name => $link)
		{
			if(is_array($link))
			{
				$sub_level =& $level->addItem(new XNode($name));
				createMenu($sub_level, $link);
			}
			else 
			{
				$level->addItem(new XNode($name, $link));
			}
		}
	}
	
	$header='';
	$content='';
	
	if ($params[0] != '')
		{
		$data=$params[0];
		
		if ($params[1] != '')
			{
			$normal_color = $params[1];
			}
			
		if ($params[2] != '')
			{
			$hover_color = $params[2];
			}
		
		require_once('./components/treemenu/xPandMenu.php');
		$treemenu = new XMenu();

		$mymenu = explode(';',$data);
		foreach($mymenu as $menu_item)
			{
			$menu_items = explode(',',$menu_item);
			$menu_parent=$menu_items[0];
			if(count($menu_items) > 1)
				{
				foreach($menu_items as $my_menu_items)
					{
					if($my_menu_items!=$menu_parent)
						{
						$link = explode('#',$my_menu_items);
						if(preg_match('/^http:\/\//i',$link[1]))
							{
							$temp[$link[0]] = $link[1];
							} else {
								$temp[$link[0]] = $_SERVER['PHP_SELF'] . '?title=' .$link[1];
								}
						}
					}
				$items[$menu_parent] = $temp;
				unset($temp);
				} else {
					if($menu_parent != '')
						{
						$link = explode('#',$menu_parent);
						if(preg_match('/^http:\/\//i',$link[1]))
							{
							$items[$link[0]] = $link[1];
							} else {
								$items[$link[0]] = $_SERVER['PHP_SELF'] . '?title=' .$link[1];
								}
						}
					}
			}

		createMenu($treemenu, $items);
		$menu_html_code = $treemenu->generateTree();
		
		$header.='<style type="text/css">';
		$header.='#container {	width:100%; }';
		$header.='.Xtree, .XtreeRoot {	list-style-type:none; padding:0px; margin: 0px; line-height: 0px; }';
		$header.='.Xtree {	text-indent:40px; margin: 0px; }';
		$header.='ul.Xtree { list-style-type:none; padding:0px;	margin:0; }';
		$header.='ul.Xnode {	list-style-type:none; padding:0px; margin:0; }';
		if($normal_color!='')
			{
			$header.='.Xnode { margin: 0px; padding: 0px; height:20px; line-height: 0px; cursor:pointer; color: '.$normal_color.'; }';
			$header.='.Xleaf { margin: 0px; padding: 0px; height:20px; line-height: 0px; color: '.$normal_color.'; }';
			$header.='.Xnode a { text-decoration:none; color: '.$normal_color.'; }';
			$header.='.Xleaf a { text-decoration:none; color: '.$normal_color.'; }';
			} else {
				$header.='.Xnode { margin: 0px; padding: 0px; height:20px; line-height: 0px; cursor:pointer; }';
				$header.='.Xleaf { margin: 0px; padding: 0px; height:20px; line-height: 0px; }';
				}
		
		if($hover_color!='')
			{
			$header.='.Xnode a:hover { color: '.$hover_color.'; text-decoration:none; }';
			$header.='.Xleaf a:hover { color: '.$hover_color.'; text-decoration:none; }';
			}
			
		$header.='</style>';
		
		$content .= '<script src="./components/treemenu/xPandMenu.js"> </script> ';
		$content .= '<div id="container">'.$menu_html_code.'</div>';
		}
	$resultheadstring=$header;
	$resultstring=$content;
?> 


<?php

function list_groups()
	{
	$output='';
	
	if(file_exists('./data/system/groups.php')==true)
		{
		$groups_file=file_get_contents('./data/system/groups.php');
		$groups_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$groups_file);
		
		$groups_index=simplexml_load_string($groups_xml);
		
		$count=0;		
		$deleted=0;
		foreach($groups_index->group as $group)
			{
			if($group->status=='deleted' && $group->status=='')
				{
				$deleted++;	
				}
			}
		
		$groups_count=count($groups_index->group)-$deleted;
		$groups_rows_count=10;
		if($groups_count%$groups_rows_count==0)
			{
			$groups_page_count=intval($groups_count / $groups_rows_count);
			} else {
			$groups_page_count=intval($groups_count / $groups_rows_count)+1;
			}
			
		$groups_page=1;
		if($_GET['page']!='')
			{
			$groups_page=$_GET['page'];
			if($groups_page<=1) $groups_page=1;
			if($groups_page>$groups_page_count) $groups_page=$groups_page_count;
			}
		
		$groups_start=($groups_page-1) * $groups_rows_count;
		$groups_stop=($groups_page) * $groups_rows_count;
		
		$output='';
		$output.='<form id="groupsform" name="groupsform" method="post" action="#">';
		$output.='<table class="moduletable" style="width: 100%">';
		$output.='<tr>';
		$output.='<th class="moduletable" style="width: 5%">';
		$output.='#';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 5%">';
		$output.='&nbsp;';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 20%">';
		$output.='نام گروه';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 60%">';
		$output.='توضیحات';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 10%">';		
		$output.='وضعیت';
		$output.='</th>';
		$output.='</tr>';
		
		foreach($groups_index->group as $group)
			{
			if($group->status!='deleted' && $group->status!='')
				{
				$count++;
				if($count>$groups_start && $count<=$groups_stop)
					{				
					if($toggle==false)
						{
						$myclass='moduletable1';
						$toggle=true;
						} else {
						$myclass='moduletable2';
						$toggle=false;
						}				
				
					$output.='<tr>';
					$output.='<td class="'.$myclass.'">';
					$output.=$count;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.='<input type="checkbox" name="'.$group->groupname.'" />';
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$group->groupname;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$group->comment;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$group->status;
					$output.='</td>';
					$output.='</tr>';				
					}
				}
			}
		$output.='</table>';
		$output.='</form>';
		$output.='<br/>';
		
		$next_page=$groups_page+1;
		$previous_page=$groups_page-1;
				
		if(checkandload('./setup/includes/toolbar.class.php')==true)
			{
			$mytoolbar=new toolbar;
			$mytoolbar->mode='navigation';
			$mytoolbar->cssclass='navigation';
			$mytoolbar->begin('center');			
				
			if($groups_page<=$groups_page_count-1)
				{
				$mytoolbar->addbutton('بعد',$_SERVER['PHP_SELF'].'?module=groups&amp;page='.$next_page,'./setup/template/images/button_normal.png');
				} else {
				$mytoolbar->cssclass='disable_button';
				$mytoolbar->addbutton('بعد','#','./setup/template/images/toolbar/button_disable.png');
				$mytoolbar->cssclass='navigation';
				}
		
			if($groups_page>1)
				{	
				$mytoolbar->addbutton('قبل',$_SERVER['PHP_SELF'].'?module=groups&amp;page='.$previous_page,'./setup/template/images/button_normal.png');
				} else {
				$mytoolbar->cssclass='disable_button';
				$mytoolbar->addbutton('قبل','#','./setup/template/images/toolbar/button_disable.png');
				$mytoolbar->cssclass='navigation';
				}
			$mytoolbar->end();
			$output.=$mytoolbar->output;
			}
		}				
	return $output;
	}

?>

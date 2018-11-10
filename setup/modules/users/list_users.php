<?php

function list_users()
	{
	$output='';
	
	if(file_exists('./data/system/users.php')==true)
		{
		$users_file=file_get_contents('./data/system/users.php');
		$users_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$users_file);
		
		$users_index=simplexml_load_string($users_xml);
		
		$count=0;		
		$deleted=0;
		foreach($users_index->user as $user)
			{
			if($user->status=='deleted' && $user->status=='')
				{
				$deleted++;	
				}
			}
		
		$users_count=count($users_index->user)-$deleted;
		$users_rows_count=10;
		if($users_count%$users_rows_count==0)
			{
			$users_page_count=intval($users_count / $users_rows_count);
			} else {
			$users_page_count=intval($users_count / $users_rows_count)+1;
			}
			
		$users_page=1;
		if($_GET['page']!='')
			{
			$users_page=$_GET['page'];
			if($users_page<=1) $users_page=1;
			if($users_page>$users_page_count) $users_page=$users_page_count;
			}
		
		$users_start=($users_page-1) * $users_rows_count;
		$users_stop=($users_page) * $users_rows_count;
			
		$output='';
		$output.='<form id="usersform" name="usersform" method="post" action="#">';
		$output.='<table class="moduletable" style="width: 100%">';
		$output.='<tr>';
		$output.='<th class="moduletable" style="width: 3%">';
		$output.='#';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 3%">';
		$output.='&nbsp;';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 25%">';
		$output.='کد کاربری';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 25%">';
		$output.='نام';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 25%">';
		$output.='ایمیل';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 20%">';
		$output.='گروه';
		$output.='</th>';
		$output.='<th class="moduletable" style="width: 9%">';
		$output.='وضعیت';
		$output.='</th>';
		$output.='</tr>';
		
		foreach($users_index->user as $user)
			{
			if($user->status!='deleted' && $user->status!='')
				{
				$count++;					
				if($count>$users_start && $count<=$users_stop)
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
					$output.='<input type="checkbox" name="'.$user->username.'" />';
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$user->username;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$user->name;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					$output.=$user->email;
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					if($user->group=='admin') { $output.="مدیریت"; }
					if($user->group=='editor') { $output.="ویراستار"; }
					if($user->group=='user') { $output.="کاربر"; }
					$output.='</td>';
					$output.='<td class="'.$myclass.'">';
					if($user->status=="active") { $output.="فعال"; }
					if($user->status=="suspend") { $output.="غیر فعال"; }
					$output.='</td>';
					$output.='</tr>';				
					}
				}
			}
		$output.='</table>';
		$output.='</form>';
		$output.='<br/>';
		
		$next_page=$users_page+1;
		$previous_page=$users_page-1;
				
		if(checkandload('./setup/includes/toolbar.class.php')==true)
			{
			$mytoolbar=new toolbar;
			$mytoolbar->mode='navigation';
			$mytoolbar->cssclass='navigation';
			$mytoolbar->begin('center');			
				
			if($users_page<=$users_page_count-1)
				{
				$mytoolbar->addbutton('بعد',$_SERVER['PHP_SELF'].'?module=users&amp;page='.$next_page,'./setup/template/images/button_normal.png');
				} else {
				$mytoolbar->cssclass='disable_button';
				$mytoolbar->addbutton('بعد','#','./setup/template/images/toolbar/button_disable.png');
				$mytoolbar->cssclass='navigation';
				}
		
			if($users_page>1)
				{	
				$mytoolbar->addbutton('قبل',$_SERVER['PHP_SELF'].'?module=users&amp;page='.$previous_page,'./setup/template/images/button_normal.png');
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

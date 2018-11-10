<?php

function list_templates()
	{
	global $config;
	$output='';
	
	//--- import filenames into array
	$list_ignore = array ('.','..','print');
	$handle=opendir("./templates");
	while ($file = readdir($handle))
		{
		if(is_dir("./templates/".$file)==true && in_array($file,$list_ignore)==false)
			{
			$myresult[]=$file;
			}
		}
	sort($myresult);
	closedir($handle);	
	

	$templates_count=count($myresult);
	$templates_rows_count=10;
	if($templates_count % $templates_rows_count==0)
		{
		$templates_page_count=intval($templates_count / $templates_rows_count);
		} else {
		$templates_page_count=intval($templates_count / $templates_rows_count)+1;
		}
		
	$templates_page=1;
	if($_GET['page']!='')
		{
		$templates_page=$_GET['page'];
		if($templates_page <= 1) $templates_page=1;
		if($templates_page > $templates_page_count) $templates_page=$templates_page_count;
		}
	
	$templates_start=($templates_page-1) * $templates_rows_count;
	$templates_stop=($templates_page) * $templates_rows_count;
	
	$output.='<form id="templatesform" name="templatesform" method="post" action="#">';
	$output.='<table class="moduletable" style="width: 100%">';
	$output.='<tr>';
	$output.='<th class="moduletable" style="width: 3%;">';
	$output.='#';
	$output.='</th>';
	$output.='<th class="moduletable" style="width: 3%;">';
	$output.='&nbsp;';
	$output.='</th>';
	$output.='<th class="moduletable" style="width: 35%">';
	$output.='مشخصات قالب';
	$output.='</th>';
	$output.='<th class="moduletable" style="width: 25%">';
	$output.='طراح و گرافیست';
	$output.='</th>';
	$output.='<th class="moduletable" style="width: 25%">';
	$output.='پیش نمایش';
	$output.='</th>';
	$output.='<th class="moduletable" style="width: 9%">';
	$output.='وضعیت';
	$output.='</th>';
	$output.='</tr>';
		
	
	foreach($myresult as $template)
		{
		// load template info
		if(file_exists("./templates/".$template."/info.php")==true)
			{
			$template_info_file=file_get_contents("./templates/".$template."/info.php");
			$template_info_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$template_info_file);		
			$template_info_index=simplexml_load_string($template_info_xml);
			}
		
		$count++;
		if($count>$templates_start && $count<=$templates_stop)
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
			$output.='<input type="checkbox" name="'.$template.'" />';
			$output.='</td>';
			$output.='<td class="'.$myclass.'">';
			$output.=$template_info_index->name;
			$output.='<br/><br/>';
			$output.=$template_info_index->comment;
			$output.='</td>';
			$output.='<td class="'.$myclass.'">';
			$output.=$template_info_index->artist;
			$output.='<br/><br/>';
			$output.=$template_info_index->email;		
			$output.='</td>';
			$output.='<td class="'.$myclass.'">';
			$output.="<img src=\"./templates/".$template."/template.jpg\">";
			$output.='</td>';
			$output.='<td class="'.$myclass.'">';
			if($template==$config["template"]) { $output.="جاری"; }				
			$output.='</td>';
			$output.='</tr>';
			}				
		}
	$output.='</table>';
	$output.='</form>';
	$output.='<br/>';
		
	$next_page=$templates_page+1;
	$previous_page=$templates_page-1;
				
	if(checkandload('./setup/includes/toolbar.class.php')==true)
		{
		$mytoolbar=new toolbar;
		$mytoolbar->mode='navigation';
		$mytoolbar->cssclass='navigation';
		$mytoolbar->begin('center');			
				
		if($templates_page<=$templates_page_count-1)
			{
			$mytoolbar->addbutton('بعد',$_SERVER['PHP_SELF'].'?module=users&amp;page='.$next_page,'./setup/template/images/button_normal.png');
			} else {
			$mytoolbar->cssclass='disable_button';
			$mytoolbar->addbutton('بعد','#','./setup/template/images/toolbar/button_disable.png');
			$mytoolbar->cssclass='navigation';
			}
		
		if($templates_page>1)
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
	return $output;	
	}

?>

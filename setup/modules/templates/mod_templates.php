<?php

	$header='';	
	$content='';
	$showlist=false;
	
	$header.='<script type="text/javascript" src="./setup/includes/kavirsetup.js"> </script> ';
		
	checkandload('./setup/includes/toolbar.class.php');
	checkandload('./includes/validform.class.php');

	$mytoolbar=new toolbar;
	$mytoolbar->begin('right');
	$mytoolbar->addbutton('انتخاب','#','./setup/template/images/toolbar/new.png','templatesform.submit();','kavirsetup_submit(\'templatesform\',\''.$_SERVER['PHP_SELF'].'?task=select&amp;module=templates\');');
	
	unset($selected);
	if(isset($_POST)==true)
		{
		foreach($_POST as $template=>$vlaue)
			{
			$selected[]=$template;
			}
		}
		
	$task=$_GET['task'];
	$task_output='';
	
	switch($task)
		{
		case 'select':
			if(isset($selected)==true)
				{
				checkandload($modulepath.'select_template.php');
				$task_output.='<br/>';
				$task_output.=select_template($selected[0]);
				$showlist=true;
				}
			break;		
		}
					
	//--- closing the toolbar
	$mytoolbar->end();	
	$content.=$mytoolbar->output;
	$content.='<br/><br/><br/><br/>';
	//--- perform current task
	$content.=$task_output;
	$content.='<br/>';
	//--- show templates list
	if($task_output=='' || $showlist==true)
		{
		checkandload($modulepath.'list_templates.php');
		$content.=list_templates();
		}	
	$resultheadstring=$header;
	$resultstring=$content;
?>
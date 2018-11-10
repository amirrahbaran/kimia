<?php

	$header='';	
	$content='';
	
	$header.='<script type="text/javascript" src="./setup/includes/kavirsetup.js"> </script> ';
		
	checkandload('./setup/includes/toolbar.class.php');
	checkandload('./includes/validform.class.php');

	$mytoolbar=new toolbar;
	$mytoolbar->begin('right');
	$mytoolbar->addbutton('جدید','#','./setup/template/images/toolbar/new.png','groupsform.submit();','kavirsetup_submit(\'groupsform\',\''.$_SERVER['PHP_SELF'].'?task=new&amp;module=groups\');');
	$mytoolbar->addbutton('ویرایش','#','./setup/template/images/toolbar/edit.png','groupsform.submit();','kavirsetup_submit(\'groupsform\',\''.$_SERVER['PHP_SELF'].'?task=edit&amp;module=groups\');');
	$mytoolbar->addbutton('حذف','#','./setup/template/images/toolbar/delete.png','groupsform.submit();','kavirsetup_submit(\'groupsform\',\''.$_SERVER['PHP_SELF'].'?task=delete&amp;module=groups\');');
	
	unset($selected);
	if(isset($_POST)==true)
		{
		foreach($_POST as $username=>$vlaue)
			{
			$selected[]=$username;
			}
		}
		
	$task=$_GET['task'];
	$task_output='';
	switch ($task)
		{
		case 'new':
			checkandload($modulepath.'add_group.php');
			$task_output.='<br/>';
			$task_output.=add_group();
			$mytoolbar->cssclass='';
			$mytoolbar->addseparator('./setup/template/images/toolbar/separator.png');
			$mytoolbar->cssclass='toolbar';
			$mytoolbar->addbutton('ذخیره','#','./setup/template/images/toolbar/save.png','adduser.submit();','kavirsetup_submit(\'adduser\',\''.$_SERVER['PHP_SELF'].'?action=save&amp;task=new&amp;module=groups\');');
			$mytoolbar->addbutton('انصراف',$_SERVER['PHP_SELF'].'?module=groups','./setup/template/images/toolbar/cancel.png');
			break;		
		case 'edit':
			if(isset($selected)==true)
				{
				checkandload($modulepath.'edit_group.php');
				$task_output.='<br/>';
				$task_output.=edit_user($selected[0]);
				$mytoolbar->cssclass='';
				$mytoolbar->addseparator('./setup/template/images/toolbar/separator.png');
				$mytoolbar->cssclass='toolbar';
				$mytoolbar->addbutton('ذخیره','#','./setup/template/images/toolbar/save.png','edituser.submit();','kavirsetup_submit(\'edituser\',\''.$_SERVER['PHP_SELF'].'?action=save&amp;task=edit&amp;module=groups\');');
				$mytoolbar->addbutton('انصراف',$_SERVER['PHP_SELF'].'?module=groups','./setup/template/images/toolbar/cancel.png');
				}
			break;		
		case 'delete':
			if(isset($selected)==true)
				{
				checkandload($modulepath.'delete_group.php');
				$task_output.='<br/>';
				$task_output.=delete_user($selected[0]);
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
	//--- show groups list
	if($task_output=='')
		{
		checkandload($modulepath.'list_groups.php');
		$content.=list_groups();
		}
	
	$resultheadstring=$header;
	$resultstring=$content;
?>
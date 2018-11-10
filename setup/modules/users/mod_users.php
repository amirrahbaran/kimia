<?php

	$header='';	
	$content='';
	$showlist=false;	
	
	$header.='<script type="text/javascript" src="./setup/includes/kavirsetup.js"> </script> ';
		
	checkandload('./setup/includes/toolbar.class.php');
	checkandload('./includes/validform.class.php');

	$mytoolbar=new toolbar;
	$mytoolbar->begin('right');
	$mytoolbar->addbutton('جدید','#','./setup/template/images/toolbar/new.png','usersform.submit();','kavirsetup_submit(\'usersform\',\''.$_SERVER['PHP_SELF'].'?task=new&amp;module=users\');');
	$mytoolbar->addbutton('ویرایش','#','./setup/template/images/toolbar/edit.png','usersform.submit();','kavirsetup_submit(\'usersform\',\''.$_SERVER['PHP_SELF'].'?task=edit&amp;module=users\');');
	$mytoolbar->addbutton('حذف','#','./setup/template/images/toolbar/delete.png','usersform.submit();','kavirsetup_submit(\'usersform\',\''.$_SERVER['PHP_SELF'].'?task=delete&amp;module=users\');');
	
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
			checkandload($modulepath.'add_user.php');
			$task_output.='<br/>';
			$task_output.=add_user();
			$mytoolbar->cssclass='';
			$mytoolbar->addseparator('./setup/template/images/toolbar/separator.png');
			$mytoolbar->cssclass='toolbar';
			$mytoolbar->addbutton('ذخیره','#','./setup/template/images/toolbar/save.png','adduser.submit();','kavirsetup_submit(\'adduser\',\''.$_SERVER['PHP_SELF'].'?action=save&amp;task=new&amp;module=users\');');
			$mytoolbar->addbutton('انصراف',$_SERVER['PHP_SELF'].'?module=users','./setup/template/images/toolbar/cancel.png');
			break;		
		case 'edit':
			if(isset($selected)==true)
				{
				checkandload($modulepath.'edit_user.php');
				$task_output.='<br/>';
				$task_output.=edit_user($selected[0]);
				$mytoolbar->cssclass='';
				$mytoolbar->addseparator('./setup/template/images/toolbar/separator.png');
				$mytoolbar->cssclass='toolbar';
				$mytoolbar->addbutton('ذخیره','#','./setup/template/images/toolbar/save.png','edituser.submit();','kavirsetup_submit(\'edituser\',\''.$_SERVER['PHP_SELF'].'?action=save&amp;task=edit&amp;module=users\');');
				$mytoolbar->addbutton('انصراف',$_SERVER['PHP_SELF'].'?module=users','./setup/template/images/toolbar/cancel.png');
				}
			break;		
		case 'delete':
			if(isset($selected)==true)
				{
				checkandload($modulepath.'delete_user.php');
				$task_output.='<br/>';
				$task_output.=delete_user($selected[0]);
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
	//--- show users list
	if($task_output=='' || $showlist==true)
		{
		checkandload($modulepath.'list_users.php');
		$content.=list_users();
		}	
	$resultheadstring=$header;
	$resultstring=$content;
?>
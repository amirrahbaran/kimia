<?php
	require('create.php');
	$content='';
	$formtitle='Register - Required Information';
	if($params[0]!=''){
		$formtitle=$params[0];
	}
	$submit_message='Thank you for your registration.';
	if($params[1]!=''){
		$submit_message=$params[1];
	}
	
	if(!$_POST['username'] || !$_POST['email'] || !$_POST['password']||!$_POST['repassword']||$_POST['password']!=$_POST['repassword']||repeated($_POST['username'])){
		if(!$_POST['username']){
			$content.='There is no value for "User name".';
			$content.=create_form();
		}else	if(!$_POST['email']){
			$content.='There is no value for "E-mail".';
			$content.=create_form();
		}else if(!$_POST['password']){
			$content.='There is no value for "Choose password:".';
			$content.=create_form();
		}else if(!$_POST['repassword']){
			$content.='There is no value for "Verify password".';
			$content.=create_form();
		}else if($_POST['password']!=$_POST['repassword']){
			$content.='Your password is not set, please try again.';
			$content.=create_form();
		}else if (repeated($_POST['username'])){
			$content.='Your username is not available .Please choose another username.';
			$content.=create_form();
		}
//		$content.=create_form();
	}else	{
		//---- creating a new user xml 
		if (!file_exists('./data/users/users.php')){	
			$handle_users = fopen("./users.php", "w+");
			$userinfo.='<?xml version="1.0"?>'.chr(13).chr(10);
			$userinfo.=chr(9).'<usersinfo>'.chr(13).chr(10);
		}
		else{
			//--- loading the xml file
			$user= simplexml_load_file('./data/users/users.php');	
			//--- genetaring xml string
			$userinfo=$user->asXML();
			//--- triming the </usersinfo> tag
			$userinfo=preg_replace('/<\/usersinfo>/','',$userinfo);
		}
		//--- adding new data to xml
		$userinfo.=chr(9).chr(9).'<user>'.chr(13).chr(10);
		$userinfo.=chr(9).chr(9).chr(9).'<username>'.$_POST['username'].'</username>'.chr(13).chr(10);
		$userinfo.=chr(9).chr(9).chr(9).'<email>'.$_POST['email'] .'</email>'.chr(13).chr(10);
		$userinfo.=chr(9).chr(9).chr(9).'<password>'.md5($_POST['password']).'</password>'.chr(13).chr(10);
		$userinfo.=chr(9).chr(9).'</user>'.chr(13).chr(10);
		//--- adding the </usersinfo> tag
		$userinfo.=chr(9).'</usersinfo>';
		//--- saving the new xml
		file_put_contents('./data/users/users.php',$userinfo);
		$content.=$submit_message;
	}
	$resultstring=$content;
?> 
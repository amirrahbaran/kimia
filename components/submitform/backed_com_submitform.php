<?php
	$content='';
	$formtitle='Register - Required Information';
	if($params[0]!=''){
		$formtitle=$params[0];
	}
	$submit_message='Thank you for your registration.';
	if($params[1]!=''){
		$submit_message=$params[1];
	}
	
	function repeated($input_usr){
		if (file_exists('./data/users/users.php')){
			//--- loading the xml file
			$usr_info= simplexml_load_file('./data/users/users.php');
			//--- reading all records
			$usrcount=0;
			foreach($usr_info->user as $usr_data){
				//--- load records
				$stored_usr=$usr_data->username;
				if ($stored_usr==$input_usr){
					return true;
					continue; 
				}
				$usrcount++;
			}
		}
	}
	
	if(!$_POST['username'] || !$_POST['email'] || !$_POST['password']||!$_POST['repassword']||$_POST['password']!=$_POST['repassword']||repeated($_POST['username'])){
		$content.=$formtitle;
		$content.='<form method="POST" action="'.$_SERVER['PHP_SELF'].'?title='.$title.'">';
		$content.='<font size="2">';
		$content.='<br />';
		$content.='<table border="0" cellpadding="0" cellspacing="0">';
		$content.='<tr>';
		$content.='<td>';
		$content.='Choose username:';
		$content.='</td>';
		$content.='<td>';
		$content.='<input type="text" name="username"><br />';
		$content.='</td>';
		$content.='</tr>';
		$content.='<tr>';
		$content.='<td>';
		$content.='E-mail:';
		$content.='</td>';
		$content.='<td>';
		$content.='<input type="text" name="email"><br />';
		$content.='</td>';
		$content.='</tr>';
		$content.='<tr>';
		$content.='<td>';
		$content.='Choose password:';
		$content.='</td>';
		$content.='<td>';
		$content.='<input type="password" name="password"><br />';
		$content.='</td>';
		$content.='</tr>';
		$content.='<tr>';
		$content.='<td>';
		$content.='Verify password:';
		$content.='</td>';
		$content.='<td>';
		$content.='<input type="password" name="repassword"><br />';
		$content.='</td>';
		$content.='</tr>';
		$content.='</table>';
		$content.='<input type="submit" value="Submit" class="mybutton">';
		$content.='</font></form>';
	} else	{
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

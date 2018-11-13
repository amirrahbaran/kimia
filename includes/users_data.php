<?php
/*
 	# Kimia WIKI/CMS : a wiki/cms with no database and ajax technology
	
	Authors: Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  2.0.0  (your constructive criticism is appreciated, please see our
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */
defined('_KIMIA') or die('<big><big><big>ACCESS DENIED !');

function get_user_data($username,$item)
	{
	if(file_exists('./data/system/users.php')==true)
		{
		$users_file=file_get_contents('./data/system/users.php');
		$users_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$users_file);
		
		$result='';
		$users_index=simplexml_load_string($users_xml);
		foreach($users_index->user as $user)
			{
			if($username==$user->username)
				{
				if($item=='username') { $result=$user->username; }
				if($item=='password') { $result=$user->password; }
				if($item=='name') { $result=$user->name; }
				if($item=='email') { $result=$user->email; }
				if($item=='group') { $result=$user->group; }
				if($item=='status') { $result=$user->status; }
				break;
				}
			}
		return $result;
		}				
	}

function set_user_data($username,$item,$data)
	{
	if(file_exists('./data/system/users.php')==true)
		{
		$users_file=file_get_contents('./data/system/users.php');
		$users_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$users_file);
		
		$user_count=0;
		$result=false;
		$users_index=simplexml_load_string($users_xml);
		foreach($users_index->user as $user)
			{
			if($username==$user->username)
				{
				if($item=='username') { $users_index->user[$user_count]->username=$data; }
				if($item=='password') { $users_index->user[$user_count]->password=$data; }
				if($item=='name') { $users_index->user[$user_count]->name=$data; }
				if($item=='email') { $users_index->user[$user_count]->email=$data; }
				if($item=='group') { $users_index->user[$user_count]->group=$data; }
				if($item=='status') { $users_index->user[$user_count]->status=$data; }
				$users_file=$users_index->asXML();
				$users_file=preg_replace('/<\?xml version="1\.0"\?>/','<?php die("<big><big><big>ACCESS DENIED !"); ?>',$users_file);
				file_put_contents('./data/system/users.php',$users_file);
				$result=true;
				break;
				}
			$user_count++;
			}
		return $result;
		}
	}

function add_user_data($username,$password,$name,$email,$group,$status)
	{
	$result=false;
	if(file_exists('./data/system/users.php')==false)
		{
		$users_file='';
		$users_file.='<?php die("<big><big><big>ACCESS DENIED !"); ?>'.chr(10);
		$users_file.='<users>'.chr(10);
		$users_file.=chr(9).'<user>'.chr(10);
		$users_file.=chr(9).chr(9).'<username>'.$username.'</username>'.chr(10);
		$users_file.=chr(9).chr(9).'<password>'.$password.'</password>'.chr(10);
		$users_file.=chr(9).chr(9).'<name>'.$name.'</name>'.chr(10);
		$users_file.=chr(9).chr(9).'<email>'.$email.'</email>'.chr(10);
		$users_file.=chr(9).chr(9).'<group>'.$group.'</group>'.chr(10);
		$users_file.=chr(9).chr(9).'<status>'.$status.'</status>'.chr(10);
		$users_file.=chr(9).'</user>'.chr(10);
		$users_file.='</users>'.chr(10);
		
		file_put_contents('./data/system/users.php',$users_file);
		$result=true;
		} else {
		$users_file=file_get_contents('./data/system/users.php');
		$users_file=preg_replace('/\x0a<\/users>/','',$users_file);
		$users_file.=chr(9).'<user>'.chr(10);
		$users_file.=chr(9).chr(9).'<username>'.$username.'</username>'.chr(10);
		$users_file.=chr(9).chr(9).'<password>'.$password.'</password>'.chr(10);
		$users_file.=chr(9).chr(9).'<name>'.$name.'</name>'.chr(10);
		$users_file.=chr(9).chr(9).'<email>'.$email.'</email>'.chr(10);
		$users_file.=chr(9).chr(9).'<group>'.$group.'</group>'.chr(10);
		$users_file.=chr(9).chr(9).'<status>'.$status.'</status>'.chr(10);
		$users_file.=chr(9).'</user>'.chr(10);
		$users_file.='</users>'.chr(10);

		file_put_contents('./data/system/users.php',$users_file);
		$result=true;
		}
	return $result;
	}
?>
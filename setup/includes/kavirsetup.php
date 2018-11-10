<?php
/*					

	KAVIR WIKI/CMS : a wiki/cms with no database and ajax technology
	
	Authors: 
			Erfan Arabfakhri, Esfahan, Iran, <buttercupgreen@gmail.com>
			Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  2.0.0  (your constructive criticism is appreciated, please see our
    project page on http://sourceforge.net/projects/---
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */

defined('_ERFANWIKI') or die('<big><big><big>ACCESS DENIED !');

function kavirsetup_setup()
	{
	$username=$_POST['username'];
	//$password=md5($_POST['password']);
	$password=$_POST['password'];
	if(dologin($username,$password)==true)
		{
		header("Location: ".$_SERVER['PHP_SELF']);
		die('');
		}

	if($_GET['logout']=='true')
		{
		dologout();
		header("Location: ".$_SERVER['PHP_SELF']);
		die('');
		}
	}
	
function kavirsetup_templatepath()
	{
	$output="";
	$output.="./setup/template/";
	
	return $output;
	}
	
function kavirsetup_getdirection()
	{
	global $lng;

	$output=$lng['direction'];
	return $output;	
	}

function kavirsetup_header()
	{
	global $head;
	
	$output = "";
	$output.="<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />" . "\n";
	$output.="<title>Project Kavir Setup - testing...</title>". "\n";
	$output.=$head;
	
	return $output;	
	}

	
function kavirsetup_tabs()
	{
	global $lng;
	global $tabs;
	$mytabs=explode(';',$tabs);
	
	$output = "";
	$output.="<ul class='tabs'>";
		
	foreach($mytabs as $mytab)
		{
		if($mytab=='home')    { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."'>".$lng['home']."</a></li>"; }
		if($mytab=='logout')  { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?logout=true'>".$lng['tablogout']."</a></li>"; }
		}	
	$output.="</ul>";
	
	return $output;	
	}
	
function kavirsetup_mainbody()
	{
	global $lng;
	global $tabs;
	$module=get_module();
	
	$stop=false;

	//--- show module
	if($_GET['module']!='')
		{
		$module=$_GET['module'];
		if($stop==false)
			{
			if(check_permission($username,$title,$task)==true)
				{
				$tabs="home;logout;";
				
				$page=load_setup_module($module);				
				$title=$module;
				if(file_exists('./setup/modules/'.$module.'/info.txt')==true)
					{
					$title=file_get_contents('./setup/modules/'.$module.'/info.txt');
					}				
				$output="";
				$output.="<table align='center' class='mainbody'>";
				$output.="<tr><th id='top'>".$title."</th></tr>";
				$output.="<tr><td id='body'><div id='page'>". $page ."</div></td></tr>";
				$output.="<tr><td id='bottom'>".$lng['footer']."</td></tr>";
				$output.="</table>";
				
				if($page!='')
					{
					$stop=true;
					} else {
					$stop=false;
					}
				}
			}
		}
	
	//--- show module list
	if($stop==false)
		{
		if(check_permission($username,$title,$task)==true)
			{
			$tabs="home;logout;";
			
			$page=list_modules();
			$output="";
			$output.="<table align='center' class='mainbody'>";
			$output.="<tr><th id='top'>SETUP...</th></tr>";
			$output.="<tr><td id='body'><div id='page'>". $page ."</div></td></tr>";
			$output.="<tr><td id='bottom'>".$lng['footer']."</td></tr>";
			$output.="</table>";
			} else {
			$page=login_screen();			
			$output="";
			$output.="<br/><br/><br/><br/><br/><br/>";
			$output.="<table align='center' class='loginbody'>";
			$output.="<tr><th id='top'>ورود...</th></tr>";
			$output.="<tr><td id='body'><div id='login'>". $page ."</div></td></tr>";
			$output.="<tr><td id='bottom'>".$lng['footer']."</td></tr>";
			$output.="</table>";
			}
		$stop=true;
		}
		
	return $output;		
	}
		
?>

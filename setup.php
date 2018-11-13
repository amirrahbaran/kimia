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

define( '_KIMIA',1);

$startupflags='';
$article='';
$is_ok=false;
$head='';
$tabs='';

function checkandload($filename)
	{
	global $masterID;
	global $startupflags;
	global $lng;
	global $config;
	global $template;
		
	$result=false;
	if(file_exists($filename))
		{
		require_once($filename);
		$result=true;
		}
	return $result;	
	}
	
/*
	main execution block.
*/
	
if(checkandload('./includes/startup.php')==true)
	{
	$startupflags.='startup;';
	}

if(checkandload('./setup/includes/setupmain.php')==true)
	{
	$startupflags.='setupmain;';
	}
	
if(checkandload('./setup/includes/kavirsetup.php')==true)
	{
	$startupflags.='kavirsetup;';
	}
	
//--- system modes
$normal_mode='configdata;config;language;base32;xmlindex;wikiparser;wikimain;usersdata;kavir;print;startup;setupmain;kavirsetup;';

if ($startupflags==$normal_mode)
	{
	$is_ok=true;
	//--- kavirsetup setup
	kavirsetup_setup();
	//--- load selected template
	if(file_exists('./setup/template/index.htm')==true)
		{
		$memo=file_get_contents('./setup/template/index.htm');
		$memo=preg_replace('/\[sys:direction\]/',kavirsetup_getdirection(),$memo);
		$memo=preg_replace('/\[sys:path\]/',kavirsetup_templatepath(),$memo);
		$memo=preg_replace('/\[sys:body\]/',kavirsetup_mainbody(),$memo);
		$memo=preg_replace('/\[sys:header\]/',kavirsetup_header(),$memo);
		$memo=preg_replace('/\[sys:tabs\]/',kavirsetup_tabs(),$memo);
		print($memo);
		}
	}
		
if($is_ok==false)
	{
	//--- kavir cms is dead
	print "setup is dead...<br/>";
	print("<big>".$startupflags."</big><br/>");
	}

?>
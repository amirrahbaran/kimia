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
define( '_ERFANWIKI',1);

$config["homepage"]="";
$config["language"]="";
$config["template"]="";
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
	
//--- set the homepage
$config['homepage']=preg_replace('/\x20/','_',$config['homepage']);
	
//--- system modes
$normal_mode='configdata;config;language;base32;xmlindex;wikiparser;wikimain;usersdata;kavir;print;startup;';
$install_mode='configdata;language;base32;xmlindex;wikiparser;wikimain;usersdata;kavir;print;install;startup;';
$reinstall_mode='configdata;config;language;base32;xmlindex;wikiparser;wikimain;usersdata;kavir;print;install;startup;';

if ($startupflags==$normal_mode)
	{ 
	$is_ok=true;
	//--- kavir setup
	kavir_setup();
	//--- load selected template
	if(file_exists('./templates/'.$template .'/index.htm')==true)
		{
		$memo="";
		$memo=file_get_contents('./templates/'.$template .'/index.htm');
		$memo=preg_replace('/\[sys:direction\]/',kavir_getdirection(),$memo);
		$memo=preg_replace('/\[sys:path\]/',kavir_templatepath(),$memo);
		$memo=preg_replace('/\[sys:body\]/',kavir_mainbody(),$memo);
		$memo=preg_replace('/\[sys:footer\]/',kavir_footer(),$memo);
		//--- process modules
		
		preg_match_all("/\[sys:modules\|(.*?)\]/",$memo,$matches);
		if(isset($matches[1])==true)
			{
			foreach ($matches[1] as $value)
				{
				$parameters=explode("|",$value);
				$module_position=$parameters[0];
				$module_style=$parameters[1];
				$value=preg_replace('/\|/','\|',$value);
				$memo=preg_replace("/\[sys:modules\|".$value."\]/",kavir_modules($module_position,$module_style),$memo);
				}
			}

		$memo=preg_replace('/\[sys:header\]/',kavir_header(),$memo);
		$memo=preg_replace('/\[sys:tabs\]/',kavir_tabs(),$memo);
		print($memo);
		}
	}
	
if (($startupflags==$install_mode) || ($startupflags==$reinstall_mode))
	{ 
	$is_ok=true;		
	//install();
	}
	
if($is_ok==false)
	{
	//--- kavir cms is dead
	print("<big>".$startupflags."</big><br>");
	}
		
?>
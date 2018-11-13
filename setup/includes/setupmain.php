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

function get_module()
	{
	$temp=$_GET['module'];
	return $temp;
	}

function login_screen()
	{
	$output="";
	$output.="<form method='POST' action='".$_SERVER['PHP_SELF']."'>";
	$output.="کد کاربری‌:<br/>";
	$output.="<input class='text' type='text' name='username' style='width: 150px;'><br/>";
	$output.="کلمه عبور :<br/>";
	$output.="<input class='text' type='password' name='password' style='width: 150px;'><br/>";
	$output.="<input class='mybutton' type='submit' value='login'>";
	$output.="</form>";

	return $output;
	}
	
function list_modules()
	{
	$start=0;
	$row = 0;
	
	$list_ignore=array('.','..');
	$handle=opendir('./setup/modules');
	while($file=readdir($handle))
		{
		if(is_dir('./setup/modules/'.$file) && !in_array($file,$list_ignore))
    	    {
	        $modules[]=$file;
    	    }
	    }
	closedir($handle);
	
	//--- set maximum project gallery rows and columns
	$maxrows = 100;
	$maxcols = 5;
	
	$filecount=count($modules);
	$output='<div align="center"><table style="border-collapse: collapse;">';
	for($i=$start;$i<$filecount;)
		{
	    $output=$output.'<tr>';
    	for($col=0;$col<$maxcols;$col++)
			{
	        if ($i >=$filecount) 
				{
				$output=$output.'<td style="width: 130px; height:160px; border: none; padding: 5px;">&nbsp;</td>';
            	} else {
				$icon='./setup/modules/'.$modules[$i].'/icon.jpg';
				if (file_exists($icon)==false)
					{
					$icon='./setup/template/images/module.jpg';
					}
				$info=$modules[$i];
				if (file_exists('./setup/modules/'.$modules[$i].'/info.txt')==true)
					{
					$info=file_get_contents('./setup/modules/'.$modules[$i].'/info.txt');
					}
				$output.='<td valign="top" style="width: 130px; height:160px; border: none; padding: 5px;"><center>';
				$output.='<a href="'.$_SERVER['PHP_SELF'].'?module='.$modules[$i].'">';
				$output.='<img style="border: 1px solid #000000;" src="'.$icon.'" alt=" " width="90" height="90" /></a><br/>';
				$output.='<font face="tahoma" color="#FFFFEE" size="2">'.$info.'</font>';
				$output.='</center></td>';
				}
			$i++;
        	}
	    $output=$output.'</tr>';
    	$row++;
		if ($row==$maxrows)
			{
			break;
	    	}
    	}
	$output=$output.'</table></div>';

	return $output;		
	}
	
function load_setup_module($mod_name)
	{
	global $lng;
	global $head;
	global $tabs;
	
	$modulepath='./setup/modules/'.$mod_name.'/';
	$resultstring='';
	$resultheadstring='';
	if (file_exists('./setup/modules/' . $mod_name . '/mod_' . $mod_name . '.php') == true)
		{
		include('./setup/modules/' . $mod_name . '/mod_' . $mod_name . '.php');
		}
	$head.=$resultheadstring;
	return $resultstring;	
	}
	
?>
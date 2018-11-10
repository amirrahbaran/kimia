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

function get_title()
	{
	global $config;
	
	$temp="";
	if($temp=="")
		{
		$temp=$_GET['title'];
		}
	if($temp=="")
		{
		$temp=$_GET['edit'];
		}
	if($temp=="")
		{
		$temp=$_GET['create'];
		}
	if($temp=="")
		{
		$temp=$config['homepage'];
		}
	return $temp;
	}
	
function user_exists($username)
	{
	$output=false;
	$user_status=get_user_data($username,'status');
	if($user_status!='' && $user_status!='deleted')
		{
		$output=true;	
		}
	return $output;		
	}
	
function dologin($username,$password)
	{
	$result=false;
	
	if(user_exists($username)==true)
		{	
		if($_COOKIE["ERFANWIKI"]["logged-in"]!=true)
			{
			if($username!='' && $password!='')
				{
				if(get_user_data($username,'password')==$password && get_user_data($username,'status')=="active")
					{
					setcookie("ERFANWIKI[logged-in]",true);
					setcookie("ERFANWIKI[username]",$username);
					setcookie("ERFANWIKI[name]",get_user_data($username,'name'));
					setcookie("ERFANWIKI[group]",get_user_data($username,'group'));
					setcookie("ERFANWIKI[ip]",$_SERVER['REMOTE_ADDR']);
					$result=true;
					}
				}
			}
		}	
	return $result;
	}

function dologout()
	{
	setcookie("ERFANWIKI[logged-in]",false,time()-3600);
	setcookie("ERFANWIKI[username]",$username,time()-3600);
	setcookie("ERFANWIKI[name]",get_user_data($username,'name'),time()-3600);
	setcookie("ERFANWIKI[group]",get_user_data($username,'group'),time()-3600);
	setcookie("ERFANWIKI[ip]",$_SERVER['REMOTE_ADDR'],time()-3600);
	}
	
function check_permission($username,$title)
	{
	$result="";
	if($_COOKIE["ERFANWIKI"]["logged-in"]==true) { $result.="logged-in;"; }
	if($_COOKIE["ERFANWIKI"]["group"]=="admin") { $result.="admin;"; }
	if($_COOKIE["ERFANWIKI"]["group"]=="editor") { $result.="editor;"; }
	if($_COOKIE["ERFANWIKI"]["group"]=="user") { $result.="user;"; }
	return $result;
	}

function erfanwiki_encode($mystring)
	{
	$mybase32=new Base32;
	$mybase32->setCharset(Base32::csSafe);
	$mystring=$mybase32->fromString($mystring);
	return $mystring;
	}

function erfanwiki_decode($mystring)
	{
	$mybase32=new Base32;
	$mybase32->setCharset(Base32::csSafe);
	$mystring=$mybase32->toString($mystring);
	return $mystring;
	}
	
function page_exists($title)
	{
	$result=false;
	$datafile=erfanwiki_encode($title);
	if(file_exists('./data/pages/'.$datafile)==true)
		{
		$result=true;
		}
	return $result;
	}
	
function load_module($module,$title,$style)
	{
	global $article;
	$parser = &new wikiparser();
	
	$module=process_patterns($article,$module);
	$module=process_components($article,$module);
	$parser->parse_all($article,$module);
	$module=$parser->output;
	//$module=process_wikisyntax($article,$module);
		
	if($style=="")
		{
		$output = "";
		$output.="<table class='moduletable'>";
		$output.="<tr>";
		$output.="<th>".$title."</th>";
		$output.="</tr>";
		$output.="<tr>";
		$output.="<td>";
		$output.=$module;
		$output.="</td>";
		$output.="</tr>";
		$output.="</table>";
		}
		
	if($style=="simple")
		{
		$output.=$module;
		}
		
	return $output;
	}
	
function load_component($com_name, $parameterstring, $title)
	{
	global $lng;
	global $head;
	$resultstring = '';
	$resultheadstring = '';
	if (file_exists('./components/' . $com_name . '/com_' . $com_name . '.php') == true)
		{
		$params = explode('|',$parameterstring);
		include('./components/' . $com_name . '/com_' . $com_name . '.php');
		} else {
			$resultstring = '(COMPONENT NOT FOUND)';
		}
	$head.=$resultheadstring;
	return $resultstring;
	}
	
function process_components($title, $in)
	{
	preg_match_all("/\[component:(.*?)\]/",$in,$matches);
	foreach ($matches  as $v1)
		foreach ($v1 as $v2)
		{
		if (preg_match("/\[component:(.*?)\]/",$v2))
			{
			$com_name  = preg_replace("/\[component:(.*?)\|(.*?)\]/", "$1", $v2);
			$com_params  = preg_replace("/\[component:(.*?)\|(.*?)\]/", "$2", $v2);
			$com_name = preg_replace("/\[component:(.*?)\]/","$1",$com_name);
			$com_params = preg_replace("/\[component:(.*?)\]/","",$com_params);
			$com_params_pattern = preg_replace("/\|/","\|",$com_params);
			$com_output = load_component($com_name,$com_params,$title);
			$com_params_pattern  = preg_replace("/\//", "\/", $com_params_pattern);
			$com_params_pattern  = preg_replace("/\?/", "\?", $com_params_pattern);
			$in = preg_replace("/\[component:" . $com_name . "\|" . $com_params_pattern . "\]/",$com_output,$in);
			$in = preg_replace("/\[component:" . $com_name . "\]/",$com_output,$in);
			}
		}		
	return $in;
	}

function process_patterns($title, $in)
	{
	preg_match_all("/\{\{(.*?)\}\}/",$in,$matches);
	foreach ($matches  as $v1)
		foreach ($v1  as $v2)
			{
			if (preg_match("/\{\{(.*?)\}\}/",$v2))
				{
				$pattern_name = preg_replace("/\{\{(.*?)\}\}/","$1",$v2);
				$datafile =  erfanwiki_encode($pattern_name);
				if (!$pattern = @file_get_contents('./data/pages/'.$datafile))
					{
					$pattern = "[[" . $pattern_name . "]]";
					}
				$in = preg_replace("/\{\{" . $pattern_name . "\}\}/",$pattern ,$in);
				}
			}		
	return $in;
	}

function searchpage($keyword)
	{
	global $lng;		
	$output="";
	//--- import filenames into array
	$handle=opendir("./data/pages");
	while ($file = readdir($handle))
		{
		if(!is_dir($file))
			{
			$myresult[]=$file;
			}
		}
	sort($myresult);
	closedir($handle);	
	//--- searching the array for keyword
	$isfound=false;
	$count=0;
	$searchresult1="";
	foreach($myresult as $myfiles) 
		{
		if(preg_match("/".$keyword."/i", erfanwiki_decode($myfiles)) == true)
			{
			$isfound=ture;
			$count=$count+1;
			$searchresult1=$searchresult1."<li style='list-style:none'>$count . <a href='".$_SERVER['PHP_SELF']."?title=".erfanwiki_decode($myfiles)."'>".erfanwiki_decode($myfiles)."</a></li>";
			if($count >= 20) break;
			}
		}
	if($isfound==false)
		{
		$searchresult1.=$lng['noresult'].'<br />';
		$searchresult1.=$lng['clicknewpage1'].' <a href="'.$_SERVER['PHP_SELF'].'?title='.$keyword.'">'.$keyword.'</a>';
		$searchresult1.=$lng['clicknewpage2'].' <a href="'.$_SERVER['PHP_SELF'].'?title='.$keyword.'">';
		$searchresult1.=$lng['clicknewpage3'].'<br />';
		}
	$isfound=false;
	$count=0;
	$searchresult2="";
	foreach($myresult as $myfiles) 
		{
		$mycontent=implode("", file("./data/pages/".$myfiles));
		if (preg_match("/".$keyword."/i",$mycontent)==true)
			{
			$isfound=ture;
			$count=$count+1;
			$searchresult2=$searchresult2."<li style='list-style:none'>$count . <a href='".$_SERVER['PHP_SELF']."?mark=".$keyword."&amp;title=".erfanwiki_decode($myfiles)."'>".erfanwiki_decode($myfiles)."</a></li>";
			if($count>=20) break;
			}
		}
	if ($isfound==false)
		{
		$searchresult2=$lng['noresult']."<br/>";
		}
	$output.='<br/>'.$lng['searchintitle'].'<hr><br/>';
	$output.=$searchresult1.'<br/>';
	$output.='<br/>'.$lng['searchintext'].'<hr><br/>';
	$output.=$searchresult2;

	return $output;
	}
	
function displaypage($title,$mark)
	{
	global $lng;
	$parser = &new wikiparser();
	
	if(page_exists($title)==true)
		{
		$datafile=erfanwiki_encode($title);
		$page=file_get_contents('./data/pages/'.$datafile);		
		if($mark!='')
			{
			$page=preg_replace("/".$mark."/","&nbsp;@@".$mark."@@&nbsp;",$page);
			}		
		$page=process_patterns($title,$page);
		$page=process_components($title,$page);
		$parser->parse_all($title,$page);
		$page=$parser->output;
		$output=$page;
		} else {
		$output='';
		}

	return $output;
	}

function createpage($title)
	{
	global $lng;
	$stop=false;
	$title=preg_replace('/ /','_',$title);	
	
	if($stop==false)
		{
		if($_POST['save']!='')
			{
			$datafile=erfanwiki_encode($title);
			file_put_contents('./data/pages/'.$datafile,stripslashes($_POST['page']));
			add_article_index($title,'');
			$output=displaypage($title,"");
			$stop=true;
			}
		}
		
	if($stop==false)
		{
		$page='شما پیوندی را دنبال کرده‌اید و به صفحه‌ای رسیده‌اید که هنوز وجود ندارد. برای ایجاد صفحه، در این مستطیل شروع به تایپ کنید. اگر اشتباهاً اینجا آمده‌اید، دکمهٔ back مرورگرتان را بزنید.';

		$output='';
		$output.='<form action="'.$_SERVER['PHP_SELF'].'?create='.$title.'&title='.$title.'" method="post">';
		$output.='<p align=center>';
		$output.='<textarea id="editpage" name="page" cols="80" rows="24">'.$page.'</textarea><br />';
		$output.='<input class="mybutton" type="submit" name="save" value="'.$lng['savechanges'].'" />';
		$output.='</p>';
		$output.='</form>';
		$stop=true;		
		}
	return $output;
	}

function editpage($title)
	{
	global $lng;
	global $tabs;
	$stop=false;
	$title=preg_replace('/ /','_',$title);
	
	if($stop==false)
		{
		if($_POST['save']!='')
			{
			$datafile=erfanwiki_encode($title);
			file_put_contents('./data/pages/'.$datafile,stripslashes($_POST['page']));
			add_article_index(preg_replace('/ /','_',$title),'');
			$output=displaypage($title,"");
			$stop=true;
			}
		}
		
	if($stop==false)
		{
		if(page_exists($title)==true)
			{
			$datafile=erfanwiki_encode($title);
			$page=file_get_contents('./data/pages/'.$datafile);
	
			$output='';
			$output.='<form action="'.$_SERVER['PHP_SELF'].'?edit='.$title.'&title='.$title.'" method="post">';
			$output.='<p align=center>';
			$output.='<textarea id="editpage" name="page" cols="80" rows="24">'.$page.'</textarea><br />';
			$output.='<input class="mybutton" type="submit" name="save" value="'.$lng['savechanges'].'" />';
			$output.='</p>';
			$output.='</form>';
			} else {
			$output='';
			$stop=true;
			}
		}		
	return $output;
	}

function login_form()
	{
	$output="";
	$output.="<!DOCTYPE html PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n";
	$output.="<html dir=\"".kavir_getdirection()."\">\n";
	$output.="<head>\n";
	$output.="<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
	$output.="<link type=\"text/css\" rel=\"stylesheet\" href=\"".kavir_templatepath()."template.css\">\n";	
	$output.="<title>Login...</title>\n";
	$output.="</head>\n";
	$output.="<body>\n";
	$output.="<br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>\n";
	$output.="<div align=\"center\">\n";
	$output.="<table class=\"logintable\">\n";
	$output.="<tr>\n";
	$output.="<td class=\"logintable_head\">\n";
	$output.="<h1>ورود به سيستم</h1>\n";
	$output.="</td>\n";
	$output.="</tr>\n";
	$output.="<tr>\n";
	$output.="<td class=\"logintable_body\">\n";
	$output.="<form action=\"#\" method=\"post\">\n";
	$output.="<span class=\"pagetext\">\n";
	$output.="کد کاربري\n";
	$output.="</span>\n";
	$output.="<br/>\n";
	$output.="<input name=\"username\" type=\"text\" class=\"text\" style=\"width: 150px;\">\n";
	$output.="<br/>\n";
	$output.="<span class=\"pagetext\">\n";
	$output.="کلمه عبور\n";
	$output.="</span>\n";
	$output.="<br/>\n";
	$output.="<input name=\"password\" type=\"password\" class=\"text\" style=\"width: 150px;\">\n";
	$output.="<br/>\n";
	$output.="<button type=\"submit\" class=\"smallbutton\">ورود</button>\n";
	$output.="</form>\n";
	$output.="</td>\n";
	$output.="</tr>\n";
	$output.="<tr>\n";
	$output.="<td class=\"logintable_foot\">\n";
	$output.="</td>\n";
	$output.="</tr>\n";
	$output.="</table>\n";
	$output.="</div>\n";
	$output.="</body>\n";
	$output.="</html>\n";
	return $output;
	}
		
function putMessage($msg,$caption)
	{
	$output='';
	$output.='<h1>'.$caption.'</h1>';
	$output.='<br />';
	$output.='<div id="page">'.$msg.'</div>';
	
	print($output);
	}
?>
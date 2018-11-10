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

function kavir_setup()
	{
	global $template;
			
	$title=$_POST['title'];
	$username=$_POST['username'];
	//$password=md5($_POST['password']);
	$password=$_POST['password'];
	if(dologin($username,$password)==true)
		{
		header("Location: ".$_SERVER['PHP_SELF']."?title=".$title);
		die('');
		}

	if($_GET['login']=='true')
		{
		if($_COOKIE["ERFANWIKI"]["logged-in"]!=true)
			{
			print login_form();
			die('');		
			}
		}
		
	if($_GET['logout']=='true')
		{
		dologout();
		header("Location: ".$_SERVER['PHP_SELF']."?title=".$title);
		die('');
		}
		
	if($_GET['print']!='')
			{
			$template='print';
			}
	}
	
function kavir_templatepath()
	{
	global $template;
	
	$output="";
	$output.="./templates/".$template."/";
	
	return $output;
	}
	
function kavir_getdirection()
	{
	global $lng;

	$output=$lng['direction'];
	return $output;	
	}

function kavir_header()
	{
	global $head;
	
	$output="";
	$output.="<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>\n";
	$output.="<title>Project Kavir - testing...</title>\n";
	$output.=$head;
	
	return $output;	
	}

function kavir_footer()
	{
	global $lng;
		
	$output="";
	$output.=$lng['footer'];
	
	return $output;	
	}
	
function kavir_modules($position,$style)
	{
	//--- looking for modules
	if(file_exists('./data/indexes/articles.xml'))
		{
		$articles_index=simplexml_load_file('./data/indexes/articles.xml');
		foreach($articles_index->article as $article)
			{
			$mycategories=explode("|",$article->category);
			foreach($mycategories as $category)
				{
				if($category=="sys-modules")
					{
					$mymodule=$article->title;
					if(file_exists("./data/pages/".$mymodule)==true)
						{
						$module=file_get_contents("./data/pages/".$mymodule);
						preg_match_all("/\[module-position:(.*?)\]/",$module,$matches);
						$mod_position=$matches[1][0];
						preg_match_all("/\[module-order:(.*?)\]/",$module,$matches);
						$mod_order=$matches[1][0];
						if($mod_position==$position)
							{
							if($mymodules[$mod_order]=="")
								{
								$mymodules[$mod_order]=$module;
								} else {
									for(;$mymodules[$mod_order]!="";)
										{
										$mod_order++;
										}
								$module.='<br/><span class="warning"><b>هشدار!</b></span>';
								$mymodules[$mod_order]=$module;
								}
							}
						}
					}
				}
			}

		//--- loading modules
		$output="";
		if(isset($mymodules)==true)
			{
			ksort($mymodules);
			foreach($mymodules as $mymodule)
				{
				preg_match_all("/\[module-title:(.*?)\]/",$mymodule,$matches);
				$mod_title=$matches[1][0];
				preg_match_all("/\[module-style:(.*?)\]/",$mymodule,$matches);
				$mod_style=$matches[1][0];
				$output.=load_module($mymodule,$mod_title,$mod_style);
				}
			}
		}

	return $output;	
	}
		
function kavir_tabs()
	{
	global $lng;
	global $config;
	global $tabs;
	$title=get_title();
	$title=preg_replace('/\x20/','_',$title);
	
	$mytabs=explode(';',$tabs);
	
	$output="";
	$output.="<ul class='tabs'>\n";
		
	foreach($mytabs as $mytab)
		{
		if($mytab=='home')    { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?title=".urlencode($config["homepage"])."'>".$lng['home']."</a></li>\n"; }
		if($mytab=='edit')    { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?edit=".urlencode($title)."'>".$lng['edit']."</a></li>\n"; }
		if($mytab=='article') { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?title=".urlencode($title)."'>".$lng['article']."</a></li>\n"; }
		if($mytab=='file')    { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?file=1'>".$lng['tabfile']."</a></li>\n"; }
		if($mytab=='print')   { $output.="<li class='tabs'><a class='tabs' target='print' href='".$_SERVER['PHP_SELF']."?print=".urlencode($title)."'>".$lng['print']."</a></li>\n"; }
		if($mytab=='login')   { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?title=".urlencode($title)."&amp;login=true'>".$lng['tablogin']."</a></li>\n"; }
		if($mytab=='logout')  { $output.="<li class='tabs'><a class='tabs' href='".$_SERVER['PHP_SELF']."?title=".urlencode($title)."&amp;logout=true'>".$lng['tablogout']."</a></li>\n"; }
		}	
	$output.="</ul>\n";
	
	return $output;	
	}
	
function kavir_mainbody()
	{
	global $lng;
	global $config;
	global $tabs;
	global $article;
	$title=get_title();
	$title=preg_replace('/\x20/','_',$title);
	//$article=$title;
	$mark="";
	$stop=false;
	$username=$_COOKIE["ERFANWIKI"]["username"];
	$permission=check_permission($username,$title);
	
	if($_GET['mark']!="")
		{
		$mark=$_GET['mark'];
		}
	
	// printable view
	if($stop==false)
		{
		if($_GET['print']!='')
			{
			printpage($_GET['print']);
			$stop=true;			
			}
		}

	// search results
	if($stop==false)
		{
		if($_GET['search']!='')
			{
			$tabs="home;article";
			
			$page=searchpage($_GET['search']);
			$output="";
			$output.="<table class='mainbody'>\n";
			$output.='<tr><th id="top"><p style="text-indent: 0px;"><font size="3"><b>'.$lng['searchfor'].' "<small>'.$_GET['search'].'</small>" :</b></font></p></th></tr>';
			$output.="<tr><td id='body'><div id='page'>". $page ."</div></td></tr>\n";
			$output.="</table>\n";				
			
			$stop=true;			
			}
		}
	// upload file	
	if($stop==false)
		{
		if($_GET['file']!='')
			{
			if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
				{
				$tabs="home;article;edit;logout;";
				}
		
			}
		}
		
	// create page
	if($stop==false)
		{
		if($_GET['create']!='')
			{
			$title=$_GET['create'];
			
			if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
				{
				$tabs="home;article;file;logout;";
						
				if($_POST['save']!='')
					{
					if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
						{
						$tabs="home;edit;print;logout;";
						}
					if($permission=="logged-in;user;")
						{
						$tabs="home;article;print;logout;";
						}
					}
				
				$page=createpage($title);
				$output="";
				$output.="<table class='mainbody'>\n";
				$output.="<tr><th id='top'>".preg_replace('/_/',' ',$title)."</th></tr>\n";
				$output.="<tr><td id='body'><div id='page'>".$page."</div></td></tr>\n";
				$output.="</table>\n";								
				} else {
					$output.="لطفا ابتدا وارد سایت شوید.";					
				}
			$stop=true;
			}
		}
	
	//--- edit page
	if($stop==false)
		{
		if($_GET['edit']!='')
			{
			$title=$_GET['edit'];
			if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
				{
				$tabs="home;article;file;logout;";
				
				if($_POST['save']!='')
					{
					if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
						{
						$tabs="home;edit;print;logout;";
						}
					if($permission=="logged-in;user;")
						{
						$tabs="home;article;print;logout;";
						}
					}
						
				$page=editpage($title);
				if($page!='')
					{				
					$output = "";
					$output.= "<table class='mainbody'>\n";
					$output.= "<tr><th id='top'>".preg_replace('/_/',' ',$title)."</th></tr>\n";
					$output.= "<tr><td id='body'><div id='page'>".$page."</div></td></tr>\n";
					$output.= "</table>\n";
					} else {
					$output="";
					$output.="<table class='mainbody'>\n";
					$output.="<tr><th id='top'>".preg_replace('/_/',' ',$title)."</th></tr>\n";
					$output.="<tr><td id='body'><div id='page'>\n";
					$output.="<p align='justify'>\n";
					$output.="مقاله ای با عنوان <a href='".$_SERVER['PHP_SELF']."?create=".$title."' >".$title."</a> یافت نشد٬ برای ایجاد آن <a href='".$_SERVER['PHP_SELF']."?create=".$title."' >اینجا</a> کلیک کنید.";
					$output.="</p>\n";
					$output.="</div></td></tr>\n";				
					$output.="</table>\n";						
					}
				} else {
					$output.="لطفا ابتدا وارد سایت شوید.";					
				}
			$stop=true;				
			}
		}
		
	//--- display page
	if($stop==false)
		{
		$tabs="home;article;print;login";
		if($permission=="logged-in;admin;" || $permission=="logged-in;editor;")
			{
			$tabs="home;edit;print;logout;";
			}
		if($permission=="logged-in;user;")
			{
			$tabs="home;article;print;logout;";
			}
		
		$page=displaypage($title,$mark);		
		if($page!="")
			{
			$output="";
			$output.="<table class='mainbody'>\n";
			$output.="<tr><th id='top'>".preg_replace('/_/',' ',$title)."</th></tr>\n";
			$output.="<tr><td id='body'><div id='page'>". $page ."</div></td></tr>\n";
			$output.="</table>\n";				
			} else {
			//---task - create
			if(check_permission($username,$title,$task)==true)
				{
				$output="";
				$output.="<table class='mainbody'>\n";
				$output.="<tr><th id='top'>". $title ."</th></tr>\n";
				$output.="<tr><td id='body'><div id='page'>\n";
				$output.="<p align='justify'>\n";
				$output.="مقاله ای با عنوان <a href='".$_SERVER['PHP_SELF']."?create=".$title."' >".$title."</a> یافت نشد٬ برای ایجاد آن <a href='".$_SERVER['PHP_SELF']."?create=".$title."' >اینجا</a> کلیک کنید.";
				$output.="</p>\n";
				$output.="</div></td></tr>\n";				
				//$output.="<tr><td id='bottom'>".$lng['footer']."</td></tr>";
				$output.="</table>\n";
				} else {
				$output="";
				$output.="<table class='mainbody'>\n";
				$output.="<tr><th id='top'>". $title ."</th></tr>\n";
				$output.="<tr><td id='body'><div id='page'>\n";
				$output.="<p align='justify'>\n";
				$output.="مقاله با عنوان ".$title." یافت نشد.";
				$output.="</p>\n";
				$output.="</div></td></tr>\n";
				//$output.="<tr><td id='bottom'>".$lng['footer']."</td></tr>";
				$output.="</table>\n";
				}
			}
		$stop=true;
		}
	return $output;
	}
?>
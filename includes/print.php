<?php
/*
 	ERFAN WIKI : a wiki with no database based on PrintWiki
 
    Authors: 
			Erfan Arabfakhri, Esfahan, Iran, <buttercupgreen@gmail.com>
			Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  0.1  (your constructive criticism is appreciated, please see our
    project page on http://sourceforge.net/projects/erfanwiki/
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */
defined('_ERFANWIKI') or die('<big><big><big>ACCESS DENIED !');

function printpage($title)
	{
	global $lng;
	global $config;
	$parser = &new wikiparser();
	
	$datafile=erfanwiki_encode($title);
	if(file_exists('./data/pages/'.$datafile)==true)
		{
		$page=file_get_contents("./data/pages/".$datafile);
		$page = process_patterns($title, $page);
		$page = process_components($title, $page);
		$parser->parse_all($title,$page);
		$page=$parser->output;
		//$page = process_wikisyntax($title, $page);

		print(getprintHtmlHead($title));
		print("<body>");
		print("<h1>".preg_replace('/_/',' ',$title)."</h1>");
		print("<div id='page'>".$page."</div>");
		print("</body>");
		print("</html>");
		}
	}
 
function getprinthtmlhead($title)
	{
	global $lng;
	$head ="<!DOCTYPE html PUBLIC '-//W3C//DTD HTML 3.2//EN'>
	<html dir=\"".$lng['direction']."\">
	<head>
		<title>$title</title>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />
		<meta name=\"description\" content=\"Developer Tips - This is a WIKI designed to assist PHP and Delphi developers.\" />
		<meta name=\"keywords\" content=\"developer tips,dev-tips,php tips,delphi tips,tips,delphi,php,php wiki,delphi wiki,erfan,erfan arabfakhri,open source,free,wiki,arabfakhri\" />		
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./templates/print/print.css\" />
		<style type=\"text/css\">
		.pagebrk { page-break-after: always; }
		</style>
	</head>";
	return $head;
	}
?>
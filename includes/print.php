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

function printpage($title)
	{
	global $lng;
	global $config;
	$parser = &new wikiparser();
	
	$datafile=kimia_encode($title);
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
		<meta name=\"description\" content=\"Developer Tips - This is a WIKI designed to assist PHP developers.\" />
		<meta name=\"keywords\" content=\"developer tips,dev-tips,php tips,php,php wiki,open source,free,wiki,amir,amir rahbaran,rahbaran,amir reza rahbaran\" />		
		<link type=\"text/css\" rel=\"stylesheet\" href=\"./templates/print/print.css\" />
		<style type=\"text/css\">
		.pagebrk { page-break-after: always; }
		</style>
	</head>";
	return $head;
	}
?>
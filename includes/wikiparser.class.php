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

class wikiparser
	{
	var $output='';
		
	// parse basic elements
	function parse_basic( $in )
		{
        // Platform-independent newlines.
	    $in = preg_replace("/(\r\n|\r)/", "\n", $in);
   		// Remove excess newlines.
    	$in = preg_replace("/\n\n+/", "\n\n", $in);
		// Tabs
		$in =preg_replace('/\x09/','&nbsp;&nbsp;&nbsp;&nbsp;',$in);
    	// Delete module commands
		$in = preg_replace('/\[module-title:(.*?)\]/','',$in);
		$in = preg_replace('/\[module-position:(.*?)\]/','',$in);
		$in = preg_replace('/\[module-order:(.*?)\]/',"",$in);
		$in = preg_replace('/\[module-style:(.*?)\]/',"",$in);
		// Remove caregory symbols
    	$in = preg_replace("/\[category:(.*?)\]/", "", $in);
    	// Make paragraphs, including one at the end.
    	$in = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $in);	    
     	// Remove paragraphs if they contain only whitespace.
	    $in = preg_replace('|<p>\s*?<\/p>|', '', $in);
	    // Return output
	    return $in;
		}
	// parse emphasis
	function parse_emphasis( $in )
		{
		// Bold Italic
	    $in = preg_replace("/'''''(.*?)'''''/", "<b><i>$1</i></b>", $in);
		// Bold
    	$in = preg_replace("/'''(.*?)'''/", "<b>$1</b>", $in);
		// Italic
    	$in = preg_replace("/''(.*?)''/", "<i>$1</i>", $in);
		// Highlight text
    	$in = preg_replace("/@@(.*?)@@/", "<span class='highlight'>$1</span>", $in);    		
	    // Return output
	    //$this->output=$in;
	    return $in;
		}
	// parse page breaks
	function parse_pagebreaks( $in )
		{
		// page breaks
		$in = preg_replace("/-pb-/", "<p class='pagebrk'>&nbsp;</p>\n", $in);			
	    // Return output
	    //$this->output=$in;
	    return $in;
	    }
	// parse horizontal lines
	function parse_horizontal_lines( $in )
		{ 
		// Horizontal lines
	    $in = preg_replace("/----/", "<hr style='text-indent: 0px'>\n", $in);
		// Horizontal section lines
	    $in = preg_replace("/==(.*?)==/", "<p style='text-indent: 0px; margin-bottom: 0px;'><b>$1</b></p><hr style='text-indent: 0px' />\n", $in);    	
	    // Return output
	    //$this->output=$in;
	    return $in;
		}
	// parse images
	function parse_images( $in )
		{
		global $lng;
		$align = "left";
		$mystyle = "style='margin-right: 30px;'";
		if ($lng['direction'] == "ltr")
			{
			$align = "right";
			$mystyle = "style='margin-left: 30px;'";
			}
		// Image thumbnails with comments
    	$in = preg_replace("/\[image:(.*?)\|(.*?)\]/", "</p><table class='image' $mystyle align=".$align." border=1><tr><td class='image'><a class=imglink href='./data/uploads/$1' target='image'><img alt='&nbsp;'  border=1 src='./data/uploads/thumbs/$1' /></a><br />$2</td></tr></table>\n", $in);	
    	//$in = preg_replace("/\[image:(.*?)\|(.*?)\]/", "</p><table class='image' $mystyle align=".$align." border=1><tr><td class='image'><a class=imglink href='".$_SERVER['PHP_SELF']."?picture=$1&amp;article=$title'><img alt='&nbsp;'  border=1 src='./data/uploads/thumbs/$1' /></a><br />$2</td></tr></table>", $in);	
		// Image thumbnails
		$in = preg_replace("/\[image:(.*?)\]/", "<table class='image' $mystyle align=".$align." border=1><tr><td class='image'><a class=imglink href='./data/uploads/$1' target='image'><img alt='&nbsp;'  border=1 src='./data/uploads/thumbs/$1' /></a></td></tr></table>\n", $in);
		//$in = preg_replace("/\[image:(.*?)\]/", "<table class='image' $mystyle align=".$align." border=1><tr><td class='image'><a class=imglink href='".$_SERVER['PHP_SELF']."?picture=$1&amp;article=$title'><img alt='&nbsp;'  border=1 src='./data/uploads/thumbs/$1' /></a></td></tr></table>", $in);
		// Return output
	    //$this->output=$in;
	    return $in;
		}
	// parse lists
	function parse_lists_handle( $matches, $close=false )
		{
		$listtypes = array( '*'=>'ul', '#'=>'ol' );
		$output = "";
		if($close==true)
			{
			$newlevel=0;
			} else {
			$newlevel=strlen($matches[1]);
			}
		while ($this->list_level!=$newlevel)
			{
			$listchar = substr($matches[1],-1);
			$listtype = $listtypes[$listchar];
			if ($this->list_level>$newlevel)
				{
				$listtype = '/'.array_pop($this->list_level_types);
				$this->list_level--;
				} else {
				$this->list_level++;
				array_push($this->list_level_types,$listtype);
				}
			$output .= "<{$listtype}>\n";
			}
		if ($close) return $output;
		$output .= "<li>".$matches[2]."</li>\n";
		return $output;
		}
	// parse lists
	function parse_lists_line($line)
		{
		$line_regexes = array( 'list'=>'^([\*\#]+)(.*?)$' );
		$this->stop = false;
		$this->stop_all = false;
		$called = array();
		foreach ($line_regexes as $func=>$regex)
			{
			if (preg_match("/$regex/i",$line,$matches))
				{
				$called[$func] = true;
				$line = $this->parse_lists_handle( $matches );
				if ($this->stop || $this->stop_all) break;
				}
			}
		// if this wasn't a list item, and we are in a list, close the list tag(s)
		if (($this->list_level>0) && !$called['list']) $line = $this->parse_lists_handle( false, true ) . $line;
		return $line;
		}
	// parse lists
	function parse_lists( $in )
		{
		$output = "";
		$this->list_level_types = array();
		$this->list_level = 0;
		$lines = explode("\n",$in);
		foreach ($lines as $k=>$line)
			{
			$line = $this->parse_lists_line( $line );
			$output .= $line;
			}
	    //$this->output=$output;
	    return $output;
		}
	// parse internal links
	function parse_internals( $in )
		{
		while(preg_match('/\[\[(.*?)\|(.*?)\]\]/', $in, $internal_matches)!=0)
			{
			$link_alias=$internal_matches[2];
			$link_title=$internal_matches[1];
			$link = preg_replace('/\x20/', '_', $link_title);
			$link=htmlentities(urlencode($link));			
			$link = '<a href="' . $_SERVER['PHP_SELF'] . '?title=' . $link . '" title="' . $link_title . '" >' . $link_alias . '</a>';
			$in = preg_replace('/\[\[(.*?)\|(.*?)\]\]/', $link, $in, 1);
			}
		while(preg_match('/\[\[(.*?)\]\]/', $in, $internal_matches)!=0)
			{
			$link_title=$internal_matches[1];
			$link = preg_replace('/\x20/', '_', $link_title);
			$link=htmlentities(urlencode($link));
			$link = '<a href="' . $_SERVER['PHP_SELF'] . '?title=' . $link . '" title="' . $link_title . '" >' . $link_title . '</a>';			
			$in = preg_replace('/\[\[(.*?)\]\]/', $link, $in, 1);
			}
		//$this->output=$output;
	    return $in;			
		}
	// parse external links
	function parse_externals( $in )
		{
		while(preg_match('/\[http\:\/\/(.*?)\x20(.*?)\]/', $in, $external_matches)!=0)
			{
			$link_alias=$external_matches[2];
			$link_title=$external_matches[1];
			$link = $link_title;
			$link = '<a href="http://' . $link . '" >' . $link_alias . '</a>';
			$in = preg_replace('/\[http\:\/\/(.*?)\x20(.*?)\]/', $link, $in, 1);
			}
		while(preg_match('/\[http\:\/\/(.*?)\]/', $in, $external_matches)!=0)
			{
			$link_title=$external_matches[1];
			$link = $link_title;
			$link = '<a href="http://' . $link . '" >' . $link_title . '</a>';
			$in = preg_replace('/\[http\:\/\/(.*?)]/', $link, $in, 1);
			}
		//$this->output=$output;
	    return $in;			
		}		
	// parse w3c compability
	function parse_w3c( $in )
		{
		// w3c standards		
		$in = preg_replace('/<\/div><\/p>/','</div>',$in);		
	    $in = preg_replace('/<p><\/p>/', '', $in);
	    $in = preg_replace('/<p>\x0a<\/p>/', '', $in);
	    $in = preg_replace('/<\/form>\x0a<\/p>/', '</form>', $in);
	    $in = preg_replace('/<\/div>\x0a<\/p>/', '</div>', $in);
	    $in = preg_replace('/<\/table>\x0a<\/p>/', '</table>', $in);
	    $in = preg_replace('/<hr(.*?)>\x0a<\/p>/', '<hr$1>', $in);
	    $in = preg_replace('/<p>\x0a\x0a<div(.*?)>/','<div$1>', $in);
		$in = preg_replace('/<\/table><\/p>/','</table>',$in);		
		$in = preg_replace('/<p(.*?)><code(.*?)>/','<code$2>',$in);		
		$in = preg_replace('/<\/code><\/p>/','</code>',$in);		
		$in = preg_replace('/<p><p(.*?)>/','<p$1>',$in);		
		$in = preg_replace('/<\/p><\/li>/','</li>',$in);		
		$in = preg_replace('/<\/p><\/ul>/','</ul>',$in);
		$in = preg_replace('/<p><table(.*?)>/','<table$1>',$in);
		$in = preg_replace('/<\/table>(.*?)<\/p>/','</table>$1',$in);
		$in = preg_replace('/<p><span(.*?)>/','<span$1>',$in);		
		$in = preg_replace('/<p><div(.*?)>/','<div$1>',$in);		
		$in = preg_replace('/<p><form(.*?)>/','<form$1>',$in);
		$in = preg_replace('/<\/form><\/p>/','</form>',$in);
		$in = preg_replace('/<p><hr(.*?)><\/p>/','<hr$1>',$in);
		$in = preg_replace('/<hr(.*?)><\/p>/','<hr$1>',$in);
		$in = preg_replace('/<p><\/span>/','',$in);
		$in = preg_replace('/<\/p><\/p>/','',$in);
		$in = preg_replace('/<\/p><\/div>/','</div>',$in);
		$in = preg_replace('/<br>/','<br/>',$in);
		$in = preg_replace('/<br\/><\/p>/','<br/>',$in);
		$in = preg_replace('/<\/script><\/p>/','</script>',$in);
		$in = preg_replace('/<\/li><p>/','</li>',$in);
		//$in = preg_replace('/<\/li>\x0a<ul>/','</li><li><ul>',$in);
	    // Return output
	    return $in;		
		}
	// parse all and exclude nowiki tags
	function parse_all( $title, $in ) 
		{
		$nowiki_count=0;
		while(preg_match('/<nowiki>(.*?)<\/nowiki>/s', $in, $nowiki_matches)!=0)
			{
			$nowiki_count++;
			$nowiki[$nowiki_count]=$nowiki_matches[1];
			$in = preg_replace('/<nowiki>(.*?)<\/nowiki>/s', '---'.$nowiki_count.'---', $in, 1);
			}
		$in = $this->parse_basic($in);
		$in = $this->parse_internals($in);
		$in = $this->parse_externals($in);
		$in = $this->parse_emphasis($in);
		$in = $this->parse_pagebreaks($in);
		$in = $this->parse_horizontal_lines($in);
		$in = $this->parse_images($in);
		$in = $this->parse_lists($in);	
		$in = $this->parse_w3c($in);
		for($nowiki_index=1;$nowiki_index<=$nowiki_count;$nowiki_index++)
			{
			$in = preg_replace('/---'.$nowiki_index.'---/', $nowiki[$nowiki_index],$in,1);
			}
		// Return output		
		$this->output=$in;
	    return $in;
		}
	}
?>
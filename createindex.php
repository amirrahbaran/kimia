<?php
$index_xml='<index>'.chr(13).chr(10);
$handle=opendir('./data/pages/');
$list_ignore = array ('.','..');
while ($file = readdir($handle))
    {
    if (!in_array($file,$list_ignore))
        {
		$temp=file_get_contents('./data/pages/' . $file);
		preg_match('/\[category:(.*?)\]/',$temp,$matches);
		$category=$matches[1];
		
		$index_xml.=chr(9).'<article>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<title>'.$file.'</title>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<category>'.$category.'</category>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<editor></editor>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<day>'.date('j').'</day>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<month>'.date('n').'</month>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<year>'.date('Y').'</year>'.chr(13).chr(10);
		$index_xml.=chr(9).chr(9).'<flags></flags>'.chr(13).chr(10);
		$index_xml.=chr(9).'</article>'.chr(13).chr(10);
        }
    }
$index_xml.='</index>';
closedir($handle);
file_put_contents('./data/indexes/articles.xml',$index_xml);
?>
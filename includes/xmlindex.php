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

function add_article_index($title,$flags)
	{
	$editor=$_SESSION['username'];
	$day=date('j');
	$month=date('n');
	$year=date('Y');
	$time=date("H:i:s");
	
	$is_newxml=false;
	$temp = file_get_contents('./data/pages/' . kimia_encode($title));
	preg_match('/\[category:(.*?)\]/',$temp,$matches);
	$category=$matches[1];
	
	if (!file_exists('./data/indexes/articles.xml'))
		{
		$new_articles_index='<index>';
		$new_articles_index.=chr(9) . '<article>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<title>'.kimia_encode($title).'</title>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<category>'.$category.'</category>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<editor>'.$editor.'</editor>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<day>'.$day.'</day>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<month>'.$month.'</month>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<year>'.$year.'</year>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<time>'.$time.'</time>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . chr(9) . '<flags>'.$flags.'</flags>' .chr(13) . chr(10);
		$new_articles_index.=chr(9) . '</article>' .chr(13) . chr(10);
		$new_articles_index.='</index>';
		file_put_contents('./data/indexes/articles.xml',$new_articles_index);
		$is_newxml=true;
		}

	$is_found=false;
	if (file_exists('./data/indexes/articles.xml'))
		{
		$articles_index = simplexml_load_file('./data/indexes/articles.xml');
		
		if($is_newxml==false)
			{
			$article_count=0;
			foreach($articles_index->article as $article)
				{				
				if(kimia_decode($article->title) == $title)
					{
					$is_found=true;
					$articles_index->article[$article_count]->title=kimia_encode($title);
					$articles_index->article[$article_count]->category=$category;
					$articles_index->article[$article_count]->editor=$editor;
					$articles_index->article[$article_count]->day=$day;
					$articles_index->article[$article_count]->month=$month;
					$articles_index->article[$article_count]->time=$time;
					$articles_index->article[$article_count]->year=$year;
					$articles_index->article[$article_count]->flags=$flags;				
					break;
					}
				$article_count++;
				}
			}
		
		$new_articles_index=$articles_index->asXML();
		
		if(($is_found==false) && ($is_newxml==false))
			{
			$new_articles_index=preg_replace('/<\/index>/','',$new_articles_index);
			$new_articles_index.=chr(9) . '<article>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<title>'.kimia_encode($title).'</title>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<category>'.$category.'</category>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<editor>'.$editor.'</editor>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<day>'.$day.'</day>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<month>'.$month.'</month>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<year>'.$year.'</year>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<time>'.$time.'</time>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . chr(9) . '<flags>'.$flags.'</flags>' .chr(13) . chr(10);
			$new_articles_index.=chr(9) . '</article>' .chr(13) . chr(10);
			$new_articles_index.='</index>';
			}
		file_put_contents('./data/indexes/articles.xml',$new_articles_index);
		}	
	}
	
function create_article_index()
	{
	$index_xml='<index>'.chr(13).chr(10);
	$handle=opendir('./data/pages/');
	$list_ignore = array ('.','..');
	while ($file = readdir($handle))
	    {
	    if(!in_array($file,$list_ignore))
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
			$index_xml.=chr(9).'</article>';
	        }
	    }
	$index_xml.='</index>';
	closedir($handle);
	file_put_contents('./data/indexes/articles.xml',$index_xml);	
	}
?>
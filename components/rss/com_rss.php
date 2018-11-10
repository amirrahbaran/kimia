<?php
	function get_description($article_name)
		{
		$mywikiparser = &new wikiparser();
		if(file_exists("./data/pages/".$title)==true)
			{
			$article=file_get_contents("./data/pages/".$title);
			$article=$mywikiparser->strip_all($title,$article);
			$article=explode(" ",$article);
			$count=0;
			foreach($article as $word)
				{
				$count++;
				$description.=$word . " ";
				if($count>=100) break;
				}
			$description.="...";
			}
		return $description;
		}
/*
  This component has two element. first category and second the number of recent news; 
 */
	$content='';
	$cat_flag=false; 
	$num_flag=false;
	$num_value=10;

	//check whether there is the first element; 
	if ($params[0] != '')
		{
		$cat_flag=true;
		$cat_value=$params[0];
		$cat_value1='_'.erfanwiki_encode($params[0]);
		}

	//check whether there is the second element;
	if ($params[1] != '')
		{
		$num_flag=true;
		$num_value=$params[1];
		}
	
	if (file_exists('./data/indexes/articles.xml'))
		{
		//--- loading the xml file
		$xml = simplexml_load_file('./data/indexes/articles.xml');
		//--- reading all records
		$xmlcount=0;
		foreach($xml->article as $article)
			{
			//--- load records
			$title=$article->title;
			$category=$article->category;
			$editor=$article->editor;
			$day=$article->day;
			$month=$article->month;
			$year=$article->year;
			$time=$article->time;
	
			$update_time=' '.$year.'/'.$month.'/'.$day.' '.$time;
			
			//Server Day 
			$server_time = date("Y/m/d H:i:s");
			
			// Server time & update time Diffrencial
			$time_dif = strtotime($server_time) - strtotime($update_time);
			
			if($cat_flag && $category == $cat_value && $cat_value!='sys-modules')
				{
				//creating array of updates
				$info_array[$time_dif] = $title ;
				}
				
			if(!$cat_flag && $category != 'sys-modules')
				{
				$info_array[$time_dif] = $title ;	
				}
			//--- count records
			$xmlcount++;
			}
			
		//--- sorting the array by its key
		if (isset($info_array))
			{
			ksort($info_array);
			$filtered = array_slice($info_array, 0, $num_value);

	 		//---- writing into an RSS/XML 
			if (file_exists('./data/temp/rss'.$cat_value1.'.xml'))	
				unlink ('./data/temp/rss'.$cat_value1.'.xml');
			$handle = fopen("./data/temp/rss".$cat_value1.".xml", "w+");
			$rss.='<?xml version="1.0"?>'.chr(13).chr(10);
			$rss.='<rss version="2.0">'.chr(13).chr(10);
			$rss.=chr(9).'<channel>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<title>Liftoff News</title>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<link>http://liftoff.msfc.nasa.gov/</link>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<description>Liftoff to Space Exploration.</description>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<language>en-us</language>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<pubDate>Tue, 10 Jun 2003 04:00:00 GMT</pubDate>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<lastBuildDate>Tue, 10 Jun 2003 09:41:01 GMT</lastBuildDate>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<docs>http://blogs.law.harvard.edu/tech/rss</docs>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<generator>Weblog Editor 2.0</generator>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<managingEditor>editor@example.com</managingEditor>'.chr(13).chr(10);
			$rss.=chr(9).chr(9) .'<webMaster>webmaster@example.com</webMaster>'.chr(13).chr(10).chr(13).chr(10);
			$news_count=0;
			foreach ($filtered as $k => $v) 
				{
				$cnt=0;
				foreach ($xml->children() as $second_gen)
					{
					if ($second_gen->title == $v)
						{
/*							$rss.=chr(9).chr(9).'<item>'.chr(13).chr(10);
							$rss.='<u>'.$cnt.'</u><br/>';
							$rss.=erfanwiki_decode($xml->article[$cnt]->title).'<br/>';
							$rss.=$xml->article[$cnt]->category.'<br/>';
							$rss.=$xml->article[$cnt]->year.'/'.$xml->article[$cnt]->month.'/'.$xml->article[$cnt]->day.'<br/>';
							$rss.=$xml->article[$cnt]->time.'<br/>';
							$rss.=$xml->article[$cnt]->editor.'<br/><hr/>';
*/
							$rss.=chr(9).chr(9).'<item>'.chr(13).chr(10).chr(13);
							$rss.=chr(9).chr(9).chr(9).'<title>'.erfanwiki_decode($xml->article[$cnt]->title).'</title>'.chr(13).chr(10);
							$rss.=chr(9).chr(9).chr(9).'<link></link>'.chr(13).chr(10);
							$rss.=chr(9).chr(9).chr(9).'<description>'.get_description($xml->article[$cnt]->title).'</description>'.chr(13).chr(10);
							$rss.=chr(9).chr(9).chr(9).'<pubDate>'.$xml->article[$cnt]->year.'/'.$xml->article[$cnt]->month.'/'.$xml->article[$cnt]->day.'</pubDate>'.chr(13).chr(10);
							$rss.=chr(9).chr(9).chr(9).'<guid></guid>'.chr(13).chr(10);
							$rss.=chr(9).chr(9).'</item>'.chr(13).chr(10).chr(13).chr(10);
						}
					$cnt++;	
					}
				$new_count++;
				}
			//--- adding the </channel> & </rss>tag
			$rss.=chr(9).'</channel>'.chr(13).chr(10);
			$rss.='</rss>';
			//--- saving the new xml
			file_put_contents('./data/temp/rss'.$cat_value1.'.xml',$rss);		
			fclose($handle);
			}
		$content = "<a href=./data/temp/rss".$cat_value1.".xml>rss</a>";
		$resultstring = $content;
		}
		
?>
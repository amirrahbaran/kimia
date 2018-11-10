<?php
	function get_summery($article_name)
		{
		if(file_exists("./data/pages/".$title)==true)
			{
			$article=file_get_contents("./data/pages/".$title);
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
			$content.='<pre>';
			$news_count=0;
			foreach ($filtered as $k => $v) 
				{
				$cnt=0;
				foreach ($xml->children() as $second_gen)
					{
					if ($second_gen->title == $v)
						{
						//if ($cnt<$num_value)
							//{
							$content.='<u>'.$cnt.'</u><br/>';
							$content.=erfanwiki_decode($xml->article[$cnt]->title).'<br/>';
							$content.=get_summery($xml->article[$cnt]->title).'<br/>';
							$content.=$xml->article[$cnt]->category.'<br/>';
							$content.=$xml->article[$cnt]->year.'/'.$xml->article[$cnt]->month.'/'.$xml->article[$cnt]->day.'<br/>';
							$content.=$xml->article[$cnt]->time.'<br/>';
							$content.=$xml->article[$cnt]->editor.'<br/><hr/>';
							//}
						}
					$cnt++;	
					}
				$new_count++;
				}
			$content.=$cnt.'<hr/>';	
			$content.=$new_count;
			}
		$content.='</pre>';
		$resultstring=$content;
		}
?>
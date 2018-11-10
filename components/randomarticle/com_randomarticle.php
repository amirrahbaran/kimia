<?php
	if ($params[0] != '')
		{
		if(file_exists('./data/indexes/articles.xml'))
			{
			$articles_index=simplexml_load_file('./data/indexes/articles.xml');
			foreach($articles_index->article as $article)
				{
				$mycategories=explode("|",$article->category);
				foreach($mycategories as $category)
					{
					if($category==$params[0])
						{
						$randomarticle[]=erfanwiki_encode($article->title);
						}
					}
				}
			} else
				{
				$handle=opendir('./data/pages/');
				$list_ignore = array ('.','..');
				while ($file = readdir($handle))
					{
					if (!in_array($file,$list_ignore))
						{
						$temp = file_get_contents('./data/pages/' . $file);
						preg_match('/\[category:(.*?)\]/',$temp,$matches);
						$mycategories=explode("|",$matches[1]);
						foreach($mycategories as $category)
							{
							if($category==$params[0])
								{
								$randomarticle[]=$file;
								}
							}
						}
					}
				closedir($handle);		
				}
		}
	if($randomarticle)
		{
		$rand_keys = array_rand($randomarticle);
		$resultstring = file_get_contents('./data/pages/' . $randomarticle[$rand_keys]);
		}
?> 






<?php
//....fetch the posted comments from the xml file.....
	$content='';
	if (file_exists("./data/temp/comment_".erfanwiki_encode($title).".xml"))
		{
		$content.="----";
		//--- loading the xml file
		$comment_xml = simplexml_load_file('./data/temp/comment_'.erfanwiki_encode($title).'.xml');
		//--- reading all records
		$xmlcount=0;
		foreach($comment_xml->post as $article)
			{
			//--- post comments
			$content.="Date:<br/>";
			$content.=$article->date."<br/>";
			$content.="Time:<br/>";
			$content.=$article->time."<br/>";
			$content.="Name:<br/>";
			$content.=$article->name."<br/>";
			$content.="Email:<br/>";
			$content.=$article->email."<br/>";
			$content.="Comment:<br/>";
			$content.=$article->comment."<br/>";
			$content.="----";
			//--- count comments
			$xmlcount++;
			}
		}
//....write the posted comment into the xml file.....
	//....TIME..... 
	$comment_date = date("Y/m/d");
	$comment_time = date("H:i:s");
	if(!$_POST['name'] || !$_POST['email'] || !$_POST['comment'])
		{
		$content.="<br/><br/><br/><br/><br/>";		
		$content.="You can also leave your comment about this article.";
		$content.='<form method="POST" action="'.$_SERVER['PHP_SELF'].'?title='.$title.'">';
		$content.='<font size="2">';
		$content.='<br />';
		$content.='Name :<br />';
		$content.='<input type="text" name="name"><br />';
		$content.='E-mail :<br />';
		$content.='<input type="text" name="email"><br />';
		$content.='Comment :<br>';
		$content.='<textarea name="comment" style="width: 300px; height: 200px;"></textarea><br />';
		$content.='<input type="submit" value="Send" class="mybutton">';
		$content.='</font></form>';
		} else {
				if (!file_exists("./data/temp/comment_".erfanwiki_encode($title).".xml"))
					{
					$comment='<?xml version="1.0"?>'.chr(13).chr(10);		
					$comment.='<index>'.chr(13).chr(10);	
					}else{
					//--- loading the xml file
					$xml = simplexml_load_file('./data/temp/comment_'.erfanwiki_encode($title).'.xml');	
					//--- genetaring xml string
					$lastxml=$xml->asXML();
					$comment=preg_replace('/<\/index>/','',$lastxml);
					}
				$comment.=chr(9).'<post>'.chr(13).chr(10);
				$comment.=chr(9).chr(9) .'<name>'.$_POST['name'].'</name>'.chr(13).chr(10);
				$comment.=chr(9).chr(9) .'<email>'.$_POST['email'].'</email>'.chr(13).chr(10);
				$comment.=chr(9).chr(9) .'<comment>'.$_POST['comment'].'</comment>'.chr(13).chr(10);
				$comment.=chr(9).chr(9) .'<date>'.$comment_date.'</date>'.chr(13).chr(10);
				$comment.=chr(9).chr(9) .'<time>'.$comment_time.'</time>'.chr(13).chr(10);
				$comment.=chr(9).'</post>'.chr(13).chr(10);
				$comment.='</index>';
				//--- saving the xml
				file_put_contents('./data/temp/comment_'.erfanwiki_encode($title).'.xml',$comment);
				}
	$resultstring=$content;
	?>
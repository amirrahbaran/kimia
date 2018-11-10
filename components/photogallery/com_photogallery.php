<?php
	$content='';
	$gallery_array=$params;
	//--- returns a directory handle to be used in opendir function
/*
 	$handle=opendir('./data/uploads');
	//--- this loop reads directory files into $file
	while ($file = readdir($handle))
	    {
	    if (!is_dir($file))
	        {
	        //--- if current file is a jpg,png or gif do...
	        if (preg_match('/\.jpg/i',$file))
	            {
	            //--- add current file to $myimages array
	            $myimages[]=$file;
				//--- if thumbnail is not exists create one
	            if(!file_exists('./data/uploads/thumbs/'.$file))
					{
					//--- create a JPEG image from source file into memory
					$image = imageCreateFromJPEG('./data/uploads/'.$file);
					//--- get image width and height
					$image_width = imagesx($image);
					$image_height = imagesy($image);
					//--- set thumbnail width and height
					$thumb_width = 100;
					//--- automatically calculate thumbnail height
					$thumb_height = round($image_height * $thumb_width / $image_width);
					//--- create an image for thumbnail into memory
					$thumb = imageCreateTrueColor($thumb_width, $thumb_height);
					//--- genterate thumbnail from source image
					imageCopyResampled($thumb, $image, 0, 0, 0, 0, $thumb_width,$thumb_height, $image_width, $image_height);
					//--- save thumbnail in JPEG format and quality 70%
					imageJPEG($thumb,'./data/uploads/thumbs/'.$file,70);
					//--- free the allocated memory
					imageDestroy($image);
					imageDestroy($thumb);				
					}
				}
	        }
	    }
	//--- closes the directory stream indicated by $handle
	closedir($handle);
*/	
	//--- set maximum gallery rows and columns
	$maxrows = 5;
	$maxcols = 4;
	//--- set starting image
	$start=0;
	if($_GET['s'])
		{
		//--- get starting image id from link
		$start=$_GET['s'];
		}
	
	$row = 0;
	//--- get the nimber of images
	$gallery_size = count($gallery_array);
	
	//--- create navigation ( Prior link )
	if ($start > 1)
		{
		$nav="<a href=\"".$_SERVER['PHP_SELF']."?s=".($start - ($maxcols * $maxrows))."\">Prior</a>";
		}
	
	//--- create table
	$table="<table border=\"1\">\n";
	for ($i=$start;$i<$gallery_size;)
		{
	    //--- create row
	    $table=$table."<tr>\n";
	    for($col=0;$col<$maxcols;$col++)
			{
			//--- create column
	        if ($i >=$gallery_size) 
				{
				$table=$table."<td>&nbsp;</td>";
	            } else {
	                $table=$table."<td><a href=\"./data/uploads/".$gallery_array[$i]."\">";
					$table=$table."<img src=\"./data/uploads/thumbs/".$gallery_array[$i]."\"></a></td>";
					}
			$i++;
	        }
	    $table=$table."</tr>\n";
	    $row++;
	    //--- check if maximum number of rows is used
	    if ($row==$maxrows)
			{
	        //--- create navigation ( Next link )
	        if ($i < $filecount)
				{
	            $nav=$nav."&nbsp;&nbsp;&nbsp;<a href=\"".$_SERVER['PHP_SELF']."?s=".$i."\">Next</a>";
				}
			break;
	        }
	    }
	$table=$table."</table>\n";
	
	//--- display gallery on web page
	$content=$nav."\n".$table;
	$resultstring=$content;	
?>
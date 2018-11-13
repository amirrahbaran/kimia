<?php
/*
  This component has four element. ; 
 */
	$content='';
	$col_value=3;
	$row_value=3;
	$alphabet_en="A B C D E F G H I J K L M N O P Q R S T W V U X Y Z"; //Alphabet letter definition for an special language;
 	$alphabet_fa="ا ب پ ت ث ج چ ح خ د ذ ر ز ژ س ش ص ض ط ظ ع غ ف ق ک گ ل م ن و ه ی";	
	
	//check whether there is the first element; 
	if ($params[0] != '')
		{
		$cat_value=$params[0];
		}
	
	//check whether there is the second element; 
	if ($params[1] != '')
		{
		$col_value=$params[1];
		}

	//check whether there is the third element;
	if ($params[2] != '')
		{
		$row_value=$params[2];
		}

	//check whether there is the forth element;
	if ($params[3] != '')
		{
		$alphabet_value=$alphabet."_".$params[3];
		}

define('COLS',       $col_value);    // Number of columns
define('ROWS',       $row_value);    // Number of rows
define('PREVIOUS',  '[قبلی]');
define('NEXT',      '[بعدی]');

	
	function get_alphabet($alphabet){
		$alphabet_length = strlen($alphabet);		//Contains the length of alphabet string with Space character;
		for ($i==0;$i<$alphabet_length;$i++)
			{
			//echo"<br>";
			$myletters[]=$alphabet{$i++};		//Devide the letters and put them in an array
			}
		return $myletters;
	}
	
	function get_files($category_value) {

		if (file_exists('./data/indexes/articles.xml')==true)
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
//				$editor=$article->editor;
//				$day=$article->day;
//				$month=$article->month;
//				$year=$article->year;
//				$time=$article->time;
		
//				$update_time=' '.$year.'/'.$month.'/'.$day.' '.$time;
				
				//Server Day 
//				$server_time = date("Y/m/d H:i:s");
				
				// Server time & update time Diffrencial
//				$time_dif = strtotime($server_time) - strtotime($update_time);
				if($category == $category_value)
					{
					//creating array of updates
					$articles_array[]="[[".kimia_decode($title)."]]";
					}
				//--- count records
				$xmlcount++;
				}
			}
		if(isset($articles_array)==true)
			{
			sort($articles_array);
			}
	    return $articles_array;
	}

	function create_table($files, $start = 1) 
		{
		//$row=0;
		$filecount=count($files);

	    // Create navigation (previous link)
 	   	$navigation = "<div>\n";

    	if ($start > 1)
	    	{
	        $navigation .= "<a href=\"".$_SERVER[PHP_SELF]."?s=" . ($start - (COLS * ROWS) ) . "\">". PREVIOUS . "</a>\n";
	    	}	
	    // Create table
		$table = "<table border=1>\n";
	    for ($i = $start; $i < $filecount;) 
	    	{
	        // Create row
	        $table .= "<tr>\n";
	        for ($col = 0; $col <COLS; $col++) 
	        	{
	            // Create column
	            if ($i >= $filecount)
	            	{ 
	                $table .= "<td>&nbsp;</td>\n";
	            	}else{
	                	 $table .="<td>".$files[$i]."</td>\n";
	            		 }
	            $i++;
	        	}
	        $table .= "</tr>\n";
					
	        $row++;
	
	        // Check if maximum number of rows is used
	        if ($row == ROWS) 
	        	{	
	            // Create navigation (next link)
            	if ($i < $filecount)
            		{
	                $navigation .= "<a href=\"".$_SERVER[PHP_SELF]."?s=" . $i ."\">" . NEXT . "</a>\n";
            		}					
	            // End of table
	            break;
		        }
			}
    	$table .= "</table>\n";
	    $navigation .= "</div>\n";
	    return $navigation . $table;
		}
			
	function category_table($files, $start = 1) 
		{
		$row=0;
		$filecount=count($files);

	    // Create navigation (previous link)
    	$navigation = "<div>\n";

    	if ($start > 1)
    		{
        	$navigation .= "<a href=\"".$_SERVER[PHP_SELF]."?s=" . ($start - (COLS * ROWS) ) . "\">". PREVIOUS . "</a>\n";
    		}
    	// Create table
		$table = "<table border=1>\n";
	    for ($i = $start; $i < $filecount;) 
	    	{
	        // Create row
	        $table .= "<tr>\n";
	        for ($col = 0; $col <COLS; $col++) 
	        	{
	            // Create column
	            if ($i >= $filecount)
	            	{ 
	                $table .= "<td>&nbsp;</td>\n";
	            	}else{
	                	 $table .="<td>".$files[$i]."</td>\n";
	            		 }
	        	$i++;
		        }
	        $table .= "</tr>\n";

	        $row++;
	
	        // Check if maximum number of rows is used
	        if ($row == ROWS) 
	        	{
	            // Create navigation (next link)
            	if ($i < $filecount)
	            	{
	                $navigation .= "<a href=\"".$_SERVER[PHP_SELF]."?s=" . $i ."\">" . NEXT . "</a>\n";
	            	}
	            // End of table
	            break;
	        	}
	    	}
	    $table .= "</table>\n";
	    $navigation .= "</div>\n";
	    return $navigation . $table;
	}

	//--- The main program
	if($cat_value!="")
		{
		$letter_menu=get_alphabet($alphabet_value);
		
		//--- Generate final content
		
	    $start = empty($_GET['s']) ? 1 : intval($_GET['s']);
		if ($start < 1)
			{
			$start = 1;
			}
		$list_of_files=get_files($cat_value);
		$result=create_table($list_of_files, $start);
		
		$letters_size=sizeof($letter_menu);
		$file_count=sizeof($list_of_files);
		
		$content.="<a href=\"" .$_SERVER['PHP_SELF']. "?letters=\"all\">All</a>\n";	

		$letter_category=0;
		while ($letter_category<$letters_size) 
			{
			$content.="<a href=\"" .$_SERVER['PHP_SELF']. "?letters=".$letter_menu[$letter_category]."\">".$letter_menu[$letter_category]."</a>&nbsp&nbsp&nbsp&nbsp&nbsp\n";
			$letter_category++;
			}
		$content.="\n\r";
		if($_GET['letters']!='')
			{
			foreach ($list_of_files  as $result)
				{
				if(preg_match('/^'.$_GET['letters'].'(.*?)/i',$result))
					{
					$isfound = true;
					$mylist[]=$result;
					}
				}
			$lstTable=category_table($mylist,$start);
			$content.=$lstTable;
		}else{		
             $content.="----";
             $content.="YOU ARE FUNNY BOY!!";
             $content.=$result;
		     }
		$resultstring=$content;
		}
?>
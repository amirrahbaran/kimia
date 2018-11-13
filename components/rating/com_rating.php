<?php
	$content="";
	$tagname="rate_".kimia_encode($title);	
	if($params[0]!="")
		{
		$tagname="rate_".kimia_encode($params[0]);
		}				

	$rate=$_GET[$tagname];
	$filename="./data/temp/".$tagname;
	if (file_exists($filename)) 
		{
		$array_average=file($filename);
		$text_average_info=implode("",$array_average);	
		$array_average_info=explode(":",$text_average_info);
		$sum=$array_average_info[0];
		$num=$array_average_info[1];
		if($rate!=0)
			{
			$num ++;
			}
		if($num!=0)
			{
			$average = ($sum+$rate) / $num ;
			}else{
			$average = $sum + $rate;
			}
		}else{
		$sum=0;
		$num=0;
		}
	$sum+=$rate;
	$average_info=$sum.":".$num;
	$handle=fopen($filename,'w');
	fwrite($handle,$average_info);
	fclose($handle);
	
	$title=urlencode($title);
	//show the result in star format 
	if ($average == 0) 
		{
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";		
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";		
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif ($average == 1) {
		//$image = 'stars-1.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif($average > 1 && $average < 2){
		//$image = 'stars-1.5.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/half.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif ($average == 2) {
		//$image = 'stars-2.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif ($average > 2 && $average < 3) {
		//$image = 'stars-2.5.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/half.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif($average == 3){
		//$image = 'stars-3.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif ($average > 3 && $average < 4) {
		//$image = 'stars-3.5.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/half.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif ($average == 4) {
		//$image = 'stars-4.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/off.gif\">";
		$images.="</a>";
		} elseif($average > 4 && $average < 5){
		//$image = 'stars-4.5.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/half.gif\">";
		$images.="</a>";
		} elseif ($average >= 5) {
		//$image = 'stars-5.gif';
		$images="";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=1\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=2\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=3\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=4\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		$images.="<a href=\"".$_SERVER["PHP_SELF"]."?title=".$title."&amp;".$tagname."=5\">";
		$images.="<img class=\"rating\" alt=\"\" src=\"./components/rating/images/on.gif\">";
		$images.="</a>";
		}

	$content.="<span dir=\"ltr\">".$images."</span>";
	$resultstring=$content;
?>
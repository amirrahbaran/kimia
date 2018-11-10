<?php
	$filename = './data/temp/hitcounter.cmp';
	if (file_exists($filename)) 
		{
		$array_hitcounter=file($filename);
		$hitcounter = $array_hitcounter[0];
		}
	else
		{
		$hitcounter  = 0;
		}
	$hitcounter ++;
	$handle = fopen($filename,'w');
	fwrite($handle, $hitcounter);
	fclose($handle);
	if ($params[0] != '')
		{
		$hitcounter = $hitcounter + $parameterstring;
		}
	
	if ($params[1] == 'graphical')
		{
		$n = $hitcounter;
		$div = 100000;
		while ($n > $div)
			{
			$div *= 10;
			}
		$content .= "<span dir='ltr'>";
		while ($div >= 1)
			{
			$digit = $n / $div % 10;
			$content .= "<img alt=' ' src='./data/uploads/a" . $digit . ".gif' height='22' width='16' />";
			$n -= $digit * $div;
			$div /= 10;
			}
		$content .= "</span>";			
		$resultstring = $content;
		} else {
			$resultstring = $hitcounter;
		}
?>
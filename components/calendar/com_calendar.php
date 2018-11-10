<?php
	$header='';
	$content='';
	$calendar_type = 'gregorian';
	if ($params[0] != '' ){
		$calendar_type = strtolower($params[0]);
	}
	$header.='<style type="text/css">';
	$header.='Body';
	$header.='{';
	$header.='background-color: #EEEEDD;';
	$header.='font-family: tahoma; ';
	$header.='color: #000000;';
	$header.='font-size: 14 px;';
	$header.='margin-top: 0;';
	$header.='margin-left: 0';
	$header.='}';
	$header.='</style>';

	switch ($calendar_type) 
		{
		case 'jalali' :
			include_once "jcalendar.class.php";
			$c = new Calendar;
		
			//----- Get the Server date with Gregorian format----------
			$present_gyear = date("Y");
			$present_gmonth = date("m");
			$present_gday = date("d");
			list ($present_jyear , $present_jmonth , $present_jday ) = $c->gregorian_to_jalali ($present_gyear , $present_gmonth , $present_gday );
			
			$c->SetStyle();
			$header .= $c->result_header;
		
			$c->ShowJalaliMonth($present_jyear , $present_jmonth) ;
			$content = $c->result_html;
			break;
		case 'gregorian' :
			include_once "gcalendar.php";
			/*
			here will be placed the code of Gregorian calendar	
			*/
			$content = ShowGregorianMonth(); 
			break;
		}
	$resultheadstring=$header;
	$resultstring=$content;
?> 
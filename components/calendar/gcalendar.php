<?php
/*
	Develpoer TIPS (www.dev-tips.org)
	Licence:  GNU General Public License
*/

	function SetStyle()
	{
		$this->style = 
				"
				<style>
				table {
				background-color: #EEEEDD;
				border-width: 0;
				font-size: 80%
				}
				
				td.day {
				border:1px solid #c6a646; background-color: #EEEEDD;
				text-align: center;
				direction: rtl 
				}
				
				td.month {
				border:1px solid #c6a646; background-color: #FFCCBB;
				font-size : 11px;
				text-align: center;
				direction: rtl 
				}
				
				td.today {
				border:1px solid #c6a646; background-color: #FFCCFF;
				text-align: center;
				direction: rtl 
				}
				</style>
				";
		$this->result_header = $this->style;
	}


	function ShowGregorianMonth()
		{
		//This gets today's date
		$date =time () ;
		
		//This puts the day, month, and year in seperate variables
		$day = date('d', $date) ;
		$month = date('m', $date) ;
		$year = date('Y', $date) ;
		
		//Here we generate the first day of the month
		$first_day = mktime(0,0,0,$month, 1, $year) ;
		
		//This gets us the month name
		$title = date('F', $first_day) ; 
		
		//Here we find out what day of the week the first day of the month falls on
		$day_of_week = date('D', $first_day) ;
		
		//Once we know what day of the week it falls on, we know how many blank days occure before it. If the first day of the week is a Sunday then it would be zero
		switch($day_of_week)
			{
			case "Sun": $blank = 0; break;
			case "Mon": $blank = 1; break;
			case "Tue": $blank = 2; break;
			case "Wed": $blank = 3; break;
			case "Thu": $blank = 4; break;
			case "Fri": $blank = 5; break;
			case "Sat": $blank = 6; break;
			}
		
		//We then determine how many days are in the current month
		$days_in_month = cal_days_in_month(0, $month, $year) ;
		
		//Here we start building the table heads
		$result .= '<table border=1 >';
		$result .= '<tr>';
		$result .= '<th colspan=7>'.$title . ' ' . $year.'</th>';
		$result .= '</tr>';
		$result .= '<tr>';
		$result .= '<td width=20>S</td>';
		$result .= '<td width=20>M</td>';
		$result .= '<td width=20>T</td>';
		$result .= '<td width=20>W</td>';
		$result .= '<td width=20>T</td>';
		$result .= '<td width=20>F</td>';
		$result .= '<td width=20>S</td>';
		$result .= '</tr>';
		
		//This counts the days in the week, up to 7
		$day_count = 1;
		
		$result .= '<tr>';
		//first we take care of those blank days
		while ( $blank > 0 )
			{
			$result .= '<td></td>';
			$blank = $blank-1;
			$day_count++;
			}
		
		//sets the first day of the month to 1
		$day_num = 1;
		
		//count up the days, untill we've done all of them in the month
		while ( $day_num <= $days_in_month )
			{
			if ($day_num == $day )
				$result .= '<td><b>'.$day_num.'</b></td>';
			else
				$result .= '<td>'.$day_num.'</td>';
			$day_num++;
			$day_count++;
		
			//Make sure we start a new row every week
			if ($day_count > 7)
				{
				$result .= '</tr><tr>';
				$day_count = 1;
				}
			}
		
		//Finaly we finish out the table with some blank details if needed
		while ( $day_count >1 && $day_count <=7 )
			{
			$result .= '<td> </td>';
			$day_count++;
			}
		$result .= '</tr></table>';
		
		return $result ;
		}
?>
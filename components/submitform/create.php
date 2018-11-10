<?php
	function create_form(){
		$create.=$formtitle;
		$create.='<form method="POST" action="'.$_SERVER['PHP_SELF'].'?title='.$title.'">';
		$create.='<font size="2">';
		$create.='<br />';
		$create.='<table border="0" cellpadding="0" cellspacing="0">';
		$create.='<tr>';
		$create.='<td>';
		$create.='Choose username:';
		$create.='</td>';
		$create.='<td>';
		$create.='<input type="text" name="username"><br />';
		$create.='</td>';
		$create.='</tr>';
		$create.='<tr>';
		$create.='<td>';
		$create.='E-mail:';
		$create.='</td>';
		$create.='<td>';
		$create.='<input type="text" name="email"><br />';
		$create.='</td>';
		$create.='</tr>';
		$create.='<tr>';
		$create.='<td>';
		$create.='Choose password:';
		$create.='</td>';
		$create.='<td>';
		$create.='<input type="password" name="password"><br />';
		$create.='</td>';
		$create.='</tr>';
		$create.='<tr>';
		$create.='<td>';
		$create.='Verify password:';
		$create.='</td>';
		$create.='<td>';
		$create.='<input type="password" name="repassword"><br />';
		$create.='</td>';
		$create.='</tr>';
		$create.='</table>';
		$create.='<input type="submit" value="Submit" class="mybutton">';
		$create.='</font></form>';
		return $create;
	}
	
	function repeated($input_usr){
		if (file_exists('./data/users/users.php')){
			//--- loading the xml file
			$usr_info= simplexml_load_file('./data/users/users.php');
			//--- reading all records
			$usrcount=0;
			foreach($usr_info->user as $usr_data){
				//--- load records
				$stored_usr=$usr_data->username;
				if ($stored_usr==$input_usr){
					return true;
					continue; 
				}
				$usrcount++;
			}
		}
	}
?>
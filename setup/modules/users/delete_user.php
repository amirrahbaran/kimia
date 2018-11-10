<?php
function delete_user($username)
	{
	if(user_exists($username)!=true)
		{
		$output='';
		$output.='چنین کاربری وجود ندارد.';
		$output.='<br/><br/>';	
		return $output;
		}
	
	set_user_data($username,'status','deleted');

	$output='';
	$output.='کاربر مورد نظر با موفقیت حذف شد.';
	$output.='<br/><br/>';	
	return $output;
	}

?>
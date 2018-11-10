<?php
function edit_user($username)
	{
	$password='******';
	$name=get_user_data($username,'name');
	$email=get_user_data($username,'email');
	$group=get_user_data($username,'group');
	$status=get_user_data($username,'status');
	
	if($_GET['action']=='save')
		{
		$original=$_POST['original'];
		$username=$_POST['username'];
		$password=$_POST['password'];
		$name=$_POST['name'];
		$email=$_POST['email'];
		$group=$_POST['group'];
		$status=$_POST['status'];
		
		if(user_exists($original)!=true)
			{
			$output='';
			$output.='چنین کاربری وجود ندارد.';
			$output.='<br/><br/>';			
			return $output;
			}		
				
		if($username!=$original)
			{
			$user_status=get_user_data($username,'status');
			if($user_status=='')
				{
				//کاربر می تواند ویرایش شود
				//کد کاربری تغییر می کند
				unset($message);
				$valid=new validform;
				
				if($valid->text_box($username,1,3,3,30)==false) { $message[]='کد کاربری وارد شده مجاز نمی باشد.'; }
				if($password!='******')
					{
					if($valid->text_box($password,1,3,3,30)==false) { $message[]='کلمه عبور وارد شده مجاز نمی باشد.'; }
					}
				if($valid->text_box($name,1,3)==false) { $message[]='نام وارد شده مجاز نمی باشد.'; }
				if($valid->email_check($email,1)==false) { $message[]='آدرس ایمیل وارده شده مجاز نمی باشد.'; }
				if($valid->select_box($group,1,"select...",3,3,30)==false) { $message[]='لطفا یک گروه انتخاب کنید.'; }
				if($valid->select_box($status,1,"select...",3,3,30)==false) { $message[]='لطفا یک وضعیت انتخاب کنید.'; }
											
				if(empty($message)==true)
					{
					$message[]='کاربر مورد نظر با موفقیت ویرایش شد.';
					set_user_data($original,'username',$username);
					if($password!='******') { set_user_data($original,'password',$password); }
					set_user_data($original,'name',$name);
					set_user_data($original,'email',$email);
					set_user_data($original,'group',$group);
					set_user_data($original,'status',$status);
					}				
				}
			} else {
			//کاربر می تواند ویرایش شود
			unset($message);
			$valid=new validform;
			
			if($valid->text_box($username,1,3,3,30)==false) { $message[]='کد کاربری وارد شده مجاز نمی باشد.'; }
			if($password!='******')
				{
				if($valid->text_box($password,1,3,3,30)==false) { $message[]='کلمه عبور وارد شده مجاز نمی باشد.'; }
				}
			if($valid->text_box($name,1,3)==false) { $message[]='نام وارد شده مجاز نمی باشد.'; }
			if($valid->email_check($email,1)==false) { $message[]='آدرس ایمیل وارده شده مجاز نمی باشد.'; }
			if($valid->select_box($group,1,"select...",3,3,30)==false) { $message[]='لطفا یک گروه انتخاب کنید.'; }
			if($valid->select_box($status,1,"select...",3,3,30)==false) { $message[]='لطفا یک وضعیت انتخاب کنید.'; }
										
			if(empty($message)==true)
				{
				$message[]='کاربر مورد نظر با موفقیت ویرایش شد.';
				if($password!='******') { set_user_data($original,'password',$password); }
				set_user_data($original,'name',$name);
				set_user_data($original,'email',$email);
				set_user_data($original,'group',$group);
				set_user_data($original,'status',$status);
				}
			}
		}

	$output='';
	$output.=$message[0];
	$output.='<br/><br/>';
	$output.='<form id="edituser" name="edituser" method="post" action="#">';
	$output.='<input type="hidden" name="original" value="'.$username.'" /><br/>';
	$output.='<table style="border-collapse: collapse; border: none; width: 300px;">';
	$output.='<tr>';	
	$output.='<td style="vertical-align: top;">';	
	$output.='کد کاربری<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="text" name="username" value="'.$username.'" /><br/>';
	$output.='</span>';
	$output.='کلمه عبور<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="password" name="password" value="'.$password.'" /><br/>';
	$output.='</span>';
	$output.='نام<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="text" name="name" value="'.$name.'" /><br/>';
	$output.='</span>';
	$output.='ایمیل<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="text" name="email" value="'.$email.'" /><br/>';
	$output.='</span>';
	$output.='</td>';	
	$output.='<td style="vertical-align: top;">';	
	$output.='گروه<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="text" name="group">';
	$output.='<option selected="selected" value="'.$group.'">'.$group.'</option>';
	$output.='<option value="grp1">grp1</option>';
	$output.='<option value="grp2">grp2</option>';
	$output.='<option value="grp3">grp3</option>';
	$output.='<option value="grp4">grp4</option>';
	$output.='</select>';
	$output.='</span>';
	$output.='<br/>';
	$output.='وضعیت<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="text" name="status">';
	$output.='<option selected="selected" value="'.$status.'">'.$status.'</option>';
	$output.='<option value="active">active</option>';
	$output.='<option value="suspend">suspend</option>';
	$output.='</select>';
	$output.='</span>';
	$output.='<br/>';
	$output.='</td>';	
	$output.='</tr>';	
	$output.='</table>';	
	$output.='</form>';
	
	return $output;
	}

?>
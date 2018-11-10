<?php
function add_user()
	{
	if($_GET['action']=='save')
		{	
		$user_status=get_user_data($_POST['username'],'status');
		if($user_status=='' || $user_status=='deleted')
			{
			$username=$_POST['username'];
			$password=$_POST['password'];
			$name=$_POST['name'];
			$email=$_POST['email'];
			$group=$_POST['group'];
			$status=$_POST['status'];
				
			unset($message);
			$valid=new validform;
			
			if($valid->text_box($username,1,3,3,30)==false) { $message[]='کد کاربری وارد شده مجاز نمی باشد.'; }
			if($valid->text_box($password,1,3,3,30)==false) { $message[]='کلمه عبور وارد شده مجاز نمی باشد.'; }
			if($valid->text_box($name,1,3)==false) { $message[]='نام وارد شده مجاز نمی باشد.'; }
			if($valid->email_check($email,1)==false) { $message[]='آدرس ایمیل وارده شده مجاز نمی باشد.'; }
			if($valid->select_box($group,1,"select...",3,3,30)==false) { $message[]='لطفا یک گروه انتخاب کنید.'; }
			if($valid->select_box($status,1,"select...",3,3,30)==false) { $message[]='لطفا یک وضعیت انتخاب کنید.'; }
										
			if(empty($message)==true)
				{
				$message[]='کاربر مورد نظر با موفقیت ایجاد شد.';
				if($user_status=='deleted')
					{
					set_user_data($username,'password',$password);
					set_user_data($username,'name',$name);
					set_user_data($username,'email',$email);
					set_user_data($username,'group',$group);
					set_user_data($username,'status',$status);						
					} else {
					add_user_data($username,$password,$name,$email,$group,$status);	
					}
				unset($username);
				unset($password);
				unset($name);
				unset($email);
				}
			} else {
			$message[]='کد کاربری وارد شده تکراری است.';		
			}
		}

	$output='';
	$output.=$message[0];
	$output.='<br/><br/>';
	$output.='<form id="adduser" name="adduser" method="post" action="#">';
	$output.='<table class="moduleform" style="border-collapse: collapse; border: none; width: 300px;">';
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
	$output.='<option selected="selected" value="0">select...</option>';
	$output.='<option value="user">کاربر</option>';
	$output.='<option value="editor">ویراستار</option>';
	$output.='<option value="admin">مدیریت</option>';
	$output.='</select>';
	$output.='</span>';
	$output.='<br/>';
	$output.='وضعیت<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="text" name="status">';
	$output.='<option selected="selected" value="0">select...</option>';
	$output.='<option value="active">فعال</option>';
	$output.='<option value="suspend">غیر فعال</option>';
	$output.='</select>';
	$output.='</span>';
	$output.='<br/>';
	$output.='</td>';	
	$output.='</tr>';	
	$output.='</table>';	
	$output.='</form>';
	$output.='<form id="usersform" name="usersform" method="post" action="#">';
	$output.='</form>';
	
	return $output;
	}

?>
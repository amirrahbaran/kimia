<?php
function add_group()
	{
	if($_GET['action']=='save')
		{	
		$group_status=get_group_data($_POST['groupname'],'status');
		if($group_status=='' || $group_status=='deleted')
			{
			$groupname=$_POST['groupname'];
			$comment=$_POST['comment'];
			$cat_display=$_POST['cat_display'];
			$cat_edit=$_POST['cat_edit'];
			$cat_create=$_POST['cat_create'];
			$com_display=$_POST['com_display'];
			$com_create=$_POST['com_create'];
			$mod_display=$_POST['mod_display'];
			$status=$_POST['status'];
	
			unset($message);
			$valid=new validform;
			
			if($valid->text_box($groupname,1,3,3,30)==false) { $message[]='نام گروه وارد شده مجاز نمی باشد.'; }
			if($valid->text_box($comment,1,3,3,150)==false) { $message[]='توضیحات وارد شده مجاز نمی باشد.'; }

			if(empty($message)==true)
				{
				$message[]='گروه مورد نظر با موفقیت ایجاد شد.';
				if($group_status=='deleted')
					{
					set_group_data($groupname,'comment',$comment);
					set_group_data($groupname,'cat:display',$cat_display);
					set_group_data($groupname,'cat:edit',$cat_edit);
					set_group_data($groupname,'cat:create',$cat_create);
					set_group_data($groupname,'com:display',$com_display);
					set_group_data($groupname,'com:create',$com_create);
					set_group_data($groupname,'mod:display',$mod_display);
					set_group_data($groupname,'status',$status);						
					} else {
					add_group_data($groupname,$comment,$cat_display,$cat_edit,$cat_create,$com_display,$com_create,$mod_display,$status);
					}
				unset($groupname);
				unset($comment);
				unset($cat_display);
				unset($cat_edit);
				unset($cat_create);
				unset($com_display);
				unset($com_create);
				unset($mod_display);
				}
			} else {
			$message[]='نام گروه وارد شده تکراری است.';		
			}
		}

	$output='';
	$output.=$message[0];
	$output.='<br/><br/>';
	$output.='<form id="addgroup" name="addgroup" method="post" action="#">';
	$output.='<table class="moduleform" style="border-collapse: collapse; border: none; width: 300px;">';
	$output.='<tr>';	
	$output.='<td style="vertical-align: top;">';	
	$output.='نام گروه<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="text" name="groupname" value="'.$groupname.'" /><br/>';
	$output.='</span>';
	$output.='</td>';
	$output.='<td style="vertical-align: top;">';	
	$output.='وضعیت<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="text" name="status">';
	$output.='<option selected="selected" value="0">select...</option>';
	$output.='<option value="active">active</option>';
	$output.='<option value="suspend">suspend</option>';
	$output.='</select>';
	$output.='</span>';
	$output.='</td>';
	$output.='</tr>';	
	$output.='</table>';	
	$output.='توضیحات...<br/>';
	$output.='<span dir="ltr">';
	$output.='<input class="text" type="text" style="width:271px;" name="password" value="'.$comment.'" /><br/>';
	$output.='</span>';
	$output.='<table class="moduleform" style="border-collapse: collapse; border: none; width: 450px;">';
	$output.='<tr>';
	$output.='<td style="vertical-align: top;">';
	$output.='<br/>';
	//--- categories
	$output.='موضوعات...<br/><br/>';
	$output.='</td>';	
	$output.='</tr>';	
	$output.='<tr>';
	$output.='<td style="vertical-align: top;">';
	$output.='نمایش<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="cat_display[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="cat_all_display" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='<td style="vertical-align: top;">';
	$output.='ویرایش<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="cat_edit[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="cat_all_edit" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='<td style="vertical-align: top;">';
	$output.='ایجاد<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="cat_create[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="cat_all_create" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='</tr>';	
	$output.='<tr>';	
	$output.='<td style="vertical-align: top;">';
	$output.='<br/>';
	//--- components
	$output.='سرویس ها...<br/><br/>';
	$output.='</td>';	
	$output.='</tr>';	
	$output.='<tr>';
	$output.='<td style="vertical-align: top;">';
	$output.='نمایش<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="com_display[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="com_all_display" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='<td style="vertical-align: top;">';
	$output.='ایجاد<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="com_create[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="com_all_create" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='<td>';
	$output.='</td>';
	$output.='</tr>';	
	$output.='<tr>';
	$output.='<td style="vertical-align: top;">';
	$output.='<br/>';
	//--- setup modules
	$output.='ابزارهای مدیریتی...<br/><br/>';
	$output.='</td>';	
	$output.='</tr>';	
	$output.='<tr>';
	$output.='<td style="vertical-align: top;">';
	$output.='نمایش<br/>';
	$output.='<span dir="ltr">';
	$output.='<select class="list" name="mod_display[]" multiple="multiple">';
	$output.='<option>item 1</option>';
	$output.='<option>item 2</option>';
	$output.='<option>item 3</option>';
	$output.='<option>item 4</option>';
	$output.='<option>item 5</option>';	
	$output.='</select><br/>';
	$output.='<input class="check" type="checkbox" name="mod_all_display" />';
	$output.='</span>';
	$output.='&nbsp;&nbsp;همه موارد';
	$output.='</td>';
	$output.='</tr>';	
	$output.='</table>';		
	$output.='</form>';
	$output.='<form id="groupsform" name="groupsform" method="post" action="#">';
	$output.='</form>';	
	
	return $output;
	}
?>
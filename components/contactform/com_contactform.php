<?php
	$content='';
	if($params[0]!='')
		{
		$sendto=$params[0];
		$subject='Contact...';
		if($params[1]!='')
			{
			$subject=$params[1];
			}
		$thankyou='Thank you for your e-mail.';
		if($params[2]!='')
			{
			$thankyou=$params[2];
			}
		
		if(!$_POST['name'] || !$_POST['email'] || !$_POST['message'])
			{
			$content.='<form method="POST" action="'.$_SERVER['PHP_SELF'].'?title='.$title.'">';
			$content.='<font size="2">';
			$content.='<br />';
			$content.='Name :<br />';
			$content.='<input type="text" name="name"><br />';
			$content.='E-mail :<br />';
			$content.='<input type="text" name="email"><br />';
			$content.='Message :<br>';
			$content.='<textarea name="message" style="width: 300px; height: 200px;"></textarea><br />';
			$content.='<input type="submit" value="Send" class="mybutton">';
			$content.='</font></form>';
			} else	{
				$headers  = 'MIME-Version: 1.0\r\n';
				$headers .= 'Content-type: text/html; charset=utf-8\r\n';
				$headers .= 'To: '.$sendto.'\r\n';
				$headers .= 'From: '.$_POST['name'].' <'.$_POST['email'].'>\r\n';
				$headers .= 'Reply-To: '.$_POST['email'].'\r\n';
				$message= '';
				$message.= 'Name : ' . $_POST['name']. '\r\n';
				$message.= 'Email : ' . $_POST['email']. '\r\n\r\n';
				$message.= $_POST['message'];
				@mail($sendto,$subject,$message,$headers);
				$content.=$thankyou;
				}
		}
	$resultstring=$content;
?> 

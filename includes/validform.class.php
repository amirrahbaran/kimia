<?
defined('_KIMIA') or die('<big><big><big>ACCESS DENIED !');

class validform
	{
	var $value;
	var $value2;
	var $type;
	var $min;
	var $max;
	var $required;
	var $notvalid;
	
	function text_box($value, $required=1, $type=null, $min=0, $max=null)
	{
		if ($required)
		{
			if (!($value))
			{
				return false;
			}
		}
		
		if ($max==null)
		{
			if (strlen($value)<$min)
			{
				return false;
			}
		}
		elseif (strlen($value)<$min)
		{
			return false;
		}
		elseif (strlen($value)>$max)
		{
			return false;
		}

		if ($type!==null)
			return $this->type_check($value,$type);

		return true;
	}

function select_box($value,$required=1,$notvalid=null,$type=null,$min=null, $max=null)
	{
		if ($value==$notvalid)
		{
			return false;
		}

		if ($required)
		{
		return $this->text_box($value,1,$type,$min,$max);
		}

		return true;
	}

	function password_check($value,$value2,$type=null,$min,$max)
	{
		if ($value!==$value2)
		{
			return false;
		}
		else
		{
			return $this->text_box($value,1,$type,$min,$max);
		}
		return true;
	}


	function date_check($value,$required=1)
	{
		if ($required)
		{
			if (!$value)
			{
				return $this->text_box($value,1,null,0,1000);
			}
			else
			{
				return $this->catch_date($value);
			}
		}
		else
		{
			if (!$value)
			{
				return true;
			}
			else
			{
				return $this->catch_date($value);
			}
		}
	}
		
	function check_box($value)
	{
		if (!$value[0])
		{
			return false;
		}
		else
			return true;
	}

	function email_check($value, $required)
    {
		if ($required)
		{
			if (!$value)
			{
				return $this->text_box($value);
			}
			else
			{
				return $this->catch_email($value);
			}
		}
		else
		{
			if (!$value)
			{
				return true;
			}
			else
			{
				return $this->catch_email($value);
			}
		}
	}

	function catch_email($value)
	{
		if(!eregi("^([a-z0-9\\_\\.\\-]+)@([a-z0-9\\_\\.\\-]+)\\.([a-z]{2,4})$",$value)) 
		{
			return false;
		}
		return true;
	}
	
	function catch_date($value)
	{
		list($Day, $Month, $Year) = explode("/",$value);
		if (strlen($Year)==4)
		{
			if (!checkdate($Month,$Day,$Year))
			{
				return false;
			}
		}
		else
		{
			
			return false;
		}
		return true;
	}

	function type_check($value,$type)
	{
		switch ($type) 
		{
			case 1:
			   return $this->catch_letters($value);
			   break;
			case 2:
			   return $this->catch_numbers($value);
			   break;
			case 3:
			   return $this->catch_letters_and_numbers($value);
			   break;
		}
	}
	
	function catch_letters($value)
	{
		if (!preg_match('/^[a-zA-Z����������������������[:space:]]+$/', $value))
		{
			return false;
		}
		return true;
	}
	
	function catch_numbers($value)
	{
		if (!is_numeric($value))
		{
			return false;
		}
		return true;
	}

	function catch_letters_and_numbers($value)
	{
		if (!preg_match('/^[a-zA-Z0-9����������������������[:space:]]+$/', $value))
		{
			return false;
		}
		return true;
	}
}
?>

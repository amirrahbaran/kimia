<?php
function select_template($template)
	{
	global $config;
	$output="";

	set_config_data("template",$template);
	$config["template"]=$template;

	$output='';
	$output.='قالب مورد نظر به عنوان قالب جاری قرار گرفت.';
	$output.='<br/><br/>';
	return $output;
	}

?>
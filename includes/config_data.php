<?php
/*
 	# Kimia WIKI/CMS : a wiki/cms with no database and ajax technology
	
	Authors: Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  2.0.0  (your constructive criticism is appreciated, please see our
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */
defined('_KIMIA') or die('<big><big><big>ACCESS DENIED !');

function get_config_data($item)
	{
	$result="";
	if(file_exists('./data/config.php')==true)
		{
		$config_file=file_get_contents('./data/config.php');
		$config_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$config_file);		
		$config_index=simplexml_load_string($config_xml);
		
		if($item=='homepage') { $result=$config_index->homepage; }
		if($item=='language') { $result=$config_index->language; }
		if($item=='template') { $result=$config_index->template; }		
		}
	return $result;		
	}

function set_config_data($item,$data)
	{
	$result=false;	
	if(file_exists('./data/config.php')==true)
		{
		$config_file=file_get_contents('./data/config.php');
		$config_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$config_file);		
		$config_index=simplexml_load_string($config_xml);
		
		if($item=='homepage') { $config_index->homepage=$data; }
		if($item=='language') { $config_index->language=$data; }
		if($item=='template') { $config_index->template=$data; }
		$config_file=$config_index->asXML();
		$config_file=preg_replace('/<\?xml version="1\.0"\?>/','<?php die("<big><big><big>ACCESS DENIED !"); ?>',$config_file);
		file_put_contents('./data/config.php',$config_file);
		$result=true;		
		}
	return $result;
	}

function add_config_data($homepage,$language,$template)
	{
	$result=false;
	if(file_exists('./data/config.php')==false)
		{
		$config_file='';
		$config_file.='<?php die("<big><big><big>ACCESS DENIED !"); ?>'.chr(10);
		$config_file.='<configuration>'.chr(10);
		$config_file.=chr(9).'<homepage>'.$homepahe.'</homepage>';
		$config_file.=chr(9).'<language>'.$language.'</language>';
		$config_file.=chr(9).'<template>'.$template.'</template>';
		$config_file.='</configuration>'.chr(10);		
		file_put_contents('./data/config.php',$config_file);
		$result=true;
		} else {
		$config_file='';
		$config_file.='<?php die("<big><big><big>ACCESS DENIED !"); ?>'.chr(10);
		$config_file.='<configuration>'.chr(10);
		$config_file.=chr(9).'<homepage>'.$homepahe.'</homepage>';
		$config_file.=chr(9).'<language>'.$language.'</language>';
		$config_file.=chr(9).'<template>'.$template.'</template>';
		$config_file.='</configuration>'.chr(10);			
		file_put_contents('./data/config.php',$config_file);
		$result=true;
		}
	return $result;
	}
?>
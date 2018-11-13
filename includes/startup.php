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

//--- load config handling functions
if(checkandload('./includes/config_data.php')==ture)
	{
	$startupflags.="configdata;";
	}


//--- load config file
if(file_exists('./data/config.php')==true)
	{
	$startupflags.='config;';
	//--- load configuration data
	$config["homepage"]=get_config_data("homepage");
	$config["language"]=get_config_data("language");
	$config["template"]=get_config_data("template");	
	//--- load selected template
	$template=$config["template"];
	//--- load selected language file
	if(checkandload('./languages/'.$config["language"].'.php')==true)
		{
		$startupflags.='language;';
		}
	} else {
	//--- load the default language file
	if(checkandload('./languages/default.php')==true)
		{
		$startupflags.='language;';
		}
	}
	
//--- load base 32 coding class

if(checkandload('./includes/base32.class.php')==ture)
	{
	$startupflags.="base32;";
	}
	
//--- load xml indexing system
if(checkandload('./includes/xmlindex.php')==ture)
	{
	$startupflags.="xmlindex;";
	}
	
//--- load wiki parser class
if(checkandload('./includes/wikiparser.class.php')==ture)
	{
	$startupflags.="wikiparser;";
	}
	
//--- load wiki main functions

if(checkandload('./includes/wikimain.php')==ture)
	{
	$startupflags.="wikimain;";
	}

//--- load user handling functions
if(checkandload('./includes/users_data.php')==ture)
	{
	$startupflags.="usersdata;";
	}
	
//--- load kavir cms main functions
if(checkandload('./includes/kavir.php')==ture)
	{
	$startupflags.="kavir;";
	}
	
//--- load print engine
if(checkandload('./includes/print.php')==ture)
	{
	if((file_exists('./templates/print/index.htm')==true) && (file_exists('./templates/print/print.css')==true))
		{
		$startupflags.="print;";
		}
	}
	
//--- load installer program
if(checkandload('./includes/install.php')==ture)
	{
	$startupflags.="install;";
	}
?>
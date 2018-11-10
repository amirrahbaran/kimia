<?php
/********************************
* File
*********************************
* A simple file reader/writer
*********************************
* Patrick Brosset
* patrickbrosset@gmail.com
*********************************
* 05/2005
*********************************/

class File
{


	// source: the filename (or URL if fopen wrappers have been enabled)
	var $source = "";
	
	// lines: the content of the retrieved file stored in an array
	var $lines = array();
	
	// content: the retrieved content of the file in a string
	var $content = "";

	// error: string containing an error message if any
	var $error = "";
	

	/**
	 * Constructor
	 */
	function File()
	{
	}


	/**
	 * open
	 *
	 * Loads the content of the source file
	 */
	function open($src)
	{
		$this->source = $src;
		
		if(empty($this->source))
		{
			$this->error = "Source file not specified";
			return;
		}
		
		if($lines = @file($this->source))
		{
			$this->content = implode("",$lines);
			$this->lines = $lines;
		}
		else
		{
			//failure
			$this->error = "Could not read file";
			return;
		}
	}


	/**
	 * read
	 *
	 * Loads & returns file content
	 */
	function read($src = false, $type = "str")
	{
		if($src)
		{
			$this->open($src);
		}
		if($type == "str")	return $this->content;
		elseif($type == "array")	return $this->lines;
	}
	
	
	/**
	 * write
	 *
	 * Writes a given content into the source file
	 */
	function write($content, $src = false)
	{
		if($src)
		{
			$this->source = $src;
		}
		
		if(empty($this->source))
		{
			$this->error = "Source file not specified";
			return;
		}
		
		if(is_array($content))
		{
			// the user provided lines, let's merge them
			$content = implode("",$content);
		}
		
		// The function can be called to write a NEW file, let's create it if needed
		if(!is_file($this->source))
		{
			touch($this->source);
		}
		
		if($handle = fopen($this->source,"w"))
		{
			fwrite($handle,$content);
			fclose($handle);
			$this->open($this->source);
		}
		else
		{
			//failure
			$this->error = "Could not write to file";
			return;
		}
	}


	function setSource($src)
	{
		$this->source = $source;
	}
	
	function getLines()
	{
		return $this->lines;
	}

	function getContent()
	{
		return $this->content;
	}

	function getError()
	{
		return $this->error;
	}

	function printError()
	{
		echo $this->error;
	}
		
}

?>              
<?php
/*					

	KAVIR WIKI/CMS : a wiki/cms with no database and ajax technology
	
	Authors: 
			Erfan Arabfakhri, Esfahan, Iran, <buttercupgreen@gmail.com>
			Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  2.0.0  (your constructive criticism is appreciated, please see our
    project page on http://sourceforge.net/projects/---
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */

defined('_ERFANWIKI') or die('<big><big><big>ACCESS DENIED !');

class toolbar
	{
	var $output='';
	var $mode='toolbar';
	var $cssclass='toolbar';
	
	function begin($align)
		{
		$this->output.='<table align="'.$align.'" class="'.$this->cssclass.'" >';
		$this->output.='<tr>';
		}
	
	function addbutton($title,$link,$icon='',$onclick='',$onmouseover='')
		{
		if($this->mode=='toolbar')
			{
			$this->output.='<td class="'.$this->cssclass.'">';
			$this->output.='<a class="'.$this->cssclass.'" href="'.$link.'" onClick="'.$onclick.'" onMouseover="'.$onmouseover.'" >';
			$this->output.='<img class="'.$this->cssclass.'" src="'.$icon.'" alt=" " /><br/>';
			$this->output.=$title.'</a>';
			$this->output.='</td>';										
			}
		if($this->mode=='navigation')
			{
			$this->output.='<td class="'.$this->cssclass.'">';
			$this->output.='<a class="'.$this->cssclass.'" href="'.$link.'" onClick="'.$onclick.'" onMouseover="'.$onmouseover.'" >';
			$this->output.=$title.'</a>';
			$this->output.='</td>';										
			}													
		}
		
	function addseparator($icon='',$width='')
		{
		if($width=='')
			{
			$this->output.='<td class="'.$this->cssclass.'">';
			} else {
			$this->output.='<td width="'.$width.'" class="'.$this->cssclass.'">';				
			}
		$this->output.='<img class="'.$this->cssclass.'" src="'.$icon.'" alt=" " /><br/>';		
		$this->output.='</td>';
		}		
		
	function end()
		{
		$this->output.='</tr>';
		$this->output.='</table>';		
		}
		
	}

?>
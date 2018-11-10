<?php
/*
 	ERFAN WIKI : a wiki with no database based on PrintWiki
 
    Authors: 
			Erfan Arabfakhri, Esfahan, Iran, <buttercupgreen@gmail.com>
			Amir Reza Rahbaran, Esfahan, Iran <amirrezarahbaran@gmail.com>
 
    Version:  0.1  (your constructive criticism is appreciated, please see our
    project page on http://sourceforge.net/projects/erfanwiki/
 
   Licence:  GNU General Public License

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
 */
defined('_ERFANWIKI') or die('<big><big><big>ACCESS DENIED !');

function get_group_data($groupname,$item)
	{
	if(file_exists('./data/system/groups.php')==true)
		{
		$groups_file=file_get_contents('./data/system/groups.php');
		$groups_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$groups_file);
		
		$result='';
		$groups_index=simplexml_load_string($groups_xml);
		foreach($groups_index->group as $group)
			{
			if($groupname==$group->groupname)
				{
				if($item=='groupname') { $result=$group->groupname; }
				if($item=='comment') { $result=$group->comment; }
				if($item=='cat:display') { $result=$group->categories->dislay; }
				if($item=='cat:edit') { $result=$group->categories->edit; }
				if($item=='cat:create') { $result=$group->categories->create; }
				if($item=='com:display') { $result=$group->components->dislay; }
				if($item=='com:create') { $result=$group->components->create; }
				if($item=='mod:display') { $result=$group->modules->display; }
				if($item=='status') { $result=$group->status; }
				break;
				}
			}
		return $result;
		}				
	}

function set_group_data($groupname,$item,$data)
	{
	if(file_exists('./data/system/groups.php')==true)
		{
		$groups_file=file_get_contents('./data/system/groups.php');
		$groups_xml=preg_replace('/<\?php die\("<big><big><big>ACCESS DENIED !"\); \?>\x0a/','<?xml version="1.0"?>',$groups_file);
		
		$group_count=0;
		$result=false;
		$groups_index=simplexml_load_string($groups_xml);
		foreach($groups_index->group as $group)
			{
			if($groupname==$group->groupname)
				{
				if($item=='groupname') { $groups_index->group[$group_count]->groupname=$data; }
				if($item=='comment') { $groups_index->group[$group_count]->comment=$data; }
				if($item=='cat:display') { $groups_index->group[$group_count]->categories->display=$data; }
				if($item=='cat:edit') { $groups_index->group[$group_count]->categories->edit=$data; }
				if($item=='cat:create') { $groups_index->group[$group_count]->categories->create=$data; }
				if($item=='com:display') { $groups_index->group[$group_count]->components->display=$data; }
				if($item=='com:create') { $groups_index->group[$group_count]->components->create=$data; }
				if($item=='mod:display') { $groups_index->group[$group_count]->modules->display=$data; }
				if($item=='status') { $groups_index->group[$group_count]->status=$data; }
				$groups_file=$groups_index->asXML();
				$groups_file=preg_replace('/<\?xml version="1\.0"\?>/','<?php die("<big><big><big>ACCESS DENIED !"); ?>',$groups_file);
				file_put_contents('./data/system/groups.php',$groups_file);
				$result=true;
				break;
				}
			$group_count++;
			}
		return $result;
		}
	}

function add_group_data($groupname,$comment,$cat_display,$cat_edit,$cat_create,$com_display,$com_create,$mod_display,$status)
	{
	$result=false;
	if(file_exists('./data/system/groups.php')==false)
		{
		$groups_file='';
		$groups_file.='<?php die("<big><big><big>ACCESS DENIED !"); ?>'.chr(10);
		$groups_file.='<groups>'.chr(10);
		$groups_file.=chr(9).'<group>'.chr(10);
		$groups_file.=chr(9).chr(9).'<groupname>'.$groupname.'</groupname>'.chr(10);
		$groups_file.=chr(9).chr(9).'<comment>'.$comment.'</comment>'.chr(10);
		$groups_file.=chr(9).chr(9).'<categories>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$cat_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<edit>'.$cat_edit.'</edit>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<create>'.$cat_create.'</create>'.chr(10);
		$groups_file.=chr(9).chr(9).'</categories>'.chr(10);
		$groups_file.=chr(9).chr(9).'<components>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$com_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<create>'.$com_create.'</create>'.chr(10);
		$groups_file.=chr(9).chr(9).'</components>'.chr(10);
		$groups_file.=chr(9).chr(9).'<modules>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$mod_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).'</modules>'.chr(10);
		$groups_file.=chr(9).chr(9).'<status>'.$status.'</status>'.chr(10);
		$groups_file.=chr(9).'</group>'.chr(10);
		$groups_file.='</groups>'.chr(10);
		
		file_put_contents('./data/system/groups.php',$groups_file);
		$result=true;
		} else {
		$groups_file=file_get_contents('./data/system/groups.php');
		$groups_file=preg_replace('/\x0a<\/groups>/','',$groups_file);
		$groups_file.=chr(9).'<group>'.chr(10);		
		$groups_file.=chr(9).chr(9).'<groupname>'.$groupname.'</groupname>'.chr(10);
		$groups_file.=chr(9).chr(9).'<comment>'.$comment.'</comment>'.chr(10);
		$groups_file.=chr(9).chr(9).'<categories>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$cat_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<edit>'.$cat_edit.'</edit>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<create>'.$cat_create.'</create>'.chr(10);
		$groups_file.=chr(9).chr(9).'</categories>'.chr(10);
		$groups_file.=chr(9).chr(9).'<components>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$com_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<create>'.$com_create.'</create>'.chr(10);
		$groups_file.=chr(9).chr(9).'</components>'.chr(10);
		$groups_file.=chr(9).chr(9).'<modules>'.chr(10);
		$groups_file.=chr(9).chr(9).chr(9).'<display>'.$mod_display.'</display>'.chr(10);
		$groups_file.=chr(9).chr(9).'</modules>'.chr(10);
		$groups_file.=chr(9).chr(9).'<status>'.$status.'</status>'.chr(10);
		$groups_file.=chr(9).'</group>'.chr(10);
		$groups_file.='</groups>'.chr(10);

		file_put_contents('./data/system/groups.php',$groups_file);
		$result=true;
		}
	return $result;
	}
?>
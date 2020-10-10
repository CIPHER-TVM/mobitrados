<?php
 function admin_url($url='')
{
    return base_url(ADMIN.'/'.$url);
}


function ismodule_present($module ='',$subfolder_index=0)
{
	if(($module)&&($subfolder_index)){
		$module_location = array_keys(config_item('modules_locations'))[$subfolder_index];
		// $d = dir($module_location);
		$modules = array();
		foreach(glob($module_location . '*' , GLOB_ONLYDIR) as $dir) {
			$dir = str_replace($module_location, '', $dir);
			$modules[]= $dir;
		}
		// $modules = glob($module_location . '*' , GLOB_ONLYDIR);
		if( in_array($module,$modules) ){
			return true;
		}
	}
	return false;
}
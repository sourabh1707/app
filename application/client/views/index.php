<?php
		
	// if (isset($_SERVER['HTTPS_HOST'])) {
	// 	$base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on' ? 'https'	: 'http'; 
	// 	$base_url .= '://'. $_SERVER['HTTPS'];
	// 	$base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']),'',$_SERVER['SCRIPT_NAME']);

	// 	include 'header.php';
	//     include 'sidebar.php';
	//     //include APPPATH.'/modules/'.$module_name.'/views/'.$page_name.'.php';
	//     include $module_name.'/'.$page_name.'.php';
	//     include 'footer.php';
	
	// }else{
		include 'header.php';
	    include 'sidebar.php';
	    //include APPPATH.'/modules/'.$module_name.'/views/'.$page_name.'.php';
	    include $module_name.'/'.$page_name.'.php';
	    include 'footer.php';

	    
		// $base_url = 
		// include 'header.php';
	 //    include 'sidebar.php';
	 //    //include APPPATH.'/modules/'.$module_name.'/views/'.$page_name.'.php';
	 //    include $module_name.'/'.$page_name.'.php';
	 //    include 'footer.php';
	// }	
	// define('BASE_URL',$base_url);
	// include 'header.php';
    //include 'sidebar.php';
 	////include APPPATH.'/modules/'.$module_name.'/views/'.$page_name.'.php';
 	//include $module_name.'/'.$page_name.'.php';
 	//include 'footer.php';
?>
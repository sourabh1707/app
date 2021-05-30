<?php
    include 'header.php';
    include 'sidebar.php';
    //include APPPATH.'/modules/'.$module_name.'/views/'.$page_name.'.php';
    include $module_name.'/'.$page_name.'.php';
    include 'footer.php';
?>
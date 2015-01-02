<?php 
if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){
	
	$next_file =  MenuAndIncludeByGet($_GET,getMenuLevel(WEB_DIR,__DIR__),dirname(__FILE__));
	if(isset($next_file) && !empty($next_file)) include($next_file."/".$next_file."_view.php");
	
}else $_SESSION['danger'][] = 'Not allowed';

?>
<?php 
if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){
	
	MenuAndIncludeOrCreateViewFileByGet($_GET,getMenuLevel(WEB_DIR,__DIR__),dirname(__FILE__));
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
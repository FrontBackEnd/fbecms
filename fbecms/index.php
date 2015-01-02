<?php 
session_start();

// DATABASE CONNECTION
include("config/database_connect.php"); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>FBEcms</title>
	
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<link rel="icon"   type="image/png"   href="../img/fav_fbecms.png" />
	
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular.min.js"></script>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

</head>
<body>
	<div class="container">
	<?php
	
		// LOGIN
		include("login.php");

		
		//PRINT
		if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
			$next_file =  MenuAndIncludeByGet($_GET,getMenuLevel(WEB_DIR,__DIR__),dirname(__FILE__));
			if(isset($next_file) && !empty($next_file)) include($next_file."/".$next_file."_view.php");
		}

	?>
	</div>	
</body>



<?php 
if(isset($_SESSION['danger']) && $_SESSION['danger']) echo alertMessage(implode(' - ',$_SESSION['danger']),'danger'); unset($_SESSION['danger']);
if(isset($_SESSION['info']) && $_SESSION['info']) echo alertMessage(implode(' - ',$_SESSION['info']),'info'); unset($_SESSION['info']);
if(isset($_SESSION['success']) && $_SESSION['success']) echo alertMessage(implode(' - ',$_SESSION['success']),'info'); unset($_SESSION['success']);

?>


<?php
include("fbecms/config/database_connect.php");


if(isset($part1) && !empty($part1)) $page_data = getPageData($part1);
else $page_data = getPageData($homepage);

echo'<title>FBEcms '.$page_data['page_title'].'</title>
	
	 <meta charset="utf-8">
	 
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 
	 <meta name="description" content="'.$page_data['page_description'].'">
	 <meta name="keywords" content="'.$page_data['page_keywords'].'">
	 
 	 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	 <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5442754e4dd37391" async></script>
	 
	 <link rel="icon"   type="image/png" href="'.WEB_PAGE.'img/fav_fbecms.png" />
	 ';
	 if(isset($page_data['css_name']) && !empty($page_data['css_name'])) 
	 echo '<link rel="stylesheet" href="'.WEB_PAGE.'css/themes/'.$page_data['css_name'].'">';
	 
	 
	 echo ' 
	 <link rel="stylesheet" type="text/css" href="'.WEB_PAGE.'js/slick/slick.css"/>
	 <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	 <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	 <script type="text/javascript" src="'.WEB_PAGE.'js/slick/slick.min.js"></script>
	 ';
	
?>
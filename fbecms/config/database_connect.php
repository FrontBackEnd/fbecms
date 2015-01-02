<?php
$error = $message = $article_id = $categ = '';

$conn = mysqli_connect('localhost', 'frontbac_cms_usr', '?;$$7firgT2N', 'frontbac_cms');

if ($conn) { 
	mysqli_query($conn, "SET names 'utf8'");
	if($error) echo '<p class="error">' . $error . '</p>';
	if($message) echo '<p class="message">' . $message . '</p>';
	
}else{ 
	echo "Connect error: " . mysqli_connect_error();
	die();
}

$page_url = $_SERVER['REQUEST_URI'];

if($_SERVER['HTTP_HOST'] == 'localhost'){
	$page_url = str_replace('/FBEcms','',$page_url); // change your first part if you are working in localhost
	define('LOCAL_HOST_TRUE','1');
}


$url_parts = explode('/',$page_url);
foreach($url_parts AS $key => $url_part) ${'part'.$key} = $url_part;


define('WEB_PAGE','http://cms.front-back-end.com/');
define('WEB_DIR','/home/frontbac/cms/');

include("functions.php");

$permissions_types = array('view','add','update','delete');
$content_types = array ('menu' => 'Menu','settings' => 'Settings','plugin' => 'Plugin');
$articleExclusiveColors = array(1 => array('id' => 1,'color' => '#d9edf7'));
$menu_style = array('nav-tabs' => 'Tabs','nav-pills' => 'Pills');

## Image settings
$all_image_settings = selectAll('b_images_settings','*',' AS a LEFT JOIN `b_menu` AS b ON a.menu_id = b.id');
$allowed_image_settings = array();
foreach($all_image_settings AS $image_settings){
	
	$allowed_image_settings[$image_settings['folder_url']]['allowed_img_extensions'] = explode(', ',$image_settings['allow_extensions']);
	$allowed_image_settings[$image_settings['folder_url']]['allowed_img_files'] = explode(', ',$image_settings['allow_files']);
	$allowed_image_settings[$image_settings['folder_url']]['max_size'] = $image_settings['max_size'];
	$allowed_image_settings[$image_settings['folder_url']]['allowed_thumbs'] = explode(', ',$image_settings['thumbs']);
	$allowed_image_settings[$image_settings['folder_url']]['original_folder'] = WEB_DIR.'upload/images/'.$image_settings['original_folder'];
	$allowed_image_settings[$image_settings['folder_url']]['thumbs_folder'] = WEB_DIR.'upload/images/'.$image_settings['thumbs_folder'];	
	$allowed_image_settings[$image_settings['folder_url']]['original_folder_url'] = WEB_PAGE.'upload/images/'.$image_settings['original_folder'];
	$allowed_image_settings[$image_settings['folder_url']]['thumbs_folder_url'] = WEB_PAGE.'upload/images/'.$image_settings['thumbs_folder'];	
}

## Roles settings
$roles = array();
$all_roles = selectAll('b_roles');
foreach($all_roles AS $role) $roles[$role['id']] = $role['title'];

$backend_menus = selectAll('b_menu','`id`,`folder_url`'," WHERE `status` = '1'");

$priv = array();
if(isset($backend_menus) && !empty($backend_menus)){
	foreach($backend_menus AS $menu){
	
		$all_permision = getPermision($menu['id']);
	
		foreach($permissions_types AS $type){
			if(strlen($all_permision[$type]) > 0){
				$priv[$menu['folder_url']][$type]   = explode(', ', $all_permision[$type]);
			}
		}
	}
}

$all_statuses = selectAll('b_menu','`folder_url`,`statuses`',"WHERE `status` = '1'");
$statuses = array();
foreach($all_statuses AS $status){
	if(isset($status['statuses']) && !empty($status['statuses'])) $statuses[$status['folder_url']] = explode(', ',$status['statuses']);
}


$all_themes = selectAll('f_themes');
$themes = array();
foreach($all_themes AS $theme){
	$themes[$theme['id']] = $theme['title'];
}

$all_templates = selectAll('f_templates');
$templates = array();
foreach($all_templates AS $template){
	$templates[$template['id']] = $template['title'];
}


$homepage = selectOneByRow('f_pages','homepage','1','`page_url`'," AND `status` = '1'");
if(isset($homepage['page_url']) && !empty($homepage['page_url'])) $homepage = $homepage['page_url'];
else{
	$homepage = selectOneByRow('f_pages','status','1','`page_url`'," ORDER BY `id` ASC");
	$homepage = $homepage['page_url'];
}


$print_contents = selectAll('f_print_contents','`title`,`file`'," WHERE `status` = '1'");
$plugin_parts = array();
if(isset($print_contents) && !empty($print_contents)) foreach($print_contents AS $content) $plugin_parts[$content['title']] = $content['file'];


?>
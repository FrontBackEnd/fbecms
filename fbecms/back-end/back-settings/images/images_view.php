<?php
$name = 'image settings';
$table = 'b_images_settings';
$chain = 'menu_id';
$save_chain = 'save_images_settings';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	
	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		$allowed_menus = selectAll('b_menu','`id`,`title`'," WHERE `upload_images` = '1' ");
		echo '<h1 class="text-center">Images settings</h1>';
		
		foreach($allowed_menus AS $allowed_menu){
			
			$images_settings = selectOneByRow($table,'menu_id',$allowed_menu['id']);
			
			
			$size_in_mb = $images_settings['max_size'] / 1024 / 1024;
			
			if(isset($images_settings) && !empty($images_settings)){
				
				echo '
					<div class="panel panel-default">
			 		 <div class="panel-body">
						<form method="POST" action="">
							<input type="hidden" name="'.$chain.'" value="'.$images_settings['id'].'" >';
				if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))) echo'<input type="submit" name="action" value="UPDATE" class="btn btn-success">';
				echo'<h4 class="pull-right">'.$allowed_menu['title'].'<h4>
					  </div>
					  	<div class="panel-footer">
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Allowed images extensions</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.$images_settings['allow_extensions'].'</li>
							  </ul>
							</div>
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Allowed images files</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.$images_settings['allow_files'].'</li>
							  </ul>
							</div>
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Allowed images size</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.$images_settings['max_size'].' ('.$size_in_mb.' MB)</li>
							  </ul>
							</div>
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Allowed images thumbs</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.$images_settings['thumbs'].'</li>
							  </ul>
							</div>
							    		
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Original images upload folder</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.WEB_DIR.'upload/images/'.$images_settings['original_folder'].'</li>
							  </ul>
							</div>
	
							<div class="panel panel-primary">
							  <!-- Default panel contents -->
							  <div class="panel-heading"><b>Thumbs images upload folder</b></div>
							  <!-- List group -->
							  <ul class="list-group">
							    <li class="list-group-item">'.WEB_DIR.'upload/images/'.$images_settings['thumbs_folder'].'</li>
							  </ul>
							</div>     		
						</div>
					</form>	
					</div>';
			}
		}
	}
	
}else $_SESSION['danger'][] = 'Not allowed';

<?php

function checkPermission($role,$type,$folder){
	global $priv;
	
	
	if(LOCAL_HOST_TRUE == '1') $dir_name = end(explode('\\', $folder));
	else $dir_name = end(explode('/', $folder));
	
	
	if(isset($dir_name) && !empty($dir_name)){
		foreach($priv AS $folder => $menu){
			
			if(($dir_name == $folder) || $dir_name == 'fbecms'){
			
				if(isset($role) && isset($menu[$type])){
					
					if(is_array($menu[$type])){
							
						if(in_array($role, $menu[$type])) return true;
						else return false;
				
					}else{
						if($role == $menu[$type]) return true;
						else return false;
					}
				
				}else return false;
				
			}
		}
	}else return false;
}

function checkPrivileges($role,$users){
	
	if(isset($role) && !empty($role) && isset($users)){
		
		if(is_array($users)){
			
			if(in_array($role, $users)) return true;
			else return false;
	
		}else{
			if($role == $users) return true;
			else return false;
		}
		
	}else return false;
}

function getProperUrl($url){

	$url = str_replace(' ','-',$url);
	$url = strtolower($url);

	return $url;
}

function insertData($table,$data){
	global $conn;
	
	$colums = '';
	$values = '';
	$i=0;
	foreach($data AS $key => $value){
		if($i == 0) $colums .="`".$key."`";
		else $colums .=",`".$key."`";
	
		if($i == 0) $values .="'".mysqli_real_escape_string($conn,$value)."'";
		else $values .=",'".mysqli_real_escape_string($conn,$value)."'";
	
		$i++;
	}
		
	return "INSERT INTO `$table` (".$colums.") VALUES(".$values.")";
	
}

function updateData($table,$data,$update_row,$id){
	global $conn;
	
	$update_values ='';
	$i=0;
	foreach($data AS $key => $value){
		if($i == 0) $update_values .="`".$key."` = '".mysqli_real_escape_string($conn,$value)."'";
		else $update_values .=", `".$key."` = '".mysqli_real_escape_string($conn,$value)."'";
		$i++;
	}
		
	return "UPDATE `$table` SET ".$update_values." WHERE `$update_row` = '".$id."'";
	
}


function deleteData($table,$delete_row,$id){
	
	return "DELETE FROM `$table` WHERE `$delete_row` = '$id'";
	
}


function selectAll($table,$what='*',$add=''){
	global $conn;
	
	$sql="SELECT $what FROM `$table`$add";
	$result = mysqli_query($conn,$sql);
	
	$all = array();
	if(isset($result) && !empty($result)){
		if(mysqli_num_rows($result)) 
			while($row = mysqli_fetch_assoc($result)) $all[] = $row;
		else $all = false;
	}else $all = false;
	
	return $all;	
}

function selectOne($table,$id,$what='*',$add=''){
	global $conn;
	
	$sql="SELECT $what FROM `$table` WHERE `id` = '$id'$add LIMIT 1";
	$result = mysqli_query($conn,$sql);
	
	if(isset($result) && !empty($result)){
		if(mysqli_num_rows($result))  $one = mysqli_fetch_assoc($result);
		else $one = false;
	}else $one = false;
	
	return $one;
}

function selectOneByRow($table,$where,$id,$what='*',$add=''){
	global $conn;

	$sql="SELECT $what FROM `$table` WHERE `$where` = '$id'$add LIMIT 1";
	$result = mysqli_query($conn,$sql);

	if(mysqli_num_rows($result))  $one = mysqli_fetch_assoc($result);
	else $one = false;

	return $one;
}




function alertMessage($message,$type){
	
	return  '<div class="alert alert-'.$type.' navbar-fixed-top alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				'.$message.'
			  </div>';
}

function getPermision($menu_id){
	global $conn;
	
	$sql = "SELECT * FROM `b_permission` WHERE `menu_id` = '$menu_id'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)){
		$permission = mysqli_fetch_assoc($result);		
	}else $permission = false;
	
	return $permission;
	
}

function getAllAllowedRoles($privs){
	
	$permision = '';
	
	if(isset($privs) && strlen($privs) != 0){
	
		if(strlen($privs) == 1){
	
			$role = selectOne('b_roles',$privs,'title');
			$permision .= $role['title'];
				
		}else{
	
			$privs = explode(', ',$privs);
			$i=0;
	
			if(is_array($privs)){
					
				foreach($privs AS $key => $priv){
					$role = selectOne('b_roles',$priv,'title');
					if($i == 0) $permision .= $role['title'];
					else $permision .= ', '.$role['title'];
					$i++;
				}
			}
		}
	}
	
	return $permision;
	
}

function getPremissionsInString($premission_array){
	
	if(is_array($premission_array)){
		$privs = '';
		$i = 0;
		foreach($premission_array AS $key => $on){
			if($on == 'on'){
				if($i == 0) $privs .= $key;
				else $privs .= ', '.$key;
				$i++;
			}
		}
	}else $privs = false;
	
	return $privs;
	
}

function getMenuLevel($constant,$directory){

	if((isset($constant) && !empty($constant)) && isset($directory) && !empty($directory)){
		if(LOCAL_HOST_TRUE == '1') return end(array_keys(explode('\\',str_replace(str_replace('/','\\', $constant), '', $directory))));
		else  return end(array_keys(explode('/',str_replace($constant, '', $directory))));

	}else return false;
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != ".." &&  $object != "config" &&  $object != "change_password" &&  $object != "index.php" &&  $object != "login.php") {
				if (filetype($dir."/".$object) == "dir")
					rrmdir($dir."/".$object);
				else unlink   ($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}



function MenuAndIncludeOrCreateViewFileByGet($get_array, $menu_level ,$dir){
	global $_SESSION;
	
	$ount_get = count($get_array);
	$href ='';
	$get_nav = array();
	foreach($get_array AS $get) $get_nav[]= $get;
	
	if($ount_get == 0) $_SESSION['menu_link'][$ount_get] = '?menu=';
	else{
		$_SESSION['menu_link'][$ount_get] = '?menu=';
		for($i=0;$i<$ount_get;$i++) $_SESSION['menu_link'][$ount_get] .= $get_nav[$i].'&'.$get_nav[$i].'=';
	}
	
	if(isset($_SESSION['menu_link']) && !empty($_SESSION['menu_link'])){
	
		$href = $_SESSION['menu_link'][$menu_level];
			
		if(isset($get_nav[$menu_level]) && !empty($get_nav[$menu_level])) $next_file = $get_nav[$menu_level];
		else $next_file = '';
	
	}else{
		$href="#";
		$next_file = '';
	}
	
	if($menu_level != 0){
	
		$nav_join =" LEFT JOIN `b_parts` AS b ON a.part_id = b.id";
		$nav_add = " AND b.status = '1' AND b.folder_url = '".$get_nav[$menu_level-1]."'";
	
	} else {
		$nav_join = '';
		$nav_add =  " AND a.part_id = '1'";
	}
	
	
	$nav = selectAll('b_menu','a.id,a.title,a.privs,a.folder_url'," AS a ".$nav_join." WHERE a.status ='1'".$nav_add." ORDER BY a.position ASC");
	
	$final_menu = '';
	if(isset($nav) && !empty($nav)){
		$final_menu .= '<ul class="nav nav-tabs nav-justified" role="tablist" style="clear:both;">';
		foreach($nav AS $menu){
	
			if(isset($menu['privs']) && strlen($menu['privs']) != 0){
				if(strlen($menu['privs']) == 1) $menu['privs'] = $menu['privs'];
				else $menu['privs'] = explode(', ',$menu['privs']);
	
				if(checkPermission($_SESSION['role'], 'view', $dir)){
					if(isset($next_file) && !empty($next_file) && $next_file == $menu['folder_url']) $final_menu .= '<li class="active"><a href="'.$href.$menu['folder_url'].'">'.$menu['title'].'</a></li>';
					else $final_menu .= '<li><a href="'.$href.$menu['folder_url'].'">'.$menu['title'].'</a></li>';
				}
			}
		}
		$final_menu .= '</ul>';
	}else{
		
		/*
		$folder_to_delete_files =  end($get_array);
		if(isset($folder_to_delete_files) && !empty($folder_to_delete_files)){
			
			$file_dir = str_replace('\\', '/',$dir.'/');
			rrmdir($file_dir);		
		}
		*/
	}
	
	echo $final_menu;
	
	if(isset($next_file) && !empty($next_file)){
	
		$file_dir = str_replace('\\', '/',$dir);
		$dir_list = scandir($file_dir);
	
		foreach($dir_list AS $list){
	
			if($list == $next_file){
	
				$new_file = $file_dir.'/'.$next_file.'/'.$next_file.'_view.php';
				if(file_exists($new_file)){
					include_once($file_dir.'/'.$next_file."/".$next_file."_view.php");
					break;
				}
				elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
					$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
				}else{
					include_once($file_dir.'/'.$next_file."/".$next_file."_view.php");
					break;
				}
	
			}else{
	
				if(isset($next_file) && !empty($next_file)){
					if (!file_exists($file_dir.'/'.$next_file)) {
	
						if (!mkdir($file_dir.'/'.$next_file, 0777, true)) {
							$_SESSION['danger'][] = 'Not created folder'.$next_file;
						}else{
	
							$new_file = $file_dir.'/'.$next_file.'/'.$next_file.'_view.php';
								
							if(file_exists($new_file)){
								include_once($next_file."/".$next_file."_view.php");
								break;
							}
							elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
								$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
							}else{
								include_once($file_dir.'/'.$next_file."/".$next_file."_view.php");
								break;
							}
						}
					}else{
	
						$new_file = $file_dir.'/'.$next_file.'/'.$next_file.'_view.php';
	
						if(file_exists($new_file)){
							include_once($file_dir.'/'.$next_file."/".$next_file."_view.php");
							break;
						}
						elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
							$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
						}else{
							include_once($file_dir.'/'.$next_file."/".$next_file."_view.php");
							break;
						}
					}
				}
			}
		}
	}
}







function MenuAndIncludeByGet( $get_array, $menu_level ,$dir){
	global $_SESSION;

	$ount_get = count($get_array);
	$href ='';
	$get_nav = array();
	foreach($get_array AS $get) $get_nav[]= $get;
	
	if($ount_get == 0) $_SESSION['menu_link'][$ount_get] = '?menu=';
	else{
		$_SESSION['menu_link'][$ount_get] = '?menu=';
		for($i=0;$i<$ount_get;$i++) $_SESSION['menu_link'][$ount_get] .= $get_nav[$i].'&'.$get_nav[$i].'=';
	}
	
	if(isset($_SESSION['menu_link']) && !empty($_SESSION['menu_link'])){
		
		$href = $_SESSION['menu_link'][$menu_level];
			
		if(isset($get_nav[$menu_level]) && !empty($get_nav[$menu_level])) $next_file = $get_nav[$menu_level];
		else $next_file = '';
		
	}else{
		$href="#";
		$next_file = '';
	}
	
	if($menu_level != 0){
		
		$nav_join =" LEFT JOIN `b_parts` AS b ON a.part_id = b.id";
		$nav_add = " AND b.status = '1' AND b.folder_url = '".$get_nav[$menu_level-1]."'";
		
	} else {
		$nav_join = '';
		$nav_add =  " AND a.part_id = '1'";
	}
	 		
	$nav = selectAll('b_menu','a.id,a.title,a.privs,a.folder_url'," AS a ".$nav_join." WHERE a.status ='1'".$nav_add." ORDER BY a.position ASC");
	
	$final_menu = '';
	if(isset($nav) && !empty($nav)){		
		
		$final_menu .= '<ul class="nav nav-tabs nav-justified" role="tablist" style="clear:both;">';
		foreach($nav AS $menu){
	
			if(isset($menu['privs']) && strlen($menu['privs']) != 0){
				if(strlen($menu['privs']) == 1) $menu['privs'] = $menu['privs'];
				else $menu['privs'] = explode(', ',$menu['privs']);
				
				if(checkPermission($_SESSION['role'], 'view', $dir)){
					if(isset($next_file) && !empty($next_file) && $next_file == $menu['folder_url']) $final_menu .= '<li class="active"><a href="'.$href.$menu['folder_url'].'">'.$menu['title'].'</a></li>';
					else $final_menu .= '<li><a href="'.$href.$menu['folder_url'].'">'.$menu['title'].'</a></li>';
				}
			}
		}
		$final_menu .= '</ul>';
	}
	echo $final_menu;
	
	
	return $next_file;
	
	
}


function includeOrCreateViewFile($next_file,$file_dir){
	global $_SESSION;
	
	if(isset($next_file) && !empty($next_file)){
	
		$dir = str_replace('\\', '/',$file_dir);
		$dir_list = scandir($dir);
	
		foreach($dir_list AS $list){
	
			if($list == $next_file){
	
				$new_file = $dir.'/'.$next_file.'/'.$next_file.'_view.php';
				if(file_exists($new_file)){
					include_once($dir.'/'.$next_file."/".$next_file."_view.php");
					break;
				}
				elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
					$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
				}else{
					include_once($dir.'/'.$next_file."/".$next_file."_view.php");
					break;
				}
	
			}else{
	
				if(isset($next_file) && !empty($next_file)){
					if (!file_exists($dir.'/'.$next_file)) {
	
						if (!mkdir($dir.'/'.$next_file, 0777, true)) {
							$_SESSION['danger'][] = 'Not created folder'.$next_file;
						}else{
								
							$new_file = $dir.'/'.$next_file.'/'.$next_file.'_view.php';
							
							if(file_exists($new_file)){
								include_once($next_file."/".$next_file."_view.php");
								break;
							}
							elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
								$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
							}else{
								include_once($dir.'/'.$next_file."/".$next_file."_view.php");
								break;
							}
						}
					}else{
	
						$new_file = $dir.'/'.$next_file.'/'.$next_file.'_view.php';
	
						if(file_exists($new_file)){
							include_once($dir.'/'.$next_file."/".$next_file."_view.php");
							break;
						}
						elseif(!copy(WEB_DIR.'fbecms/config/index_menu.php',$new_file)){
							$_SESSION['danger'][] = 'Not created file'.$next_file.'_view.php';
						}else{
							include_once($dir.'/'.$next_file."/".$next_file."_view.php");
							break;
						}
					}
				}
			}
		}
	}
}


function getStatusesForm($status_array,$status,$type="status"){
	
	$status_form ='';
	
	if(isset($status_array) && !empty($status_array)){
		$status_form ='<div class="form-group">
						<label for="'.$type.'">'.ucfirst($type).':</label>
				<select id="'.$type.'" name="data['.$type.']" class="form-control">';
				foreach($status_array AS $key => $status_name){
					if(isset($status) && !empty($status) && $status == $key) $sel =' selected="selected"';
					else $sel = '';
				$status_form .= '<option value="'.$key.'"'.$sel.'>'.$status_name.'</option>';
				}
		$status_form .='	</select>
			</div>';
	}
	
	echo $status_form;
}


/* PRINT */

function getPageData($url){
	global $conn;
	
	$sql =" SELECT a.`id`,a.`page_title`,a.`page_url`,a.`page_description`,a.`page_keywords`,a.`template_id`,c.`css_name`
			FROM `f_pages` AS a
			LEFT JOIN `f_templates` AS b
			ON a.`template_id` = b.`id`
			LEFT JOIN `f_themes` AS c
			ON b.`theme` = c.`id`
			WHERE a.`page_url` = '$url' AND a.`status` = '1' AND b.`status` = '1' AND c.`status` = '1'
			LIMIT 1";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $data = mysqli_fetch_assoc($result);
	else $data = false;
	
	return $data;
}

function selectFirstCategory(){
	global $conn;
	
	$sql = "SELECT * FROM `p_categories` ORDER BY `position` ASC LIMIT 1";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $data = mysqli_fetch_assoc($result);
	else $data = false;
	
	return $data;
	
}



function getExclusiveArticle($categ = ''){
	global $conn;
	
	if(isset($categ) && !empty($categ)) $add = " AND `category_id` = '".$categ."'";
	else $add = '';
	
	$sql="SELECT * FROM `p_articles` WHERE `exclusive` = '1'".$add." ORDER BY `published_date` DESC LIMIT 1";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $exclusive = mysqli_fetch_assoc($result);
	else $exclusive = false;
	
	return $exclusive;
}

function getCommentsNum($id,$table = 'p_comments'){
	global $conn;
	
	$sql="SELECT * FROM `$table` WHERE `article_id` = '$id'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $num = mysqli_num_rows($result);
	else $num = false;
	
	return $num;
}


function getCategoryId($category_url){
	global $conn;
	
	$sql="SELECT `id` FROM `p_categories` WHERE `category_url` = '".mysqli_real_escape_string($conn,$category_url)."'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $categ_id = mysqli_fetch_assoc($result);
	else $categ_id = false;
	
	return $categ_id['id'];
	
}

function getArticleId($article_url){
	global $conn;
	
	$sql="SELECT `id` FROM `p_articles` WHERE `article_url` = '".mysqli_real_escape_string($conn,$article_url)."'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result))  $article_id = mysqli_fetch_assoc($result);
	else $article_id = false;
	
	return $article_id['id'];
	
}

function deleteAllComments($id,$table = 'p_comments'){
	global $conn;
	
	$sql_comments="SELECT `id` FROM `".$table."` WHERE `article_id` = '".mysqli_real_escape_string($conn,$id)."'";
	$result_comments = mysqli_query($conn,$sql_comments);
	if(mysqli_num_rows($result_comments)){
		while($row_comment = mysqli_fetch_assoc($result_comments)){
			$sql_comment="DELETE FROM `".$table."` WHERE `id` = '".mysqli_real_escape_string($conn,$row_comment['id'])."'";
			mysqli_query($conn,$sql_comment);
		}
	}
	
}


function createThumbs($fname,$pathToImages, $pathToThumbs, $new_width ,$new_height,$allowedExts )
{
  // open the directory
  $dir = opendir( $pathToImages );

  // loop through it, looking for any/all JPG files:
  
    // parse path for the extension
    $info = pathinfo($pathToImages . $fname);
    // continue only if this is a JPEG image
    if ( in_array($info['extension'], $allowedExts) )
    {
      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$fname}" );
      $width = imagesx( $img );
      $height = imagesy( $img );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      $fname = $new_width.'x'.$new_height.'-'.$fname;
      
      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$fname}" );
    }
  
  // close the directory
  closedir( $dir );
}

function deleteImg($table,$id,$next_file){
	global $conn,$allowed_image_settings;
	
	$sql="SELECT `img` FROM `$table` WHERE `id` = '".mysqli_real_escape_string($conn,$id)."'";
	$result = mysqli_query($conn,$sql);
	if(mysqli_num_rows($result)){
		$img = mysqli_fetch_assoc($result);
	
		if(isset($img['img']) && !empty($img['img']) && $img['img'] != ' '){
			if(unlink($allowed_image_settings[$next_file]['original_folder'].$img['img'])){
				
				foreach($allowed_image_settings[$next_file]['allowed_thumbs'] AS $thumb){
					$thumb_data = explode('x',$thumb);
					if(!unlink($allowed_image_settings[$next_file]['thumbs_folder'].$thumb_data[0].'x'.$thumb_data[1].'-'.$img['img'])) return false;
				}
		
				$sql="UPDATE `$table`   SET `img` ='' WHERE  `id` = '".mysqli_real_escape_string($conn,$id)."'";
		
				if(mysqli_query($conn,$sql)) return true;
				
			}else return false;
		}else return false;
	}else return false;
}


function ImgCreation($img, $id, $img_new_name, $table, $next_file){
	global $conn,$allowed_image_settings;
	
	
	$temp = explode(".", $img["img"]["name"]);
	$extension = end($temp);
	
	$img["img"]["name"] = $id.'-'.$img_new_name.'.jpeg';
	
	if (in_array($img["img"]["type"],$allowed_image_settings[$next_file]['allowed_img_files']) && ($img["img"]["size"] < $allowed_image_settings[$next_file]['max_size']) && in_array($extension, $allowed_image_settings[$next_file]['allowed_img_extensions'])) {
			
		if ($img["img"]["error"] > 0) return  $_SESSION['danger'][] = 'Return Code: ' . $img["img"]["error"];
		else {
			
			$img_name = $img["img"]["name"];
			
			if (file_exists($allowed_image_settings[$next_file]['original_folder'] . $img["img"]["name"])) return $_SESSION['danger'][] = $img["img"]["name"] . " already exists. ";
			else{
				
				if(is_dir($allowed_image_settings[$next_file]['original_folder'])){
					if(move_uploaded_file($img["img"]["tmp_name"],$allowed_image_settings[$next_file]['original_folder'] . $img["img"]["name"])){
					
						foreach($allowed_image_settings[$next_file]['allowed_thumbs'] AS $thumb){
							$thumb_data = explode('x',$thumb);
							createThumbs($img_name,$allowed_image_settings[$next_file]['original_folder'],$allowed_image_settings[$next_file]['thumbs_folder'],$thumb_data[0],$thumb_data[1],$allowed_image_settings[$next_file]['allowed_img_extensions']);
						}
						
						$sql_img = "UPDATE `".$table."` SET `img` = '$img_name' WHERE `id` = '$id'";
						
						if(mysqli_query($conn,$sql_img)) return $_SESSION['success'][] = 'Img added';
						else return $_SESSION['danger'][] = 'Error while adding img';
					
					}else return $_SESSION['danger'][] = 'Error while adding img';
				}else return $_SESSION['danger'][] = 'Not found directory';
			}
		}
			
	}else return $_SESSION['danger'][] = 'Invalid file';
	
}



?>

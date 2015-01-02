<?php
switch($_POST[$save_chain]){

	case 'ADD':

		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
			$data = $_POST['data'];
			$data['folder_url'] = getProperUrl($data['title']);
			$data['created_date'] = date("Y-m-d H:i:s",time());
			
			$sql = insertData($table,$data);
	
	
			if(mysqli_query($conn,$sql)){
				$_SESSION['success'][] = 'Menu added';
				
				$menu_id = mysqli_insert_id($conn);
				
				$check_permission_data = getPermision($menu_id);
				if($check_permission_data == false){
					$inserted_id['menu_id'] = $menu_id;
					$sql_permission = insertData('b_permission',$inserted_id);
					if(mysqli_query($conn,$sql_permission)) $_SESSION['success'][] = 'Permission added';
					else $_SESSION['danger'][] = 'Error while add permission';
					
					$image_settings = insertData('b_images_settings',$inserted_id);
					if(mysqli_query($conn,$image_settings)) $_SESSION['success'][] = 'Images settings added';
					else $_SESSION['danger'][] = 'Error while add images settings';
				}
			}
			else $_SESSION['danger'][] = 'Error while add '.$name;

		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'UPDATE':

		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			$data = $_POST['data'];
	
			if(isset($data['privs']) && !empty($data['privs'])){
				if(is_array($data['privs'])){
					$privs = '';
					$i = 0;
					foreach($data['privs'] AS $key => $on){
						if($on == 'on'){
							if($i == 0) $privs .= $key;
							else $privs .= ', '.$key;
							$i++;
						}
					}
					$data['privs'] = $privs;
				}
			}else $data['privs'] = '';
			
			$data['folder_url'] = getProperUrl($data['title']);
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
			
			$update_id = $data[$chain];
			unset($data[$chain]);
	
			$sql = updateData($table,$data,'id',$update_id);
			
			if(mysqli_query($conn,$sql)){
				$_SESSION['info'][] = 'Menu updated';
				
				$check_permission_data = getPermision($update_id);
				if($check_permission_data == false){
					$permission_data['menu_id'] = $update_id;
					$sql_permission = insertData('b_permission',$permission_data);
					if(mysqli_query($conn,$sql_permission)) $_SESSION['success'][] = 'Permission added';
					else $_SESSION['danger'][] = 'Error while add permission';
				}
			}else $_SESSION['danger'][] = 'Error while updating '.$name;

		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'DELETE':

		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){

			$id = $_POST[$chain];
	
			$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
	
			if(mysqli_query($conn,$sql)){
				$_SESSION['danger'][] = 'Menu deleted';
				
				$check_permission_data = getPermision($id);
				if(isset($check_permission_data) && !empty($check_permission_data)){
					
					$sql_permission = deleteData('b_permission','menu_id',mysqli_real_escape_string($conn,$id));
					if(mysqli_query($conn,$sql_permission)) $_SESSION['danger'][] = 'Permission deleted';
					else $_SESSION['danger'][] = 'Error while deleting permission';
					
					$sql_image_settings = deleteData('b_images_settings','menu_id',mysqli_real_escape_string($conn,$id));
					if(mysqli_query($conn,$sql_image_settings)) $_SESSION['danger'][] = 'Images settings deleted';
					else $_SESSION['danger'][] = 'Error while deleting images settings';
				}
				
			}else $_SESSION['danger'][] = 'Error while deleting '.$name;

		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;
}
?>
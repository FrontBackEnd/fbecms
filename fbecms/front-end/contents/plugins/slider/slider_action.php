<?php
switch($_POST[$save_chain]){

	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			$data = $_POST['data'];
			$data['img_name'] = getProperUrl($data['title']);
			$data['created_date'] = date("Y-m-d H:i:s",time());
			
			
			$sql = insertData($table,$data);
			
			if(mysqli_query($conn,$sql)){
				
				if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
					
					$id = mysqli_insert_id($conn);

					ImgCreation($_FILES, $id, $data['img_name'], $table, $next_file);
				}
				
				$_SESSION['success'][] = 'Slider added';
				
			}else $_SESSION['danger'][] = 'Error while adding slider';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
			
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			
			$data = $_POST['data'];
			$update_id = $data[$chain];
			unset($data[$chain]);
			
			$data['img_name'] = getProperUrl($data['title']);
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
			
			if(isset($_POST['delete_slider_img']) && !empty($_POST['delete_slider_img']) && $_POST['delete_slider_img'] == 'delete'){
			
				if(deleteImg($table,$update_id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
				else $_SESSION['danger'][] = 'Not deleted Img';
			}
			

			if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
				
				ImgCreation($_FILES, $update_id, $data['img_name'], $table, $next_file);
			}
			
			$sql = updateData($table,$data,'id',$update_id);
				
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = 'Slider updated';
			else $_SESSION['danger'][] = 'Error while updating slider';
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
			
			$id = $_POST[$chain];
			
			if(deleteImg($table,$id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
			
			$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
		
			if(mysqli_query($conn,$sql)){
				$_SESSION['danger'][] = 'Slider deleted';
			}else $_SESSION['danger'][] = 'Error while slider';
			
		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;
	
}

?>
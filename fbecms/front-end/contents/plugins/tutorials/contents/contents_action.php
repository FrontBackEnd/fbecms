<?php
switch($_POST[$save_chain]){

	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			$data = $_POST['data'];
			$data['created_date'] = date("Y-m-d H:i:s",time());
				
			$sql = insertData($table,$data);
				
			if(mysqli_query($conn,$sql)){
				
				if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
					
					$id = mysqli_insert_id($conn);

					ImgCreation($_FILES, $id, $data['title'], $table, $next_file);
				}
				
				$_SESSION['success'][] = ucfirst($name).' added';
			}
			else $_SESSION['danger'][] = 'Error while add '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
				
			$data = $_POST['data'];
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
				
			$update_id = $data[$chain];
			unset($data[$chain]);
				
			if(isset($_POST['delete_'.$name.'_img']) && !empty($_POST['delete_'.$name.'_img']) && $_POST['delete_'.$name.'_img'] == 'delete'){
			
				if(deleteImg($table,$update_id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
				else $_SESSION['danger'][] = 'Not deleted Img';
			}
		
			if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
				ImgCreation($_FILES, $update_id, $data['title'], $table, $next_file);
			}
			
			
			$sql = updateData($table,$data,'id',$update_id);
				
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = ucfirst($name).' updated';
			else $_SESSION['danger'][] = 'Error while updating '.$name;

		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){

			$id = $_POST[$chain];
			
			if(deleteImg($table,$id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
				
			$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
				
			if(mysqli_query($conn,$sql)) $_SESSION['danger'][] = ucfirst($name).' deleted';
			else $_SESSION['danger'][] = 'Error while deleting '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
				
		break;
}
?>
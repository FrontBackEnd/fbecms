<?php
switch($_POST['save_category']){

	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
			$data = $_POST['data'];
			$data['category_url'] = getProperUrl($data['title']);
			$data['created_date'] = date("Y-m-d H:i:s",time());
				
			$sql = insertData($table,$data);
			
			if(mysqli_query($conn,$sql)) $_SESSION['success'][] = 'Category added';
			else $_SESSION['danger'][] = 'Error while add category';
			
		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;

	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			$data = $_POST['data'];
			$data['category_url'] = getProperUrl($data['title']);
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
				
			$update_id = $data[$chain];
			unset($data[$chain]);
				
			$sql = updateData($table,$data,'id',$update_id);
			
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = 'Category updated';
			else $_SESSION['danger'][] = 'Error while updating category';
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;


	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){	
			
				$id = $_POST[$chain];
				
				$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
				
				if(mysqli_query($conn,$sql)) $_SESSION['danger'][] = 'Category deleted';
				else $_SESSION['danger'][] = 'Error while deleting category';
					
			}else $_SESSION['danger'][] = 'Not found category with ID'.$_POST['category_id'];
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
}
		
?>
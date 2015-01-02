<?php
switch($_POST[$save_chain]){

	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			$data = $_POST['data'];
			
			$data['page_url'] = getProperUrl($data['page_title']);
			$data['created_date'] = date("Y-m-d H:i:s",time());
				
			$sql = insertData($table,$data);
				
			if(mysqli_query($conn,$sql)) $_SESSION['success'][] = ucfirst($name).' added';
			else $_SESSION['danger'][] = 'Error while add '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
				
			$data = $_POST['data'];
			
			if(isset($data['homepage']) && !empty($data['homepage']) && $data['homepage'] == 'on') $data['homepage'] = 1;
			else $data['homepage'] = 0;
			
			$data['page_url'] = getProperUrl($data['page_title']);
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
				
			$update_id = $data[$chain];
			unset($data[$chain]);
				
			$sql = updateData($table,$data,'id',$update_id);
				
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = ucfirst($name).' updated';
			else $_SESSION['danger'][] = 'Error while updating '.$name;

		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){

			$id = $_POST[$chain];
				
			$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
				
			if(mysqli_query($conn,$sql)) $_SESSION['danger'][] = ucfirst($name).' deleted';
			else $_SESSION['danger'][] = 'Error while deleting '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
				
		break;
}
?>
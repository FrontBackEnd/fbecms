<?php	
switch($_POST[$save_chain]){

	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			$data = $_POST['data'];
			
			$update_id = $data[$chain];
			unset($data[$chain]);
			
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];

		    $sql = updateData($table, $data, 'id', $update_id);
			
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = 'Comment updated';
			else $_SESSION['danger'][] = 'Error while updating comment';
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;


	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
			
				$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
			
				if(mysqli_query($conn,$sql)) $_SESSION['danger'][] = 'Comment deleted';
				else $_SESSION['danger'][] = 'Error while deleting comment';
				
			}else $_SESSION['danger'][] = 'Not selected comment';
				
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
		
}
		
?>
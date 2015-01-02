<?php
switch($_POST[$save_chain]){
	
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			$data = $_POST['data'];
		
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
		
			$update_id = $data[$chain];
			unset($data[$chain]);
		
			$sql = updateData($table,$data,'id',$update_id);
		
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = ucfirst($name).' updated';
			else $_SESSION['danger'][] = 'Error whille updating '.$name;
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		
		break;
}
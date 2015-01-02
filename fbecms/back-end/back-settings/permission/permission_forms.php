<?php
switch($_POST['action']){

	case 'UPDATE':

		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
	
				$row = selectOne('b_menu',mysqli_real_escape_string($conn,$id));
				
				$all_permision = getPermision($row['id']);
				
				$view_privs = explode(', ',$all_permision['view']); 
				$add_privs = explode(', ',$all_permision['add']); 
				$update_privs = explode(', ',$all_permision['update']); 
				$delete_privs = explode(', ',$all_permision['delete']); 
				
				$roles = selectAll('b_roles');
					
				if(isset($row) && !empty($row)){
	
					$permision = explode(', ',$row['privs']);
	
					echo '<h1 class="text-center">Edit '.$name.'</h1>
	
							  <form method="POST" action="">
							  <input type="hidden" name="data['.$chain.']" value="'.$id.'">
	
							 	<div class="form-group">
									<label for="title">Menu</label>
									<input id="title" type="text" value="'.$row['title'].'" class="form-control" readonly="readonly">
								</div>';
					
					foreach($permissions_types AS $permission_type){
					
						$per_type = $permission_type.'_privs';
						
						echo'<h4>'.ucfirst($permission_type).'</h4>			
							 <div class="form-group">';
							foreach($roles AS $role){
								if(in_array($role['id'],$$per_type)) $checked = 'checked="checked"';
								else $checked = '';
			
								echo'<div class="checkbox">
												  <label><input type="checkbox" name="data['.$permission_type.']['.$role['id'].']" '.$checked.'>'.$role['title'].'</label>
												</div>';
							}
						echo'</div>';
	
					}

							getStatusesForm($$menu_statuses,$row['status']);
	
				echo'		<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
						</form>';
	
				}else $_SESSION['danger'][] = 'Not found '.$name.' with ID:'.$_POST[$chain];
	
			}else $_SESSION['danger'][] = 'Not selected '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
		break;

}

?>
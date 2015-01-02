<?php
$name = 'permision';
$table = 'b_permission';
$chain = 'menu_id';
$save_chain = 'save_permission';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){
	
	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
		
			echo'<h1 class="text-center">Permission</h1>';
	
		$parts = selectAll('b_parts','`title`,`id`'," WHERE `status` = '1'");
			
			
		if(isset($parts) && !empty($parts)){
			foreach($parts AS $part){
		
			echo'	<div class="panel panel-default">
						<div class="panel-heading">
							<h4>'.$part['title'].'</h4>
						</div>';
			
			$backend_menu = selectAll('b_menu','*'," WHERE `part_id` = '".$part['id']."' AND `status` = '1'");
			if(isset($backend_menu) && !empty($backend_menu)){
				
				
			echo'		<table class="table">
							<thead>
								<tr>
								<th>Menu</th>
								<th>View</th>
								<th>Add</th>
								<th>Update</th>
								<th>Delete</th>';
			if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
			echo'				<th>Action</th>
							</thead>
							<tbody>';
		
				foreach($backend_menu AS $row){
					
					
					$all_permision = getPermision($row['id']);
					
					if(isset($all_permision) && !empty($all_permision)){
					
						$view_permision =  getAllAllowedRoles($all_permision['view']);
						$add_permision =  getAllAllowedRoles($all_permision['add']);
						$update_permision =  getAllAllowedRoles($all_permision['update']);
						$delete_permision =  getAllAllowedRoles($all_permision['delete']);
					
	
					echo'		<tr>
									<td>'.$row['title'].'</td>
								 	<td>'.$view_permision.'</td>
								 	<td>'.$add_permision.'</td>
								 	<td>'.$update_permision.'</td>
								 	<td>'.$delete_permision.'</td>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)){
						if(isset($row['status'])){
							foreach($$menu_statuses AS $key => $status) if($row['status'] == $key) echo '<td>'.$status.'</td>';
						}else echo '<td></td>';
					}
					echo'		  	<td><form method="POST" action="">
										<input type="hidden" name="'.$chain.'" value="'.$all_permision['menu_id'].'">';
					if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))) echo'<input type="submit" name="action" value="UPDATE" class="btn btn-default">';
							echo'		</form>
								 	</td>
								 </tr>';
					
					}else echo '<tr><td>'.$row['title'].'</td><td>Not found any perrmissions</td></tr>';
					
				}
			
		
			echo '			</tbody>
						</table>';
			
			}else echo '<h5 class="text-center">Not found any</h5>';
			
		echo '</div>';
			}
		}	
	}
}else $_SESSION['danger'][] = 'Not allowed';	
?>
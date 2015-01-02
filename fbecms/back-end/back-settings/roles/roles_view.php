<?php
$name = 'role';
$table = 'b_roles';
$chain = 'user_id';
$save_chain = 'save_role';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Roles list</h1>
				<div class="panel panel-default">
					<div class="panel-heading">
						<form method="POST" action="">';
				if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__)))echo'<input type="submit" name="action" value="ADD" class="btn btn-success">';
			echo'		</form>
					</div>';
			
			$roles = selectAll($table);
			if(isset($roles) && !empty($roles)){
				
			echo'	<table class="table">
						<thead>
							<tr>
							<th>ID</th>
							<th>Title</th>';
			if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
			echo'			<th>Actions</th>
						</thead>
						<tbody>';
		
			
			foreach($roles AS $row){
				if($row['id'] == '0') continue;
				else{
				echo'		<tr>
								<td>'.$row['id'].'</td>
							 	<td>'.$row['title'].'</td>';
				if(isset($$menu_statuses) && !empty($$menu_statuses)){
					
					if(isset($row['status'])){
						foreach($$menu_statuses AS $key => $status) if($row['status'] == $key) echo '<td>'.$status.'</td>';
					}else echo '<td></td>';
					
				}
				
				echo'		  	<td><form method="POST" action="">
									<input type="hidden" name="'.$chain.'" value="'.$row['id'].'">';
					if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__)))echo'<input type="submit" name="action" value="UPDATE" class="btn btn-default">';
					if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__)))echo'<input type="submit" name="action" value="DELETE" class="btn btn-danger">';
				echo'	 			</form>
							 	</td>
							 </tr>';
				}
			}
			echo '		</tbody>
					</table>';
			
		}else echo '<h5 class="text-center">Not found any</h5>';	
		
		echo '			
				</div>';
	
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
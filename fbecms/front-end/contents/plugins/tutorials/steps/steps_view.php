<?php
$name = 'steps';
$table = 'p_tutorial_steps';
$chain = 'step_id';
$save_chain = 'save_step';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Tutorial steps</h1>';
		
		$tutorials = selectAll('p_tutorial');
		if(isset($tutorials) && !empty($tutorials)){
			foreach($tutorials AS $tutorial){

				echo'		<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="pull-right">'.$tutorial['title'].'</h4>
								<form method="POST" action="">
									<input type="hidden" name="tutorial_id" value="'.$tutorial['id'].'">';
						if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__)))echo'<input type="submit" name="action" value="ADD" class="btn btn-success">';
					echo'		</form>
							</div>';
					$$table = selectAll($table,'*'," WHERE `tutorial_id` = '".$tutorial['id']."' ORDER BY `position` ASC");
					
					
					
					if(isset($$table) && !empty($$table)){
						
					echo'	<table class="table">
								<thead>
									<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Position</th>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
					echo'			<th>Actions</th>
								</thead>
								<tbody>';
				
					
					foreach($$table AS $row){
						
						echo'		<tr>
										<td>'.$row['id'].'</td>
									 	<td>'.$row['title'].'</td>
									 	<td>'.$row['position'].'</td>';
						
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
					echo '	</tbody>
						</table>';
					
				}else echo '<h5 class="text-center">Not found any</h5>';	
				
				echo '	</div>';
			}
		}else echo '<h5 class="text-center">Not found any tutorial</h5>';	
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
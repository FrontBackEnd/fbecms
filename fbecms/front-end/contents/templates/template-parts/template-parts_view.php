<?php
$name = 'template part';
$table = 'f_templates_parts';
$chain = 'template_part_id';
$save_chain = 'save_template_part';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Templates parts</h1>';
		
		$templates = selectAll('f_templates');
		if(isset($templates) && !empty($templates)){
			foreach($templates AS $template){
			
				echo'		<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="pull-right">'.$template['title'].'</h4>
								<form method="POST" action="">
									<input type="hidden" name="template_id" value="'.$template['id'].'">';
						if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__)))echo'<input type="submit" name="action" value="ADD" class="btn btn-success">';
					echo'		</form>
							</div>';
					$$table = selectAll($table,'*'," WHERE `template_id` = '".$template['id']."' ORDER BY `position` ASC");
					if(isset($$table) && !empty($$table)){
						
					echo'	<table class="table">
								<thead>
									<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Position</th>
									<th>Tags</th>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
					echo'			<th>Actions</th>
								</thead>
								<tbody>';
				
					
					foreach($$table AS $row){
						
						echo'		<tr>
										<td>'.$row['id'].'</td>
									 	<td>'.$row['title'].'</td>
									 	<td>'.$row['position'].'</td>
									 	<td>'.$row['start_tag'].$row['end_tag'].'</td>';
						
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
		}else echo '<h5 class="text-center">Not found any template</h5>';	
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
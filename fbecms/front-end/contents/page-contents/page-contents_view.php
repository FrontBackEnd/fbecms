<?php
$name = 'page content';
$table = 'f_pages_contents';
$chain = 'pages_contents_id';
$save_chain = 'save_pages_contents';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Page contents</h1>';
		
		$pages = selectAll('f_pages');
		if(isset($pages) && !empty($pages)){
			foreach($pages AS $page){
			
				echo'		<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="pull-right">'.$page['page_title'].'</h4>
								<form method="POST" action="">
									<input type="hidden" name="page_id" value="'.$page['id'].'">';
						if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__)))echo'<input type="submit" name="action" value="ADD" class="btn btn-success">';
					echo'		</form>
							</div>';
					$$table = selectAll($table,'a.*'," AS a LEFT JOIN `f_templates_parts` AS b ON a.template_part = b.id  WHERE a.page_id = '".$page['id']."' ORDER BY b.position ASC,a.position ASC");
					if(isset($$table) && !empty($$table)){
						
					echo'	<table class="table">
								<thead>
									<tr>
									<th>ID</th>
									<th>Template part</th>
									<th>Plugin part</th>
									<th>Position</th>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
					echo'			<th>Actions</th>
								</thead>
								<tbody>';
				
					
					foreach($$table AS $row){
						
						$template_name = selectOne('f_templates_parts',$row['template_part'],'`title`');
						
						
						echo'		<tr>
										<td>'.$row['id'].'</td>
									 	<td>'.$template_name['title'].'</td>';
						if(isset($plugin_parts) && !empty($plugin_parts)){
							if(isset($row['plugin_part'])){
								foreach($plugin_parts AS $name => $key) if($key == $row['plugin_part']) echo '<td>'.$name.'</td>';
								
							}else echo '<td></td>';
							
						}else echo '<td></td>';
						
								echo '<td>'.$row['position'].'</td>';
						
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
		}else echo '<h5 class="text-center">Not found any menu</h5>';	
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
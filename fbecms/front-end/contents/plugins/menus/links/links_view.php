<?php
$name = 'link';
$table = 'f_menu_links';
$chain = 'link_id';
$save_chain = 'save_link';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Links</h1>';
		
		$pages = selectAll('f_pages');
		$menus = selectAll('f_menu');
		if(isset($menus) && !empty($menus)){
			foreach($menus AS $menu){
			
				echo'		<div class="panel panel-default">
							<div class="panel-heading">
							<h4 class="pull-right">'.$menu['title'].'</h4>
								<form method="POST" action="">
									<input type="hidden" name="menu_id" value="'.$menu['id'].'">';
						if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__)))echo'<input type="submit" name="action" value="ADD" class="btn btn-success">';
					echo'		</form>
							</div>';
					$$table = selectAll($table,'*'," WHERE `menu_id` = '".$menu['id']."'");
					if(isset($$table) && !empty($$table)){
						
					echo'	<table class="table">
								<thead>
									<tr>
									<th>ID</th>
									<th>Title</th>
									<th>Page</th>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)) echo'<th>Status</th>';
					echo'			<th>Actions</th>
								</thead>
								<tbody>';
				
					
					foreach($$table AS $row){
						
						echo'		<tr>
										<td>'.$row['id'].'</td>
									 	<td>'.$row['title'].'</td>';
						if(isset($row['page_id']) && !empty($row['page_id'])){
							foreach($pages AS $page){
								if($row['page_id'] == $page['id']) echo '<td>'.$page['page_title'].'</td>'; 
								
							}
						}else echo '<td></td>';
						
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
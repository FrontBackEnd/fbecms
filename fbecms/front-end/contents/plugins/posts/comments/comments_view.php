<?php

$table = 'p_comments';
$chain = 'comment_id';
$save_chain = 'save_comments';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){
	
	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");	
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
		
			$articles = selectAll('p_articles');
			
			if(isset($articles) && !empty($articles)){
				
				echo '<h1 class="text-center">Comment list</h1>';
				
				foreach($articles AS $article){
				
					$$table = selectAll($table,'*'," WHERE `article_id` = '".mysqli_real_escape_string($conn,$article['id'])."'");
					if(isset($$table) && !empty($$table) && $$table !=false){
					
					
					echo'	<div class="panel panel-default">
								<div class="panel-heading">
									<b>Article:</b> '.$article['title'].'
								</div>
								<table class="table">
									<thead>
										<tr>
										<th>Created date</th>
										<th>Commenator</th>
										<th>Active</th>
										<th>Actions</th>
									</thead>
									<tbody>';
						foreach($$table AS $row){
							echo '<tr>
									<td>'.date('d.m.Y H:i:s',strtotime($row['created_date'])).'</td>
									<td>'.$row['commentator'].'</td>';
									if(isset($$menu_statuses) && !empty($$menu_statuses)){
									
										if(isset($row['status'])){
											foreach($$menu_statuses AS $key => $status) if($row['status'] == $key) echo '<td>'.$status.'</td>';
										}else echo '<td></td>';
										
									}
						echo'<td><form method="POST" action="">
										<input type="hidden" name="'.$chain.'" value="'.$row['id'].'">';
										if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))) echo '<input type="submit" name="action" value="UPDATE" class="btn btn-default">';
										if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))) echo '<input type="submit" name="action" value="DELETE" class="btn btn-danger">';
								echo'</form>
									</td>
								</tr>';
							}
							
					echo '		</tbody>
							</table>
						</div>';
					}	
				}
			}else $_SESSION['danger'][] = 'Not found any article';
		
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
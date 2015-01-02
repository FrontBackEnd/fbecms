<?php
$table = 'p_articles';
$chain = 'article_id';
$save_chain = 'save_article';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");	
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo'<h1 class="text-center">Article list</form></h1>
				<div class="panel panel-default">
					<div class="panel-heading">';
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			echo'		<form method="POST" action="">
							<input type="submit" name="action" value="ADD" class="btn btn-success">
						</form>';
		}			
		
		echo'		</div>
					<table class="table">
						<thead>
							<tr>
							<th>ID</th>
							<th>Publish date</th>
							<th>Title</th>
							<th>Category</th>
							<th>Published</th>
							<th>Actions</th>
						</thead>
						<tbody>';
		
		
		$$table = selectAll($table);
		if(isset($$table) && !empty($$table) && $$table !=false){
			
			foreach($$table AS $row){
				$category = selectOne('p_categories',$row['category_id'],'`title`');
				
				foreach($articleExclusiveColors AS $exclusive){
					if($row['exclusive'] == $exclusive['id']) $ex = ' style="background-color: '.$exclusive['color'].';"';
					else $ex = '';
				}
				
				$comments_num = getCommentsNum(mysqli_real_escape_string($conn,$row['id']));
				if(isset($comments_num) && !empty($comments_num) && $comments_num != false) $comments_num =' <code class="pull-right">'.$comments_num.'</code>';
				else $comments_num = '';
				
				echo '<tr'.$ex.'>
						<td>'.$row['id'].'</td>
						<td>'.date('H:i:s d.m.Y',strtotime($row['published_date'])).'</td>
						<td>'.$row['title'].'</td>
						<td>'.$category['title'].'</td>';
					if(isset($$menu_statuses) && !empty($$menu_statuses)){
					
						if(isset($row['status'])){
							foreach($$menu_statuses AS $key => $status) if($row['status'] == $key) echo '<td>'.$status.'</td>';
						}else echo '<td></td>';
						
					}
					echo'
						<td><form method="POST" action="">
							<input type="hidden" name="'.$chain.'" value="'.$row['id'].'">';
					if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))) echo'<input type="submit" name="action" value="UPDATE" class="btn btn-default">';
					if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))) echo '<input type="submit" name="action" value="DELETE" class="btn btn-danger">';
					echo	$comments_num.'
							</form>
						</td>
					</tr>';				
				}
				
		}else echo '<tr><td>Not found articles</td></tr>';
		
		echo '			 </tbody>
					</table>';
		
	}
	
}else $_SESSION['danger'][] = 'Not allowed';
?>
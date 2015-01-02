<?php
switch($_POST['action']){
		
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
				
				$row = selectOne($table,mysqli_real_escape_string($conn,$id));
				
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit comment</h1>
						  <form method="POST" action="">
						  	<input type="hidden" name="data['.$chain.']" value="'.$id.'">
						  
							  <div class="form-group">
								<label for="title">Commentator</label>
								<input id="title" type="text" value="'.$row['commentator'].'" class="form-control" readonly="readonly">
							  </div>	
							  
							  <div class="form-group">
								<label for="comment">Comment</label>
								<textarea id="comment" class="form-control" readonly="readonly">'.$row['comment'].'"</textarea>
							  </div>';
					
								getStatusesForm($$menu_statuses,$row['status']);
								
						echo'<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
						  </form>';
					
				}else $_SESSION['danger'][] = 'Not found comment with ID:'.$_POST['comment_id'];
				
			}else $_SESSION['danger'][] = 'Not selected comment';
			
		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;	
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				
				$id = $_POST[$chain];
				echo '<h1 class="text-center">Do you realy wont to delete this comment ?</h1>
					  <form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="'.$id.'">
						<input type="submit" name="'.$chain.'" value="DELETE" class="btn btn-danger">
						<input type="submit" name="no" value="NO" class="btn btn-default">
					  </form>';
				
			}else $_SESSION['danger'][] = 'Not found comment with ID: '.$_POST['comment_id'];
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;	

}
	
?>
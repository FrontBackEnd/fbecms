<?php

switch($_POST['action']){
	
	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			echo '<h1 class="text-center">Add category</h1>
				  <form method="POST" action="">
				  	<div class="form-group">
				  		<label for="title">Title</label></p>
						<input id="title" type="text" name="data[title]" class="form-control">
					</div>
					
					<input type="submit" name="'.$save_chain.'" value="ADD" class="btn btn-success">
				  </form>';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
				
				$row = selectOne($table, mysqli_real_escape_string($conn,$id));
				
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit category</h1>
						  <form method="POST" action="">
						  	<input type="hidden" name="data['.$chain.']" value="'.$id.'">
						  
							  <div class="form-group">
								<label for="title">Title</label>
								<input id="title" type="text" name="data[title]" value="'.$row['title'].'" class="form-control">
							  </div>';
					
								getStatusesForm($$menu_statuses,$row['status']);
								
						echo'	<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
						  </form>';
					
				}else $_SESSION['danger'][] = 'Not found category with ID:'.$_POST['category_id'];
				
			}else $_SESSION['danger'][] = 'Not selected category';

		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;	
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				
			$id = $_POST[$chain];
			
			echo '<h1 class="text-center">Do you realy wont to delete this category ?</h1>
				  <form method="POST" action="">
					<input type="hidden" name="'.$chain.'" value="'.$id.'">
					<input type="submit" name="'.$save_chain.'" value="DELETE" class="btn btn-danger">
					<input type="submit" name="no" value="NO" class="btn btn-default">
				  </form>';
			
			}else $_SESSION['danger'][] = 'Not selected category';
			
		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;	

}
	
?>
<?php
switch($_POST['action']){
	
	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
			echo '<h1 class="text-center">Add slider</h1>
				  <form method="POST" action="" enctype="multipart/form-data">
				  	<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[title]" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="img">Image:</label>
						<input id="img" type="file" name="img"  >
					</div>
					
					<input type="submit" name="'.$save_chain.'" value="ADD" class="btn btn-success"> 
				  </form>';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];

				$row = selectOne($table,mysqli_real_escape_string($conn,$id));
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit slider</h1>
						 	 <form method="POST" action="" enctype="multipart/form-data">
						 		 <input type="hidden" name="data['.$chain.']" value="'.$id.'">
						  
								  <div class="form-group">
									<label for="title">Title</label>
									<input id="title" type="text" name="data[title]" value="'.$row['title'].'" class="form-control">
								  </div>
								  
								  <div class="form-group">
									<label for="slider_url">Link url</label>
									<input id="slider_url" type="text" name="data[slider_url]" value="'.$row['slider_url'].'" class="form-control">
								  </div>
						  
								  <div class="form-group">
								  	<label for="img">Image:</label>';
					
								if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
									echo '<img src="'.$allowed_image_settings[$next_file]['original_folder_url'].$row['img'].'" alt="" style="width:200px;height:200px;">
											 <div class="checkbox">
			         							 <label><input type="checkbox" value="delete" name="delete_slider_img">DELETE IMG</label>
			       							 </div>';
									
								}else echo '<input type="file" name="img" id="img"> ';
					
					echo '		<div class="form-group">
									<label for="position">Position</label>
									<input id="position" type="text" name="data[position]" value="'.$row['position'].'" class="form-control">
								  </div>';		
								
								
								getStatusesForm($$menu_statuses,$row['status']);
								
				echo'	 
						<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
					</form>';
					
				}else $_SESSION['danger'][] = 'Not found slider with ID:'.$_POST['article_id'];
				
			}else $_SESSION['danger'][] = 'Not selected slider';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				
				$id = $_POST[$chain];
				echo '<h1 class="text-center">Do you realy wont to delete this slider ?</h1>
					  <form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="'.$id.'">
						<input type="submit" name="'.$save_chain.'" value="DELETE" class="btn btn-danger">
						<input type="submit" name="no" value="NO" class="btn btn-default">
					  </form>';
				
			}else $_SESSION['danger'][] = 'Not selected slider';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
}
	

	
?>
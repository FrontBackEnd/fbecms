<?php
switch($_POST['action']){

	case 'ADD':
	
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			echo '<h1 class="text-center">Add '.$name.'</h1>
				  <form method="POST" action="" enctype="multipart/form-data">
					<input type="hidden" name="data[step_id]" value="'.$_POST['step_id'].'">
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[title]" class="form-control" required="required">
					</div>
					
					<div class="form-group">
						<label for="content">Content</label>
						<textarea id="content" name="data[content]" class="form-control"></textarea>
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
						
					echo '<h1 class="text-center">Edit '.$name.'</h1>
			
						  <form method="POST" action="" enctype="multipart/form-data">
						  <input type="hidden" name="data['.$chain.']" value="'.$id.'">

						 	<div class="form-group">
								<label for="title">Title</label>
								<input id="title" type="text" value="'.$row['title'].'" name="data[title]" class="form-control" required="required">
							</div>

							<div class="form-group">
								<label for="content">Content</label>
								<textarea id="content" name="data[content]" class="form-control">'.htmlspecialchars($row['content']).'</textarea>
							<div>				  
							
							<div class="form-group">
							  	<label for="img">Image:</label>';
					
								if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
									echo '<img src="'.$allowed_image_settings[$next_file]['original_folder_url'].$row['img'].'" alt="" style="width:200px;height:200px;">
											 <div class="checkbox">
			         							 <label><input type="checkbox" value="delete" name="delete_'.$name.'_img">DELETE IMG</label>
			       							 </div>';
									
								}else echo '<input type="file" name="img" id="img"> ';
					
					echo '	<div class="form-group">
								<label for="position">Position</label>
								<input id="position" type="text" value="'.$row['position'].'" name="data[position]" class="form-control" required="required">
							</div>';

						getStatusesForm($$menu_statuses,$row['status']);
					
					echo'	<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
						  </form>';
						
				}else $_SESSION['danger'][] = 'Not found '.$name.' with ID:'.$_POST[$chain];

			}else $_SESSION['danger'][] = 'Not selected '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;

	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){

			if(isset($_POST[$chain]) && !empty($_POST[$chain])){

				$id = $_POST[$chain];
				echo '<h1 class="text-center">Do you realy wont to delete this '.$name.' ?</h1>
					  <form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="'.$id.'">
						<input type="submit" name="'.$save_chain.'" value="DELETE" class="btn btn-danger">
						<input type="submit" name="no" value="NO" class="btn btn-default">
					  </form>';

			}else $_SESSION['danger'][] = 'Not selected '.$name;
			
		}else $_SESSION['danger'][] = 'Not allowed';
		break;

}

?>
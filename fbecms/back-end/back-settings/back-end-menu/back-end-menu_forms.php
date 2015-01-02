<?php
switch($_POST['action']){

	case 'ADD':

		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
		echo '<h1 class="text-center">Add '.$name.'</h1>
				  <form method="POST" action="">
					<input type="hidden" name="data[part_id]" value="'.$_POST['part_id'].'">
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[title]" class="form-control" required="required">
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
	
				$roles = selectAll('b_roles');
				
				if(isset($row) && !empty($row)){
					
					$permision = explode(', ',$row['privs']);
	
					
					echo '<h1 class="text-center">Edit '.$name.'</h1>
			
							  <form method="POST" action="">
							  <input type="hidden" name="data['.$chain.']" value="'.$id.'">
	
							 	<div class="form-group">
									<label for="title">Title</label>
									<input id="title" type="text" value="'.$row['title'].'" name="data[title]" class="form-control" required="required">
								</div>
											
								<div class="form-group">
									<label for="upload_images">Content type</label>					
									<select name="data[content_type]" class="form-control">';
		
									foreach($content_types AS $key =>  $content_type){
										if(isset($row['content_type']) && !empty($row['content_type']) && $row['content_type'] == $key) $sel = ' selected="selected"';
										else $sel = '';
										
										echo '<option value="'.$key.'"'.$sel.'>'.$content_type.'</option>';
									}							
											
						echo 	'	</select>							
								</div>
								
								<div class="form-group">
									<label for="plugin_table">Data table</label>
									<input id="plugin_table" type="text" value="'.$row['plugin_table'].'" name="data[plugin_table]" class="form-control" >
								</div>			
											
								<div class="form-group">
									<label for="statuses">Statuses</label>
									<textarea id="statuses" name="data[statuses]" class="form-control">'.$row['statuses'].'</textarea>
								</div>
														
								<div class="form-group">
									<label for="upload_images">Upload Images</label>
									<select id="upload_images" name="data[upload_images]"  class="form-control">';
									if($row['upload_images'] == 1){
										echo '<option value="0">No</option>
											  <option value="1" selected="selected">Yes</option>';
										
									}else{
										echo '<option value="0">No</option>
											  <option value="1">Yes</option>';
									}	
					echo		'	</select>
								</div>	
													
								<div class="form-group">
									<label for="position">Position</label>
									<input id="position" type="text" value="'.$row['position'].'" name="data[position]" class="form-control" required="required">
								</div>			
											
								<div class="form-group">';
								foreach($roles AS $role){
									if(in_array($role['id'],$permision)) $checked = 'checked="checked"';
									else $checked = '';
									
									echo'<div class="checkbox">
										  <label><input type="checkbox" name="data[privs]['.$role['id'].']" '.$checked.'>'.$role['title'].'</label>
										</div>';
								}			
					echo'		</div>';	
								
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
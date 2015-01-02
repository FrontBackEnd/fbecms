<?php
switch($_POST['action']){

	case 'ADD':
	
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			echo '<h1 class="text-center">Add '.$name.'</h1>
				  <form method="POST" action="">
					<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[page_title]" class="form-control" required="required">
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
			
						  <form method="POST" action="">
						  <input type="hidden" name="data['.$chain.']" value="'.$id.'">

						 	<div class="form-group">
								<label for="title">Title</label>
								<input id="title" type="text" value="'.$row['page_title'].'" name="data[page_title]" class="form-control" required="required">
							</div>
										
							<div class="form-group">
								<label for="title">Page description</label>
								<textarea name="data[page_description]" class="form-control">'.$row['page_description'].'</textarea>	
							</div>		
										
							<div class="form-group">
								<label for="title">Page keywords</label>
								<textarea name="data[page_keywords]" class="form-control">'.$row['page_keywords'].'</textarea>	
							</div>
							
							<div class="form-group">
								<label for="template">Template</label>
								<select id="template" name="data[template_id]" class="form-control">';
					
							foreach($templates AS $key => $name){
								if(isset($row['template_id']) && !empty($row['template_id']) && $row['template_id'] == $key) $sel =' selected="selected"';
								else $sel ='';
								echo'<option value="'.$key.'"'.$sel.'>'.$name.'</option>';
							}
					
					echo'		</select>
							</div>
							
							<div class="form-group">
								<div class="checkbox">';
					
								if($row['homepage'] == 1) $checked = 'checked="checked"';
								else $checked = '';
					
								echo'  <label><input type="checkbox" name="data[homepage]" '.$checked.'>Homepage</label>
					 			</div>
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
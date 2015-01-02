<?php
switch($_POST['action']){

	case 'ADD':
	
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			$template = selectOneByRow('f_pages','id',$_POST['page_id'],'`template_id`');
			$template_parts = selectAll('f_templates_parts','*'," WHERE `template_id` = '".$template['template_id']."' ORDER BY `position` ASC");
			
			echo '<h1 class="text-center">Add '.$name.'</h1>
				  <form method="POST" action="">
					<input type="hidden" name="data[page_id]" value="'.$_POST['page_id'].'">';	
					
			echo '	<div class="form-group">
						<label for="template_part">Template part</label>
						<select id="template_part" name="data[template_part]" class="form-control">';
						foreach($template_parts AS $part) echo '<option value="'.$part['id'].'">'.$part['title'].'</option>';
				echo '	</select>		
					</div>
					
					<div class="form-group">
						<label for="plugin_part">Content</label>
						<select id="plugin_part" name="data[plugin_part]" class="form-control">';
						foreach($plugin_parts AS $name => $part) echo '<option value="'.$part.'">'.$name.'</option>';
				echo '	</select>		
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

				$template = selectOneByRow('f_pages','id',$row['page_id'],'`template_id`');
				$template_parts = selectAll('f_templates_parts','*'," WHERE `template_id` = '".$template['template_id']."' ORDER BY `position` ASC");
				
				$pages = selectAll('f_pages');
				
				if(isset($row) && !empty($row)){
						
					echo '<h1 class="text-center">Edit '.$name.'</h1>
			
						  <form method="POST" action="">
						  <input type="hidden" name="data['.$chain.']" value="'.$id.'">';
					
					
					echo '	<div class="form-group">
								<label for="template_part">Template part</label>
								<select id="template_part" name="data[template_part]" class="form-control">';
								foreach($template_parts AS $part){
									if($row['template_part'] == $part['id']) $sel = 'selected="selected"';
									else $sel ='';
									
									echo '<option value="'.$part['id'].'"'.$sel.'>'.$part['title'].'</option>';
								}
						echo '	</select>		
							</div>
						
							<div class="form-group">
								<label for="plugin_part">Content</label>
								<select id="plugin_part" name="data[plugin_part]" class="form-control">';
								foreach($plugin_parts AS $name => $part){
									if($row['plugin_part'] == $part) $sel = 'selected="selected"';
									else $sel ='';
									
									echo '<option value="'.$part.'"'.$sel.'>'.$name.'</option>';
								}
						echo '	</select>		
							</div>
							
							<div class="form-group">
								<select name="data[link_page]" class="form-control">
								<option value="0"> -- </option>';
								foreach($pages AS $page){
									if($row['link_page'] == $page['id']) $sel = 'selected="selected"';
									else $sel ='';
									
									echo '<option value="'.$page['id'].'"'.$sel.'>'.$page['page_title'].'</option>';
								}
						echo '	</select>		
							</div>
							
							<div class="form-group">
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
<?php
switch($_POST['action']){
	
	case 'ADD':
	
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			echo '<h1 class="text-center">Add '.$name.'</h1>
				  <form method="POST" action="">
				  	<div class="form-group">
						<label for="email">E-mail</label>
						<input id="email" type="email" name="data[email]" class="form-control" required="required">
					<div>
					<div class="form-group">
						<label for="password">Password</label>
						<input id="password" type="password" name="data[password]" class="form-control" required="required">
					</div>
					<div class="form-group">
						<label for="role">Role:</label>
						<select id="role" name="data[role]" class="form-control">';
						foreach($roles AS $key => $role) echo'<option value="'.$key.'">'.$role.'</option>';
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
				
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit '.$name.'</h1>
					
						  <form method="POST" action="">
						  <input type="hidden" name="data['.$chain.']" value="'.$id.'">
						  
						 	<div class="form-group">
						  		<label for="email">E-mail</label>
								<input id="email" type="text" name="email" value="'.$row['email'].'" class="form-control" readonly="readonly">
							</div>
							
							<div class="form-group">
								<label for="password">Password</label>
								<input id="password" type="password" name="data[password]" value="" class="form-control">
							</div>
							
							<div class="form-group">
								<label for="role">Role:</label>
								<select id="role" name="data[role]"  class="form-control">';
												
								foreach($roles AS $key => $role){
									if($row['role'] == $key) $sel = ' selected="selected"';
									else $sel = '';
									echo '<option value="'.$key.'"'.$sel.'>'.$role.'</option>';
								}
						echo '	</select>
							</div>';
								
							getStatusesForm($$menu_statuses,$row['status']);
								
					echo '	<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
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
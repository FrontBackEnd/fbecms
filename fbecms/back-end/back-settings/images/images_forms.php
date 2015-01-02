<?php
switch($_POST['action']){
	
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
				
				$row = selectOne($table,mysqli_real_escape_string($conn,$id));
				
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Update '.$name.'</h1>
							<form action="" method="POST">
							 <input type="hidden" name="data['.$chain.']" value="'.$id.'">
							<div class="panel panel-default">
							  <div class="panel-body">
							  <input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-success">
							  </div>
							  	<div class="panel-footer">
							  		
									<div class="panel panel-default">
									  <div class="panel-heading"><b>Allowed images extensions</b></div>
									  <ul class="list-group">
									  	<li class="list-group-item">
											<textarea id="allow_extensions" name="data[allow_extensions]" class="form-control">'.$row['allow_extensions'].'</textarea>
										</li>
									  </ul>
									</div>
													
									<div class="panel panel-default">
									  <div class="panel-heading"><b>Allowed images files</b></div>
									  <ul class="list-group">
									    <li class="list-group-item">
											<textarea id="allow_files" name="data[allow_files]" class="form-control">'.$row['allow_files'].'</textarea>
										</li>
									  </ul>
									</div>
													
									<div class="panel panel-default">
									  <div class="panel-heading"><b>Allowed images size</b></div>
									  <ul class="list-group">
									    <li class="list-group-item">
											<textarea id="max_size" name="data[max_size]" class="form-control">'.$row['max_size'].'</textarea>
										</li>
									  </ul>
									</div>
									<div class="panel panel-default">
									  <div class="panel-heading"><b>Allowed images thumbs</b></div>
									  <ul class="list-group">
									    <li class="list-group-item">
											<textarea id="thumbs" name="data[thumbs]" class="form-control">'.$row['thumbs'].'</textarea>
										</li>
									  </ul>
									</div>
													
									<div class="panel panel-default">
									  <div class="panel-heading"><b>Original images upload folder</b></div>
									  <ul class="list-group">
									    <li class="list-group-item">
									    	<label for="thumbs">'.WEB_DIR.'upload/images/</label>
											<textarea id="thumbs" name="data[original_folder]" class="form-control">'.$row['original_folder'].'</textarea>
										</li>
									  </ul>
									</div>

									<div class="panel panel-default">
									  <div class="panel-heading"><b>Thumbs images upload folder</b></div>
									  <ul class="list-group">
									    <li class="list-group-item">
									    	<label for="thumbs">'.WEB_DIR.'upload/images/</label>
											<textarea id="thumbs" name="data[thumbs_folder]" class="form-control">'.$row['thumbs_folder'].'</textarea>
										</li>
									  </ul>
									</div>					
													
								</div>
							</div>
						</form>';
					
					
				}else $_SESSION['danger'][] = 'Not found '.$name.' with ID:'.$_POST[$chain];
				
			}else $_SESSION['danger'][] = 'Not selected '.$name;	
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
	
}
<?php
switch($_POST['action']){
	
	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
			$categories = selectAll('p_categories');
			
			echo '<h1 class="text-center">Add article</h1>
				  <form method="POST" action="" enctype="multipart/form-data">
				  	<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[title]" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="intro_text">Intro text</label>
						<input id="intro_text" type="text" name="data[intro_text]" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="content">Content</label>
						<textarea id="content" name="data[content]" class="form-control"></textarea>
					</div>
					
					<div class="form-group">
						<label for="img">Image:</label>
						<input id="img" type="file" name="img"  >
					</div>
					
					<div class="form-group">
						<label for="category">Category</label>
						<select id="category" name="data[category_id]" class="form-control">
							<option value="0">Select category</option>';
						if(isset($categories) && !empty($categories)){
							foreach($categories AS $category){
							echo '<option value="'.$category['id'].'">'.$category['title'].'</option>';
							}
						}
			echo'	   </select>
					</div>
					
					<div class="form-group">
						<label for="comments">Comments:</label>
						<select id="comments" name="data[comments]" class="form-control">';
							foreach($articleComments AS $key => $status) echo '<option value="'.$key.'">'.$status.'</option>';
			echo'		</select>
					</div>
					
					<input type="submit" name="'.$save_chain.'" value="ADD" class="btn btn-success"> 
				  </form>';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];
				
				$categories = selectAll('p_categories');
				
				$row = selectOne($table,mysqli_real_escape_string($conn,$id));
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit article</h1>
						 	 <form method="POST" action="" enctype="multipart/form-data">
						 		 <input type="hidden" name="data[article_id]" value="'.$id.'">
						  
								  <div class="form-group">
									<label for="title">Title</label>
									<input id="title" type="text" name="data[title]" value="'.$row['title'].'" class="form-control">
								  </div>
						  
								  <div class="form-group">
									<label for="intro_text">Intro text</label>
									<input id="intro_text" type="text" name="data[intro_text]" value="'.$row['intro_text'].'" class="form-control">
								  </div>
						  
								  <div class="form-group">
									<label for="content">Content</label>
									<textarea id="content" name="data[content]" class="form-control">'.$row['content'].'</textarea>
								  <div>
						  
								  <div class="form-group">
								  	<label for="img">Image:</label>';
					
								if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
									echo '<img src="http://localhost/FBEcms/upload/images/original/'.$row['img'].'" alt="" style="width:200px;height:200px;">
											 <div class="checkbox">
			         							 <label><input type="checkbox" value="delete" name="delete_article_img">DELETE IMG</label>
			       							 </div>';
									
								}else echo '<input type="file" name="img" id="img"> ';
							
							echo' <div>
					
								  <div class="form-group">
									<label for="category">Category</label></p>
		 							<select id="category" name="data[category_id]" class="form-control">
										<option value="0">Select category</option>';
										if(isset($categories) && !empty($categories)){
											foreach($categories AS $category){
												if(isset($row['category_id']) && !empty($row['category_id']) && $row['category_id'] == $category['id']) $sel = ' selected="selected"';
												else $sel = '';
												echo '<option value="'.$category['id'].'"'.$sel.'>'.$category['title'].'</option>';
											}
										}
							echo'	</select>
								</div>';
					
								getStatusesForm($$menu_statuses,$row['status']);
					
								getStatusesForm($$menu_statuses,$row['fearured'],'fearured');
								
								getStatusesForm($$menu_statuses,$row['exclusive'],'exclusive');
								
								getStatusesForm($$menu_statuses,$row['comments'],'comments');
								
				echo'	 <input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
					</form>';
					
				}else $_SESSION['danger'][] = 'Not found article with ID:'.$_POST['article_id'];
				
			}else $_SESSION['danger'][] = 'Not selected article';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				
				$id = $_POST[$chain];
				echo '<h1 class="text-center">Do you realy wont to delete this article ?</h1>
					  <form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="'.$id.'">
						<input type="submit" name="'.$save_chain.'" value="DELETE" class="btn btn-danger">
						<input type="submit" name="no" value="NO" class="btn btn-default">
					  </form>';
				
			}else $_SESSION['danger'][] = 'Not selected article';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
}
	

	
?>
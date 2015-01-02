<?php
switch($_POST['action']){
	
	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
		
			echo '<h1 class="text-center">Add blog article</h1>
				  <form method="POST" action="" enctype="multipart/form-data">
				  	<div class="form-group">
						<label for="title">Title</label>
						<input id="title" type="text" name="data[title]" class="form-control">
					</div>
					
					<div class="form-group">
						<label for="intro_text">Intro text</label>
						<textarea id="intro_text" name="data[intro_text]" class="form-control"></textarea>
					</div>';
			
					getStatusesForm($$menu_statuses,false,'comments');
					
			echo'	<input type="submit" name="'.$save_chain.'" value="ADD" class="btn btn-success"> 
				  </form>';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
		
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				$id = $_POST[$chain];

				$row = selectOne($table,mysqli_real_escape_string($conn,$id));
				if(isset($row) && !empty($row)){
					
					echo '<h1 class="text-center">Edit blog article</h1>
						 	 <form method="POST" action="" enctype="multipart/form-data">
						 		 <input type="hidden" name="data['.$chain.']" value="'.$id.'">
						  
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
								  <div>';
					
								getStatusesForm($$menu_statuses,$row['comments'],'comments');
					
								getStatusesForm($$menu_statuses,$row['status']);
								
								
				echo'<input type="submit" name="'.$save_chain.'" value="UPDATE" class="btn btn-default">
					</form>';
					
				}else $_SESSION['danger'][] = 'Not found blog article with ID:'.$_POST['article_id'];
				
			}else $_SESSION['danger'][] = 'Not selected blog article';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
		
			if(isset($_POST[$chain]) && !empty($_POST[$chain])){
				
				$id = $_POST[$chain];
				echo '<h1 class="text-center">Do you realy wont to delete this blog article ?</h1>
					  <form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="'.$id.'">
						<input type="submit" name="'.$save_chain.'" value="DELETE" class="btn btn-danger">
						<input type="submit" name="no" value="NO" class="btn btn-default">
					  </form>';
				
			}else $_SESSION['danger'][] = 'Not selected blog article';
	
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
}
	

	
?>
<?php
switch($_POST[$save_chain]){

	case 'ADD':
		
		if(checkPermission($_SESSION['role'], 'add', dirname(__FILE__))){
			
			$data = $_POST['data'];
			$data['blog_url'] = getProperUrl($data['title']);
			$data['created_date'] = date("Y-m-d H:i:s",time());
			$data['created_user'] = $_SESSION['user'];
			
			$sql = insertData($table,$data);
			
			if(mysqli_query($conn,$sql)){
				
				if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
					
					$id = mysqli_insert_id($conn);

					ImgCreation($_FILES, $id, $data['blog_url'], $table, $next_file);
				}
				
				$_SESSION['success'][] = 'Blog article added';
				
			}else $_SESSION['danger'][] = 'Error while adding blog article';
		
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'UPDATE':
			
		if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))){
			
			
			$data = $_POST['data'];
			$update_id = $data[$chain];
			unset($data[$chain]);
			
			$data['blog_url'] = getProperUrl($data['title']);
			$data['changed_date'] = date("Y-m-d H:i:s",time());
			$data['changed_user'] = $_SESSION['user'];
			
			if(isset($_POST['delete_article_img']) && !empty($_POST['delete_article_img']) && $_POST['delete_article_img'] == 'delete'){
			
				if(deleteImg($update_id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
				else $_SESSION['danger'][] = 'Not deleted Img';
			}
			

			if(isset($_FILES["img"]["name"]) && !empty($_FILES["img"]["name"])){
				
				ImgCreation($_FILES, $update_id, $data['article_url'], $table, $next_file);
			}
			
			$sql = updateData($table,$data,'id',$update_id);
				
			if(mysqli_query($conn,$sql)) $_SESSION['info'][] = 'Article updated';
			else $_SESSION['danger'][] = 'Error while updating img';
			
		}else $_SESSION['danger'][] = 'Not allowed';
		
		break;
		
	case 'DELETE':
		
		if(checkPermission($_SESSION['role'], 'delete', dirname(__FILE__))){
			
			$id = $_POST[$chain];
			
			if(deleteImg($id,$next_file)) $_SESSION['danger'][] = 'Img deleted';
			
			$sql = deleteData($table,'id',mysqli_real_escape_string($conn,$id));
		
			if(mysqli_query($conn,$sql)){
				deleteAllComments($id,'p_blog_comments');
				$_SESSION['danger'][] = 'Blog article deleted';
			}else $_SESSION['danger'][] = 'Error while deleting img';
			
		}else $_SESSION['danger'][] = 'Not allowed';
			
		break;
	
}

?>
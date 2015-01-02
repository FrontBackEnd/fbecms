<?php
if(isset($part2) && !empty($part2)){
						
	if(isset($_POST['save_comment']) && !empty($_POST['save_comment']) && $_POST['save_comment'] == 'Comment'){
			
		if(isset($_POST['commentator']) && !empty($_POST['commentator'])){
			if(isset($_POST['comment']) && !empty($_POST['comment'])){
					
				$data['article_id'] = mysqli_real_escape_string($conn,$_POST['article_id']);
				$data['commentator'] = mysqli_real_escape_string($conn,$_POST['commentator']);
				$data['comment'] = mysqli_real_escape_string($conn,$_POST['comment']);
				$data['created_date'] = date("Y-m-d H:i:s",time());
					
				$sql = insertData('p_comments',$data);
				if(mysqli_query($conn,$sql)) $out.=  '<div class="alert alert-success" role="alert">Comment added</div>';
					
			}else $out.=  '<div class="alert alert-danger" role="alert">Please enter comment</div>';

		}else $out.=  '<div class="alert alert-danger" role="alert">Please enter commentator</div>';
	}


	$article = selectOneByRow('p_articles','article_url',mysqli_real_escape_string($conn,$part2));
	if(isset($article) && !empty($article)){
		$cat = selectOne('p_categories',mysqli_real_escape_string($conn,$article['category_id']));

			
		$out.=  '<article>
					<div class="media">';
		if(isset($article['img']) && !empty($article['img']) && $article['img'] !=' '){
			$out.=  '<img src="'.WEB_PAGE.'upload/thumbs/200x150-'.$article['img'].'" alt="'.$article['title'].'" class="pull-left" style="margin-top:25px;">';
		}

		$out.=  '	<div class="media-body">
						<h1>'.$article['title'].'</h1>
						<p>Category: <span class="text-info">'.$cat['title'].'</span></p>
						<p>Publish date: <time datetime="'.$article['published_date'].'">'.date("d.m.Y H:i:s",strtotime($article['published_date'])).'</time></p>
						<em class="lead">'.$article['intro_text'].'</em>
						<p>'.$article['content'].'</p>
						<button onclick="goBack()" class="btn btn-default">Back</button>
						<div class="pull-right">Share on:<div class="addthis_sharing_toolbox"></div></div>';

		$comments = selectAll('p_comments','*'," WHERE `article_id` ='".mysqli_real_escape_string($conn,$article['id'])."' ORDER BY `created_date` DESC");
			
		if(isset($comments) && !empty($comments) && $comments != false){
			$out.=  '<h3>Comments<h3>
						<div class="list-group">';
				
				foreach($comments AS $comment){
						$out .= '<a class="list-group-item"><h4 class="list-group-item-heading">'.$comment['commentator'].'<span class="small pull-right">'.date('d.m.Y (H:i:s)',strtotime($comment['created_date'])).'</span></h4><p class="list-group-item-text small">'.$comment['comment'].'</p></a>';
				}
			$out.=  '	</div>';
		}

		if($article['comments'] == '1'){
				
			$out.=  '<h4>Comment article</h4>

						  <form method="POST" action="">
						  	<input type="hidden" name="article_id" value="'.$article_id.'" >
					
						  	<div class="form-group">
						  		<label for="commentator">Commentator</label>
						  		<input type="text" name="commentator" class="form-control">
						  	</div>
					
						  	<div class="form-group">
						  		<label for="comment">Comment</label>
						  		<textarea id ="comment" name="comment" class="form-control"></textarea>
						  	</div>
						  	<input type="submit" name="save_comment" value="Comment" class="btn btn-info">
						  </form>';
		}

		$out.=  '</div>
				 <div>
			 </article>
			  <script>
				function goBack() {
				    window.history.back()
				}
			  </script>';
	}

}else $out.=  '<p>Not selected article</p>';	

?>
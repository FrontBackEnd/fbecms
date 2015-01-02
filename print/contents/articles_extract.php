<?php

$articles = selectAll('p_articles','*'," WHERE `status` ='1' AND `featured` = '1' ORDER BY `published_date` LIMIT 4");
if(isset($articles) && !empty($articles) && $articles !=false){
	
$out .=	'<div class="row" style="margin-top:20px;">';
	
	foreach($articles AS $row){
		$category = selectOne('p_categories',mysqli_real_escape_string($conn,$row['category_id']),'`title`');
		
		$article_url = WEB_PAGE.$LINK_PAGE.'/'.$row['article_url'].'/';
		
		
		if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
			  $img = '<a href="'.$article_url.'"><img src="'.WEB_PAGE.'upload/thumbs/200x150-'.$row['img'].'" alt="'.$row['title'].'" class="img-responsive"></a>';
		}else $img = '<a href="'.$article_url.'"><img src="'.WEB_PAGE.'img/200x150-articlePage.png" alt="'.$row['title'].'" class="img-responsive"></a>';
			 
$out .=	 '<div class="col-sm-4 col-md-3" style="height:500px;margin-top:20px;">
		    <div class="thumbnail">
			  '.$img.'
		      <div class="caption">
		      	<p>Category: <span class="text-info">'.$category['title'].'</span></p>
		        <p>Publish date: <time class="text-info" datetime="'.$row['published_date'].'">'.date("d.m.Y H:i:s",strtotime($row['published_date'])).'</time></p>
		        <h4><a href="'.$article_url.'">'.$row['title'].'</a></h4>
		        <p>'.$row['intro_text'].'</p>
		      </div>
		    </div>
		  </div>';
		
	}
}	
	
$out .='</div>';

?>
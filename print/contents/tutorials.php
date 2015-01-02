<?php

$tutorials = selectAll('p_tutorial','*'," ORDER BY `position` ASC");

if(isset($tutorials) && !empty($tutorials)){
	
	foreach($tutorials AS $row){
		
		$tutorial_url = WEB_PAGE.$LINK_PAGE.'/'.$row['tutorial_url'].'/';
		
		if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
			  $img = '<a href="'.$tutorial_url.'" class="media-left pull-left"><img src="'.WEB_PAGE.'upload/images/tutorials/tutorial/thumbs/200x150-'.$row['img'].'" alt="'.$row['title'].'" class="img-responsive"></a>';
		}else $img = '<a href="'.$tutorial_url.'" class="media-left pull-left"><img src="'.WEB_PAGE.'img/200x150-articlePage.png" alt="'.$row['title'].'" class="img-responsive"></a>';
			 
		$out .=	 '	<div class="media">
			      		'.$img.'
				    	<div class="media-body">
				        	<h4 class="media-heading"><a href="'.$tutorial_url.'">'.$row['title'].'</a></h4>
				        	 <p>Publish date: <time class="text-info" datetime="'.$row['created_date'].'">'.date("d.m.Y H:i:s",strtotime($row['created_date'])).'</time></p>
					         <em>'.$row['intro_text'].'</em>
				     	</div>
				    </div>';
	}
	
}



?>
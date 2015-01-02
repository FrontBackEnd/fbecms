<?php
$exclusive_articles = selectAll('p_articles','*'," WHERE `exclusive` = '1' ");

if(isset($exclusive_articles) && !empty($exclusive_articles)){
	foreach($exclusive_articles AS $exclusive){
		
		if(isset($exclusive['img']) && !empty($exclusive['img']) && $exclusive['img'] != ' '){
		  	  $e_img = '<img src="'.WEB_PAGE.'upload/original/'.$exclusive['img'].'" alt="'.$exclusive['title'].'" class="img-responsive" style="height:320px;width:100%;border-radius:10px;">';
		}else $e_img = '<img src="'.WEB_PAGE.'img/1200x500-articlePage.png" alt="'.$exclusive['title'].'" class="img-responsive" style="height:320px;width:100%;border-radius:10px;">';
	
		$article_url = WEB_PAGE.$LINK_PAGE.'/'.$exclusive['article_url'].'/';
		
		$out .=	'<div class="col-sm-3 col-md-6" >
		
					<article style="margin-top:20px;border:1px solid #b8b8b8;border-radius:10px;box-shadow:0px 0px 5px #888888">
						'.$e_img.'
						<p style="position:relative;margin:-35px 0 0 0px;padding:5px 0px 5px 20px;font-size:18px;width:100%;background-color: rgba(73, 44, 54, 0.8);border-radius:0 0 8px 8px;">
							<a style="color:#fff;" href="'.$article_url.'">'.$exclusive['title'].'</a>
						</p>
					</article>
				</div>';
		
	}	
}






?>
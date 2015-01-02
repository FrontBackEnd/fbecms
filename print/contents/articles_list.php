<?php

if(isset($part2) && !empty($part2)) $cat = selectOneByRow('p_categories','category_url',mysqli_real_escape_string($conn,$part2));
else $cat = selectFirstCategory();


$exclusive = getExclusiveArticle($cat['id']);

if(isset($exclusive) && !empty($exclusive) && $exclusive != false){
	
	if(isset($exclusive['img']) && !empty($exclusive['img']) && $exclusive['img'] != ' '){
		  $e_img = '<img src="'.WEB_PAGE.'upload/original/'.$exclusive['img'].'" alt="'.$exclusive['title'].'" class="img-responsive" style="height:250px;width:100%;border-radius:10px;">';
	}else $e_img = '<img src="'.WEB_PAGE.'img/1200x500-articlePage.png" alt="'.$exclusive['title'].'" class="img-responsive" style="height:250px;width:100%;border-radius:10px;">';
	
	$article_url = WEB_PAGE.$LINK_PAGE.'/'.$exclusive['article_url'].'/';
	
	$out .=	'<div class="col-sm-3 col-md-12" >
				<article style="margin-bottom:20px;border:1px solid #fff;border-radius:10px;">
					'.$e_img.'
					<p style="position:relative;margin:-40px 0 0 0px;padding:5px 0px 5px 20px;font-size:22px;width:100%;background-color: rgba(73, 44, 54, 0.8);border-radius:0 0 10px 10px;">
						<a style="color:#fff;" href="'.$article_url.'">'.$exclusive['title'].'</a>
					</p>
				</article>
			</div>	';
}

if(isset($exclusive['id']) && !empty($exclusive['id'])) $ex_article = " AND `id` != '".$exclusive['id']."'";
else $ex_article = '';


$num_per_page = 3;
$articles_num = selectAll('p_articles','*'," WHERE `status` ='1' AND `category_id` = '".$cat['id']."'$ex_article ORDER BY `published_date`");
$num_all = count($articles_num);
if($num_all / $num_per_page > 1){
	if($num_all % $num_per_page == 0) $pages = $num_all / $num_per_page;
	else $pages = floor($num_all / $num_per_page) + 1;
}else $pages = 0;

if(isset($part3) && !empty($part3)) $page_num = $part3;
else $page_num = 1;


if($page_num == 1) $limit = " LIMIT 0,".$num_per_page;
else $limit = " LIMIT ".$num_per_page*($page_num-1).','.$num_per_page;


$articles = selectAll('p_articles','*'," WHERE `status` ='1' AND `category_id` = '".$cat['id']."'$ex_article ORDER BY `published_date` $limit");
if(isset($articles) && !empty($articles) && $articles !=false){

	foreach($articles AS $row){
		$category = selectOne('p_categories',mysqli_real_escape_string($conn,$row['category_id']),'`title`');
		
		$article_url = WEB_PAGE.$LINK_PAGE.'/'.$row['article_url'].'/';
		
		
		if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
			  $img = '<a href="'.$article_url.'"><img src="'.WEB_PAGE.'upload/thumbs/200x150-'.$row['img'].'" alt="'.$row['title'].'" class="img-responsive"></a>';
		}else $img = '<a href="'.$article_url.'"><img src="'.WEB_PAGE.'img/200x150-articlePage.png" alt="'.$row['title'].'" class="img-responsive"></a>';
			 
		$out .=	 '<div class="col-sm-3 col-md-4" >
				    <div class="thumbnail" style="min-height:480px;">
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
	
	if($pages > 1){
		
		$out .= '<nav style="clear:both;display:block;">
				  <ul class="pagination" style="margin:30px auto;display:table;">';
						
					if(isset($page_num) && !empty($page_num) && $page_num == 1) $first_page = ' class="disabled"';
					else $first_page = '';
		
					$out .= '<li'.$first_page.'><a href="'.WEB_PAGE.$part1.'/'.$part2.'/1/"><span aria-hidden="true">&laquo;</span><span class="sr-only">First</span></a></li>';

					$i = 1;
					while($i<=$pages){
						if(isset($page_num) && !empty($page_num) && $page_num == $i) $sel_page = ' class="active"';
						else $sel_page = '';
						
						$out .='<li'.$sel_page.'><a href="'.WEB_PAGE.$part1.'/'.$part2.'/'.$i.'/">'.$i.'</a></li>';
						$i++;
					}
		
					if(isset($page_num) && !empty($page_num) && $page_num == $pages) $last_page = ' class="disabled"';
					else $last_page = '';
					
					$out .= '<li'.$last_page.'><a href="'.WEB_PAGE.$part1.'/'.$part2.'/'.$pages.'/"><span aria-hidden="true">&raquo;</span><span class="sr-only">Last</span></a></li>';
					
			$out .= ' </ul>
				</nav>';
		
	}
	
	
}	

?>
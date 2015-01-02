<?php

if(isset($part2) && !empty($part2)) $sel_cat = selectAll('p_faq_categories','*'," WHERE `category_url` = '$part2' ORDER BY `position` ASC LIMIT 1");
else $sel_cat = selectAll('p_faq_categories','*'," WHERE `status` = '1' ORDER BY `position` ASC LIMIT 1");


$faq_categories = selectAll('p_faq_categories','*'," WHERE `status` = '1' ORDER BY `position` ASC ");

if(isset($faq_categories) && !empty($faq_categories)){
	
	$out .= '<div class="col-sm-3 col-md-2 pull-left">
				<nav>
					<ul class="nav nav-pills nav-stacked " role="tablist">';
					foreach($faq_categories AS $faq_category){
						$category_url = WEB_PAGE.$LINK_PAGE.'/'.$faq_category['category_url'].'/';
						
						if(isset($sel_cat[0]) && !empty($sel_cat[0]) && $sel_cat[0]['id'] == $faq_category['id']) $sel = ' class="active"';
						else $sel = '';
						
						$out .= '<li'.$sel.' role="presentation"><a href="'.$category_url.'">'.$faq_category['title'].'</a></li>';
					}
			$out .= '</ul>
				</nav>
			</div>';
}

if(isset($sel_cat[0]['id']) && !empty($sel_cat[0]['id'])){
	$faq = selectAll('p_faq','*'," WHERE `category_id` = '".$sel_cat[0]['id']."' AND `status` = '1' ORDER BY `position` ASC");
	
	if(isset($faq) && !empty($faq)){
		$out .= '<div class="col-md-10 pull-right" >';
		foreach($faq AS $question){
			$out .= '<article>
						<h1>'.$question['question'].'</h1>
						<p>'.$question['answer'].'</p>
			
					 </article>';
			
			
		}
		$out .= '</div>';
	}
	
}




?>
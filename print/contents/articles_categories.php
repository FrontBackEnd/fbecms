<?php

$categories = selectAll('p_categories');

$out .= '<nav>
			<ul class="nav nav-pills nav-stacked " role="tablist">';
			foreach($categories AS $category){
				$category_url = WEB_PAGE.$LINK_PAGE.'/'.$category['category_url'].'/';
				
				if(isset($cat) && !empty($cat) && $cat['id'] == $category['id']) $sel = ' class="active"';
				else $sel = '';
				
				$out .= '<li'.$sel.' role="presentation"><a href="'.$category_url.'">'.$category['title'].'</a></li>';
			}
	$out .= '</ul>
		</nav>';


?>
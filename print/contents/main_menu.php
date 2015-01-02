<?php

$menu = selectOneByRow('f_menu','main','1');
$links = selectAll('f_menu_links','*'," WHERE `menu_id` = '".$menu['id']."' ORDER BY `position` ASC");

$out .= '<nav class="navbar navbar-default" role="navigation">
			<div class="container">
				<ul class="nav '.$menu['style'].'">';
				foreach($links AS $link){
					$page = selectOne('f_pages',$link['page_id']);
					if($page_data['page_url'] == $page['page_url']) $sel = ' class="active"';
					else $sel = '';
					$out .= '<li'.$sel.' style="margin-top:4px;"><a href="'.WEB_PAGE.$page['page_url'].'/">'.$link['title'].'</a></li>';	
					
				}
$out .= '		</ul>
			</div>
		</nav>';
?>
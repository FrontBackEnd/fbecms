<?php

$months = selectAll('p_blog','`created_date`,`id`'," WHERE `status` = '1' ORDER BY `created_date` DESC");

$blog_y_m = array();
foreach($months AS $month) $blog_y_m[date('Y',strtotime($month['created_date']))][date('m',strtotime($month['created_date']))][] = $month['id'];


if(isset($part2) && !empty($part2)){
	$sel_date = explode('-',$part2);
	$sel_year = $sel_date[0];
	$sel_month = $sel_date[1];

}else{
	$sel_year = key($blog_y_m);
	$sel_month = key($blog_y_m[$sel_year]);
}

	$out .='<div class="col-sm-3 col-md-2 pull-left">
				<nav>
					<ul class="nav nav-pills nav-stacked " role="tablist">';
	foreach($blog_y_m AS $blog_y => $blog){
		foreach($blog AS $blog_m => $b){
			
			if((isset($sel_year) && !empty($sel_year) && $sel_year == $blog_y) && (isset($sel_month) && !empty($sel_month) && $sel_month == $blog_m)) $sel = ' class="active"';
			else $sel = '';
			
			$out .= '<li'.$sel.' role="presentation"><a href="'.WEB_PAGE.$LINK_PAGE.'/'.$blog_y.'-'.$blog_m.'/">'.$blog_m.','.$blog_y.'</a></li>'; 
		}
	}
	$out .= '		</ul>
				</nav>
			</div>';

	
	
	
	if((isset($sel_year) && !empty($sel_year)) && (isset($sel_month) && !empty($sel_month))){
		
		$blogs = selectAll('p_blog','*'," WHERE `status` ='1' AND YEAR(`created_date`) = ".$sel_year." AND MONTH (`created_date`) = ".$sel_month." ORDER BY `created_date`");
		
		if(isset($blogs) && !empty($blogs)){
			
			$out .= '<div class="col-sm-4 col-md-10" >';
			
			foreach($blogs AS $blog){
				
			$out .=	 '<div class="thumbnail">
					      <div class="caption">
					      	 <h1>'.$blog['title'].'</h1>
					        <p>Publish date: <time class="text-info" datetime="'.$blog['created_date'].'">'.date("d.m.Y H:i:s",strtotime($blog['created_date'])).'</time></p>
					        <em class="lead">'.$blog['intro_text'].'</em>
					        <p>'.$blog['content'].'</p>
					      </div>
					    </div>';
				
			}
			$out .= '</div>';

		}else $out .= 'Nije pronađen niti jedan čalank za traženi datum';
		
	}else $out .= 'Nije odabran datum';
	
	
?>
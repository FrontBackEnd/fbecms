<?php

$sliders = selectAll('p_slider','*'," WHERE `status` = '1' ORDER BY `position` ASC");

if(isset($sliders) && !empty($sliders)){
	$out .= '<div class="slider">';
			foreach($sliders AS $slider){
				
				if(isset($slider['img']) && !empty($slider['img'])){
					
					$img = '<img src="'.WEB_PAGE.'upload/images/slider/thumbs/1138x400-'.$slider['img'].'" alt="'.$slider['title'].'" title="'.$slider['title'].'">';
					
					$span = '<span>'.$slider['title'].'</span>';
					
					if(isset($slider['slider_url']) && !empty($slider['slider_url'])) $span = '<a href="'.$slider['slider_url'].'">'.$span.'</a>';
					
					$out .= '<div>'.$img.$span.'</div>';
				}
			}

	$out .= '</div>
	
		<script>
		$(document).ready(function(){
			$(\'.slider\').slick({
			  dots: true,
			  infinite: true,
			  speed: 500,
			  fade: true,
			  slide: \'div\',
			  cssEase: \'linear\',
			  autoplay: true,
 			  autoplaySpeed: 4000
			});
		});
		</script>
	';
}

?>
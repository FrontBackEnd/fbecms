<?php
if(isset($part2) && !empty($part2)){

	$tutorial = selectOneByRow('p_tutorial','tutorial_url',$part2,'*'," AND `status` = '1'");

	if(isset($tutorial) && !empty($tutorial)){
		
		$out .= '<h1 class="text-center">'.$tutorial['title'].'</h1>';
		
		
		$all_steps = selectAll('p_tutorial_steps','`step_url`'," WHERE `tutorial_id` = '".$tutorial['id']."' ORDER BY `position` ASC");
		if(isset($all_steps) && !empty($all_steps)){
			$step_list = array();
			foreach($all_steps AS $ss) $step_list[] = $ss['step_url'];
		}
		
		if(isset($part3) && !empty($part3)) $steps[] = selectOneByRow('p_tutorial_steps','step_url',$part3);
		else $steps = selectAll('p_tutorial_steps','*'," WHERE `status` = '1' AND `tutorial_id` = '".$tutorial['id']."' ORDER BY `position` ASC LIMIT 1");

		if(isset($steps) && !empty($steps)){
			foreach($steps AS $step){
				
				$out .= '<h2>'.$step['title'].'</h2>';
				
				$contents = selectAll('p_tutorial_steps_contents','*'," WHERE `status` = '1' AND `step_id` = '".$step['id']."'");
				
				if(isset($contents) && !empty($contents)){
					foreach($contents AS $row){
						
						if(isset($row['img']) && !empty($row['img']) && $row['img'] !=' '){
						  $img = '<a href="#" class="media-left pull-left"><img src="'.WEB_PAGE.'upload/images/tutorials/contents/thumbs/200x150-'.$row['img'].'" alt="'.$row['title'].'" class="img-responsive"></a>';
						}else $img = '<a href="#" class="media-left pull-left"><img src="'.WEB_PAGE.'img/200x150-articlePage.png" alt="'.$row['title'].'" class="img-responsive"></a>';
							 
						$out .=	 '	<div class="media">
							      		'.$img.'
								    	<div class="media-body">
								        	<h4 class="media-heading">'.$row['title'].'</h4>
								        	 <p>Publish date: <time class="text-info" datetime="'.$row['created_date'].'">'.date("d.m.Y H:i:s",strtotime($row['created_date'])).'</time></p>
									         <pre>'.htmlspecialchars($row['content']).'</pre>
								     	</div>
								    </div>';
						
					}
				}
				
				
				if(isset($step_list) && !empty($step_list)){
					
					$num = '';
					
					foreach($step_list AS $key => $value){
						if($value == $step['step_url']) $num = $key;
					}
					
					
					if(isset($num)){
						
						
						
						if(array_key_exists($num-1,$step_list)) $previous_url = WEB_PAGE.$LINK_PAGE.'/'.$tutorial['tutorial_url'].'/'.$step_list[$num-1].'/';
						else $previous_url ='';
						
						if(array_key_exists($num+1,$step_list)) $next_url = WEB_PAGE.$LINK_PAGE.'/'.$tutorial['tutorial_url'].'/'.$step_list[$num+1].'/';
						else $next_url = '';
						
						
						$out .= '<nav>
								  <ul class="pager">';
						if(isset($previous_url) && !empty($previous_url)) $out .= '<li><a href="'.$previous_url.'">Previous</a></li>';
						if(isset($next_url) && !empty($next_url))	$out .= '<li><a href="'.$next_url.'">Next</a></li>';
						
						$out .= ' </ul>
								</nav>';
					}
				}
				
				
				
				
			}
		}
		

		
		
	}else $out .= 'Not found tutorial';
		
}else $out .= 'Not selected tutorial';



?>
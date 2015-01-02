<?php

$template_parts = selectAll('f_templates_parts','*'," WHERE `template_id` = '".$page_data['template_id']."' ORDER BY `position` ASC");

if(isset($template_parts) && !empty($template_parts)){
	foreach($template_parts AS $template_part){
		$out ='';
		
		$plugins = selectAll('f_pages_contents','*'," WHERE `template_part` = '".$template_part['id']."' AND `page_id` = '".$page_data['id']."' ORDER BY `position` ASC");
		
		if(isset($plugins) && !empty($plugins)){
			
			foreach($plugins AS $plugin){
				
				if(isset($plugin['link_page']) && !empty($plugin['link_page'])) $link_page = selectOne('f_pages',$plugin['link_page']);
				else $link_page['page_url'] = '#'; 
				
				$LINK_PAGE = $link_page['page_url'];
				
				if(file_exists(WEB_DIR."print/contents/".$plugin['plugin_part'])){
					include("contents/".$plugin['plugin_part']);
				}
			}	
		}
		
		if((isset($template_part['start_tag']) && !empty($template_part['start_tag'])) && (isset($template_part['end_tag']) && !empty($template_part['end_tag']))) 
		echo htmlspecialchars_decode($template_part['start_tag']).$out.htmlspecialchars_decode($template_part['end_tag']);
		else echo $out;
		
	}
}

?>
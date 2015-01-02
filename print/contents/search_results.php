<?php

if(isset($_POST['search']) && !empty($_POST['search']) && $_POST['search'] == 'Search'){

	$search = htmlentities($_POST['search_term']);

	$articles = selectAll('p_articles','*'," WHERE `status` ='1' AND (`content` LIKE '%".mysqli_real_escape_string($conn,$search)."%' OR `intro_text` LIKE '%".mysqli_real_escape_string($conn,$search)."%' OR `title` LIKE '%".mysqli_real_escape_string($conn,$search)."%')");

	$out .= '<h2>Searched term: '.$search.'</h2>';

	if(isset($articles) && !empty($articles) && $articles !=false){
		foreach($articles AS $row){
			$category = selectOne('f_categories',mysqli_real_escape_string($conn,$row['category_id']),'`title`');

			$row['title'] = str_replace($search,'<b>'.$search.'</b>',$row['title']);
			$row['intro_text'] = str_replace($search,'<b>'.$search.'</b>',$row['intro_text']);

			$article_url = WEB_PAGE.$LINK_PAGE.'/'.$row['article_url'].'/';

			$out .= '<article>
						  <blockquote>
						    <p><a href="'.$article_url.'">'.$row['title'].'</a></p>
						    <p>Category: '.$category['title'].' | Publish date: <time datetime="'.$row['published_date'].'">'.date("d.m.Y H:i:s",strtotime($row['published_date'])).'</time></p>
						    <small>'.$row['intro_text'].'</small>
						   </blockquote>
					  </article>';
		}
	}else $out .= '<h3>Not found any articles</h3>';
	
}else $out .= '<h2>Not enterd search term</h2>';


?>
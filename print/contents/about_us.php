<?php

$about_us = selectOne('p_text','1');

$out .= '<div class="col-sm-4 col-md-12" >
			<article>
				<h1>'.$about_us['title'].'</h1>
				<em class="lead">'.$about_us['intro_text'].'</em>
				<p>'.$about_us['content'].'</p>
			</article>
		</div>	';



?>

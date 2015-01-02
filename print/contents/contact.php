<?php

$about_us = selectOne('p_text','2');

$out .= '<div class="col-md-6">
			<article>
				<h1>'.$about_us['title'].'</h1>
				<em class="lead">'.$about_us['intro_text'].'</em>
				<p>'.$about_us['content'].'</p>
			</article>
		</div>	';



?>

<?php
$name = 'chat';
$table = 'p_chat_settings';
$chain = 'chat_id';
$save_chain = 'save_chat_settings';
$menu_statuses = $next_file.'_status';
if(array_key_exists($next_file, $statuses)) $$menu_statuses = $statuses[$next_file];

if(checkPermission($_SESSION['role'], 'view', dirname(__FILE__))){

	
	if(isset($_POST[$save_chain]) && !empty($_POST[$save_chain])) include($next_file."_action.php");
	
	if(isset($_POST['action']) && !empty($_POST['action'])) include($next_file."_forms.php");
	else{
	
		echo '<h1 class="text-center">Chat</h1>
				<div class="panel panel-default">
		 		 <div class="panel-body">
					<form method="POST" action="">
						<input type="hidden" name="'.$chain.'" value="" >';
			if(checkPermission($_SESSION['role'], 'update', dirname(__FILE__))) echo'<input type="submit" name="action" value="UPDATE" class="btn btn-success">';
			echo'</div>
				  	<div class="panel-footer">
						<div class="panel panel-primary">
						  	<div class="panel-heading"><b>Chat status</b></div>
							  <ul class="list-group">
							    <li class="list-group-item"></li>
							  </ul>
						</div>
					</div>
				</form>	
				</div>';
	}
		
}else $_SESSION['danger'][] = 'Not allowed';

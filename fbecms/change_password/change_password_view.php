<?php

if(isset($_POST['change_password']) && !empty($_POST['change_password']) && $_POST['change_password'] == 'Change password'){
	
	$id = $_SESSION['user'];
	$data['password'] = mysqli_real_escape_string($conn,$_POST['new_password']);
	$sql= updateData('b_users',$data,'email',$id);
				
	if(mysqli_query($conn,$sql)) $_SESSION['success'][] = 'Password changed';	
	
}elseif(isset($_POST['not_change_password']) && !empty($_POST['not_change_password'])) header("Location:".WEB_PAGE."FBEcms/");


echo '<h1 class="text-center">Change password</h1>
	 <form method="POST" action="">
	 <div class="form-group">
	 	<label for="new_password">New password</label>
	 	<input id="new_password" type="password" name="new_password" class="form-control">
	 </div>	
	 	<input type="submit" class="btn btn-success dropdown-toggle" name="change_password" value="Change password">
	 	<input type="submit" class="btn btn-danger dropdown-toggle" name="not_change_password" value="NO">
	 </form>';
?>
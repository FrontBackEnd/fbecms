<?php

if(isset($_POST['log']) && !empty($_POST['log']) && $_POST['log'] == 'LOGIN'){ 
	
	if(isset($_POST['email']) && !empty($_POST['email'])){
		
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$password = htmlentities($_POST['password']);
		
		
		$sql="SELECT *  FROM `b_users`  WHERE `email` = '".$email."' AND `status` = '1'";
		$result = mysqli_query($conn,$sql);
		
		if(mysqli_num_rows($result)){ 
			$row = mysqli_fetch_assoc($result);
			
			if($password == $row['password']){
				
				$_SESSION['success'][] = 'You are logged in';
				$_SESSION['user'] = $row['email'];
				$_SESSION['role'] = $row['role'];
				
			}else $_SESSION['danger'][] = 'Wrong password';
			
		}else $_SESSION['danger'][] = 'Not found your email';
		
	}else $_SESSION['danger'][] = 'Please enter email';		
	
}elseif(isset($_POST['log']) && !empty($_POST['log']) && $_POST['log'] == 'LOGOUT'){ 
	unset($_SESSION['user']);
	unset($_SESSION['role']);
}


if(isset($_SESSION['user']) && !empty($_SESSION['user'])){ 
	
echo '<form method="POST" method="" style="margin:60px 0;height:40px;">
		<button type="button" class="btn btn-default btn-lg">
			<span class="glyphicon glyphicon-user"></span><small style="margin-left:5px;">'.$_SESSION['user'].'</small>
		</button>
		<input type="submit" class="btn btn-default" value="LOGOUT" name="log" style="float:right;">
		<a href="?change=change_password" class="btn btn-info" style="float:right;margin-right:10px;">Change password</a>
	  </form>';
	
}else{ 
	
echo '	
		<div class="row">
			<div class="col-sm-3 col-md-4">
			</div>
			<div class="col-sm-3 col-md-4">
				<div class="col-md-2 col-md-offset-2"  >
					<img src="'.WEB_PAGE.'img/120x90-logo.png" style="margin:20px;">
					
				</div>
					
				<div class="col-md-12 col-md-12" >	
					<form method="POST" method="" style="margin-top:20px">
						<div class="form-group">
							<label for="email">Email:</label>
							<input id="email" type="email" name="email"  class="form-control">
						</div>
						
						<div class="form-group">	
							<label for="password"> Password:</label> 
							<input id="password" type="password" name="password"  class="form-control">
						</div>
						<input type="submit" class="btn btn-default" value="LOGIN" name="log">
				 	 </form>
				</div>
				
				
			</div>
			<div class="col-sm-3 col-md-4">
			</div>
		</div>

		';
}

?>
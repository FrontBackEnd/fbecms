<?php
$to = 'info@front-back-end.com';
$subject = 'Hello';


if(isset($_POST['contact_name']) && !empty($_POST['contact_name'])) $name = $_POST['contact_name'];
else $name ='';

if(isset($_POST['contact_email']) && !empty($_POST['contact_email'])) $email = $_POST['contact_email'];
else $email = '';

if(isset($_POST['contact_message']) && !empty($_POST['contact_message'])) $message = $_POST['contact_message'];
else $message = '';

$mail_succes = '';
$mail_error = '';

if(isset($_POST['send_mail']) && !empty($_POST['send_mail']) && $_POST['send_mail'] == 'Send'){
	
	if(!empty($name)){
		if($name >= 2){
			if(!empty($email)){
				if(!empty($message)){
					
					$body = "From: $name\n E-Mail: $email\n Message:\n $message";
				
					if (mail ($to, $subject, $body, $from)){
						
						$mail_succes = 'Thank you for contact us';
						
					}else $mail_error = 'Error while sending mail';
					
				}else $mail_error = 'Must eneter message';
				
			}else  $mail_error = 'Must eneter email';
			
		}else  $mail_error = 'Name cannot be less than 2 characthers';
		
	}else $mail_error = 'Must eneter name';
}



$out .= '<div class="col-md-6" style="margin-bottom:20px">';

if(isset($mail_succes) && !empty($mail_succes)) $out .='<div class="alert alert-success" role="alert">'.$mail_succes.'</div>';
	
if(isset($mail_error) && !empty($mail_error)) $out .='<div class="alert alert-warning" role="alert">'.$mail_error.'</div>';

$out .= '	<h1>Contact form</h1>
			<form action="" method="POST">
				<div class="form-group">
					<label for="name">Name</label>
					<input id="name" type="text" name="contact_name" value="'.$name.'" class="form-control" required="required">
				</div>
				
				<div class="form-group">
					<label for="email">E-mail</label>
					<input id="email" type="email" name="contact_email" value="'.$email.'" class="form-control" required="required">
				</div>
				
				<div class="form-group">	
					<label for="message">Message</label>
					<textarea name="contact_message" class="form-control" required="required">'.$message.'</textarea>
					
				</div>
				<input type="submit" name="send_mail" value="Send" class="btn btn-default">
			</form>
		</div>';





?>
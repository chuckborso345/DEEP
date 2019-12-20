<?php

$return      = array();
$error       = false;
$toEmail     = 'digequality@gmail.com';
$subject     = "New message from DEEP";
$from        = 'DEEP';

$messages = array(
	'success'               => 'Your message was sent',
	'error_mail_send'       => 'There was an error please send your message to: '.$toEmail,
	'error_name_empty'			=> 'Your name is required',
	'error_phone_empty'			=> 'Your phone is required',
	'error_email_empty'         => 'Your email is required',
	'error_email_format'        => 'Your email looks wrong',
	'error_comments_empty'		=> 'Remember to write your message',
	);



if( empty( $_POST['name'] ))
{
	$error[] = $messages['error_name_empty'];
}

if( empty( $_POST['phone'] ))
{
	$error[] = $messages['error_phone_empty'];
}

if( empty( $_POST['email'] ))
{
	$error[] = $messages['error_email_empty'];
}

if( !empty( $_POST['email'] ))
{
	if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$error[] = $messages['error_email_format'];
	}
}

if( empty( $_POST['comments'] ))
{
	$error[] = $messages['error_comments_empty'];
}

// prepare errors
if( !empty($error) ) {
	$return['errorMsg'] = $error[0];
}

// no errors
if( !isset( $return['errorMsg'] ) ) {

	require_once('library/phpmailer.php');

	$name = $_POST['name'];
	$subject = $_POST['subject'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$comments = $_POST['comments'];

	$mail  = new PHPMailer();
	$mail->IsHTML(true);
	$mail->CharSet  = 'UTF-8';
	$mail->Subject = ($subject);
	$mail->SetFrom( $email, $name . ' ' . $lastname );
	$mail->AddAddress( $toEmail );

	ob_start();
	?>
	<html>
	<body>
		<div style="margin:0;padding:10px;border:20px solid #ccc">
			<h3 style="text-align:center;">New Message from DEEP</h3><hr>
			<p><strong>Name:</strong> <?php echo $name ?></p>
			<p><strong>Phone:</strong> <?php echo $phone ?></p>
			<p><strong>Email:</strong> <?php echo $email ?></p>
			<p><strong>Message:</strong> <?php echo $comments ?></p>
		</div>
	</body>
	</html>
	<?php
	$message = ob_get_clean();


	$mail->Body = $message;
	$mail->AltBody = 'New message from DEEP';


	if( $mail->Send() ) {

		$return['successMsg'] = $messages['success'];

	}else{
		$return['errorMsg'] = $messages['error_mail_send'];
	}
}


echo json_encode( $return );

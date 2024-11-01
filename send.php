<?php
session_start();
$_SESSION['start'] = time(); // taking now logged in time
$_SESSION['expire'] = $_SESSION['start'] + (1 * 5) ; // ending a session in 30


require('../../../wp-load.php');

if(isset($_POST['submit']) && !empty($_POST['submit']))
{
	extract($_POST);
	$valid = validateEmail($fr_mail);
	//echo 'hi'; exit;
	if($valid =='valid')
	{
		//print_r($_POST);
		$to = esc_attr( $fr_mail);
		$subject = esc_attr($subject);
		$message = esc_attr($mail_body);
		
		$headers = (
			"MIME-Version: 1.0" . "\r\n" .
			"Content-type:text/html;charset=iso-8859-1" . "\r\n" .
			"From: $ur_name <$ur_mail>"
		);
		
		//check security question answer
		if(isset($rans) && isset($ur_ans))
		{
			if($rans == $ur_ans)
			{
				if (!@wp_mail( $to, $subject, $message, $headers ))
				{
					$_SESSION['snapycodesendmailmsg'] = 'Sorry! Could not send mail to '.$to;
				}
				else{
					$_SESSION['snapycodesendmailmsg'] = 'Mail sucessfully sent to '.$to;
				}
			}
			else
			{
				$_SESSION['snapycodesendmailmsg'] = 'Sorry Security answer does not match!!';
			}
		}
		else{
			if (!@wp_mail( $to, $subject, $message, $headers ))
			{
				$_SESSION['snapycodesendmailmsg'] = 'Sorry! Could not send mail to '.$to;
			}
			else
			{
				$_SESSION['snapycodesendmailmsg'] = 'Mail sucessfully sent to '.$to;
			}
		}
		
	}
	else
	{
		$_SESSION['snapycodesendmailmsg'] = 'mail sending failed as wrong recipient email address';
	}
}



header('Location: ' . $_SERVER['HTTP_REFERER']);

//email address validation
function validateEmail($email)
{
	$regex = '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/'; 
	// Run the preg_match() function on regex against the email address
	if (preg_match($regex, $email)) {
		 return 'valid';
	} else { 
		 return 'invalid';
	} 
}

?>
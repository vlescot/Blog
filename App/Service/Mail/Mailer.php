<?php
namespace Service\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require $_SERVER['DOCUMENT_ROOT'].'P5/blog/vendor/autoload.php';

class Mailer 
{
	private $email,
			$password,
			$server,
			$port;

	function __construct (){
		$MailAccess = json_decode( file_get_contents(__DIR__ . "\MailAccess.json"), true);	// Private file to protect confidenfial data (Json)
		$this->username = $MailAccess['Username'];
		$this->password = $MailAccess['Password'];
	}

	function Mailer ($file ='mail_registration'){

		require $file.'.php';
		$mail_to = 'vincent.lescot@gmail.com';

	    $mail = new PHPMailer;
	    //$mail->SMTPDebug = 3;                 // Enable verbose debug output
	    $mail->isSMTP();                        // Set mailer to use SMTP
	    $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                 // Enable SMTP authentication
	    $mail->Username = $this->username;  	// SMTP username
	    $mail->Password = $this->password;             // SMTP password
	    $mail->SMTPSecure = 'ssl';              // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 465;                      // TCP port to connect to
	    $mail->SMTPOptions = array(
	      	'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
	      	)
	    ); 
	    $mail->isHTML(true);                      // Set email format to HTML
		$mail->CharSet = "utf-8";

	    $mail->setFrom('vincent.lescot@gmail.com', 'Vincent Lescot');   // Add a recipient
	    $mail->addAddress($mail_to);               // Name is optional
	    //$mail->addReplyTo('info@example.com', 'Information');
	    //$mail->addCC('cc@example.com');
	    //$mail->addBCC('bcc@example.com');

	    $mail->Subject = $subject;
	    $mail->Body    = $message;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $mail->send();
	}
}

$mailer = new Mailer;
$mailer->Mailer();
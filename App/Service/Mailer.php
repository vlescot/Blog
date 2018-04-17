<?php
namespace Service;

use PHPMailer\PHPMailer\PHPMailer;

class Mailer 
{
	private $_username,
			$_password,
			$_host,
			$_SMTPSecure,
			$_port,
			$_mail;

	function __construct ($email_to, $subject, $content){
		$MailAccess = json_decode( file_get_contents($_SERVER['DOCUMENT_ROOT'] . "P5/Blog/Conf/MailAccess.json"), true);	// Private file to protect confidenfial data (Json)
		$this->_username = $MailAccess['Username'];
		$this->_password = $MailAccess['Password'];
		$this->_host 	 = $MailAccess['Host'];
		$this->_SMTPSecure = $MailAccess['SMTPSecure'];
		$this->_port 	= $MailAccess['Port'];

		$this->Mailer($email_to, $subject, $content);
	}

	private function Mailer ($email_to, $subject, $content){
	    $mail = new PHPMailer;
	    $mail->isSMTP();                        // Set mailer to use SMTP
	    $mail->Host = $this->_host;         // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                 // Enable SMTP authentication
	    $mail->Username = $this->_username;  	// SMTP username
	    $mail->Password = $this->_password;      // SMTP password
	    $mail->SMTPSecure = $this->_SMTPSecure;              // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = $this->_port;                      // TCP port to connect to
	    $mail->SMTPOptions = array(
	     	 	'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
	      	)
	    ); 
	    $mail->isHTML(true);                      // Set email format to HTML
		$mail->CharSet = "utf-8";
	    $mail->setFrom($this->_username, 'Vincent Lescot [Blog]');   // Add a recipient

    	$mail->addAddress($email_to);               // Name is optional
	    $mail->Subject = $subject;
	    $mail->Body    = $content;

	    $this->_mail = $mail;
	}

	function send ()
	{
	    $this->_mail->send();
	}
}

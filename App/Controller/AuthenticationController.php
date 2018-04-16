<?php
namespace Controller;

use Manager\MemberManager;
use Entity\MemberEntity;
use Service\Authentication;
use Service\Mailer;
use Service\Notification;

class AuthenticationController extends Controller
{
	private function Alert ($message)
	{
		new Notification ($message);
		header('Location: ' . $_SERVER['REQUEST_URI']);
		exit;
	}

	function connection ()
	{
		// Check if the user is already connected
		if (isset($_SESSION['ip']) && $_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
			header('Location: http://localhost/P5/Blog/admin');
			exit;
		}
		if (empty($_POST['login']) || empty($_POST['psw'])) {
			echo $this->twig->render('connection.twig');
			exit;
		}
		$MemberManager = new MemberManager();
		$member = $MemberManager->getMember($_POST['login']);

		$Authentication = new Authentication($member);
		if (is_string($Authentication->LogIn($_POST['psw'])))  /*Error case*/ $this->Alert($Authentication->LogIn($_POST['psw'])); /*exit*/
		new Notification ('Bonjour ' . $_POST['login'], 'success');
		header("Location: http://localhost/P5/Blog/admin");	
	}

	function registration ()
	{
		if (empty($_POST['login']) || empty($_POST['psw']) || empty($_POST['psw2']) || empty($_POST['email'])) {
			echo $this->twig->render('registration.twig');
			exit;
		}

		$MemberManager = new MemberManager();
		$member = $MemberManager->getMember($_POST['login']);

		$Authentication = new Authentication($member);
		// Checking if member can be create within given datas
		$result = $Authentication->signUp($_POST['psw'], $_POST['psw2']);

		// Error case
		if (is_string($result)) $this->Alert($result);
		// If correct $result, creating the member...
		elseif (is_array($result)){ // Into the database
			$MemberManager->createMember([
				'login' 	=> $_POST['login'],
				'password' 	=> $result['password'],
				'email' 	=> $_POST['email']
			]);
			// Redirecting user to the espace admin
			new Notification ('Bienvenue ' . $_POST['login'], 'info');
			header("Location: http://localhost/P5/Blog/admin/");

			// Sending an e-mail to the new member
			require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_member_registration_notification.php');
			$mail = new Mailer ($_POST['email'], $subject, $message);
			$mail->send();
			// Sending an e-mail to administration member asking validation's member
			require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_admin_registration_notification.php');
			$mail = new Mailer ('vincent.lescot@gmail.com', $subject, $message);
			$mail->send();
		}
	}

	function askingResetEmail ()
	{
		if (empty($_POST['login'])) {
			echo $this->twig->render('reset_password.twig');
			exit;
		}

		$MemberManager = new MemberManager;
		$member = $MemberManager->getMember($_POST['login']);

		$Authentication = new Authentication ($member);
		$hashedlink = $Authentication->resetPassword($_POST['login']);

		//  Unknown member case
		if (strlen($hashedlink) !== 128) $this->Alert($hashedlink); /*exit*/

		// Save le resetPasswors link inot the database for futur verification
		$MemberManager->updateResetPassword($hashedlink, $_POST['login']);

		// Send an e-mail to the member with an authentificate link
		require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_member_reset_password.php');
		$mail = new Mailer ($member['email'], $subject, $message);
		$mail->send();

		echo $this->twig->render('email_send.twig');
	}

	function checkMember (){
		if (empty($_GET['p'])) {
			new Notification ('o/O Un intru...');
			header('Location: http://localhost/P5/Blog/');
			exit;
		}

		$MemberManager = new MemberManager;
		$member = $MemberManager->getMemberbyResetPassword ($_GET['p']);

		if ($member === false) {
			new Notification ('Nous n\'avons pas put vous reconnaitre');
			header('Location: http://localhost/P5/Blog/authentication/');
			exit;
		}

		echo $this->twig->render('change_password.twig', ['login' => $member['login']]);
	}

	function changePassword ()
	{
		if (empty($_POST['login']) && empty($_POST['psw']) && empty($_POST['psw2'])) {
			$this->Alert('Vous avez oublié de remplir une case'); 
			/*exit*/
		}

		$MemberManager = new MemberManager;
		$member = $MemberManager->getMember($_POST['login']);

		$Authentication = new Authentication ($member);
		$hashedPassword = $Authentication->changePassword($_POST['login'], $_POST['psw'], $_POST['psw2']);

		// Error case
		if (strlen($hashedPassword) !== 128) $this->Alert($hashedPassword); /*exit*/

		// If, the new password is correct, then save it into the database
		$MemberManager->changePassword($hashedPassword, $_POST['login']);
		// Reset an empty string for reset_password SQL field
		$MemberManager->updateResetPassword('', $_POST['login']);
		header("Location: http://localhost/P5/Blog/admin/");
	}

	function disconnect ()
	{
		session_destroy();
		session_start();
		new Notification ('Au revoir !', 'info');
		header('Location: http://localhost/P5/Blog/');
		exit;
	}
}

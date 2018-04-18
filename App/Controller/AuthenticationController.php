<?php
namespace Controller;

use Manager\MemberManager;
use Entity\Member;
use Entity\Mail;
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
		$Member = new Member (['login' => $_POST['login']]);
		$MemberManager = new MemberManager();
		$member = $MemberManager->getMember($Member);

		$Authentication = new Authentication($member);
		$result = $Authentication->LogIn($_POST['psw']);

		if (is_string($result))  /*Error case*/ $this->Alert($result); /*exit*/

		new Notification ('Bonjour ' . $_POST['login'], 'success');
		header("Location: http://localhost/P5/Blog/admin");	
	}

	function registration ()
	{
		if (empty($_POST['login']) || empty($_POST['psw']) || empty($_POST['psw2']) || empty($_POST['email'])) {
			echo $this->twig->render('registration.twig');
			exit;
		}

		$Member = new Member (['login' => $_POST['login']]);
		$MemberManager = new MemberManager();
		$member = $MemberManager->getMember($Member);

		$Authentication = new Authentication($member);
		// Checking if member can be create within given datas
		$result = $Authentication->signUp($_POST['psw'], $_POST['psw2']);

		// Error case
		if (is_string($result)) $this->Alert($result);

		// If not, correct $result is an array... Creating the member into the database
		$Member = new Member ([
			'login' 	=> $_POST['login'],
			'password' 	=> $result['password'],
			'email' 	=> $_POST['email']
		]);
		$MemberManager->createMember($Member);
		// Redirecting user to the espace admin
		new Notification ('Bienvenue ' . $Member->login(), 'info');
		header("Location: http://localhost/P5/Blog/admin/");

		// Sending an e-mail to the new member
		require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_member_registration_notification.php');
		$mail = new Mailer ($Member->email(), $subject, $message);
		$mail->send();
		// Sending an e-mail to administration member asking validation's member
		require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_admin_registration_notification.php');
		$mail = new Mailer ('vincent.lescot@gmail.com', $subject, $message);
		$mail->send();
	}

	function askingResetEmail ()
	{
		if (empty($_POST['login'])) {
			echo $this->twig->render('reset_password.twig');
			exit;
		}

		$Member = new Member (['login' => $_POST['login']]);
		$MemberManager = new MemberManager;
		$member = $MemberManager->getMember($Member);

		$Authentication = new Authentication ($member);
		$hashedlink = $Authentication->resetPassword($Member->login());

		//  Unknown member case
		if (strlen($hashedlink) !== 128) $this->Alert($hashedlink); /*exit*/

		// Save le resetPasswors link inot the database for futur verification
		$Member->setReset_password($hashedlink);
		$MemberManager->updateResetPassword($Member);

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

		$Member = new Member (['reset_password' => $_GET['p']]);
		$MemberManager = new MemberManager();
		$member = $MemberManager->getMemberbyResetPassword ($Member);
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

		$Member = new Member ([
			'login' => $_POST['login'],
			'password' => $_POST['psw']
		]);

		$MemberManager = new MemberManager;
		$member = $MemberManager->getMember($Member);

		$Authentication = new Authentication ($member);
		$hashedPassword = $Authentication->changePassword($Member->login(), $Member->password(), $_POST['psw2']);

		// In error case $hashedPassword is explanation string and long different than 128
		if (strlen($hashedPassword) !== 128) $this->Alert($hashedPassword); //exit
		
		// If, the new password is correct, then save it into the database
		$Member->setPassword($hashedPassword);
		$MemberManager->changePassword($Member);
		// Reset an empty string for reset_password SQL field
		$Member->setReset_password('');
		$MemberManager->updateResetPassword($Member);

		new Notification ('Votre mot de passe a bien été changé', 'success');
		header("Location: http://localhost/P5/Blog/admin/");
	}

	function disconnect ()
	{
		session_destroy();
		session_start();
		new Notification ('À bientôt !', 'info');
		header('Location: http://localhost/P5/Blog/');
		exit;
	}
}

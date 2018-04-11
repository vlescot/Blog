<?php
namespace Service;

// require_once './../../vendor/autoload.php';
use Manager\MemberManager;


// -------------------------------------------------------------------
// 
// 							Class Session
//
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							public __construct (string $login, string $password)
// 							private encrypt ($str)
// 							private loginExists ()
// 							private setConnection ()
// 							public logIn ()
// 							public signUp ($check_password)
// 							public resetPassword () // Still to do


class Session
{
	private $login;
	private $password;
	private $member = [];
	private $error = [];
	
	function __construct (string $login, string $password ='')
	{
		$this->login = $login;
		$this->password = $this->encrypt($password); // Encrypts the login and password before operate with the database

		$this->MemberManager = new MemberManager;
		$this->member = $this->MemberManager->getMember($login);
	}


	private function encrypt (string $str)
	{
		return hash('whirlpool', $str . "kyO5pa;cd54s2?");
	}


	private function loginExists ()
	{
		if (!empty($this->member)) return true;
		else return false ;
	}


	private function setConnection ()
	{
		$_SESSION['ip'] 		= $_SERVER['REMOTE_ADDR'];
		$_SESSION['login'] 		= $this->login;
		$_SESSION['validated'] 	= $this->member['validated'];
		$_SESSION['member_type'] 		= $this->member['id_type'];
	}


	function logIn ()
	{
		// Checks if the member exists into the database
		$loginExists = $this->loginExists();
		if ($loginExists === false) return 'Ce nom d\'utilisateur n\'est pas reconnu';
		// Checks if the password is correct
		if ($this->password !== $this->member['password']) return 'Le mot de passe est incorrect';
		// Set connection
		$this->setConnection();
		return true;
	}


	function signUp (string $check_password)
	{
		// Checks if the two given passwords are identiques
		if ($this->password !== $this->encrypt($check_password)) return 'Les mots de passes doivent être identiques';
		// Checks if the member exists into the database
		$loginExists = $this->loginExists();
		if ($loginExists === true) return 'Ce membre existe déjà';
		// Creating the member into the database
		$this->MemberManager->createMember(['login' => $this->login,'password' => $this->password]);
		// Set connection
		$this->setConnection();
		return true;
	}

	function resetPassword ()
	{
		if (!empty($this->member)) { // Checks if the member exists into the database
			if (condition) {
				# code...
			}
		}
		else $this->message[] = "Cet utilisateur n'est pas reconnu.";
	}
}

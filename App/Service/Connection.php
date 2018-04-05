<?php
namespace Service;

require_once './../../vendor/autoload.php';
use Manager\MemberManager;

class Connection
{
	private $login,
			$password,
			$member = [],
			$salt = "kyO5pa;cd54s2?",
			$message = [];


	private function encrypt ($str)
	{
		return hash('whirlpool', $str . $this->salt);
	}
		

	function __construct (string $login, string $password)
	{
		$MemberManager = new MemberManager;
		$this->member = $MemberManager->getMember($this->login);
		$this->password = $this->encrypt($password); // Encrypts the login and password before operate with the database
		$this->login = $login;
	}


	function auth ()
	{
		if (!empty($this->member)) { // Checks if the member exists into the database
			if ($this->password === $this->member['password']) { // Checks if the password is correct
				session_start();
				$_SESSION['validated'] = $this->member['validated'];
				$_SESSION['member_type'] = $this->member['id_type'];
var_dump($_SESSION);
				exit;
			}else $this->message[] = "Le mot de passe est incorrect.";
		}else $this->message[] = "Cet identifiant n'est pas reconnu.";

		// EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION 
		// EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION 
		if (!empty($this->message)) {
			/**
			 * ECRIRE UNE EXCEPTION
			 */
			foreach ($this->message as $key => $value) {
				echo $value;
			}
			// flash($message);
		}
	}


	function registration (string $password2)
	{
		if ($this->password === $this->encrypt($password2)) {
			if ($this->login !== $this->member['login'] ) { // Checks if the member already exists
				echo("Creation du membre");
				// $MemberManager->createMember(['login' => $login,'password' => $password]); // If not, the new member is registered
				exit;
			}else $this->message[] = "Ce membre existe déjà.";
		}else $this->message[] = "Les deux mots de passes sont différents.";

		// EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION 
		// EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION EXCEPTION 
		if (!empty($this->message)) {
			/**
			 * ECRIRE UNE EXCEPTION
			 */
			foreach ($this->message as $key => $value) {
				echo $value;
			}
			// flash($message);
		}
	}
}



$_POST['login'] = "Visitor";
$_POST['psw'] = "OpenClassrooms";
$_POST['psw2'] = "OpenClassrooms";

if (isset($_POST) && isset($_POST['login']) && isset($_POST['psw'])) {

	$connection = new Connection($_POST['login'], $_POST['psw']);
	$connection->registration($_POST['psw2']);
}
<?php
namespace Manager;

// require_once './../../vendor/autoload.php';
use Manager\Manager;

// -------------------------------------------------------------------
// 
// 							Class MemberManager     => Database Queries
// 							Extends of Manager 		=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createMember (array $vars)
// 							getMember (string $login)
// 							deleteMember (int $id)
// 							getValidationMember (int $date_begin, int $date_ending, int $validated)
// 							setValidationMember  (int $id, bool $set)
							
class MemberManager extends Manager
{
	function createMember (array $vars)
	{
		$sql = self::$connection->prepare('
			INSERT INTO member (login, password, validated, id_type, date_create)
			VALUES (?, ?, ?, ?, NOW())');
		$sql->execute(array($vars['login'], $vars['password'], 0, 2));
	}


	function getMember ($login)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY login=:login');
		$sql->bindvalue(':login', (string) $login, \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();
	}


	function deleteMember ($table, $id)
	{
		return parent::delete('member', $id);
	}


	function getValidationMember (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
	{
		return parent::getValidation('member', $date_begin, $date_ending, $validated);
	}


	function setValidationMember (int $id, bool $validation)
	{
		return parent::getValidation('member', $id, $validation);
	}
}


// $MemberManager = new Manager;


/*******************************
 * Test for createMember(array $vars)
 * ****************************/
// $vars = array(
// 	'login' => 'Visitor',
// 	'password'  => 'OpenClassromms',
// 	'validated' => 0,
// 	'id_type' => 1);
// $MemberManager->createMember($vars);



/*******************************
 * Test for getMember(string $login)
 * ****************************/
// $member = $MemberManager->getMember('Visitor');
// var_dump($member);



/*******************************
 * Test for deleteMember (int $id)
 * ****************************/
 // $MemberManager->delete(11);



/*******************************
 * Test for getValidationMember (int $date_begin, int $date_ending)
 * ****************************/
// $validation = $MemberManager->getValidation($date_begin='', $date_ending='', 1);
// var_dump($validation);



/*******************************
 * Test for setValidationMember (int $id, bool $validation)
 * ****************************/
 // $MemberManager->setValidation(5, false);

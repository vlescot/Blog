<?php
namespace Manager;

// require_once './../../../vendor/autoload.php';
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
// 							getValidatedMember (int $date_begin, int $date_ending, int $validated)
// 							setValidatedMember  (int $id, bool $set)
							
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

	function getMemberList ()
	{
		$sql = self::$connection->query('SELECT id, login FROM member');
		return $sql->fetchAll();
	}


	function deleteMember ($table, $id)
	{
		return parent::delete('member', $id);
	}


	function getValidatedMember (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
	{
		return parent::getValidated('member', $date_begin, $date_ending, $validated);
	}


	function setValidatedMember (int $id, bool $validated)
	{
<<<<<<< HEAD
		return parent::setValidated('member', $id, $validated);
=======
		return parent::getValidated('member', $id, $validated);
>>>>>>> a774084bf9a96120514c02c668c6d7ff1c62bb1f
	}
}


// $MemberManager = new MemberManager;


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
 * Test for getValidatedMember (int $date_begin, int $date_ending)
 * ****************************/
// $Validated = $MemberManager->getValidated($date_begin='', $date_ending='', 1);
// var_dump($Validated);



/*******************************
 * Test for setValidatedMember (int $id, bool $Validated)
 * ****************************/
<<<<<<< HEAD
 // $MemberManager->setValidatedMember(5, false);
=======
 // $MemberManager->setValidated(5, false);
>>>>>>> a774084bf9a96120514c02c668c6d7ff1c62bb1f

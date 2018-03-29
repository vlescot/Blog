<?php
namespace Model;

// require_once './../../vendor/autoload.php';
use Model\PDOFactory;

// -------------------------------------------------------------------
// 
// 							Class MemberManager     => Database Queries
// 							Extends of PDOFactory 	=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createMember (array $vars)
// 							getMember (string $login)
// 							delete (int $id)
// 							getValidation (int $date_begin, int $date_ending, int $validated)
// 							setValidation  (int $id, bool $set)


class MemberManager extends PDOFactory
{
	function createMember (array $vars)
	{
		$sql = self::$connection->prepare('
			INSERT INTO member (login, password, validated, id_type, date_create)
			VALUES (?, ?, ?, ?, NOW())');

		$sql->execute(array($vars['login'], $vars['password'], $vars['validated'], $vars['id_type']));
	}


	function getMember ($login)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE login = :login');

		$sql->bindvalue(':login', (string) $login, \PDO::PARAM_STR);

		$sql->execute();
		return $sql->fetchAll();
	}


	function delete ($table, $id)
	{
		$sql = self::$connection->prepare('DELETE FROM member WHERE id = :id');

		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);

		$sql->execute();
	}


	function getValidation (string $date_begin='2018-01-01', string $date_ending='', $validated=2){
		$query = "SELECT * FROM member WHERE date_create BETWEEN :date_begin AND :date_ending";
	
		if ($date_ending === "") {
			$date_ending = date('Y-m-d');
		}
		
		if ($validated !== 2){
			$query .= " AND validated=" . $validated . " ORDER BY date_create DESC" ;
		}else {
			$query .= " ORDER BY date_create DESC";
		}

		$sql = self::$connection->prepare($query);
		
		if ($date_begin !== '' && $date_ending !== '') {
			$sql->bindvalue(':date_begin', (string) $date_begin, \PDO::PARAM_STR);
			$sql->bindvalue(':date_ending', (string) $date_ending, \PDO::PARAM_STR);
		}

		$sql->execute();
		return $sql->fetchAll();
	}


	function setValidation (int $id, bool $validation)
	{
		if 		($validation === true) $validation = 1;
		elseif 	($validation === false) $validation = 0;
		
		$querie = 'UPDATE member SET validated= :validated WHERE id = :id';

		$sql = self::$connection->prepare($querie);

		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);
		$sql->bindvalue(':validated', (int) $validation, \PDO::PARAM_INT);
	
		$sql->execute();
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
 * Test for delete(int $id)
 * ****************************/
 // $MemberManager->delete(11);



/*******************************
 * Test for getValidation(int $date_begin, int $date_ending)
 * ****************************/
// $validation = $MemberManager->getValidation($date_begin='', $date_ending='', 1);
// var_dump($validation);



/*******************************
 * Test for setValidation(int $id, bool $validation)
 * ****************************/
 // $MemberManager->setValidation(5, false);

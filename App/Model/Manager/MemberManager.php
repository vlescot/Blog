<?php
namespace Manager;

use Entity\Member;
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
// 							getMemberById (int $id)
// 							getMemberByResetPassword (string $reset_password)
// 							getFilteredMember (int $date_begin, int $date_ending, int $validated)
// 							setValidatedMember  (int $id, bool $set)
// 							deleteMember (int $id)
// 							updateResetPassword ($hash, $login)
// 							changePassword ($password, $login)
							
class MemberManager extends Manager
{
	function createMember (Member $Member)
	{
		$sql = self::$connection->prepare('
			INSERT INTO member (login, password, reset_password, email, validated, id_type, date_create)
			VALUES (?, ?, ?, ?, ?, ?, NOW())');
		
		$sql->execute([$Member->login(), $Member->password(), '', $Member->email(), 0, 2]);
	}


	function getMember (Member $Member)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY login=:login');

		$sql->bindvalue(':login', (string) $Member->login(), \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();
	}

	function getMemberbyId (Member $Member)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY id=:id');

		$sql->bindvalue(':id', (int) $Member->id(), \PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetch();
	}

	function getMemberList ()
	{
		$sql = self::$connection->query('SELECT id, login FROM member');
		return $sql->fetchAll();
	}

	function getMemberbyResetPassword (Member $Member)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY reset_password=:reset_password');
		$sql->bindvalue(':reset_password', (string) $Member->reset_password(), \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();		
	}

	function getFilteredMember ($date_begin, $date_ending, $validated)
	{
		if ($validated === 2) {
			$query = 'SELECT * FROM member 
			WHERE date_create 
			BETWEEN :date_begin AND :date_ending
			ORDER BY date_create DESC';
		}else $query = 'SELECT * FROM member 
			WHERE date_create 
			BETWEEN :date_begin AND :date_ending
			AND validated=' . $validated . '
			ORDER BY date_create DESC';

		$sql = self::$connection->prepare($query);
		
		$sql->bindvalue(':date_begin', (string) $date_begin, \PDO::PARAM_STR);
		$sql->bindvalue(':date_ending', (string) $date_ending, \PDO::PARAM_STR);

		$sql->execute();
		return $sql->fetchAll();
	}


	function setValidatedMember (Member $Member)
	{
		$sql = self::$connection->prepare('UPDATE member SET validated= :validated WHERE id = :id');

		$sql->bindvalue(':id', (int) $Member->id(), \PDO::PARAM_INT);
		$sql->bindvalue(':validated', (int) $Member->validated(), \PDO::PARAM_INT);
		$sql->execute();	
	}


	function updateResetPassword (Member $Member)
	{

		$sql = self::$connection->prepare('
			UPDATE member
			SET reset_password = :reset_password
			WHERE login = :login'
		);

		$sql->bindvalue(':reset_password', $Member->reset_password(), \PDO::PARAM_INT);
		$sql->bindvalue(':login', $Member->login(), \PDO::PARAM_INT);
		$sql->execute();
	}

	function changePassword (Member $Member)
	{
		$sql = self::$connection->prepare('
			UPDATE member
			SET password=:password
			WHERE login=:login'
		);

		$sql->bindvalue(':password', $Member->password(), \PDO::PARAM_INT);
		$sql->bindvalue(':login', $Member->login(), \PDO::PARAM_INT);
		$sql->execute();
	}
}

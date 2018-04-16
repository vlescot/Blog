<?php
namespace Manager;

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
// 							getMemberById (int $id)
// 							getMemberByResetPassword (string $reset_password)
// 							getValidatedMember (int $date_begin, int $date_ending, int $validated)
// 							setValidatedMember  (int $id, bool $set)
// 							deleteMember (int $id)
// 							updateResetPassword ($hash, $login)
// 							changePassword ($password, $login)
							
class MemberManager extends Manager
{
	function createMember (array $vars)
	{
		$sql = self::$connection->prepare('
			INSERT INTO member (login, password, reset_password, email, validated, id_type, date_create)
			VALUES (?, ?, ?, ?, ?, NOW())');
		
		$sql->execute(array($vars['login'], $vars['password'], '', $vars['email'], 0, 2));
	}


	function getMember (string $login)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY login=:login');

		$sql->bindvalue(':login', (string) $login, \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();
	}

	function getMemberbyId (int $id)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY id=:id');

		$sql->bindvalue(':id', (string) $id, \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();
	}

	function getMemberList ()
	{
		$sql = self::$connection->query('SELECT id, login FROM member');
		return $sql->fetchAll();
	}

	function getMemberbyResetPassword (string $reset_password)
	{
		$sql = self::$connection->prepare('
			SELECT * FROM member
			WHERE BINARY reset_password=:reset_password');
		$sql->bindvalue(':reset_password', (string) $reset_password, \PDO::PARAM_STR);
		$sql->execute();
		return $sql->fetch();		
	}

	function getValidatedMember (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
	{
		return parent::getValidated('member', $date_begin, $date_ending, $validated);
	}


	function setValidatedMember (int $id, bool $validated)
	{
		return parent::setValidated('member', $id, $validated);
	}


	function deleteMember ($table, $id)
	{
		return parent::delete('member', $id);
	}

	function updateResetPassword ($hash, $login)
	{

		$sql = self::$connection->prepare('
			UPDATE member
			SET reset_password = :reset_password
			WHERE login = :login'
		);

		$sql->bindvalue(':reset_password', $hash, \PDO::PARAM_INT);
		$sql->bindvalue(':login', $login, \PDO::PARAM_INT);
		$sql->execute();
	}

	function changePassword ($password, $login)
	{
		$sql = self::$connection->prepare('
			UPDATE member
			SET password = :password
			WHERE login = :login'
		);

		$sql->bindvalue(':password', $password, \PDO::PARAM_INT);
		$sql->bindvalue(':login', $login, \PDO::PARAM_INT);
		$sql->execute();
	}
}

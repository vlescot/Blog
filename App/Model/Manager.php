<?php
namespace Model;

use PDO;

// -------------------------------------------------------------------
// 
// 							Class PostManager       => Database Queries
// 							Extends of PDOFactory 	=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							__contruct ()
// 							delete (int $id)
// 							getValidation (string $table, int $date_begin, int $date_ending, int $validated)
// 							setValidation  (string $table, int $id, bool $set)
							
class PDOFactory
{
	private static $dbEncode =	"utf8";
	protected static $connection	=	null; 

	function __construct ()
	{
		if (self::$connection === null) 
		{
			$json = file_get_contents(__DIR__ . "\DBAccess.json");	// Private file to protect confidenfial data (Json)
			$DBAccess = json_decode($json, true);

			try
			{
				$connection = new PDO("mysql:host=" . $DBAccess['Host'] . "; dbname=" . $DBAccess['Name'] . "; charset=" . self::$dbEncode, $DBAccess['Login'], $DBAccess['Psw']);
				$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_ASSOC );
				$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				
				self::$connection = $connection;
			}
			catch (PDOException $e)
			{
				die ($e->getMessage());
			}
		}
	}


	function delete (string $table, int $id)
	{
		$query = "DELETE * FROM " . $table . " WHERE id = :id";
		$sql = self::$connection->prepare($query));
		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);
		$sql->execute();
	}



	function getValidation (string $table, string $date_begin='2018-01-01', string $date_ending='', $validated=2){
		$query = "SELECT * FROM " . $table . " WHERE date_create BETWEEN :date_begin AND :date_ending";
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


	function setValidation (string $table, int $id, bool $validation)
	{
		if 		($validation === true) $validation = 1;
		elseif 	($validation === false) $validation = 0;
		$querie = 'UPDATE ' . $table . ' SET validated= :validated WHERE id = :id';

		$sql = self::$connection->prepare($querie);
		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);
		$sql->bindvalue(':validated', (int) $validation, \PDO::PARAM_INT);
		$sql->execute();
	}
}

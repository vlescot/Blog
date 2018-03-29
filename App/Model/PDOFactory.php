<?php
namespace Model;

use PDO;

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
}

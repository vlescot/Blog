<?php
namespace Manager;

use PDO;

// -------------------------------------------------------------------
// 
// 							Class Manager       => Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							__construct ()

							
class Manager
{
	private static $dbEncode =	"utf8";
	protected static $connection	=	null;

	function __construct ()
	{
		if (self::$connection === null) 
		{
			$DBAccess = json_decode( file_get_contents($_SERVER['DOCUMENT_ROOT'] . "P5/Blog/Conf/DBAccess.json"), true);	// Private file to protect confidenfial data (Json)

			try
			{
				$connection = new PDO("mysql:host=" . $DBAccess['Host'] . "; dbname=" . $DBAccess['Name'] . "; charset=" . self::$dbEncode, $DBAccess['Login'], $DBAccess['Password']);
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

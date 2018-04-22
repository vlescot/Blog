<?php
namespace Manager;

use PDO;

/**
 * Instanciate PDO
 */
class Manager
{
    /** @var string $dbEncode contains the encode type of database */
    private static $dbEncode =	"utf8";
    /** @var null|\PDO $connection contains an instance of PDO */
    protected static $connection	=	null;

    /**
     * Instantiate PDO and set it in the static attribut $connection
     */
    public function __construct()
    {
        if (self::$connection === null) {
            $DBAccess = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "P5/Blog/Conf/DBAccess.json"), true);	// Private file to protect confidenfial data (Json)

            try {
                $connection = new PDO("mysql:host=" . $DBAccess['Host'] . "; dbname=" . $DBAccess['Name'] . "; charset=" . self::$dbEncode, $DBAccess['Login'], $DBAccess['Password']);
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                $connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                
                self::$connection = $connection;
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
    }
}

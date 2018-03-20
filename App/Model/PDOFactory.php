<?php

class PDOFactory 
{
	private static $host 		= 	"localhost";
	private static $database 	= 	"blog";
	private static $login 		= 	"root";
	private static $psw 		= 	"genesis";

	private static $db; 

	function __construct (){
	    self::$db = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$database, self::$login, self::$psw );
	    self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		return self::$db;
	}

	function getPDO (){
		return $self::$db;
	}
}

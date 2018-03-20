<?php
namespace Try;

class CRUD 
{
	private $_connection;

	function __construct ()
	{		
		try
		{
			$this->_connection = new PDOFactory;
		}
		catch(Exception $e)
		{
		        die('Erreur : '.$e->getMessage());
		}
	}



/**
 *	@fields = array ('column1', column2, ... ),
 *  @selection = array ('data => value')
 */
	function SELECT (array $fields = array('*'), string $table, array $selection = array(null))
	{
		// Query building...
		$select = 'SELECT ';
		(!$field[0] === '*')? $select .= implode(', ', $fields) : $select .= '*';

		$from = ' FROM ' . $table;

		$where = '';
		(!$where[0]=null)? $where .= ' WHERE ' . key($selection) . "=" . $selection[0];

		$sql = $select . $from . $where ;

		// BD operations...
		$datas = $this->_connection->prepare($sql);
		$datas->execute();

		$results = [];
		while ($ligne = $datas->fetch()) {
			$results[] = $ligne;
		}

		$datas->closeCursor();
		return $results;
	}


/**
 *	@fields = array ('data1'=>'value1', 'data2' => 'value2')
 */
	function INSERT (string $table, array $fields)
	{
		// Query building
		$insert = 'INSERT INTO ' . $table;

	   	$set = " SET (`".implode("`, `", array_keys($fields))."`)";
	   	$set .= " VALUES ('".implode("', '", $fields)."') ";

	   	$sql = $insert . $set ;

	   	// DB operations
	   	$this->_connection->exec($sql);

		$datas->closeCursor();
		return true;
	}


/**
 *	@fields = array ('data1'=>'value1', 'data2' => 'value2'),
 *  @selection = array ('data => value')
 */
	function UPDATE (string $table, array $fields, array $selection = array(null))
	{
		//  Query building
		$update = 'UPDATE ' . $table;

	   	$set = " SET (`".implode("`, `", array_keys($fields))."`)";
	   	$set .= " VALUES ('".implode("', '", $fields)."') ";

		$where = '';
		(!$where[0]=null)? $where .= ' WHERE ' . key($selection) . "=" . $selection[0];

		$sql = $update . $set . $where;

		$this->_connection->exec($sql);

		$datas->closeCursor();
		return true;		
	}
	

	function DELETE (string $table, int $id)
	{
		$sql = 'DELETE FROM ' . $table . ' WHERE id=' $id;

		$this->_connection->exec($sql);

		$datas->closeCursor();
		return true;	
	}

	function JOIN (){
		
	}
}

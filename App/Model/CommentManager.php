<?php
namespace Model;

// require_once './../../vendor/autoload.php';
use Model\PDOFactory;

// -------------------------------------------------------------------
// 
// 							Class CommentManager	=> Database Queries
// 							Extends of PDOFactory 	=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createComment (array $vars)
// 							getCommentList (int $id_post)
// 							updateComment (array $vars)
// 							delete (int $id)
// 							getValidation (int $date_begin, int $date_ending, int $validated)
// 							setValidation  (int $id, bool $set)


class CommentManager extends PDOFactory
{	
	function createComment(array $vars)
	{
		$sql = self::$connection->prepare('
			INSERT INTO comment (content, author, id_post, likes, dislikes, validated, date_create)
			VALUES (?, ?, ?, 0, 0, 0, NOW())');

		$sql->execute(array($vars['content'], $vars['author'], $vars['id_post']));
	}


	function getCommentList(int $id)
	{
		$sql = self::$connection->prepare('	
			SELECT comment.content, comment.date_create, comment.author, comment.validated
			FROM comment 
			RIGHT JOIN post 
			ON comment.id_post = post.id
			WHERE post.id      = :id
			ORDER BY comment.date_create DESC');

		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);

		$sql->execute();
 		return $sql->fetchAll();
	}


	function delete ($table, $id)
	{
		$sql = self::$connection->prepare('DELETE FROM comment WHERE id = :id');

		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);

		$sql->execute();
	}


	function getValidation (string $date_begin='2018-01-01', string $date_ending='', $validated=2){
		$query = "SELECT * FROM comment WHERE date_create BETWEEN :date_begin AND :date_ending";
	
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
		
		$querie = 'UPDATE comment SET validated= :validated WHERE id = :id';

		$sql = self::$connection->prepare($querie);

		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);
		$sql->bindvalue(':validated', (int) $validation, \PDO::PARAM_INT);
	
		$sql->execute();
	}
}


// $CommentManager = new Manager;


/*******************************
 * Test for createComment(array $vars)
 * ****************************/
// $vars = array(
// 'content' => 'Il est super ce blog !',
// 'author'  => 'Pumba',
// 'id_post' => 10);
// $CommentManager->createComment($vars);



/*******************************
 * Test for getCommentList(int $id)
 * ****************************/
// $comments = $CommentManager->getCommentList(1);
// var_dump($comments);



/*******************************
 * Test for delete(int $id)
 * ****************************/
 // $CommentManager->delete(11);



/*******************************
 * Test for getValidation(int $date_begin, int $date_ending)
 * ****************************/
// $validation = $CommentManager->getValidation($date_begin='', $date_ending='', 1);
// var_dump($validation);



/*******************************
 * Test for setValidation(int $id, bool $validation)
 * ****************************/
 // $CommentManager->setValidation(5, false);

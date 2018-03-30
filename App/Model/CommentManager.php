<?php
namespace Manager;

// require_once './../../vendor/autoload.php';
use Manager\Manager;

// -------------------------------------------------------------------
// 
// 							Class CommentManager	=> Database Queries
// 							Extends of Manager 		=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createComment (array $vars)
// 							getCommentList (int $id_post)
// 							updateComment (array $vars)
// 							deleteComment (int $id)
// 							getValidationComment (int $date_begin, int $date_ending, int $validated)
// 							setValidationComment  (int $id, bool $set)
							
class CommentManager extends Manager
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


	function deleteComment ($table, $id)
	{
		return parent::delete('comment', $id);
	}


	function getValidationComment (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
	{
		return parent::getValidation('comment', $date_begin, $date_ending, $validated);
	}


	function setValidationComment (int $id, bool $validation)
	{
		return parent::getValidation('comment', $id, $validation);
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
 * Test for deleteComment(int $id)
 * ****************************/
 // $CommentManager->delete(11);



/*******************************
 * Test for getValidationComment(int $date_begin, int $date_ending)
 * ****************************/
// $validation = $CommentManager->getValidation($date_begin='', $date_ending='', 1);
// var_dump($validation);



/*******************************
 * Test for setValidationComment(int $id, bool $validation)
 * ****************************/
 // $CommentManager->setValidation(5, false);

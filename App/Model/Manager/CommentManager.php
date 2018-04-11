<?php
namespace Manager;

// require_once $_SERVER['DOCUMENT_ROOT'] . '/P5/Blog/vendor/autoload.php';
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
			SELECT comment.content, comment.date_create, comment.author, comment.validated, post.title
			FROM comment 
			RIGHT JOIN post 
			ON comment.id_post = post.id
			WHERE post.id      = :id
			ORDER BY comment.date_create ASC');
		$sql->bindvalue(':id', (int) $id, \PDO::PARAM_INT);
		$sql->execute();
 		return $sql->fetchAll();
	}


	function deleteComment (int $id_post)
	{
		$query = "DELETE FROM comment WHERE id_post = :id_post";
		$sql = self::$connection->prepare($query);
		$sql->bindvalue(':id_post', (int) $id_post, \PDO::PARAM_INT);
		$sql->execute();
	}


	function getValidatedComment (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
	{
		return parent::getValidated('comment', $date_begin, $date_ending, $validated);
	}


	function setValidatedComment (int $id, bool $validated)
	{
<<<<<<< HEAD
		return parent::setValidated('comment', $id, $validated);
=======
		return parent::getValidated('comment', $id, $validated);
>>>>>>> a774084bf9a96120514c02c668c6d7ff1c62bb1f
	}
}


// $CommentManager = new CommentManager;


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
 * Test for getvalidatedComment(int $date_begin, int $date_ending)
 * ****************************/
// $validated = $CommentManager->getvalidated($date_begin='', $date_ending='', 1);
// var_dump($validated);



/*******************************
 * Test for setvalidatedComment(int $id, bool $validated)
 * ****************************/
<<<<<<< HEAD
 // $CommentManager->setValidatedComment(5, true);
=======
 // $CommentManager->setvalidated(5, false);
>>>>>>> a774084bf9a96120514c02c668c6d7ff1c62bb1f

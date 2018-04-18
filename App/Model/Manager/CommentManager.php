<?php
namespace Manager;

use Entity\Comment;
// -------------------------------------------------------------------
// 
// 							Class CommentManager	=> Database Queries
// 							Extends to Manager 		=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createComment (arary vars)
// 							getCommentList (int $id)
// 							deleteComment (int $id_post)
// 							getFilteredComment (string $date_begin='2018-01-01', string $date_ending='', $validated=2)
// 							setValidatedComment (int $id, bool $validated)


class CommentManager extends Manager
{	
	function createComment(Comment $Comment)
	{
		$sql = self::$connection->prepare('
			INSERT INTO comment (content, author, id_post, validated, date_create)
			VALUES (?, ?, ?, 0, NOW())');
		
		$sql->execute([$Comment->content(), $Comment->author(), $Comment->id_post()]);
	}

	function getCommentList(Comment $Comment)
	{
		$sql = self::$connection->prepare('	
			SELECT comment.content, comment.date_create, comment.author, comment.validated, post.title
			FROM comment 
			RIGHT JOIN post 
			ON comment.id_post = post.id
			WHERE post.id      = :id
			ORDER BY comment.date_create ASC');
		
		$sql->bindvalue(':id', (int) $Comment->id_post(), \PDO::PARAM_INT);
		$sql->execute();
 		return $sql->fetchAll();
	}


	function deleteComment (Comment $Comment)
	{
		$sql = self::$connection->prepare('DELETE FROM comment WHERE id_post = :id_post');
		
		$sql->bindvalue(':id_post', (int) $Comment->id_post(), \PDO::PARAM_INT);
		$sql->execute();
	}


	function getFilteredComment ($date_begin, $date_ending, $validated)
	{
		
		if ($validated === 2) {
			$query = 'SELECT * FROM comment 
			WHERE date_create BETWEEN :date_begin 
			AND :date_ending
			ORDER BY date_create DESC';
		}else $query = 'SELECT * FROM comment 
			WHERE date_create BETWEEN :date_begin 
			AND :date_ending
			AND validated=' . $validated . '
			ORDER BY date_create DESC';
			
		$sql = self::$connection->prepare($query);
		
		$sql->bindvalue(':date_begin', (string) $date_begin, \PDO::PARAM_STR);
		$sql->bindvalue(':date_ending', (string) $date_ending, \PDO::PARAM_STR);

		$sql->execute();
		return $sql->fetchAll();
	}


	function setValidatedComment (Comment $Comment)
	{
		$sql = self::$connection->prepare('UPDATE comment SET validated= :validated WHERE id = :id');

		$sql->bindvalue(':id', (int) $Comment->id(), \PDO::PARAM_INT);
		$sql->bindvalue(':validated', (int) $Comment->validated(), \PDO::PARAM_INT);
		$sql->execute();
	}
}

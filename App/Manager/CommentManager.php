<?php
namespace Manager;

use Model\Comment;

/**
 * Class CommentManager manage queries datas in comment table from db
 */
class CommentManager extends Manager
{
    /**
     * Adding a comment in db
     * @param  \Model\Comment $Comment
     */
    public function createComment(Comment $Comment)
    {
        $sql = self::$connection->prepare('
			INSERT INTO comment (content, author, id_post, validated, date_create)
			VALUES (?, ?, ?, 0, NOW())');
        
        $sql->execute([$Comment->content(), $Comment->author(), $Comment->id_post()]);
    }

    /**
     * Get all comments of a single post
     * @param  \Model\Comment $Comment
     * @return array containing the list of comments
     */
    public function getCommentList(Comment $Comment)
    {
        $sql = self::$connection->prepare('	
			SELECT comment.content, comment.date_create, comment.author, comment.validated, post.title
			FROM comment 
			RIGHT JOIN post 
			ON comment.id_post = post.id
			WHERE post.id      = :id
			ORDER BY comment.date_create DESC');
        
        $sql->bindvalue(':id', (int) $Comment->id_post(), \PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    /**
     * Delete all comments of a post with the id_post
     * @param  \Model\Comment $Comment
     */
    public function deleteAllComments(Comment $Comment)
    {
        $sql = self::$connection->prepare('DELETE FROM comment WHERE id_post = :id_post');
        
        $sql->bindvalue(':id_post', (int) $Comment->id_post(), \PDO::PARAM_INT);
        $sql->execute();
    }

    /**
     * Delete comment with its id
     * @param  \Model\Comment $Comment
     */
    public function deleteComment(Comment $Comment)
    {
        $sql = self::$connection->prepare('DELETE FROM comment WHERE id=:id');
        
        $sql->bindvalue(':id', (int) $Comment->id(), \PDO::PARAM_INT);
        $sql->execute();
    }

    /**
     * Get all comments filtered whith the params
     *
     * @param  string $date_begin Date which start the filter
     * @param  string $date_ending Date which end the filter
     * @param  int $validated Value of validated
     * @return array of comments
     */
    public function getFilteredComment($date_begin, $date_ending, $validated)
    {
        if ($validated === 2) {
            $query = '
            SELECT comment.id, comment.content, comment.date_create, comment.author, comment.validated, comment.id_post, post.title
            FROM comment 
            RIGHT JOIN post 
            ON comment.id_post = post.id
			WHERE comment.date_create BETWEEN :date_begin 
			AND :date_ending
			ORDER BY date_create DESC';
        } else {
            $query = '
            SELECT comment.id, comment.content, comment.date_create, comment.author, comment.validated, comment.id_post, post.title
            FROM comment 
            RIGHT JOIN post 
            ON comment.id_post = post.id
			WHERE comment.date_create BETWEEN :date_begin 
			AND :date_ending
			AND validated= :validated
			ORDER BY date_create DESC';
        }
            
        $sql = self::$connection->prepare($query);
        
        $sql->bindvalue(':date_begin', (string) $date_begin, \PDO::PARAM_STR);
        $sql->bindvalue(':date_ending', (string) $date_ending, \PDO::PARAM_STR);
        if ($validated !== 2) {
            $sql->bindvalue(':validated', (string) $validated, \PDO::PARAM_STR);
        }

        $sql->execute();
        return $sql->fetchAll();
    }

    /**
     * Set the validation status of a comment
     * @param  \Model\Comment $Comment
     */
    public function setValidatedComment(Comment $Comment)
    {
        $sql = self::$connection->prepare('UPDATE comment SET validated= :validated WHERE id = :id');

        $sql->bindvalue(':id', (int) $Comment->id(), \PDO::PARAM_INT);
        $sql->bindvalue(':validated', (int) $Comment->validated(), \PDO::PARAM_INT);
        $sql->execute();
    }
}

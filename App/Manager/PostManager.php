<?php
namespace Manager;

use Model\Post;
use PDO;

/**
 * Class PostManager manage queries datas in post table from db
 */
class PostManager extends Manager
{
    /**
     * Adding a post in bd
     * @param  \Model\Post $Post
     */
    public function createPost(Post $Post)
    {
        $sql = self::$connection->prepare("
			INSERT INTO post (title, lede, content, img, id_member, date_create, date_update)
			VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
        
        $sql->execute(array($Post->title(), $Post->lede(), $Post->content(), $Post->img(), $Post->id_member()));
    }

    
    /**
     * Count the number of post on the db
     * @return array int
     */
    public function countPosts()
    {
        $sql = self::$connection->prepare('SELECT COUNT(id) as nb FROM post');
        $sql->execute();
        return $sql->fetch();
    }


    /**
     * Get list of posts with its member login
     * @param  int $begin offset begin
     * @param  int $limit limit the number of post returned
     * @return array of posts list
     */
    public function getPostsList(int $begin = -1, int $limit = -1)
    {
        $query = 'SELECT post.id, post.title, post.lede, post.content, member.login, post.date_create, post.date_update, post.img
				FROM post 
				JOIN member 
				ON post.id_member = member.id
				ORDER BY post.date_create DESC';
        if ($begin != -1 || $limit != -1 && is_int($begin) && is_int($limit)) {
            $query .= ' LIMIT :limit OFFSET :begin';
        }
        
        $sql = self::$connection->prepare($query);
        $sql->bindvalue(':limit', (int) $limit, PDO::PARAM_INT);
        $sql->bindvalue(':begin', (int) $begin, PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetchAll();
    }

    /**
     * Get list of posts with date filter
     * @param  string $date_begin  Date which start the filter
     * @param  string $date_ending Date which end the filter
     * @return array of posts list
     */
    public function getFilteredPosts($date_begin, $date_ending)
    {
        $sql = self::$connection->prepare('SELECT * FROM post WHERE date_create BETWEEN :date_begin AND :date_ending
											ORDER BY date_create DESC');
        
        if ($date_begin !== '' && $date_ending !== '') {
            $sql->bindvalue(':date_begin', (string) $date_begin, PDO::PARAM_STR);
            $sql->bindvalue(':date_ending', (string) $date_ending, PDO::PARAM_STR);
        }
        $sql->execute();
        return $sql->fetchAll();
    }

    /**
     * Get a single post with its id
     * @param  \Model\Post $Post
     * @return array of the post
     */
    public function getPost(Post $Post)
    {
        $sql = self::$connection->prepare('		
			SELECT post.id, post.title, post.lede,member.login, post.content, post.date_create, post.date_update, post.img
			FROM post
			JOIN member
			ON post.id_member = member.id
			WHERE post.id=:id');

        $sql->bindvalue(':id', (int) $Post->id(), PDO::PARAM_INT);
        $sql->execute();
        return $sql->fetch();
    }

    /**
     * Updating a post
     * @param  \Model\Post $Post
     */
    public function updatePost(Post $Post)
    {
        $sql = self::$connection->prepare('
			UPDATE post
			SET title = :title, lede = :lede, content = :content, date_update = NOW(), img = :img
			WHERE id = :id');

        $sql->bindvalue(':id', $Post->id(), PDO::PARAM_INT);
        $sql->bindvalue(':title', $Post->title(), PDO::PARAM_STR);
        $sql->bindvalue(':lede', $Post->lede(), PDO::PARAM_STR);
        $sql->bindvalue(':content', $Post->content(), PDO::PARAM_STR);
        $sql->bindvalue(':img', $Post->img(), PDO::PARAM_STR);
        $sql->execute();
    }

    /**
     * Delete a post with its id
     * @param  \Model\Post $Post
     */
    public function deletePost(Post $Post)
    {
        $sql = self::$connection->prepare('DELETE FROM post WHERE id = :id');
        
        $sql->bindvalue(':id', (int) $Post->id(), PDO::PARAM_INT);
        $sql->execute();
    }
}

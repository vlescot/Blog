<?php
// require_once './PDOFactory.php';

/*
createPost()
getlistPosts()
getPost()
updatePost()
createComment()
getComments()
updateComment()
delete()
 */

Class Manager
{
	private static $host 		= 	"localhost";
	private static $database 	= 	"blog";
	private static $login 		= 	"root";
	private static $psw 		= 	"genesis";

	private static $db; 

	function __construct ()
	{
	    self::$db = new PDO('mysql:host=' . self::$host . ';dbname=' . self::$database, self::$login, self::$psw );
	    self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	function createPost(array $vars)
	{
		$sql = self::$db->prepare('	INSERT INTO post
									SET title = :title, lede = :lede, content = :content, date_create = NOW(), date_update = NOW(), img_path = :img_path, validated = 0, id_member = :id_member');

		$sql->bindvalue(':title', $vars['title']);
		$sql->bindvalue(':lede', $vars['lede']);
		$sql->bindvalue(':content', $vars['content']);
		$sql->bindvalue(':img_path', $vars['img_path']);
		$sql->bindvalue(':id_member', $vars['id_member']);

		$sql->execute();
	}
	
	function getListPosts()
	{
		$query = self::$db->query('	SELECT id, title, lede, content, date_create, date_update, img_path, validated, id_member 
									FROM post 
									ORDER BY id DESC');

		$listPosts = $query->fetchAll();
		
 		return $listPosts;
	}

	function getPost($id)
	{
		$sql = self::$db->prepare('	SELECT id, title, lede, content, date_create, date_update, img_path, validated, id_member 
									FROM post 
									WHERE id = :id');
		
		$sql->bindvalue(':id', (int) $id);

		$sql->execute();
		$post = $sql->fetch();

		return $post;
	}

	function updatePost(array $vars)
	{
		$sql = self::$db->prepare('	UPDATE post
									SET title = : title, lede = : lede, content = : content, date_update = NOW(), img_path = : img_path, id_member = : id_member
									WHERE id = :id');

		$sql->bindvalue(':title', $vars['title']);
		$sql->bindvalue(':lede', $vars['lede']);
		$sql->bindvalue(':content', $vars['content']);
		$sql->bindvalue(':img_path', $vars['img_path']);
		$sql->bindvalue(':id_member', $vars['id_member']);

		$sql->execute();
	}

	function createComment(array $vars)
	{
		$sql = self::$db->prepare('	INSERT INTO comment
									SET content = :content, date_create = NOW(), like = 0, dislike = 0, id_member = :id_member, id_post = :id_post');

		$sql->bindvalue(':content', $vars['content']);
		$sql->bindvalue(':id_member', $vars['id_member']);
		$sql->bindvalue(':id_post', $vars['id_post']);

		$sql->execute();
	}

	function getComments($id)
	{
		$sql = self::$db->prepare('	SELECT comment.id, comment.content, comment.date_create, comment.like, comment.dislike, comment.id_member, comment.id_post 
									FROM comment 
									RIGHT JOIN post 
									ON comment.id_post = post.id
									WHERE post.id = :id');

		$sql->bindvalue(':id', (int) $id);

		$sql->execute();
		$comments = $sql->fetchAll();

 		return $comments;
	}

	function updateComment(array $vars)
	{
		$sql = self::$db->prepare('	UPDATE comment
									SET content = :content, date_create = NOW(), like = 0, dislike = 0, id_member = :id_member, id_post = :id_post 
									WHERE id = :id');

		$sql->bindvalue(':id', $vars['id']);
		$sql->bindvalue(':content', $vars['content']);
		$sql->bindvalue(':id_member', $vars['id_member']);
		$sql->bindvalue(':id_post', $vars['id_post']);

		$sql->execute();
	}

	function delete ($id){
		self::$db->exec('DELETE FROM post WHERE id = '. (int) $id);
	}

}

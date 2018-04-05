<?php
namespace Manager;

// require_once './../../vendor/autoload.php';
use Manager\Manager;

// -------------------------------------------------------------------
// 
// 							Class PostManager       => Database Queries
// 							Extends of Manager 		=> Connection with database
// 							
// -------------------------------------------------------------------
// -------------------------------------------------------------------
// 							FUNCTION LISTING
// -------------------------------------------------------------------
// 							createPost (array $vars)
// 							getPostsList (int $begin [optional], int $limit [optional])
// 							getPost (int $id)
// 							updatePost (array $vars)
// 							countPosts ()
// 							deletePost (int $id)

class PostManager extends Manager
{
	function createPost(array $vars)
	{
		$sql = self::$connection->prepare("
			INSERT INTO post (title, lede, content, img, id_member, date_create, date_update)
			VALUES (?, ?, ?, ?, ?, NOW(), NOW())");
		$sql->execute(array($vars['title'], $vars['lede'], $vars['content'], $vars['img'], $vars['id_member']));
	}

	
	function getPostsList(int $begin = -1, int $limit = -1)
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
		$sql->bindvalue(':limit', (int) $limit,\PDO::PARAM_INT);
		$sql->bindvalue(':begin', (int) $begin,\PDO::PARAM_INT);
		$sql->execute();
 		return $sql->fetchAll();
	}

	function getPost($id)
	{
		$sql = self::$connection->prepare('		
			SELECT post.id, post.title, post.lede,member.login, post.content, post.date_create, post.date_update, post.img
			FROM post 
			JOIN member 
			ON post.id_member = member.id
			WHERE post.id=:id');

		$sql->bindvalue(':id', (int) $id,\PDO::PARAM_INT);
		$sql->execute();
		return $sql->fetch();
	}


	function updatePost(array $vars)
	{
		$sql = self::$connection->prepare('
			UPDATE post
			SET title = :title, lede = :lede, content = :content, date_update = NOW(), img = :img, id_member = :id_member
			WHERE id = :id');

		$sql->bindvalue(':id', $vars['id'], \PDO::PARAM_INT);
		$sql->bindvalue(':title', $vars['title'], \PDO::PARAM_STR);
		$sql->bindvalue(':lede', $vars['lede'], \PDO::PARAM_STR);
		$sql->bindvalue(':content', $vars['content'], \PDO::PARAM_STR);
		$sql->bindvalue(':img', $vars['img'], \PDO::PARAM_STR);
		$sql->bindvalue(':id_member', $vars['id_member'], \PDO::PARAM_INT);
		$sql->execute();
	}


	function countPosts ()
	{
		$sql = self::$connection ->query("SELECT COUNT(*) AS nb FROM post");
		$nb = $sql->fetch();
		return $nb['nb'];
	}

	function deletePost (int $id)
	{
		return parent::delete('post', $id);
	}
}

// $PostManager = new PostManager;

/*******************************
 * Test for createPost(array $vars)
 * ****************************/
// $vars = array(
	// 'title'     => 'Un titre d\'article,
	// 'lede'      => 'Un chapô d\'article,
	// 'content'   => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
	// 'img'  => 'img.png',
	// 'id_member' => 1);
// $PostManager->createPost($vars);



/*******************************
 * Test for getPostsList(int $begin [optional], int $limit [optional])
 * ****************************/
// $posts_list = $PostManager->getPostsList(1, 3);
// var_dump($posts_list);



/*******************************
 * Test for getPost(int $id)
 * ****************************/
// $post = $PostManager->getPost(2);
// var_dump($post);



/*******************************
 * Test for updatePost(array $vars)
 * ****************************/
// $vars = array(
// 	'id'        => 1,
// 	'title'     => 'Un autre titre ici',
// 	'lede'      => 'Le lede là aussi',
// 	'content'   => 'Un autre Lorem ipsum dolor sit amet, consectetur adipisicing elit. Si si vous avez vus',
// 	'img'  => 'image.jpg',
// 	'id_member' => 1);
// $PostManager->updatePost($vars);



/*******************************
 * Test for countPosts()
 * ****************************/
// $nb = $PostManager->countPosts();
// echo $nb;



/*******************************
 * Test for delete(int $id)
 * ****************************/
 // $PostManager->delete(11);

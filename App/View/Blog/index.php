<?php
require './../../../vendor/autoload.php';
	
use Manager\PostManager;
use Manager\CommentManager;

$PostManager = new PostManager;
$CommentManager = new CommentManager;

$loader = new \Twig_Loader_Filesystem(getcwd());
$twig = new \Twig_Environment($loader, array(
	'debug' => true,
	'cache' => false // __dir__ . './../tmp'
	));
$twig->addExtension(new Twig_Extension_Debug());



if (isset($_GET['v'])) {
	$page = $_GET['v'];

	switch ($page) {
		case 'blog':
			echo $twig->render('blog.twig', array(
				'posts' => $PostManager->getPostsList()));
			break;
		
		case 'blogpost-1':
			echo $twig->render('blogpost.twig', array(
				'post' => $PostManager->getPost(1),
				'comments' => $CommentManager->getCommentList(1)));
			break;

			case 'connection':
				echo $twig->render('connection.twig');
				break;

			case 'registration':
				echo $twig->render('registration.twig');
				break;

		case '404':
			$loader = new \Twig_Loader_Filesystem(array('./../Error/', getcwd()));
			$twig = new \Twig_Environment($loader, array(
				'debug' => true ));
			$twig->addExtension(new Twig_Extension_Debug());

			echo $twig->render('404.twig');
			break;
		
		default:
			echo "ERROR INDEX";
			break;
	}
}else {
	echo $twig->render('welcome.twig', array(
		''));
}
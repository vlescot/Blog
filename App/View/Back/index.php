<?php
require './../../../vendor/autoload.php';
	
use Model\PostManager;
use Model\CommentManager;
use Model\MemberManager;

$PostManager = new PostManager;
$CommentManager = new CommentManager;
$MemberManager = new MemberManager;

$loader = new \Twig_Loader_Filesystem(getcwd());
$twig = new \Twig_Environment($loader, array(
	'debug' => true,
	'cache' => false // __dir__ . './../tmp'
	));
$twig->addExtension(new Twig_Extension_Debug());


if (isset($_GET["v"])) {
	$page = $_GET['v'];

	switch ($page) {
		case 'posts':
			if (isset($_POST['date_begin']) || isset($_POST['date_ending'])) {
				if (!isset($_POST['date_begin']) || $_POST['date_begin'] == '') {
					$_POST['date_begin'] = "2018-01-01";
				}
				if (!isset($_POST['date_ending']) || $_POST['date_ending'] == '') {
					$_POST['date_ending'] = date('Y-m-d');
				}
				echo $twig->render('posts.twig', array(
					'posts' => $PostManager->getValidation($_POST['date_begin'], $_POST['date_ending'], 2)));
			}
			else {
			echo $twig->render('posts.twig', array( 
				'title' =>'Titre de la page',
				'posts' => $PostManager->getPostsList()));
			}
			break;
		
		case 'validation':
			if (isset($_POST['date_begin']) || isset($_POST['date_ending']) || isset($_POST['validation'])) {
				if (!isset($_POST['date_begin']) || $_POST['date_begin'] == '') {
					$_POST['date_begin'] = "2018-01-01";
				}
				if (!isset($_POST['date_ending']) || $_POST['date_ending'] == '') {
					$_POST['date_ending'] = date('Y-m-d');
				}
				if (!isset($_POST['validation']) || $_POST['validation'] == '') {
					$_POST['validation'] = 2;
				}else {
					$_POST['validation'] = intval($_POST['validation']);
				}

				echo $twig->render('validation.twig', array(
					'comments' => $CommentManager->getValidation($_POST['date_begin'], $_POST['date_ending'], $_POST['validation']),
					'members' => $MemberManager->getValidation($_POST['date_begin'], $_POST['date_ending'], $_POST['validation'])));
			}
			else {
				echo $twig->render('validation.twig', array(
					'comments' =>$CommentManager->getValidation(),
					'members' => $MemberManager->getValidation()));
			}
			break;

		case 'addPost':
			echo $twig->render('add_post.twig');
			break;

		case 'update-10':
			echo $twig->render('add_post.twig', array(
				'update' => $PostManager->getPost(1)));
			break;

		default:
			echo $twig->render('dashboard.twig');
			break;
	}
}else echo $twig->render('dashboard.twig');

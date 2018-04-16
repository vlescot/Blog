<?php
namespace Controller;

use Manager\CommentManager;
use Manager\MemberManager;
use Manager\PostManager;
use Service\Mailer;
use Service\Notification;

class BlogController extends Controller
{
	function NoRoute ()
	{
		echo $this->twig->render('404.twig');
	}

	function home ()
	{
		echo $this->twig->render('welcome.twig');
	}

	function article (int $id = 0){
		$PostManager = new PostManager();
		if ($id === 0) {
			echo $this->twig->render('blog.twig', ['posts' => $PostManager->getPostsList()]);
			exit;
		}
		if ($post = $PostManager->getPost($id)){
			$CommentManager = new CommentManager();
			echo $this->twig->render('blogpost.twig', array('post' => $post, 'comments' => $CommentManager->getCommentList($id)));
		}
	}

	function contact ()
	{
		if (!isset($_POST) || (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['subject']) && empty($_POST['message']))) {
			new Notification ('Une information est manquante pour l\'envoie de votre e-mail');
			header('Location: http://localhost/P5/Blog/accueil#contact-form');
			die;
		}
		require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_admin_contact.php');

		$mailer = new Mailer('vincent.lescot@gmail.com', $subject, $message);
		$mailer->send();

		new Notification ('Merci pour votre intérêt ! Votre e-mail a bien été envoyé à Vincent', 'success');
		header('Location: ' . $_SERVER['REQUEST_URI']);
	}

	function comment (int $id)
	{	
		if (isset($_POST) && isset($_POST['author']) && isset($_POST['content']) && $_POST['author'] !=='' && $_POST['content'] !== '' ) {
			$datas = [
				'content' => $_POST['content'], 
				'author' => $_POST['author'], 
				'id_post' => $id
			];
			$CommentManager = new CommentManager();
			$CommentManager->createComment($datas);
			new Notification ('Votre commentaire à été ajouté, il est maintenant en attente de validation', 'success');
			header('Location: ' . $_SERVER['REQUEST_URI']);
		}
	}
}
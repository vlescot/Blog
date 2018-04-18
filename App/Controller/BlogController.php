<?php
namespace Controller;

use Manager\CommentManager;
use Manager\MemberManager;
use Manager\PostManager;
use Entity\Post;
use Entity\Comment;
use Entity\Mail;
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


	function showPost (int $id = 0)
	{
		$PostManager = new PostManager();
		if ($id === 0) {
			echo $this->twig->render('blog.twig', ['posts' => $PostManager->getPostsList()]);
			exit;
		}

		$Post = new Post(['id' => $id]);
		$Comment = new Comment (['id_post' => $id]);

		$CommentManager = new CommentManager();
		echo $this->twig->render('blogpost.twig', [
			'post' => $PostManager->getPost($Post), 
			'comments' => $CommentManager->getCommentList($Comment)
		]);
	}


	function addComment (int $id)
	{	
		if (!isset($_POST) && !isset($_POST['author']) && !isset($_POST['content']) && $_POST['author'] ==='' && $_POST['content'] === '' ) {
			$this->notification('Vous devez remplir votre nom ainsi le commentaire');
		}

		$Comment = new Comment ([
			'content' => $_POST['content'], 
			'author' => $_POST['author'], 
			'id_post' => $id
		]);

		$CommentManager = new CommentManager();
		$CommentManager->createComment($Comment);
		$this->notification('Votre commentaire à été ajouté, il est maintenant en attente de validation', 'success');
	}


	function contact ()
	{
		if (!isset($_POST) || (empty($_POST['name']) && empty($_POST['email']) && empty($_POST['subject']) && empty($_POST['message']))) {
			$this->notification('Une information est manquante pour l\'envoie de votre e-mail');
		}
		// Sending e-mail from contact
		$Mail = new Mail([
			'contact_name' => $_POST['name'],
			'contact_email' => $_POST['email'],
			'contact_subject' => $_POST['subject'],
			'contact_content' => $_POST['message']
		]); 
		require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_admin_contact.php');

		$Mail->setMail_to('vincent.lescot@gmail.com');
		$Mail->setSubject($subject);
		$Mail->setContent($message);

		$mailer = new Mailer($Mail->Mail_to(), $Mail->subject(), $Mail->content());
		$mailer->send();

		$this->notification ('Merci pour votre intérêt ! Votre e-mail a bien été envoyé à Vincent', 'success');
	}

	private function notification ($message, $type='danger')
	{
		new Notification ($message, $type);
		header('Location: ' . $_SERVER['REQUEST_URI']);
		exit;		
	}
}
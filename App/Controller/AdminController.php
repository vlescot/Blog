<?php
namespace Controller;

use Manager\PostManager;
use Manager\CommentManager;
use Manager\MemberManager;
use Service\ImageUploader;
use Service\Notification;
use Service\Mailer;

class AdminController extends Controller
{
	function __construct($view){
		// Disallow access if the member is not connected 
		if (!isset($_SESSION['ip']) || $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
			new Notification ('Vous devez vous connecter pour accéder à cette page');
			header('Location: http://localhost/P5/Blog/authentification');
			exit;
		// Disallow access if the member is not validated
		}else if (!isset($_SESSION['validated']) || $_SESSION['validated'] === 0){
			new Notification ('Votre accès n\'as pas encore été validé');
			header('Location: http://localhost/P5/Blog');
			exit;
		}

		parent::__construct($view);
	}

	private function UploadingError ($num_error)
	{
		switch ($num_error) {
			case 1:
				new Notification ('L\'image est trop lourde pour être chargée');
				break;
			case 2:
				new Notification ('L\'image est trop lourde pour être chargée');
				break;
			case 3:
				new Notification ('L\'image n\'est que partiellement chargée. Cela peut venir de votre connexion...');
				break;
			default:
				new Notification ('Nous avons rencontré un probléme lors du téléchargement de votre fichier');
		}
		header('Location: ' . $_SERVER['REQUEST_URI']);
		exit;
	}

	function home ()
	{
		echo $this->twig->render('dashboard.twig');
	}

	function posts ()
	{
		$PostManager = new PostManager();
		$MemberManager = new MemberManager();

		// Setting of filters
		if (!isset($_GET['date_ending']) || $_GET['date_ending'] == '') {
			// Set a consistant date if empty
			$date = date_create(date('Y-m-d')); 
			date_add($date, date_interval_create_from_date_string('1 days'));
			$date_ending =  date_format($date, 'Y-m-d');
		}	else $date_ending = $_GET['date_ending'];
		(!isset($_GET['date_begin']) || $_GET['date_begin'] == '') 		?	$date_begin = "2018-01-01" 		: $date_begin = $_GET['date_begin'];

		// Get Posts List in database
		$all_posts = $PostManager->getPostFilter($date_begin, $date_ending, 2);

		// Set the login of member to inject it into the view
		$member_list = $MemberManager->getMemberList();
		$authors = [];
		foreach ($member_list as $key => $v) $authors[$member_list[$key]['id']] = $member_list[$key]['login']; // Formats an array such datas are $authors = ['id' => 'login'] 
		foreach ($all_posts as $key => $v) $all_posts[$key]['author'] = $authors[$all_posts[$key]['id_member']]; // Use the id_member to get the login into $authors and set it as 'author' into $all_posts

		echo $this->twig->render('posts.twig', ['posts' => $all_posts]); 
	}

	function validation ()
	{
		$MemberManager = new MemberManager();
		$CommentManager = new CommentManager();

		// Assigns consistents values if doesn't already done into the filter form
		if (!isset($_GET['date_ending']) || $_GET['date_ending'] == '') {
			// Set a consistant date if empty
			$date = date_create(date('Y-m-d')); 
			date_add($date, date_interval_create_from_date_string('1 days'));
			$date_ending =  date_format($date, 'Y-m-d');
		}	else $date_ending = $_GET['date_ending'];
		(!isset($_GET['date_begin']) || $_GET['date_begin'] == '') 	?	$date_begin = "2018-01-01" 		: $date_begin = $_GET['date_begin'];
		(!isset($_GET['validated']) || $_GET['validated'] == '') 	?	$validated = 2 /*both*/			: $validated = intval($_GET['validated']);

		echo $this->twig->render('validation.twig', [
			'comments' => $CommentManager->getvalidatedComment($date_begin, $date_ending, $validated),
			'members' => $MemberManager->getvalidatedMember($date_begin, $date_ending, $validated),
			'session' => $_SESSION
		]);
	}

	function addPost ()
	{
		if (empty($_POST)) {
			echo $this->twig->render('add_post.twig');
			exit;
		}
		
		if (!isset($_POST['title']) && !isset($_POST['lede']) && !isset($_POST['content']) && $_POST['title'] === '' && $_POST['content'] === '' && $_POST['lede'] === ''){
			new Notification('Les champs "Titre", "Châpo", et "Contenu" sont obligatoires');
			header('Location: ' . $_SERVER['DOCUMENT_ROOT']);
		}

		if (!empty($_FILES) && $_FILES['file']['error'] !== 4) {
			if ($_FILES['file']['error'] > 0) { 
				$this->UploadingError($_FILES['file']['error']); // Error case
			}
			// No error
			$ImgUpload = new ImageUploader();
			$img_name = $ImgUpload->upload();
		}else $img_name = '';

		$datas = [	'title' 	=> $_POST ['title'],
					'lede' 		=> $_POST ['lede'],
					'content' 	=> $_POST ['content'],
					'img' 		=> $img_name,	
					'id_member' => $_SESSION['id_member']
		];
		// Writes the informations into the database
		$PostManager = new PostManager();
		$PostManager->createPost($datas);

		new Notification ('Votre article a bien été créé', 'success');
		header('Location: http://localhost/P5/Blog/admin/article');
	}

	function updatePost ($id){
		if (empty($_POST))	{
			$PostManager = new PostManager();
			echo $this->twig->render('add_post.twig', array('update' => $PostManager->getPost($id)));
			exit;
		}

		$PostManager = new PostManager();
		$old_post = $PostManager->getPost($id);

		if (isset($_POST['img-remove']) && $_POST['img-remove'] == 'on' && (empty($_FILES) || $_FILES['file']['error'] === 4) ) {
			$ImgUpload = new ImageUploader();
			$ImgUpload->remove($old_post['img']);
			$img_name = '';
		}

		if (!empty($_FILES) && $_FILES['file']['error'] != 4) {
			if ($_FILES['file']['error'] > 0) {
				$this->UploadingError($_FILES['file']['error']);
			}
			$ImgUpload = new ImageUploader();
			$img_name = $ImgUpload->upload();
			if ($old_post['img'] !== '') $ImgUpload->remove($old_post['img']);
		}
		
		$datas = [];
		if (isset($_POST ['title']) && $_POST ['title'] !== '') 	$datas['title'] 	= $_POST ['title'];
		if (isset($_POST ['lede']) && $_POST ['lede'] !== '') 		$datas['lede'] 		= $_POST ['lede'];
		if (isset($_POST ['content']) && $_POST ['content'] !== '') $datas['content'] 	= $_POST ['content'];
		if (isset($img_name))		 								$datas['img'] 		= $img_name;
		$datas['id_member'] = $_SESSION['id_member'];
		$datas['id'] 		= $id;

		$datas = array_replace($old_post, $datas);
		$PostManager->updatePost($datas);

		new Notification ('L\'article a bien été mis à jour', 'success');
		header('Location: http://localhost/P5/Blog/admin/article');
	}

	function deletePost ()
	{
		$CommentManager = new CommentManager();
		$PostManager 	= new PostManager();
		$CommentManager->deleteComment($_POST['id']);
		$PostManager->deletePost($_POST['id']);
		new Notification ('L\'article a bien été supprimé', 'success');
	}

	function setValidation ()
	{
		$table 		= $_POST['table'];
		$validation = intval($_POST['validation']);
		$id 		= intval($_POST['id']);

		switch ($table) {
			case 'comment':
				$CommentManager = new CommentManager;
				$CommentManager->setValidatedComment($id, $validation);
				if ($validation === 0) new Notification ('Ce commentaire n\'est plus visible', 'info');
				if ($validation === 1) new Notification ('Ce commentaire est maintenant visible', 'success');
				break;
			case 'member':
				$MemberManager = new MemberManager;
				$MemberManager->setValidatedMember($id, $validation);
				if ($validation === 0) new Notification ('Ce membre n\'a plus accés à l\'espace administratif', 'info');
				if ($validation === 1) new Notification ('Ce membre a maintenant accés à l\'espace administratif', 'success');
				break;
		}

		// Sending an e-mail to the validated member
		if ($table === 'member' && $validation === 1) {
			$member = $MemberManager->getMemberbyId($id);
			require ($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_member_validation.php');
			$mail = new Mailer ($member['email'], $subject, $message);
			$mail->send();
		}
	}
}
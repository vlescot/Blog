<?php
namespace Controller;

use Manager\PostManager;
use Manager\CommentManager;
use Manager\MemberManager;
use Model\Post;
use Model\Member;
use Model\Comment;
use Model\Mail;
use Service\ImageUploader;
use Service\Notification;
use Service\Mailer;

/**
 * Manage to call the class and method for the administration part of the website
 */
class AdminController extends Controller
{
    /**
     * @param string $view is send to the parent
     */
    public function __construct($view)
    {
        if ($this->allowAccess() === true) {
            parent::__construct($view);
        }
    }

    /**
     * Checks if the user is connected and is allowing to access by validation
     */
    private function allowAccess()
    {
        // Disallow access if the member is not connected
        if (!isset($_SESSION['ip']) || $_SESSION['ip'] !== $_SERVER['REMOTE_ADDR']) {
            new Notification('Vous devez vous connecter pour accéder à cette page');
            header('Location: ' . URL . 'authentification');
            return false;
        // Disallow access if the member is not validated
        } elseif (!isset($_SESSION['validated']) || $_SESSION['validated'] === 0) {
            new Notification('Votre accès n\'as pas encore été validé', 'info');
            header('Location: ' . URL);
            return false;
        }
        return true;
    }


    /**
     * Set a notification in error case during uplaod of picture and redirects the user
     * @param int $num_error the error num given by $_FILES['file']['error']
     */
    private function UploadingError($num_error)
    {
        switch ($num_error) {
            case 1:
                new Notification('L\'image est trop lourde pour être chargée');
                return true;
                break;
            case 2:
                new Notification('L\'image est trop lourde pour être chargée');
                return true;
                break;
            case 3:
                new Notification('L\'image n\'est que partiellement chargée. Cela peut venir de votre connexion...');
                return true;
                break;
            default:
                new Notification('Nous avons rencontré un probléme lors du téléchargement de votre fichier');
                return true;
        }
        header('Location: ' . $_SERVER['REMOTE_ADDR']);
    }


    /**
     * @Route("/admin/accueil")
     */
    public function home()
    {
        echo $this->twig->render('dashboard.twig');
    }


    /**
     * @Route("/admin/article")
     */
    public function postsList()
    {
        $PostManager = new PostManager();
        $MemberManager = new MemberManager();

        // Setting of filters
        if (!isset($_GET['date_ending']) || $_GET['date_ending'] == '') {
            // Set a consistant date if empty
            $date = date_create(date('Y-m-d'));
            date_add($date, date_interval_create_from_date_string('2 days'));
            $date_ending =  date_format($date, 'Y-m-d');
        } else {
            $date_ending = $_GET['date_ending'];
        }
        (!isset($_GET['date_begin']) || $_GET['date_begin'] == '') 		?	$date_begin = "2018-01-01" 		: $date_begin = $_GET['date_begin'];

        // Get Posts List in database
        $filtered_post = $PostManager->getFilteredPosts($date_begin, $date_ending);

        // Set the login of member to inject it into the view
        $member_list = $MemberManager->getMemberList();
        $authors = [];
        foreach ($member_list as $key => $v) {
            $authors[$member_list[$key]['id']] = $member_list[$key]['login'];
        } // Formats an array such datas are $authors = ['id' => 'login']
        foreach ($filtered_post as $key => $v) {
            $filtered_post[$key]['author'] = $authors[$filtered_post[$key]['id_member']];
        } // Use the id_member to get the login into $authors and set it as 'author' into $filtered_post

        echo $this->twig->render('posts.twig', ['posts' => $filtered_post]);
    }


    /**
     * @Route("/admin/validation")
     */
    public function validation()
    {
        $MemberManager = new MemberManager();
        $CommentManager = new CommentManager();

        // Assigns consistents values if doesn't already done into the filter form
        if (!isset($_GET['date_ending']) || $_GET['date_ending'] == '') {
            // Set a consistant date if empty
            $date = date_create(date('Y-m-d'));
            date_add($date, date_interval_create_from_date_string('2 days'));
            $date_ending =  date_format($date, 'Y-m-d');
        } else {
            $date_ending = $_GET['date_ending'];
        }

        (!isset($_GET['date_begin']) || $_GET['date_begin'] == '') 	?	$date_begin = "2018-01-01" 		: $date_begin = $_GET['date_begin'];
        (!isset($_GET['validated']) || $_GET['validated'] == '') 	?	$validated = 2 /*both*/			: $validated = intval($_GET['validated']);

        echo $this->twig->render('validation.twig', [
            'comments' => $CommentManager->getFilteredComment($date_begin, $date_ending, $validated),
            'members' => $MemberManager->getFilteredMember($date_begin, $date_ending, $validated),
            'session' => $_SESSION['member_type']
        ]);
    }

    /**
     * @Route("/admin/article/creer")
     */
    public function addPost()
    {
        if (!empty($_POST) || !empty($_FILES)) {
            if (!isset($_POST['title']) && !isset($_POST['lede']) && !isset($_POST['content']) && $_POST['title'] === '' && $_POST['content'] === '' && $_POST['lede'] === '') {
                new Notification('Les champs "Titre", "Châpo", et "Contenu" sont obligatoires');
                header('Location: ' . $_SERVER['REMOTE_ADDR']);
            }
            if (isset($_FILES) && $_FILES['file']['error'] !== 4) {
                if ($_FILES['file']['error'] > 0) {
                    $error = $this->UploadingError($_FILES['file']['error']);
                } else {
                    $ImgUpload = new ImageUploader();
                    $img_name = $ImgUpload->upload();
                }
            } else {
                $img_name = '';
            }

            if (!isset($error)) {
                $Post = new Post([
                    'title' 	=> $_POST ['title'],
                    'lede' 		=> $_POST ['lede'],
                    'content' 	=> $_POST ['content'],
                    'img' 		=> $img_name,
                    'id_member' => $_SESSION['id_member']
                ]);
                // Writes the informations into the database
                $PostManager = new PostManager();
                $PostManager->createPost($Post);

                new Notification('Votre article a bien été créé', 'success');
                header('Location: ' . URL . 'admin/article');
            }
        } else {
            echo $this->twig->render('add_post.twig');
        }
    }


    /**
     * @Route("/admin/article/:id")
     *
     * @param int $id id of the post
     */
    public function updatePost($id)
    {
        $Post = new Post(['id' => intval($id)]);

        // If user send updating post form
        if (!empty($_POST)) {
            $PostManager = new PostManager();
            $old_post = $PostManager->getPost($Post);


            if (!empty($_FILES) && $_FILES['file']['error'] !== 4) {
                if ($_FILES['file']['error'] > 0) {
                    $error = $this->UploadingError($_FILES['file']['error']);
                } else {
                    $ImgUpload = new ImageUploader();
                    $img_name = $ImgUpload->upload();
                    if ($old_post['img'] !== '' && $_POST['img-remove'] !== 'on') {
                        $ImgUpload->remove($old_post['img']);
                    }
                }
            }

            if (!isset($error)) {
                if (isset($_POST['img-remove']) && $_POST['img-remove'] == 'on' && (empty($_FILES) || $_FILES['file']['error'] === 4)) {
                    $ImgUpload = new ImageUploader();
                    $ImgUpload->remove($old_post['img']);
                    $img_name = '';
                }

                // Takes the values of the changed attributes and keeps the values of the initial post if unchanged
                $datas = [];
                foreach ($_POST as $key => $value) {
                    if ($value !== '') {
                        $datas[$key] = $value;
                    }
                }
                if (isset($img_name)) {
                    $datas['img']   = $img_name;
                }
                $datas['id']        = $id;
                $datas = array_replace($old_post, $datas);

                foreach ($datas as $key => $value) {
                    $method = 'set' . $key;
                    if (is_callable([$Post, $method])) {
                        $Post->$method($value);
                    }
                }
                $PostManager->updatePost($Post);

                new Notification('L\'article a bien été mis à jour', 'success');
                header('Location: ' . URL . 'admin/article');
            }
        }
        // No form is sending, then the user makes a request to get the updating post form
        else {
            $PostManager = new PostManager();
            echo $this->twig->render('add_post.twig', array('update' => $PostManager->getPost($Post)));
        }
    }


    /**
     * @Route("/admin/article")
     */
    public function deletePost()
    {
        $PostManager    = new PostManager();
        $CommentManager = new CommentManager();

        $id = intval($_POST['id']);
        $Comment = new Comment(['id_post' => $id]);
        $Post = new Post(['id' => $id]);

        // Remove the associate image
        $old_post = $PostManager->getPost($Post);
        if (!empty($old_post['img'])) {
            $img = new ImageUploader();
            $img->remove($old_post['img']);
        }
        // Comments have to be deleted first because of foreign key 'id_post'
        $CommentManager->deleteAllComments($Comment);
        $PostManager->deletePost($Post);

        new Notification('L\'article a bien été supprimé', 'success');
    }


    /**
     * @Route("/admin/validation/deleteComment")
     */
    public function deleteComment()
    {
        if (isset($_POST['comment']) && $_POST['comment'] === 'delete') {
            $Comment = new Comment(['id' => intval($_POST['id'])]);
            $CommentManager = new CommentManager();
            $CommentManager->deleteComment($Comment);
            new Notification('Ce commentaire a bien été supprimé', 'success');
        }
    }


    /**
     * @Route("/admin/validaton")
     */
    public function updateValidation()
    {
        $table 		= $_POST['table'];
        $validation = intval($_POST['validation']);
        $id 		= intval($_POST['id']);

        switch ($table) {
            case 'comment':
                $Comment = new Comment(['id' => $id, 'validated' => $validation]);
                $CommentManager = new CommentManager();
                $CommentManager->setValidatedComment($Comment);

                if ($validation === 0) {
                    new Notification('Ce commentaire n\'est plus visible', 'info');
                }
                if ($validation === 1) {
                    new Notification('Ce commentaire est maintenant visible', 'success');
                }
                break;

            case 'member':
                $Member = new Member(['id' => $id, 'validated' => $validation]);
                $MemberManager = new MemberManager();
                $MemberManager->setValidatedMember($Member);
            
                if ($validation === 0) {
                    new Notification('Ce membre n\'a plus accés à l\'espace administratif', 'info');
                }
                if ($validation === 1) {
                    new Notification('Ce membre a maintenant accés à l\'espace administratif', 'success');
                }
                break;
        }

        // Sending an e-mail to the validated member
        if ($table === 'member' && $validation === 1) {
            $member = $MemberManager->getMemberbyId(new Member(['id' => $id]));
            require(ROOT . 'App/Service/Email_model/mail_member_validation.php');
            $mail = new Mailer($member['email'], $subject, $message);
            $mail->send();
        }
    }
}

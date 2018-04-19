<?php
namespace Controller;

use Manager\CommentManager;
use Manager\MemberManager;
use Manager\PostManager;
use Model\Post;
use Model\Comment;
use Model\Mail;
use Service\Mailer;
use Service\Notification;

/**
 * Manage to call the class and method for the blog part of the website
 */
class BlogController extends Controller
{
    /**
     * Set a notification
     * @param  string $message The message for notification
     * @param  string $type    Type of the notification which will be use as bootstrap class
     */
    private function notification(string $message, $type='danger')
    {
        new Notification($message, $type);
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }


    /**
     * if no route was matched by the class \Router\Router
     * @Route("/404")
     */
    public function NoRoute()
    {
        echo $this->twig->render('404.twig');
    }


    /**
     * @Route("/404")
     */
    public function home()
    {
        echo $this->twig->render('welcome.twig');
    }


    /**
     * @Route("/blog")
     * @Route("/blog/:id")
     * @param  int $id id of the post to show
     */
    public function showPost(int $id = 0)
    {
        $PostManager = new PostManager();
        
        if (isset($_GET['p'])) {
            $page = $_GET['p'];
        } else {
            $page = 1;
        }

        // Calcul and get the posts to show for pagination
        $posts_by_page = 8;
        $post_begin = ($page - 1) * $posts_by_page;
        $posts_list = $PostManager->getPostsList($post_begin, $posts_by_page);
        // Calcul the number of pages
        $nb_post = $PostManager->countPosts();
        $nb_pages = ceil($nb_post['nb'] / $posts_by_page);

        // @Route("/blog")
        if ($id === 0) {
            echo $this->twig->render('blog.twig', [
                'posts' => $posts_list,
                'page' =>   [
                    'current' => $page,
                    'nb' => $nb_pages
                ]
            ]);
            exit;
        }

        // @Route("/blog/:id")
        $Post = new Post(['id' => $id]);
        $Comment = new Comment(['id_post' => $id]);

        $CommentManager = new CommentManager();
        echo $this->twig->render('blogpost.twig', [
            'post' => $PostManager->getPost($Post),
            'comments' => $CommentManager->getCommentList($Comment)
        ]);
    }


    /**
     * @Route("/blog/:id")
     * @param int $id of the post where is adding the comment
     */
    public function addComment(int $id)
    {
        if (!isset($_POST) && !isset($_POST['author']) && !isset($_POST['content']) && $_POST['author'] ==='' && $_POST['content'] === '') {
            $this->notification('Vous devez remplir votre nom ainsi le commentaire');
        }

        $Comment = new Comment([
            'content' => $_POST['content'],
            'author' => $_POST['author'],
            'id_post' => $id
        ]);

        $CommentManager = new CommentManager();
        $CommentManager->createComment($Comment);
        $this->notification('Votre commentaire à été ajouté, il est maintenant en attente de validation', 'success');
    }
    

    /**
     * @Route("/accueuil")
     */
    public function contact()
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
        require($_SERVER['DOCUMENT_ROOT'] . 'P5/Blog/App/Service/Email_model/mail_admin_contact.php');

        $Mail->setMail_to('vincent.lescot@gmail.com');
        $Mail->setSubject($subject);
        $Mail->setContent($message);

        $mailer = new Mailer($Mail->Mail_to(), $Mail->subject(), $Mail->content());
        $mailer->send();

        $this->notification('Merci pour votre intérêt ! Votre e-mail a bien été envoyé à Vincent', 'success');
    }
}

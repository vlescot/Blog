<?php 
namespace Controller;
	
class Controller
{
	protected $twig;
	protected $flash;

	function __construct ($view)
	{
		$loader = new \Twig_Loader_Filesystem($_SERVER['DOCUMENT_ROOT'] .'P5/Blog/App/View/' . $view);
		$this->twig = new \Twig_Environment($loader, array(
			'debug' => true,
			'cache' => false // __dir__ . './../tmp'
			));
		$this->twig->addExtension(new \Twig_Extensions_Extension_Intl());
		$this->twig->addExtension(new \Twig_Extension_Debug());
		$this->twig->addGlobal('session', $_SESSION);

		$this->displayNotification();
	}

	private function displayNotification()
	{
		if(isset($_SESSION['flash'])) {
		    $notification = 
				'<div id="alert" class="alert alert-' . $_SESSION['flash']['type'] . ' text-center" role="alert">
				    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				    <strong>' . $_SESSION['flash']['message'] . '</strong>
				</div>';

		    unset($_SESSION['flash']);
		} else $notification = "";

		echo $notification;
	}
}

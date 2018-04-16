<?php
namespace Service;

class Notification
{
	function __construct ($message, $type = 'danger')
	{
        $_SESSION['flash']['message'] = $message;
        $_SESSION['flash']['type'] = $type;
	}
}

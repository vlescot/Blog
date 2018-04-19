<?php
namespace Service;

/**
 * Set the notification into $_SESSION['flash']
 */
class Notification
{
    /**
     * @param string $message
     * @param string $type    will be the class of the showing div
     */
    public function __construct($message, $type = 'danger')
    {
        $_SESSION['flash']['message'] = $message;
        $_SESSION['flash']['type'] = $type;
    }
}

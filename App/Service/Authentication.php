<?php
namespace Service;

/**
 * This class checks members informations on creation,
 * checks validity of connections request, authentificate members
 * in forgot passeword case, and set up member's sessions
 */
class Authentication
{
    private static $salt = "kyO5pa;cd54s2?";
    private $_member = [];

    /**
     * @param array $member or boolean if member don't exist on the database
     */
    public function __construct($member)
    {
        $this->_member = $member;
    }

    private function setConnection()
    {
        $_SESSION['ip'] 		= $_SERVER['REMOTE_ADDR'];
        $_SESSION['id_member'] 	= $this->_member['id'];
        $_SESSION['login'] 		= $this->_member['login'];
        $_SESSION['validated'] 	= $this->_member['validated'];
        $_SESSION['member_type']= $this->_member['id_type'];
    }

    /**
     * encrypt a string
     * @param  string $str
     * @return string the encrypted string
     */
    private function encrypt(string $str)
    {
        return hash('whirlpool', $str . self::$salt);
    }

    /**
     * @return boolean
     */
    private function loginExists()
    {
        if (empty($this->_member['login'])) {
            return false;
        }
        return true;
    }

    /**
     * @param  string $password
     * @return boolean
     */
    private function checkCorrectPassword(string $password)
    {
        if ($this->encrypt($password) === $this->_member['password']) {
            return true;
        }
        return false;
    }

    /**
     * @param  string $password
     * @param  string $check_password
     * @return boolean
     */
    private function checkNewPassword(string $password, string  $check_password)
    {
        // Checks if the two given passwords are identiques
        if ($password !== $check_password) {
            return 'Les mots de passe saisis ne sont pas identiques';
        }
        // Checks if the password is length enough
        if (strlen($password) < 8) {
            return 'Le mot de passe est trop court';
        }
        return true;
    }

    /**
     * @param  string $password
     * @return true or string in error case
     */
    public function logIn(string $password)
    {
        if ($this->loginExists() === false) {
            return 'Ce nom d\'utilisateur n\'est pas reconnu';
        }
        if ($this->checkCorrectPassword($password) === false) {
            return 'Le mot de passe est incorrect';
        }
        $this->setConnection();
        return true;
    }

    /**
     * @param  string $password
     * @param  string $check_password the confirmation password
     * @return encrypted password or string in error case
     */
    public function signUp(string $password, string $check_password)
    {
        if ($this->loginExists() === true) {
            return 'Ce nom de membre est déjà utilisé';
        }
        if ($this->checkNewPassword($password, $check_password) !== true) {
            return $this->checkNewPassword($password, $check_password);
        }
        $this->setConnection();

        return $member = ['password' => $this->encrypt($password)];
    }

    /**
     * @param  string $login
     * @return encrypted reset_password or string in error case
     */
    public function resetPassword($login)
    {
        if ($this->loginExists() === false) {
            return 'Ce nom d\'utilisateur n\'est pas reconnu';
        }
        
        // Create a random string that will be used to authenticate the member
        $seed = str_split('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()');
        shuffle($seed);
        $rand = '';
        foreach (array_rand($seed, 72) as $k) {
            $rand .= $seed[$k];
        }

        return $hash = hash('whirlpool', $rand);
    }

    /**
     * @param  string $login
     * @param  string $password
     * @param  string $check_password the confirmation password
     * @return encrypted password or string in error case
     */
    public function changePassword($login, $password, $check_password)
    {
        if ($this->loginExists() === false) {
            return 'Ce nom d\'utilisateur n\'est pas reconnu';
        }
        if ($this->checkNewPassword($password, $check_password) !== true) {
            return $this->checkNewPassword($password, $check_password);
        }
        $this->setConnection();
        return $this->encrypt($password);
    }
}

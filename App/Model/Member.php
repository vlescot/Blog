<?php
namespace Model;

/**
 * Model for Member
 */
class Member extends Entity
{
    private $_id;
    private $_login;
    private $_password;
    private $_reset_password;
    private $_email;
    private $_validated;
    private $_date_create;
    private $_id_type;

    public function setId($id)
    {
        if (is_int($id) && $id > 0 && $id < 9999) {
            $this->_id = $id;
        }
    }

    public function setLogin($login)
    {
        if (is_string($login) && strlen($login) <= 128) {
            $this->_login = $login;
        }
    }

    public function setPassword($password)
    {
        if (is_string($password) && strlen($password) <= 128) {
            $this->_password = $password;
        }
    }

    public function setReset_password($reset_password)
    {
        if (is_string($reset_password)) {
            $this->_reset_password = $reset_password;
        }
    }

    public function setEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->_email = $email;
        }
    }

    public function setValidated($validated)
    {
        if ($validated === 0 || $validated === 1) {
            $this->_validated = $validated;
        }
    }

    public function setDate_create($date_create)
    {
        if (is_string($date_create)) {
            $this->_date_create = $date_create;
        }
    }

    public function setId_type($id_type)
    {
        if (is_int($id_type) && $id_type > 0 && $id_type < 9999) {
            $this->_id_type = $id_type;
        }
    }


    public function id()
    {
        return $this->_id;
    }

    public function login()
    {
        return $this->_login;
    }

    public function password()
    {
        return $this->_password;
    }

    public function reset_password()
    {
        return $this->_reset_password;
    }

    public function email()
    {
        return $this->_email;
    }

    public function validated()
    {
        return $this->_validated;
    }

    public function date_create()
    {
        return $this->_date_create;
    }

    public function id_type()
    {
        return $this->_id_type;
    }
}

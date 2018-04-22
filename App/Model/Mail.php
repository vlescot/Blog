<?php
namespace Model;

/**
 * Model for Mail
 */
class Mail extends Entity
{
    public $_mail_to;
    public $_subject;
    public $_content;
    public $_contact_name;
    public $_contact_email;
    public $_contact_subject;
    public $_contact_content;

    public function setMail_to($mail_to)
    {
        if (filter_var($mail_to, FILTER_VALIDATE_EMAIL)) {
            $this->_mail_to = $mail_to;
        }
    }

    public function setSubject($subject)
    {
        if (is_string($subject)) {
            $this->_subject = $subject;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }
    
    public function setContact_name($contact_name)
    {
        if (is_string($contact_name)) {
            $this->_contact_name = $contact_name;
        }
    }
    
    public function setContact_email($contact_email)
    {
        if (filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
            $this->_contact_email = $contact_email;
        }
    }
    
    public function setContact_subject($contact_subject)
    {
        if (is_string($contact_subject)) {
            $this->_contact_subject = $contact_subject;
        }
    }

    public function setContact_content($contact_content)
    {
        if (is_string($contact_content)) {
            $this->_contact_content = $contact_content;
        }
    }


    public function mail_to()
    {
        return $this->_mail_to;
    }

    public function subject()
    {
        return $this->_subject ;
    }

    public function content()
    {
        return $this->_content;
    }

    public function contact_name()
    {
        return $this->_contact_name;
    }

    public function contact_subject()
    {
        return $this->_contact_subject;
    }

    public function contact_email()
    {
        return $this->_contact_email;
    }

    public function contact_content()
    {
        return $this->_contact_content;
    }
}

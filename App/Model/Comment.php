<?php
namespace Model;

/**
 * Model for Comment
 */
class Comment extends Entity
{
    private $_id;
    private $_content;
    private $_date_create;
    private $_author;
    private $_validated;
    private $_id_post;

    public function setId($id)
    {
        if (is_int($id) && $id > 0 && $id < 9999) {
            $this->_id = $id;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }

    public function setDate_create($date_create)
    {
        if (is_string($date_create)) {
            $this->_date_create = $date_create;
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author) && strlen($author) <= 50) {
            $this->_author = $author;
        }
    }

    public function setValidated($validated)
    {
        if (is_int($validated) && ($validated === 0 || $validated === 1)) {
            $this->_validated = $validated;
        }
    }

    public function setId_post($id_post)
    {
        if (is_int($id_post) && $id_post > 0 && $id_post < 9999) {
            $this->_id_post = $id_post;
        }
    }



    public function id()
    {
        return $this->_id;
    }
    
    public function content()
    {
        return $this->_content;
    }
    
    public function date_create()
    {
        return $this->_date_create;
    }
    
    public function author()
    {
        return $this->_author;
    }
    
    public function validated()
    {
        return $this->_validated;
    }
    
    public function id_post()
    {
        return $this->_id_post;
    }
}

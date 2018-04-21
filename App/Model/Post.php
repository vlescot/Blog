<?php
namespace Model;

/**
 * Model for Post
 */
class Post extends Entity
{
    private $_id;
    private $_title;
    private $_lede;
    private $_content;
    private $_date_create;
    private $_date_update;
    private $_img;
    private $_id_member;

    public function setId($id)
    {
        if (is_int($id) && $id > 0 && $id < 9999) {
            $this->_id = $id;
        }
    }
    
    public function setTitle($title)
    {
        if (is_string($title) && strlen(trim($title)) <= 255) {
            $this->_title = $title;
        }
    }

    public function setLede($lede)
    {
        if (is_string($lede) && strlen(trim($lede)) <= 255) {
            $this->_lede = $lede;
        }
    }

    public function setContent($content)
    {
        if (is_string(trim($content))) {
            $this->_content = $content;
        }
    }

    public function setDate_create($date_create)
    {
        if (is_string($date_create)) {
            $this->_date_create = $date_create;
        }
    }

    public function setDate_update($date_update)
    {
        if (is_string($date_update)) {
            $this->_date_update = $date_update;
        }
    }

    public function setImg($img)
    {
        if (is_string($img) && strlen($img) <= 128) {
            $this->_img = $img;
        }
    }

    public function setId_member($id_member)
    {
        if (is_int($id_member) && $id_member > 0 && $id_member < 9999) {
            $this->_id_member = $id_member;
        }
    }

    
    public function id()
    {
        return $this->_id;
    }
    
    public function title()
    {
        return $this->_title;
    }
    
    public function lede()
    {
        return $this->_lede;
    }
    
    public function content()
    {
        return $this->_content;
    }
    
    public function date_create()
    {
        return $this->_date_create;
    }
    
    public function date_update()
    {
        return $this->_date_update;
    }
    
    public function img()
    {
        return $this->_img;
    }
    
    public function id_member()
    {
        return $this->_id_member;
    }
}

<?php

namespace Menu\Event;
use Thelia\Core\Event\ActionEvent;

class MenuEvent extends ActionEvent
{
    protected $id;
    protected $title;
    protected $description;
    protected $listeItem;


    function __construct($title='', $description='')
    {
        $this->description = $description;
        $this->title = $title;
    }

    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }


    public function setListeItem($listeItem)
    {
        $this->listeItem = $listeItem;

        return $this;
    }

    public function getListeItem()
    {
        return $this->listeItem;
    }
  
} 
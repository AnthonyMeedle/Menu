<?php

namespace Menu\Event;
use Thelia\Core\Event\ActionEvent;

class MenuEvent extends ActionEvent
{
    protected $id;
    protected $typobjet;
    protected $itemId;
    protected $menu_parent;
    protected $itemtitle;
    protected $title;
    protected $url;
    protected $cssclass;
    protected $target;
    protected $sousmenu;
    protected $icone;
    protected $description;
    protected $listeItem;
    protected $listeItemContent;
    protected $locale;


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

    public function setItemId($itemId)
    {
        $this->itemId = $itemId;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTypobjet()
    {
        return $this->typobjet;
    }
    public function setTypobjet($typobjet)
    {
        $this->typobjet = $typobjet;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
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

    public function setChapo($chapo)
    {
        $this->chapo = $chapo;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getChapo()
    {
        return $this->chapo;
    }

    public function setMenuParent($menu_parent)
    {
        $this->menu_parent = $menu_parent;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMenuParent()
    {
        return $this->menu_parent;
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
	
    /**
     * @param mixed $title
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $url;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }
    /**
     * @param mixed $title
     */
    public function setCssclass($cssclass)
    {
        $this->cssclass = $cssclass;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCssclass()
    {
        return $this->cssclass;
    }
	
    /**
     * @param mixed $title
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getTarget()
    {
        return $this->target;
    }
	
    /**
     * @param mixed $title
     */
    public function setSousmenu($sousmenu)
    {
        $this->sousmenu = $sousmenu;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getSousmenu()
    {
        return $this->sousmenu;
    }
    /**
     * @param mixed $title
     */
    public function setIcone($icone)
    {
        $this->icone = $icone;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * @param mixed $itemtitle
     */
    public function setItemTitle($itemtitle)
    {
        $this->itemtitle = $itemtitle;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getItemTitle()
    {
        return $this->itemtitle;
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
    public function setListeItemContent($listeItemContent)
    {
		$this->listeItemContent = $listeItemContent;
        return $this;
    }

    public function getListeItemContent()
    {
        return $this->listeItemContent;
    }
  
    public function setMenuItem($listeItem)
    {
        $this->listeItem = $listeItem;

        return $this;
    }

    public function getMenuItem()
    {
        return $this->listeItem;
    }
  
} 
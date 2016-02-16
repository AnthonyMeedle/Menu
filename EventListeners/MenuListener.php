<?php

namespace Menu\EventListeners;

use Menu\Event\MenuEvent;
use Menu\Model\Menu;
use Menu\Model\MenuQuery;
use Menu\Model\MenuI18n;
use Menu\Model\MenuI18nQuery;
use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
use Menu\Model\MenuItemI18n;
use Menu\Model\MenuItemI18nQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Thelia\Model\RewritingUrlQuery;
use Propel\Runtime\Connection\ConnectionInterface;

class MenuListener implements EventSubscriberInterface
{
 	public static function getSubscribedEvents()
    {
        return array(
            'module_menu_add' => array('addMenu', 128),
            'module_menu_delete' => array('deleteMenu', 128),
            'module_menu_item' => array('itemMenu',128)
        );
    }
/*    public static function getSubscribedEvents()
    {
        return [
            'module_menu_add' =>['addMenu']
        ];
    }*/
    
    
	public function deleteMenu(MenuEvent $event)
    {
	/*	$menu = MenuQuery::create()
        ->findOneById($event->getId);
        $menu->delete();
     */   
     
     if (null !== $menu = MenuQuery::create()->findPk($event->getId())) {
            $menu->delete();
       		$item = MenuItemQuery::create()->filterByMenuId($event->getId())->find();
		    $item->delete();
        }
        $menu_i18n = MenuI18nQuery::create()->filterById($event->getId(),Criteria::IN)->find();
        foreach($menu_i18n as $menui18n){
	        $menui18n->delete();
        }
    }
    
    
    public function itemMenu(MenuEvent $event)
    {

		$liste_item = json_decode($event->getListeItem());
		$compteur=0;
		$item = MenuItemQuery::create()->filterByMenuId($event->getId())->find();
	    $item->delete();
		foreach($liste_item[0] as $idobj){
			$info = explode('_', $idobj);
			$compteur++;
	    	$menuItem = new MenuItem();
	    	$menuItem->setMenuId($event->getId());
	    	$menuItem->setVisible(1);
	    	$menuItem->setTypobj($info[0]);
	    	$menuItem->setObjet($info[1]);
	    	$menuItem->setPosition($compteur);
	        $menuItem->save();
	        /*
	        $menuItem_i18n = new MenuItemI18n();
	        $menuItem_i18n->setId($menuItem->getId());
	        $menuItem_i18n->setLocale('fr_FR');
	        $menuItem_i18n->save();
	        */
		}

    }
    
    public function addMenu(MenuEvent $event)
    {

    	$menu = new Menu();
        $menu->save();
        
        $menu_i18n = new MenuI18n();
        $menu_i18n->setId($menu->getId());
        $menu_i18n->setTitle($event->getTitle());
        $menu_i18n->setDescription($event->getDescription());
        $menu_i18n->setLocale('fr_FR');
        $menu_i18n->save();
        
        $event->setId($menu->getId());
    }
}

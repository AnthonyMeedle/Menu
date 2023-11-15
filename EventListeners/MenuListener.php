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
use Thelia\Model\ProductQuery;
use Thelia\Model\ContentQuery;
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
            'module_menu_add_item' => array('addMenuItem', 128),
            'module_menu_delete' => array('deleteMenu', 128),
            'module_menu_item_delete' => array('deleteItem', 128),
            'module_menu_item' => array('itemMenu',128),
            'module_menu_item_details' => array('itemDetails',128)
        );
    }
/*    public static function getSubscribedEvents()
    {
        return [
            'module_menu_add' =>['addMenu']
        ];
    }*/
    
	public function itemDetails(MenuEvent $event)
    {
	 	if (null !== $menuItem = MenuItemQuery::create()->findPk($event->getId())) {
			$menuItem
				->setLocale($event->getLocale())
				->setTitle($event->getTitle())
				->setChapo($event->getChapo())
				->setUrl($event->getUrl())
				->setCssclass($event->getCssclass())
				->setTargetblank($event->getTarget())
				->setSousmenu($event->getSousmenu())
				->setIcone($event->getIcone())
				->save();
		}
    }
	public function deleteItem(MenuEvent $event)
    {
     if (null !== $menuItem = MenuItemQuery::create()->findPk($event->getId())) {
            $menuItem->delete();
        }
    }
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
    	
    public function addMenuItem(MenuEvent $event)
    {
		$nbrItem = MenuItemQuery::create()->filterByMenuId($event->getId())->count();
		$liste_item = explode(',',$event->getListeItem());
		foreach($liste_item as $refProd){
			if(null !== $product = ProductQuery::create()->filterByRef($refProd)->findOne()){
				if(null === $item = MenuItemQuery::create()->filterByMenuId($event->getId())->filterByTypobj(1)->filterByObjet($product->getId())->findOne()){
					$nbrItem++;				
					$listeItem = new MenuItem();
			    	$listeItem->setMenuId($event->getId());
			    	$listeItem->setVisible(1);
			    	$listeItem->setTypobj(1);
	    			$listeItem->setMenuParent($event->getMenuParent());
			    	$listeItem->setObjet($product->getId());
			    	$listeItem->setPosition($nbrItem);
			    	$listeItem->setLocale($event->getLocale());
			        $listeItem->save();
				}
			}
		}
		$liste_item_content = explode(',',$event->getListeItemContent());
		foreach($liste_item_content as $idContent){
			if(null !== $content = ContentQuery::create()->findPk($idContent)){

				if(null === $item = MenuItemQuery::create()->filterByMenuId($event->getId())->filterByTypobj(3)->filterByObjet($content->getId())->findOne()){
					$nbrItem++;				
					$listeItem = new MenuItem();
			    	$listeItem->setMenuId($event->getId());
			    	$listeItem->setVisible(1);
			    	$listeItem->setTypobj(3);
	    			$listeItem->setMenuParent($event->getMenuParent());
			    	$listeItem->setObjet($content->getId());
			    	$listeItem->setPosition($nbrItem);
			    	$listeItem->setLocale($event->getLocale());
			        $listeItem->save();
				}
			}
		}
		$item_free = trim($event->getItemTitle());
		if($item_free){
			$nbrItem++;				
			$listeItem = new MenuItem();
			$listeItem->setMenuId($event->getId());
			$listeItem->setVisible(1);
			$listeItem->setTypobj(4);
			$listeItem->setObjet(0);
			$listeItem->setMenuParent($event->getMenuParent());
			$listeItem->setPosition($nbrItem);
			$listeItem->setLocale($event->getLocale());
			$listeItem->setTitle($item_free);
			$listeItem->save();
			$listeItem->setObjet($listeItem->getId())->save();
		}
		
    } 
    
    public function itemMenu(MenuEvent $event)
    {

		$liste_item = json_decode($event->getListeItem());
		$compteur=0;
//		$item = MenuItemQuery::create()->filterByMenuId($event->getId())->find();
//	    $item->delete();
		foreach($liste_item[0] as $idobj){
			$typObj = explode('_', $idobj);
			$compteur++;
			if(isset($typObj[2])){
				if(null === $menuItem = MenuItemQuery::create()->findPk($typObj[2])){
					$menuItem = new MenuItem();
				}
			}else{
				$menuItem = new MenuItem();
			}
	    	$menuItem->setMenuId($event->getId());
	    	$menuItem->setVisible(1);
	    	$menuItem->setTypobj($typObj[0]);
	    	$menuItem->setObjet($typObj[1]);
	    	$menuItem->setMenuParent($event->getMenuParent());
	    	$menuItem->setPosition($compteur);
		//	$menuItem->setLocale($event->getLocale());
	        $menuItem->save();
		}

    }
    
    public function addMenu(MenuEvent $event)
    {

    	$menu = new Menu();
        
        $menu->setLocale('fr_FR');
        $menu->setVisible(1);
        $menu->setTitle($event->getTitle());
        $menu->setDescription($event->getDescription());
        $menu->setObjet($event->getItemid());
        $menu->setTypobj($event->getTypobjet());
		
        $menu->save();
        $event->setId($menu->getId());
    }
}

<?php
namespace Menu\Controller\Admin;

use Menu\Form\Admin\AddMenuForm;
use Menu\Form\Admin\DeleteMenuForm;
use Menu\Form\Admin\DeleteItemForm;
use Menu\Form\Admin\UpdateMenuItemForm;
use Menu\Form\Admin\UpdateMenuItemDetailsForm;
use Menu\Event\MenuEvent;
use Menu\Model\Menu;
use Menu\Model\MenuQuery;
use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\ContentQuery;

use Thelia\Log\Tlog;
use Thelia\Core\Event\ActionEvent;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;



class MenuAdminController extends BaseAdminController
{
    public function __construct()
    {
    }
	public function noAction(){}
	
	public function addItemsAction(EventDispatcherInterface $eventDispatcher, $menu_id){
		
		$event = new MenuEvent();

		$event->setId($menu_id);
		if(!empty($_REQUEST['refs'])) $event->setListeItem($_REQUEST['refs']);
		if(!empty($_REQUEST['idcontents'])) $event->setListeItemContent($_REQUEST['idcontents']);
		if(!empty($_REQUEST['itemtitle'])) $event->setItemTitle($_REQUEST['itemtitle']);
		$event->setLocale($this->getCurrentEditionLocale());
		$event->setMenuParent($_REQUEST['menu_parent']); 
//		$retour = $eventDispatcher->dispatch($event, 'module_menu_add_item');
		
		
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
		
		
		
		return $this->generateRedirect($_REQUEST['success_url']);
	}
	
	public function loadItemAction(EventDispatcherInterface $eventDispatcher){
		$retour = [];
		if(null !== $menuitem = MenuItemQuery::create()->findPk($_REQUEST['item_id'])){
			$menuitem->setLocale($this->getCurrentEditionLocale());
			$retour['item_id'] = $menuitem->getId();
			$retour['title'] = $menuitem->getTitle();
			$retour['chapo'] = $menuitem->getChapo();
			$retour['url'] = $menuitem->getUrl();
			$retour['cssclass'] = $menuitem->getCssclass();
			$retour['target'] = $menuitem->getTargetblank();
			$retour['sousmenu'] = $menuitem->getSousmenu();
			$retour['icone'] = $menuitem->getIcone();
		}
		
		
		echo json_encode($retour);
		exit;
	}
	public function detailItemUpdateAction(EventDispatcherInterface $eventDispatcher){
//		$itemForm = new UpdateMenuItemDetailsForm($this->getRequest());
		
		$itemForm = $this->createForm('menu.item.details');
		
		$form = $this->validateForm($itemForm);
		$data = $form->getData($form);

		$event = new MenuEvent();

		$event->setLocale($this->getCurrentEditionLocale());

		$event->setId($data['item_id']);
		$event->setTitle($data['title']);
		$event->setChapo($data['chapo']);
		$event->setUrl($data['url']);
		$event->setCssclass($data['cssclass']);
		$event->setTarget($data['targetblank']);
		$event->setSousmenu($data['sousmenu']);
		$event->setIcone($data['icone']);
		
//		$retour = $eventDispatcher->dispatch($event, 'module_menu_item_details');
		
		
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
		

		if (method_exists($this, 'generateSuccessRedirect')) {
			return $this->generateSuccessRedirect($itemForm); //for 2.1
		} else {
			$this->redirectSuccess($itemForm); //for 2.0
		}
		
	}
	public function detailUpdateAction(EventDispatcherInterface $eventDispatcher, $menu_id){
		
		 $message = false;

      /*  if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'Menu', AccessManager::ADD)) {
            return $response;
        }
*/
//        $itemForm = new UpdateMenuItemForm($this->getRequest());
		$itemForm = $this->createForm('menu.item.form');

   //     try {
            $form = $this->validateForm($itemForm);
            $data = $form->getData($form);

			$event = new MenuEvent();

			$event->setLocale($this->getCurrentEditionLocale());
			$event->setId($data['menu_id']);
			$event->setListeItem($data['menu_list']);
			$event->setMenuParent($data['menu_parent']);
            
//            $retour = $eventDispatcher->dispatch($event, 'module_menu_item');
		
		
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
		
		
            
            if (method_exists($this, 'generateSuccessRedirect')) {
                return $this->generateSuccessRedirect($itemForm); //for 2.1
            } else {
                $this->redirectSuccess($itemForm); //for 2.0
            }
/*
        } catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }*/

        if ($message !== false) {
            Tlog::getInstance()->error(sprintf("Error during menu item process : %s. Exception was %s", $message, $e->getMessage()));

            $itemForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($itemForm)
                ->setGeneralError($message)
            ;
        }

		
		return $this->render(
          "menu_details", array(
                'menu_id' => $menu_id
            )
        );
	}
	
	public function detailAction($menu_id){
		return $this->render(
          "menu_details", array(
                'menu_id' => $menu_id
            )
        );
	}
	
	
	
    public function itemDeleteAction(EventDispatcherInterface $eventDispatcher)
    {
    	$message = false;
//    	$deleteForm = new DeleteItemForm($this->getRequest());
		$deleteForm = $this->createForm('menu.delete.item');
    	try {
            $form = $this->validateForm($deleteForm);
            $data = $form->getData($form);

			$event = new MenuEvent();
			$event->setLocale($this->getCurrentEditionLocale());
			$event->setId($data['item_id']);
            
            $eventDispatcher->dispatch($event, 'module_menu_item_delete');

            if (method_exists($this, 'generateSuccessRedirect')) {
                //for 2.1
                return $this->generateSuccessRedirect($deleteForm);
            } else {
                //for 2.0
                $this->redirectSuccess($deleteForm);
            }

       	} catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if ($message !== false) {
            Tlog::getInstance()->error(sprintf("Error during menu item delete process : %s. Exception was %s", $message, $e->getMessage()));

            $deleteForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($deleteForm)
                ->setGeneralError($message)
            ;
        }
    }
    public function deleteAction(EventDispatcherInterface $eventDispatcher)
    {
    	$message = false;
//    	$deleteForm = new DeleteMenuForm($this->getRequest());
		$deleteForm = $this->createForm('menu.delete.form');
    	try {
            $form = $this->validateForm($deleteForm);
            $data = $form->getData($form);

			$event = new MenuEvent();
			$event->setLocale($this->getCurrentEditionLocale());
			$event->setId($data['menu_id']);
            
            $eventDispatcher->dispatch($event, 'module_menu_delete');

            if (method_exists($this, 'generateSuccessRedirect')) {
                //for 2.1
                return $this->generateSuccessRedirect($deleteForm);
            } else {
                //for 2.0
                $this->redirectSuccess($deleteForm);
            }

       	} catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if ($message !== false) {
            Tlog::getInstance()->error(sprintf("Error during menu delete process : %s. Exception was %s", $message, $e->getMessage()));

            $deleteForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($deleteForm)
                ->setGeneralError($message)
            ;
        }
    }
    
      public function updateAction(EventDispatcherInterface $eventDispatcher, $menu_id){
    	if(!empty($_REQUEST['title'])){
	    	if(null !== $menu = MenuQuery::create()->findPk($menu_id)){
		    	$menu->setLocale($this->getCurrentEditionLocale());
		    	$menu->setTitle($_REQUEST['title']);
		    	$menu->save();
	    	}
    	}
    	return $this->generateRedirect($_REQUEST['success_url']);
    }
    
    public function addAction(EventDispatcherInterface $eventDispatcher)
    {
        $message = false;

      /*  if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'Menu', AccessManager::ADD)) {
            return $response;
        }
*/
//        $addForm = new AddMenuForm($this->getRequest());
        $addForm = $this->createForm('menu.add.form');

        try {
            $form = $this->validateForm($addForm);
            $data = $form->getData($form);

			$event = new MenuEvent($data['title'],$data['description']);
			$event->setTypobjet($data['typobj']);
            
//            $retour = $eventDispatcher->dispatch($event, 'module_menu_add');
			
			$menu = new Menu();

			$menu->setLocale('fr_FR');
			$menu->setVisible(1);
			$menu->setTitle($event->getTitle());
			$menu->setDescription($event->getDescription());
			$menu->setObjet($event->getItemid());
			$menu->setTypobj($event->getTypobjet());

			$menu->save();
			$event->setId($menu->getId());
			
			
            $url= $data['success_url'] . '/' . $event->getId();
            
			return $this->generateRedirect($url);
   //         $this->redirect($url);

        } catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }
	

        if ($message !== false) {
            Tlog::getInstance()->error(sprintf("Error during menu add process : %s. Exception was %s", $message, $e->getMessage()));

            $addForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($addForm)
                ->setGeneralError($message)
            ;
        }
		if(isset($_REQUEST['error_url'])){
			return $this->generateRedirect($_REQUEST['error_url']);
		}
    }
	
    public function addListAction()
    {
		if($_REQUEST['objet']){
			if(null === $menu = MenuQuery::create()->filterByTypobj($_REQUEST['menu_typobj'])->filterByObjet($_REQUEST['menu_objet'])->findOne()){
				$menu = new Menu();
				$title = 'category ' . $_REQUEST['menu_objet'];
				$menu->setTypobj($_REQUEST['menu_typobj'])->setObjet($_REQUEST['menu_objet'])->save();
				$menu->setLocale($this->getCurrentEditionLocale())->setTitle($title)->save();
			
			}
			$menuItem = new MenuItem();
			$menuItem->setMenuId($menu->getId())->setVisible(1)->setTypobj($_REQUEST['typobj'])->setObjet($_REQUEST['objet'])->save();
			if(null !== $menuitems = MenuItemQuery::create()->filterByMenuId($menu->getId())->orderBy('position')->find()){
				$pos=1;
				foreach($menuitems as $menuitem){
					$menuitem->setPosition($pos++)->save();
				}
			}
		}
		
		return $this->generateRedirect($_REQUEST['success_url']);
    }
}

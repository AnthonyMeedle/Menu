<?php
/**
 * Created by PhpStorm.
 * User: dugour
 * Date: 29/10/14
 * Time: 15:20
 */

namespace Menu\Controller\Admin;

use Menu\Form\Admin\AddMenuForm;
use Menu\Form\Admin\DeleteMenuForm;
use Menu\Form\Admin\UpdateMenuItemForm;
use Menu\Event\MenuEvent;
use Menu\Model\Menu;
use Menu\Model\MenuQuery;
use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
use Menu\Model\MenuI18nQuery;
use Menu\Model\MenuI18n;

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
		$retour = $eventDispatcher->dispatch($event, 'module_menu_add_item');
		return $this->generateRedirect($_REQUEST['success_url']);
	}
	
	public function detailUpdateAction(EventDispatcherInterface $eventDispatcher, $menu_id){
		
		 $message = false;

      /*  if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'Menu', AccessManager::ADD)) {
            return $response;
        }
*/
        $itemForm = $this->createForm('menu.item.form');

   //     try {
            $form = $this->validateForm($itemForm);
            $data = $form->getData($form);

			$event = new MenuEvent();

			$event->setId($data['menu_id']);
			$event->setListeItem($data['menu_list']);
            
            $retour = $eventDispatcher->dispatch($event, 'module_menu_item');
            
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
	
	public function detailAction(EventDispatcherInterface $eventDispatcher, $menu_id){
		return $this->render(
          "menu_details", array(
                'menu_id' => $menu_id
            )
        );
	}
	
	
	
    public function deleteAction(EventDispatcherInterface $eventDispatcher)
    {
    	$message = false;
    	$deleteForm = $this->createForm('menu.delete.form');
    	try {
            $form = $this->validateForm($deleteForm);
            $data = $form->getData($form);

			$event = new MenuEvent();
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
	    	if(null !== $menu = MenuI18nQuery::create()->findPk($menu_id)){
		    	$menu->setLocale('fr_FR');
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
            
            $retour = $eventDispatcher->dispatch($event, 'module_menu_add');
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
    public function addListAction(EventDispatcherInterface $eventDispatcher)
    {
		if($_REQUEST['objet']){
			if(null === $menu = MenuQuery::create()->filterByTypobj($_REQUEST['menu_typobj'])->filterByObjet($_REQUEST['menu_objet'])->findOne()){
				$menu = new Menu();
				$title = 'category ' . $_REQUEST['menu_objet'];
				$menu->setTypobj($_REQUEST['menu_typobj'])->setObjet($_REQUEST['menu_objet'])->save();
//				$menu->setLocale('fr_FR')->setTitle($title)->save();
				$menu_i18n = new MenuI18n();
				$menu_i18n->setId($menu->getId());
				$menu_i18n->setTitle($title);
				$menu_i18n->setLocale('fr_FR');
				$menu_i18n->save();
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

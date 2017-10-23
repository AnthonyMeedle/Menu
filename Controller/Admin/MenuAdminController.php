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


use Thelia\Log\Tlog;
use Thelia\Core\Event\ActionEvent;
use Thelia\Controller\Admin\BaseAdminController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class MenuAdminController extends BaseAdminController
{
    public function __construct()
    {
    }
	public function noAction(){}
	
	
	
	public function detailUpdateAction($menu_id){
		
		 $message = false;

      /*  if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'Menu', AccessManager::ADD)) {
            return $response;
        }
*/
        $itemForm = new UpdateMenuItemForm($this->getRequest());

   //     try {
            $form = $this->validateForm($itemForm);
            $data = $form->getData($form);

			$event = new MenuEvent();

			$event->setId($data['menu_id']);
			$event->setListeItem($data['menu_list']);
            
            $retour = $this->dispatch('module_menu_item', $event);
            
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
          "details", array(
                'menu_id' => $menu_id
            )
        );
	}
	
	public function detailAction($menu_id){
		return $this->render(
          "details", array(
                'menu_id' => $menu_id
            )
        );
	}
	
	
	
    public function deleteAction()
    {
    	$message = false;
    	$deleteForm = new DeleteMenuForm($this->getRequest());
    	try {
            $form = $this->validateForm($deleteForm);
            $data = $form->getData($form);

			$event = new MenuEvent();
			$event->setId($data['menu_id']);
            
            $this->dispatch('module_menu_delete', $event);

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
    public function addAction()
    {
        $message = false;

      /*  if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'Menu', AccessManager::ADD)) {
            return $response;
        }
*/
        $addForm = new AddMenuForm($this->getRequest());

        try {
            $form = $this->validateForm($addForm);
            $data = $form->getData($form);

			$event = new MenuEvent($data['title'],$data['description']);
            
            $retour = $this->dispatch('module_menu_add', $event);
            $url= $data['success_url'] . '/' . $event->getId();
            
            return $response = $this->generateRedirect($url);

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
    }
}

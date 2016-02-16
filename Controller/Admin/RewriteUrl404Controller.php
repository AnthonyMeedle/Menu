<?php
/**
 * Created by PhpStorm.
 * User: os
 * Date: 12/11/2014
 * Time: 14:18
 */

namespace RewriteUrl\Controller\Admin;

use Propel\Runtime\ActiveQuery\Criteria;
use Symfony\Component\Config\Definition\Exception\Exception;
use Thelia\Core\Event\ActionEvent;
use Thelia\Log\Tlog;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\LangQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\RewritingUrl;
use Thelia\Model\RewritingArgument;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;
use Thelia\Form\Exception\FormValidationException;
use Thelia\Model\RewritingUrlQuery;
use RewriteUrl\Form\Admin\Update404Form;
use RewriteUrl\Form\Admin\Delete404Form;
use RewriteUrl\Model\RewriteUrl404;
use RewriteUrl\Model\RewriteUrl404Argument;
use RewriteUrl\Model\RewriteUrl404ArgumentQuery;
use RewriteUrl\Model\RewriteUrl404Query;

class RewriteUrl404Controller extends BaseAdminController
{

    public function deleteAction()
    {
        $message = false;

        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'RewriteUrl', AccessManager::DELETE)) {
            return $response;
        }

        $deleteForm = new Delete404Form($this->getRequest());



            $form = $this->validateForm($deleteForm);

            $ids = $form->get('ids')->getData();

            $idss = $form->get('idss')->getData();

            if (!empty($idss)) {
                $idss = explode(',', $idss);
                $find = RewriteUrl404ArgumentQuery::create()
                    ->filterById($idss, Criteria::IN)
                    ->find();
                $find->delete();
            }

            if (!empty($ids)) {
                $find = RewriteUrl404Query::create()
                    ->filterById($ids, Criteria::IN)
                    ->find();
                $find->delete();
            }

        try {

        } catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if ($message !== false) {

            $deleteForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($deleteForm)
                ->setGeneralError($message)
            ;

        } else {

            if (method_exists($this, 'generateSuccessRedirect')) {
                //for 2.1
                return $this->generateRedirectFromRoute("admin.module.configure",array(), array ( 'module_code'=>"RewriteUrl"));
            } else {
                //for 2.0
                $this->redirectToRoute("admin.module.configure",array(), array ( 'module_code'=>"RewriteUrl"));
            }

        }

        if (method_exists($this, 'generateSuccessRedirect')) {
            //for 2.1
            return $this->generateSuccessRedirect($deleteForm);
        } else {
            //for 2.0
            $this->redirectSuccess($deleteForm);
        }
    }

    public function redirectAction()
    {
        $message = false;

        if (null !== $response = $this->checkAuth(array(AdminResources::MODULE), 'RewriteUrl', AccessManager::UPDATE)) {
            return $response;
        }

        $updateForm = new Update404Form($this->getRequest());

        try {

            $form = $this->validateForm($updateForm);

            $to = $form->get('to')->getData();

            $to = explode('::', $to);

            if (count($to) != 2 || !self::textExist($to[1], $to[0])) {
                throw new Exception('Invalid param to');
            }

            //url with param
            $idss = $form->get('idss')->getData();

            if (!empty($idss)) {
                $idss = explode(',', $idss);

                $find = RewriteUrl404ArgumentQuery::create()
                    ->filterById($idss, Criteria::IN)
                    ->find();

                /** @var RewriteUrl404Argument $line */
                foreach($find as $line) {

                    $url = self::insertUrl($line->getRewriteUrl404()->getUrl(), $to[1], $to[0]);

                    $parameters = explode('&', $line->getParameter());

                    foreach($parameters as $parameter) {

                        $parameter = explode('=', $parameter);

                        if ($parameter == 2) {
                            self::insertUrlArgument($url, urldecode($parameter[0]), urldecode($parameter[1]));
                        }

                    }

                    $line->delete();
                }
            }

            //simple url
            $ids = $form->get('ids')->getData();

            if (!empty($ids)) {
                $ids = explode(',', $ids);

                $find = RewriteUrl404Query::create()
                    ->filterById($ids, Criteria::IN)
                    ->find();

                /** @var RewriteUrl404 $line */
                foreach($find as $line) {
                    self::insertUrl($line->getUrl(), $to[1], $to[0]);
                    $line->delete();
                }

            }

        } catch (FormValidationException $e) {
            $message = $this->createStandardFormValidationErrorMessage($e);
        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        if ($message !== false) {

            $updateForm->setErrorMessage($message);

            $this->getParserContext()
                ->addForm($updateForm)
                ->setGeneralError($message)
            ;
        } else {
            if (method_exists($this, 'generateSuccessRedirect')) {
                //for 2.1
                return $this->generateRedirectFromRoute("admin.module.configure",array(), array ( 'module_code'=>"RewriteUrl"));
            } else {
                //for 2.0
                $this->redirectToRoute("admin.module.configure",array(), array ( 'module_code'=>"RewriteUrl"));
            }
        }

        if (method_exists($this, 'generateSuccessRedirect')) {
            //for 2.1
            return $this->generateSuccessRedirect($updateForm);
        } else {
            //for 2.0
            $this->redirectSuccess($updateForm);
        }

    }

    /**
     * @param string $view
     * @param int $id
     * @return bool
     */
    private function textExist($view, $id)
    {
        $test = null;

        if ($view == 'product') {
            $test = ProductQuery::create()->findPk($id);
        } else if ($view == 'brand') {
            $test = BrandQuery::create()->findPk($id);
        } else if ($view == 'category') {
            $test = CategoryQuery::create()->findPk($id);
        } else if ($view == 'folder') {
            $test = FolderQuery::create()->findPk($id);
        } else if ($view == 'content') {
            $test = ContentQuery::create()->findPk($id);
        }

        if ($test !== null) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param string $url
     * @param string $view
     * @param int $id
     * @return RewritingUrl
     */
    public function insertUrl($url, $view, $id)
    {
        //test if exist url principal
        $findUrlPrincipal = RewritingUrlQuery::create()
            ->filterByView($view)
            ->filterByViewId($id)
            ->filterByRedirected(null)
            ->findOne();

        if ($findUrlPrincipal !== null) {
            $redirected = $findUrlPrincipal->getId();
        } else {
            $redirected = null;
        }

        $local = LangQuery::create()
            ->findOneByByDefault(1);

        $find = RewritingUrlQuery::create()->findOneByUrl($url);

        if ($find === null) {
            //insert RewritingUrl
            $insert = new RewritingUrl();
            $insert->setUrl($url)
                ->setView($view)
                ->setViewId($id)
                ->setRedirected($redirected)
                ->setViewLocale($local->getLocale())
                ->save();
        } else {
            $insert = $find;
        }

        return $insert;
    }

    /**
     * @param RewritingUrl $url
     * @param string $name
     * @param string $value
     * @return RewritingArgument
     */
    private function insertUrlArgument(RewritingUrl $url, $name, $value) {

        $insert = new RewritingArgument();
        $insert
            ->setRewritingUrlId($url->getId())
            ->setParameter($name)
            ->setValue($value)
            ->save();

        return $insert;
    }
}

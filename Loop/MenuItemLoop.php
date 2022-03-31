<?php
namespace Menu\Loop;

use Menu\Model\MenuItemQuery;
use Menu\Model\MenuItemI18nQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ProductQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\ContentFolderQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Core\Template\Element\BaseLoop;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Element\SearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\BooleanOrBothType;


class MenuItemLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('menu_id'),
            Argument::createIntListTypeArgument('menu'),
            Argument::createAnyTypeArgument('active')
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = MenuItemQuery::create();
//		$this->configureI18nProcessing($search, array('TITLE', 'CHAPO', 'DESCRIPTION', 'POSTSCRIPTUM'));
		
        $id = $this->getId();
        if ($id) {
            $search->filterById($id, Criteria::IN);
        }

        $menuid = $this->getMenuId();
        if ($menuid) {
            $search->filterByMenuId($menuid, Criteria::IN);
        }
        $menu = $this->getMenu();
        if ($menu) {
            $search->filterByMenuId($menu, Criteria::IN);
        }

	//	$critere->joinMenu('menu_i18n', Criteria::INNER_JOIN)->where('`menu_i18n' . $idcat . '`.category_id IN ('.$liste.')');
	
        return $search;
    }


    /**
     * @param LoopResult $loopResult
     *
     * @return LoopResult
     */
    public function parseResults(LoopResult $loopResult)
    {
        foreach ($loopResult->getResultDataCollection() as $menuItem) {
            $loopResultRow = new LoopResultRow($menuItem);
       //     $title=$menuItem->getVirtualColumn('i18n_TITLE');
            $title='';
            $chapo='';
            $description='';
            $postscriptum='';
            $url='';
            $type='category';
            $objet=null;
			$classActive = 'active';
			if($this->getActive())$classActive = $this->getActive();
			$active='';
			switch($menuItem->getTypobj()){
				case 0 :
					$objet = CategoryQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='category';
					
					if($menuItem->getObjet() == $this->request->get('category_id') && $this->request->get('category_id')){
						$active = $classActive;
					}elseif($this->request->get('category_id')){
						$parentId = $this->request->get('category_id');
						while($parentId != 0  && !$active){
							$parent = CategoryQuery::create()->filterByVisible(1)->findPk($parentId);
							$parentId = $parent->getParent();
							if($parentId == $menuItem->getObjet()){
								$active = $classActive;
							}
						}
					}elseif($this->request->get('product_id')){
						if(null !== $parent = ProductCategoryQuery::create()->filterByProductId($this->request->get('product_id'))->filterByCategoryId($menuItem->getObjet())->findOne()){
							$active = $classActive;
						}else{
							if(null !== $parents = ProductCategoryQuery::create()->filterByProductId($this->request->get('product_id'))->find()){
								foreach($parents as $parent){
									$parentId = $parent->getCategoryId();
									while($parentId != 0  && !$active){
										$parent = CategoryQuery::create()->filterByVisible(1)->findPk($parentId);
										$parentId = $parent->getParent();
										if($parentId == $menuItem->getObjet()){
											$active = $classActive;
										}
									}
								}
							}
						}
					}
					
				break;	
				case 1 :
					$objet = ProductQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='product';
					if($menuItem->getObjet() == $this->request->get('product_id') && $this->request->get('product_id')){
						$active = $classActive;
					}
				break;
				case 2 :
					$objet = FolderQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='folder';
					if($menuItem->getObjet() == $this->request->get('folder_id') && $this->request->get('folder_id')){
						$active = $classActive;
					}elseif($this->request->get('folder_id') && !$active){
						$parentId = $this->request->get('folder_id');
						while($parentId != 0  && !$active){
							$parent = FolderQuery::create()->filterByVisible(1)->findPk($parentId);
							$parentId = $parent->getParent();
							if($parentId == $menuItem->getObjet()){
								$active = $classActive;
							}
						}
					}elseif($this->request->get('content_id')){
						if(null !== $parent = ContentFolderQuery::create()->filterByContentId($this->request->get('content_id'))->filterByFolderId($menuItem->getObjet())->findOne()){
							$active = $classActive;
						}else{
							if(null !== $parents = ContentFolderQuery::create()->filterByContentId($this->request->get('product_id'))->find()){
								foreach($parents as $parent){
									$parentId = $parent->getCategoryId();
									while($parentId != 0  && !$active){
										$parent = FolderQuery::create()->filterByVisible(1)->findPk($parentId);
										$parentId = $parent->getParent();
										if($parentId == $menuItem->getObjet()){
											$active = $classActive;
										}
									}
								}
							}
						}
					}
				break;
				case 3 :
					$objet = ContentQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='content';
					if($menuItem->getObjet() == $this->request->get('content_id') && $this->request->get('content_id')){
						$active = $classActive;
					}
				break;
			}
            if($objet === null) continue;

            $objet->setLocale($this->request->getSession()->getLang()->getLocale());
            if(!$title)$title=$objet->getTitle();
            if(!$chapo)$chapo=$objet->getChapo();
            if(!$description)$description=$objet->getDescription();
            if(!$postscriptum)$postscriptum=$objet->getPostscriptum();
            if(!$url)$url=$objet->getUrl();
			
            $loopResultRow
                ->set('ID', $objet->getId())
                ->set('MENU_ID', $menuItem->getId())
                ->set('OBJET', $menuItem->getObjet())
                ->set('TYPE', $type)
                ->set('TYPE_ID', $menuItem->getTypobj())
                ->set('TITLE', $title)
                ->set('CHAPO', $chapo)
                ->set('DESCRIPTION', $description)
                ->set('POSTSCRIPTUM', $postscriptum)
                ->set('URL', $url)
                ->set('ACTIVE', $active)
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
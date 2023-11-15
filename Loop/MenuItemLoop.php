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
            Argument::createIntListTypeArgument('parent'),
            Argument::createAnyTypeArgument('active'),
            Argument::createAnyTypeArgument('locale')
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
		$parent = $this->getParent();
        if ($parent) {
            $search->filterByMenuParent($parent, Criteria::IN);
        }
		$search->orderByPosition();
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
			$classActive = ' active';
			if($this->getActive())$classActive = $this->getActive();
			$active='';

			switch($menuItem->getTypobj()){
				case 0 :
					$objet = CategoryQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='category';
					
					if($menuItem->getObjet() == $this->getCurrentRequest()->get('category_id') && $this->getCurrentRequest()->get('category_id')){
						$active = $classActive;
					}elseif($this->getCurrentRequest()->get('category_id')){
						$parentId = $this->getCurrentRequest()->get('category_id');
						while($parentId != 0  && !$active){
							$parent = CategoryQuery::create()->filterByVisible(1)->findPk($parentId);
							if($parent){
								$parentId = $parent->getParent();
								if($parentId == $menuItem->getObjet()){
									$active = $classActive;
								}
							}else{
								$parentId=0;
							}
						}
					}elseif($this->getCurrentRequest()->get('product_id')){
						if(null !== $parent = ProductCategoryQuery::create()->filterByProductId($this->getCurrentRequest()->get('product_id'))->filterByCategoryId($menuItem->getObjet())->findOne()){
							$active = $classActive;
						}else{
							if(null !== $parents = ProductCategoryQuery::create()->filterByProductId($this->getCurrentRequest()->get('product_id'))->find()){
								foreach($parents as $parent){
									$parentId = $parent->getCategoryId();
									while($parentId != 0  && !$active){
										$parent = CategoryQuery::create()->filterByVisible(1)->findPk($parentId);
										$parentId=0;
										if($parent){
											$parentId = $parent->getParent();
											if($parentId == $menuItem->getObjet()){
												$active = $classActive;
											}
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
					if($menuItem->getObjet() == $this->getCurrentRequest()->get('product_id') && $this->getCurrentRequest()->get('product_id')){
						$active = $classActive;
					}
				break;
				case 2 :
					$objet = FolderQuery::create()->filterByVisible(1)->findPk($menuItem->getObjet());
					$type='folder';
					if($menuItem->getObjet() == $this->getCurrentRequest()->get('folder_id') && $this->getCurrentRequest()->get('folder_id')){
						$active = $classActive;
					}elseif($this->getCurrentRequest()->get('folder_id') && !$active){
						$parentId = $this->getCurrentRequest()->get('folder_id');
						while($parentId != 0  && !$active){
							$parent = FolderQuery::create()->filterByVisible(1)->findPk($parentId);
							if($parent){
								$parentId = $parent->getParent();
								if($parentId == $menuItem->getObjet()){
									$active = $classActive;
								}
							}else{
								$parentId=0;
							}
						}
					}elseif($this->getCurrentRequest()->get('content_id')){
						if(null !== $parent = ContentFolderQuery::create()->filterByContentId($this->getCurrentRequest()->get('content_id'))->filterByFolderId($menuItem->getObjet())->findOne()){
							$active = $classActive;
						}else{
							if(null !== $parents = ContentFolderQuery::create()->filterByContentId($this->getCurrentRequest()->get('product_id'))->find()){
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
					if($menuItem->getObjet() == $this->getCurrentRequest()->get('content_id') && $this->getCurrentRequest()->get('content_id')){
						$active = $classActive;
					}
				break;
				case 4 :
					$objet = $menuItem;
					$type='libre';
					$active = '';
				break;
			}
			
			
            if($objet === null) continue;
			$locale = $this->getLocale();

			if($locale){
				$objet->setLocale($locale);
				$menuItem->setLocale($locale);
			}else{
				$locale = $this->getCurrentRequest()->getSession()->getLang()->getLocale();
				$objet->setLocale($locale);	
				$menuItem->setLocale($locale);	
			}
            
			if($menuItem->getTitle()){
				$title = $menuItem->getTitle();
			}
			if($menuItem->getChapo()){
				$chapo = $menuItem->getChapo();
			}
            if(!$title)$title=$objet->getTitle();
            if(!$chapo)$chapo=$objet->getChapo();
            if(!$description)$description=$objet->getDescription();
            if(!$postscriptum)$postscriptum=$objet->getPostscriptum();
			
			if($menuItem->getUrl()){
				$url = $menuItem->getUrl();
			}
            if(!$url)$url=$objet->getUrl();

			
			
			$target = '';
			if($menuItem->getTargetblank()){
				$target = ' target="_blank"';
			}
			$sousmenu = '';
			if($menuItem->getSousmenu()){
				$sousmenu = 1;
			}

            $loopResultRow
                ->set('ID', $objet->getId())
                ->set('OBJET_ID', $objet->getId())
                ->set('MENU_ID', $menuItem->getMenuId())
                ->set('MENU_ITEM_ID', $menuItem->getId())
                ->set('ITEM_ID', $menuItem->getId())
                ->set('OBJET', $menuItem->getObjet())
                ->set('TYPE', $type)
                ->set('TYPE_ID', $menuItem->getTypobj())
                ->set('TITLE', $title)
                ->set('CHAPO', $chapo)
                ->set('DESCRIPTION', $description)
                ->set('POSTSCRIPTUM', $postscriptum)
                ->set('URL', $url)
                ->set('ACTIVE', $active)
                ->set('TARGET', $target)
                ->set('SOUSMENU', $sousmenu)
                ->set('CSS_CLASS', $menuItem->getCssclass())
                ->set('ICONE', $menuItem->getIcone())
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
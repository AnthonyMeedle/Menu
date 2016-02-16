<?php
namespace Menu\Loop;

use Menu\Model\MenuItemQuery;
use Menu\Model\MenuItemI18nQuery;
use Thelia\Model\CategoryI18nQuery;
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
    protected $versionable = true;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('menu_id')
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
            $type='category';
			switch($menuItem->getTypobj()){
				case 0 :
/*					$category = CategoryI18nQuery::create()->findOneById($menuItem->getObjet());
					$category->setLocale('fr_FR');
            		if(!$title)$title=$category->getTitle();*/
					$type='category';
				break;	
				case 1 :
					$type='product';
				break;	
				case 2 :
					$type='folder';
				break;	
				case 3 :
					$type='content';
				break;	
			}
            $loopResultRow
                ->set('ID', $menuItem->getId())
                ->set('OBJET', $menuItem->getObjet())
                ->set('TYPE', $type)
       //         ->set('TITLE', $title)
        //        ->set('DESCRIPTION', $menuItem->getVirtualColumn('i18n_DESCRIPTION'))
            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
<?php
namespace Menu\Loop;

use Menu\Model\MenuQuery;
use Menu\Model\MenuI18nQuery;
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


class MenuLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    protected function getArgDefinitions()
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('typobj'),
            Argument::createIntListTypeArgument('typobjex'),
            Argument::createIntListTypeArgument('objet'),
            Argument::createAnyTypeArgument('locale'),
            Argument::createBooleanOrBothTypeArgument('visible')
        );
    }

    /**
     * this method returns a Propel ModelCriteria
     *
     * @return \Propel\Runtime\ActiveQuery\ModelCriteria
     */
    public function buildModelCriteria()
    {
        $search = MenuQuery::create();
		
        $id = $this->getId();
        if ($id) {
            $search->filterById($id, Criteria::IN);
        }
		
        $typobj = $this->getTypobj();
        if ($typobj) {
            $search->filterByTypobj($typobj, Criteria::IN);
        }
		
        $typobjex = $this->getTypobjex();
        if ($typobjex !== null) {
         //   $search->filterByTypobj($typobjex, Criteria::NOT_IN);
        }
		
        $objet = $this->getObjet();
        if ($objet) {
            $search->filterByObjet($objet, Criteria::IN);
        }


        $visible = $this->getVisible();
        if ($visible !== BooleanOrBothType::ANY) $search->filterByVisible($visible ? 0 : 1);

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
        foreach ($loopResult->getResultDataCollection() as $menu) {
            $loopResultRow = new LoopResultRow($menu);
			
			$locale = $this->getLocale();
			if($locale){
				$menu->setLocale($locale);
			}else{
				$locale = $this->getCurrentRequest()->getSession()->getLang()->getLocale();
				$menu->setLocale($locale);	
			}
            
			
            $loopResultRow 
                ->set('ID', $menu->getId())
                ->set('TYPOBJ', $menu->getTypobj())
                ->set('OBJET', $menu->getObjet())
                ->set('TITLE', $menu->getTitle())
                ->set('DESCRIPTION', $menu->getDescription())
                ->set('VISIBLE', $menu->getVisible())

            ;

            $loopResult->addRow($loopResultRow);
        }

        return $loopResult;
    }
}
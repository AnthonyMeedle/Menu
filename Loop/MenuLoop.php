<?php

declare(strict_types=1);

namespace Menu\Loop;

use Menu\Model\MenuQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\BooleanOrBothType;

final class MenuLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    protected function getArgDefinitions(): ArgumentCollection
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createBooleanOrBothTypeArgument('visible', 1),
            Argument::createAnyTypeArgument('locale'),
        );
    }

    public function buildModelCriteria(): ModelCriteria
    {
        $query = MenuQuery::create()->orderByPosition();
        $this->configureI18nProcessing($query, ['TITLE', 'DESCRIPTION', 'CHAPO', 'POSTSCRIPTUM']);
        if (null !== $this->getId()) {
            $query->filterById($this->getId(), Criteria::IN);
        }
        if (BooleanOrBothType::ANY !== $this->getVisible()) {
            $query->filterByVisible($this->getVisible() ? 1 : 0);
        }

        return $query;
    }

    public function parseResults(LoopResult $loopResult): LoopResult
    {
        foreach ($loopResult->getResultDataCollection() as $menu) {
            $loopResult->addRow(
                (new LoopResultRow($menu))
                    ->set('ID', $menu->getId())
                    ->set('TITLE', $menu->getVirtualColumn('i18n_TITLE'))
                    ->set('DESCRIPTION', $menu->getVirtualColumn('i18n_DESCRIPTION'))
                    ->set('CHAPO', $menu->getVirtualColumn('i18n_CHAPO'))
                    ->set('POSTSCRIPTUM', $menu->getVirtualColumn('i18n_POSTSCRIPTUM'))
                    ->set('VISIBLE', (bool) $menu->getVisible())
                    ->set('POSITION', $menu->getPosition())
            );
        }

        return $loopResult;
    }
}

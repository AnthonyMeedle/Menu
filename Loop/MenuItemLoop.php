<?php

declare(strict_types=1);

namespace Menu\Loop;

use Menu\Model\MenuItemQuery;
use Menu\Service\MenuItemType;
use Menu\Service\MenuTargetResolver;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Thelia\Core\Template\Element\BaseI18nLoop;
use Thelia\Core\Template\Element\LoopResult;
use Thelia\Core\Template\Element\LoopResultRow;
use Thelia\Core\Template\Element\PropelSearchLoopInterface;
use Thelia\Core\Template\Loop\Argument\Argument;
use Thelia\Core\Template\Loop\Argument\ArgumentCollection;
use Thelia\Type\BooleanOrBothType;

final class MenuItemLoop extends BaseI18nLoop implements PropelSearchLoopInterface
{
    protected $timestampable = true;

    protected function getArgDefinitions(): ArgumentCollection
    {
        return new ArgumentCollection(
            Argument::createIntListTypeArgument('id'),
            Argument::createIntListTypeArgument('menu_id'),
            Argument::createIntListTypeArgument('menu'),
            Argument::createIntListTypeArgument('parent'),
            Argument::createBooleanOrBothTypeArgument('visible', 1),
            Argument::createAnyTypeArgument('active', ' active'),
            Argument::createAnyTypeArgument('locale'),
        );
    }

    public function buildModelCriteria(): ModelCriteria
    {
        $query = MenuItemQuery::create()->orderByPosition();
        $this->configureI18nProcessing($query, ['URL', 'TITLE', 'DESCRIPTION', 'CHAPO', 'POSTSCRIPTUM']);
        if (null !== $this->getId()) {
            $query->filterById($this->getId(), Criteria::IN);
        }
        $menuIds = $this->getMenuId() ?? $this->getMenu();
        if (null !== $menuIds) {
            $query->filterByMenuId($menuIds, Criteria::IN);
        }
        if (null !== $this->getParent()) {
            $query->filterByMenuParent($this->getParent(), Criteria::IN);
        }
        if (BooleanOrBothType::ANY !== $this->getVisible()) {
            $query->filterByVisible($this->getVisible() ? 1 : 0);
        }

        return $query;
    }

    public function parseResults(LoopResult $loopResult): LoopResult
    {
        $locale = $this->getLocale() ?: $this->requestLocale();
        $resolver = new MenuTargetResolver();
        foreach ($loopResult->getResultDataCollection() as $item) {
            $item->setLocale($locale);
            $resolved = MenuItemType::CUSTOM === $item->getTypobj()
                ? ['type' => 'custom', 'title' => '', 'url' => '', 'chapo' => '', 'description' => '', 'postscriptum' => '']
                : $resolver->resolve($item->getTypobj(), $item->getObjet(), $locale);
            if (null === $resolved) {
                continue;
            }

            $title = $item->getVirtualColumn('i18n_TITLE') ?: $resolved['title'];
            $url = $item->getVirtualColumn('i18n_URL') ?: $resolved['url'];
            $chapo = $item->getVirtualColumn('i18n_CHAPO') ?: $resolved['chapo'];
            $description = $item->getVirtualColumn('i18n_DESCRIPTION') ?: $resolved['description'];
            $postscriptum = $item->getVirtualColumn('i18n_POSTSCRIPTUM') ?: $resolved['postscriptum'];
            $hasChildren = MenuItemQuery::create()->filterByMenuId($item->getMenuId())->filterByMenuParent($item->getId())->filterByVisible(true)->count() > 0;
            $active = $this->isActive($item->getTypobj(), $item->getObjet()) ? (string) $this->getActive() : '';
            $objectId = MenuItemType::CUSTOM === $item->getTypobj() ? $item->getId() : $item->getObjet();

            $loopResult->addRow(
                (new LoopResultRow($item))
                    ->set('ID', $objectId)
                    ->set('OBJET_ID', $objectId)
                    ->set('OBJET', $item->getObjet())
                    ->set('MENU_ID', $item->getMenuId())
                    ->set('MENU_ITEM_ID', $item->getId())
                    ->set('ITEM_ID', $item->getId())
                    ->set('PARENT_ID', (int) $item->getMenuParent())
                    ->set('POSITION', $item->getPosition())
                    ->set('TYPE', $resolved['type'])
                    ->set('TYPE_ID', $item->getTypobj())
                    ->set('TITLE', $title)
                    ->set('URL', $url)
                    ->set('CHAPO', $chapo)
                    ->set('DESCRIPTION', $description)
                    ->set('POSTSCRIPTUM', $postscriptum)
                    ->set('VISIBLE', (bool) $item->getVisible())
                    ->set('ACTIVE', $active)
                    ->set('TARGET', $item->getTargetblank() ? ' target="_blank" rel="noopener noreferrer"' : '')
                    ->set('TARGET_BLANK', (bool) $item->getTargetblank())
                    ->set('SOUSMENU', $hasChildren ? 1 : 0)
                    ->set('HAS_CHILDREN', $hasChildren)
                    ->set('CSS_CLASS', $item->getCssclass())
                    ->set('ICONE', $item->getIcone())
            );
        }

        return $loopResult;
    }

    private function requestLocale(): string
    {
        $request = $this->getCurrentRequest();

        return null !== $request && $request->hasSession()
            ? $request->getSession()->getLang()->getLocale()
            : 'fr_FR';
    }

    private function isActive(int $type, int $objectId): bool
    {
        $request = $this->getCurrentRequest();
        if (null === $request) {
            return false;
        }
        $parameter = match ($type) {
            MenuItemType::CATEGORY => 'category_id',
            MenuItemType::PRODUCT => 'product_id',
            MenuItemType::FOLDER => 'folder_id',
            MenuItemType::CONTENT => 'content_id',
            MenuItemType::BRAND => 'brand_id',
            MenuItemType::PAGE => 'page_id',
            default => null,
        };
        if (null === $parameter) {
            return false;
        }

        return $objectId === (int) ($request->attributes->get($parameter) ?? $request->query->get($parameter, 0));
    }
}

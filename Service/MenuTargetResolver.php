<?php

declare(strict_types=1);

namespace Menu\Service;

use Page\Model\PageQuery;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\ProductQuery;

final class MenuTargetResolver
{
    /** @return array{available: bool, count: int, groups: array<string, array<string, string>>} */
    public function quickChoices(string $locale, int $maximum = 150): array
    {
        $count = CategoryQuery::create()->filterByVisible(true)->count()
            + ProductQuery::create()->filterByVisible(true)->count()
            + FolderQuery::create()->filterByVisible(true)->count()
            + ContentQuery::create()->filterByVisible(true)->count()
            + BrandQuery::create()->filterByVisible(true)->count();
        if (class_exists(PageQuery::class)) {
            $count += max(0, PageQuery::create()->filterByVisible(true)->count() - 1);
        }

        return [
            'available' => $count <= $maximum,
            'count' => $count,
            'groups' => $count <= $maximum ? $this->choices($locale) : ['Lien libre' => ['Saisir un titre et une URL' => '4:0']],
        ];
    }

    public function targetLabel(string $target, string $locale): string
    {
        if (!preg_match('/^(\d+):(\d+)$/', $target, $matches)) {
            return 'Aucune destination';
        }
        $type = (int) $matches[1];
        if (MenuItemType::CUSTOM === $type) {
            return 'Lien libre';
        }
        $resolved = $this->resolve($type, (int) $matches[2], $locale);

        return null === $resolved
            ? 'Destination indisponible'
            : (MenuItemType::labels()[$type] ?? 'Destination').' · '.$resolved['title'];
    }

    /** @return array<string, array<string, string>> */
    private function choices(string $locale): array
    {
        $choices = [
            'Lien libre' => ['Saisir un titre et une URL' => '4:0'],
            'Catégories' => $this->modelChoices(CategoryQuery::create()->filterByVisible(true)->orderByPosition()->find(), MenuItemType::CATEGORY, $locale),
            'Produits' => $this->modelChoices(ProductQuery::create()->filterByVisible(true)->orderByRef()->find(), MenuItemType::PRODUCT, $locale, true),
            'Dossiers' => $this->modelChoices(FolderQuery::create()->filterByVisible(true)->orderByPosition()->find(), MenuItemType::FOLDER, $locale),
            'Contenus' => $this->modelChoices(ContentQuery::create()->filterByVisible(true)->orderByPosition()->find(), MenuItemType::CONTENT, $locale),
            'Marques' => $this->modelChoices(BrandQuery::create()->filterByVisible(true)->orderByPosition()->find(), MenuItemType::BRAND, $locale),
        ];

        if (class_exists(PageQuery::class)) {
            $pages = PageQuery::create()->filterByVisible(true)->orderByTreeLeft()->find();
            $choices['Pages'] = [];
            foreach ($pages as $page) {
                if (method_exists($page, 'isRoot') && $page->isRoot()) {
                    continue;
                }
                $page->setLocale($locale);
                $indent = str_repeat('— ', max(0, (int) $page->getTreeLevel() - 1));
                $choices['Pages'][$indent.$page->getTitle().' (#'.$page->getId().')'] = MenuItemType::PAGE.':'.$page->getId();
            }
        }

        return array_filter($choices);
    }

    /** @return array{object: object, type: string, title: string, chapo: string, description: string, postscriptum: string, url: string}|null */
    public function resolve(int $type, int $objectId, string $locale): ?array
    {
        $object = match ($type) {
            MenuItemType::CATEGORY => CategoryQuery::create()->filterByVisible(true)->findPk($objectId),
            MenuItemType::PRODUCT => ProductQuery::create()->filterByVisible(true)->findPk($objectId),
            MenuItemType::FOLDER => FolderQuery::create()->filterByVisible(true)->findPk($objectId),
            MenuItemType::CONTENT => ContentQuery::create()->filterByVisible(true)->findPk($objectId),
            MenuItemType::BRAND => BrandQuery::create()->filterByVisible(true)->findPk($objectId),
            MenuItemType::PAGE => class_exists(PageQuery::class) ? PageQuery::create()->filterByVisible(true)->findPk($objectId) : null,
            default => null,
        };

        if (null === $object) {
            return null;
        }

        if (method_exists($object, 'setLocale')) {
            $object->setLocale($locale);
        }

        return [
            'object' => $object,
            'type' => MenuItemType::slug($type),
            'title' => (string) $this->read($object, 'getTitle'),
            'chapo' => (string) $this->read($object, 'getChapo'),
            'description' => (string) $this->read($object, 'getDescription'),
            'postscriptum' => (string) $this->read($object, 'getPostscriptum'),
            'url' => (string) $this->readUrl($object, $locale),
        ];
    }

    /** @return array<string, string> */
    private function modelChoices(iterable $objects, int $type, string $locale, bool $includeReference = false): array
    {
        $choices = [];
        foreach ($objects as $object) {
            $object->setLocale($locale);
            $suffix = $includeReference && method_exists($object, 'getRef') ? ' · '.$object->getRef() : '';
            $choices[$object->getTitle().$suffix.' (#'.$object->getId().')'] = $type.':'.$object->getId();
        }

        return $choices;
    }

    private function read(object $object, string $method): mixed
    {
        return method_exists($object, $method) ? $object->{$method}() : '';
    }

    private function readUrl(object $object, string $locale): string
    {
        return method_exists($object, 'getUrl') ? (string) $object->getUrl($locale) : '';
    }
}

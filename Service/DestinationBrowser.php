<?php

declare(strict_types=1);

namespace Menu\Service;

use Page\Model\PageQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Thelia\Model\BrandQuery;
use Thelia\Model\CategoryQuery;
use Thelia\Model\ContentFolderQuery;
use Thelia\Model\ContentQuery;
use Thelia\Model\FolderQuery;
use Thelia\Model\ProductCategoryQuery;
use Thelia\Model\ProductQuery;

final class DestinationBrowser
{
    private const LIMIT = 100;

    /** @return array{section: string, parent: int, breadcrumbs: list<array{parent: int, title: string}>, items: list<array<string, mixed>>, limited: bool} */
    public function browse(string $section, int $parent, string $search, string $locale): array
    {
        $search = trim($search);
        [$items, $breadcrumbs, $total] = match ($section) {
            'catalog' => $this->catalog($parent, $search, $locale),
            'folder' => $this->folders($parent, $search, $locale),
            'brand' => $this->brands($search, $locale),
            'page' => $this->pages($parent, $search, $locale),
            default => throw new \InvalidArgumentException('Section de navigation inconnue.'),
        };

        return [
            'section' => $section,
            'parent' => $parent,
            'breadcrumbs' => $breadcrumbs,
            'items' => array_slice($items, 0, self::LIMIT),
            'limited' => $total > self::LIMIT,
        ];
    }

    /** @return array{list<array<string, mixed>>, list<array{parent: int, title: string}>, int} */
    private function catalog(int $parent, string $search, string $locale): array
    {
        $categoryQuery = CategoryQuery::create()->filterByVisible(true);
        $productQuery = ProductQuery::create()->filterByVisible(true);
        if ('' !== $search) {
            $categoryQuery->useCategoryI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
            $productQuery->useProductI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
        } else {
            $categoryQuery->filterByParent($parent);
            if ($parent > 0) {
                $productQuery->useProductCategoryQuery()->filterByCategoryId($parent)->endUse();
            } else {
                $productQuery->filterById(-1);
            }
        }

        $categoryCount = $categoryQuery->count();
        $productCount = $productQuery->count();
        $items = [];
        foreach ($categoryQuery->orderByPosition()->limit(self::LIMIT)->find() as $category) {
            $category->setLocale($locale);
            $hasChildren = CategoryQuery::create()->filterByVisible(true)->filterByParent($category->getId())->count() > 0
                || ProductCategoryQuery::create()->filterByCategoryId($category->getId())->count() > 0;
            $items[] = $this->item(MenuItemType::CATEGORY, $category->getId(), $category->getTitle(), 'Catégorie', $hasChildren);
        }
        foreach ($productQuery->orderByRef()->limit(max(0, self::LIMIT - count($items)))->find() as $product) {
            $product->setLocale($locale);
            $items[] = $this->item(MenuItemType::PRODUCT, $product->getId(), $product->getTitle(), 'Produit', false, $product->getRef());
        }

        return [$items, '' === $search ? $this->categoryBreadcrumbs($parent, $locale) : [], $categoryCount + $productCount];
    }

    /** @return array{list<array<string, mixed>>, list<array{parent: int, title: string}>, int} */
    private function folders(int $parent, string $search, string $locale): array
    {
        $folderQuery = FolderQuery::create()->filterByVisible(true);
        $contentQuery = ContentQuery::create()->filterByVisible(true);
        if ('' !== $search) {
            $folderQuery->useFolderI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
            $contentQuery->useContentI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
        } else {
            $folderQuery->filterByParent($parent);
            if ($parent > 0) {
                $contentQuery->useContentFolderQuery()->filterByFolderId($parent)->endUse();
            } else {
                $contentQuery->filterById(-1);
            }
        }

        $folderCount = $folderQuery->count();
        $contentCount = $contentQuery->count();
        $items = [];
        foreach ($folderQuery->orderByPosition()->limit(self::LIMIT)->find() as $folder) {
            $folder->setLocale($locale);
            $hasChildren = FolderQuery::create()->filterByVisible(true)->filterByParent($folder->getId())->count() > 0
                || ContentFolderQuery::create()->filterByFolderId($folder->getId())->count() > 0;
            $items[] = $this->item(MenuItemType::FOLDER, $folder->getId(), $folder->getTitle(), 'Dossier', $hasChildren);
        }
        foreach ($contentQuery->orderByPosition()->limit(max(0, self::LIMIT - count($items)))->find() as $content) {
            $content->setLocale($locale);
            $items[] = $this->item(MenuItemType::CONTENT, $content->getId(), $content->getTitle(), 'Contenu', false);
        }

        return [$items, '' === $search ? $this->folderBreadcrumbs($parent, $locale) : [], $folderCount + $contentCount];
    }

    /** @return array{list<array<string, mixed>>, list<array{parent: int, title: string}>, int} */
    private function brands(string $search, string $locale): array
    {
        $query = BrandQuery::create()->filterByVisible(true);
        if ('' !== $search) {
            $query->useBrandI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
        }
        $total = $query->count();
        $items = [];
        foreach ($query->orderByPosition()->limit(self::LIMIT)->find() as $brand) {
            $brand->setLocale($locale);
            $items[] = $this->item(MenuItemType::BRAND, $brand->getId(), $brand->getTitle(), 'Marque', false);
        }

        return [$items, [], $total];
    }

    /** @return array{list<array<string, mixed>>, list<array{parent: int, title: string}>, int} */
    private function pages(int $parent, string $search, string $locale): array
    {
        if (!class_exists(PageQuery::class)) {
            return [[], [], 0];
        }
        $root = PageQuery::create()->findRoot();
        if (null === $root) {
            return [[], [], 0];
        }
        $parentPage = $parent > 0 ? PageQuery::create()->filterByVisible(true)->findPk($parent) : $root;
        if (null === $parentPage) {
            $parentPage = $root;
            $parent = 0;
        }

        $query = PageQuery::create()->filterByVisible(true);
        if ('' !== $search) {
            $query->usePageI18nQuery()->filterByLocale($locale)->filterByTitle('%'.$search.'%', Criteria::LIKE)->endUse();
            $query->filterById($root->getId(), Criteria::NOT_EQUAL);
        } else {
            $query
                ->filterByTreeLeft($parentPage->getTreeLeft(), Criteria::GREATER_THAN)
                ->filterByTreeRight($parentPage->getTreeRight(), Criteria::LESS_THAN)
                ->filterByTreeLevel($parentPage->getTreeLevel() + 1);
        }
        $total = $query->count();
        $items = [];
        foreach ($query->orderByTreeLeft()->limit(self::LIMIT)->find() as $page) {
            $page->setLocale($locale);
            $hasChildren = PageQuery::create()
                ->filterByVisible(true)
                ->filterByTreeLeft($page->getTreeLeft(), Criteria::GREATER_THAN)
                ->filterByTreeRight($page->getTreeRight(), Criteria::LESS_THAN)
                ->filterByTreeLevel($page->getTreeLevel() + 1)
                ->count() > 0;
            $items[] = $this->item(MenuItemType::PAGE, $page->getId(), $page->getTitle(), 'Page', $hasChildren);
        }

        return [$items, '' === $search ? $this->pageBreadcrumbs($parentPage, $root, $locale) : [], $total];
    }

    /** @return array<string, mixed> */
    private function item(int $type, int $id, string $title, string $kind, bool $hasChildren, string $reference = ''): array
    {
        return [
            'target' => $type.':'.$id,
            'browse_parent' => $id,
            'title' => $title,
            'kind' => MenuItemType::slug($type),
            'kind_label' => $kind,
            'reference' => $reference,
            'has_children' => $hasChildren,
        ];
    }

    /** @return list<array{parent: int, title: string}> */
    private function categoryBreadcrumbs(int $parent, string $locale): array
    {
        $crumbs = [['parent' => 0, 'title' => 'Catalogue']];
        $chain = [];
        while ($parent > 0 && null !== $category = CategoryQuery::create()->findPk($parent)) {
            $category->setLocale($locale);
            array_unshift($chain, ['parent' => $category->getId(), 'title' => $category->getTitle()]);
            $parent = (int) $category->getParent();
        }

        return [...$crumbs, ...$chain];
    }

    /** @return list<array{parent: int, title: string}> */
    private function folderBreadcrumbs(int $parent, string $locale): array
    {
        $crumbs = [['parent' => 0, 'title' => 'Dossiers']];
        $chain = [];
        while ($parent > 0 && null !== $folder = FolderQuery::create()->findPk($parent)) {
            $folder->setLocale($locale);
            array_unshift($chain, ['parent' => $folder->getId(), 'title' => $folder->getTitle()]);
            $parent = (int) $folder->getParent();
        }

        return [...$crumbs, ...$chain];
    }

    /** @return list<array{parent: int, title: string}> */
    private function pageBreadcrumbs(object $page, object $root, string $locale): array
    {
        $crumbs = [['parent' => 0, 'title' => 'Pages']];
        if ($page->getId() === $root->getId()) {
            return $crumbs;
        }
        foreach ($page->getAncestors() as $ancestor) {
            if ($ancestor->getId() === $root->getId()) {
                continue;
            }
            $ancestor->setLocale($locale);
            $crumbs[] = ['parent' => $ancestor->getId(), 'title' => $ancestor->getTitle()];
        }
        $page->setLocale($locale);
        $crumbs[] = ['parent' => $page->getId(), 'title' => $page->getTitle()];

        return $crumbs;
    }
}

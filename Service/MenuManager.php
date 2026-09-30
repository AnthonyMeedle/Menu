<?php

declare(strict_types=1);

namespace Menu\Service;

use Menu\Model\Menu;
use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
use Menu\Model\MenuQuery;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Propel;

final readonly class MenuManager
{
    public function __construct(private MenuTargetResolver $targets)
    {
    }

    /** @param array<string, mixed> $data */
    public function createMenu(array $data, string $locale): Menu
    {
        $menu = (new Menu())
            ->setVisible((int) (bool) ($data['visible'] ?? false))
            ->setPosition(MenuQuery::create()->count() + 1)
            ->setLocale($locale)
            ->setTitle(trim((string) $data['title']))
            ->setDescription(trim((string) ($data['description'] ?? '')));
        $menu->save();

        return $menu;
    }

    /** @param array<string, mixed> $data */
    public function updateMenu(Menu $menu, array $data, string $locale): void
    {
        $menu
            ->setVisible((int) (bool) ($data['visible'] ?? false))
            ->setLocale($locale)
            ->setTitle(trim((string) $data['title']))
            ->setDescription(trim((string) ($data['description'] ?? '')))
            ->save();
    }

    public function deleteMenu(Menu $menu): void
    {
        $menu->delete();
        $this->normalizeMenus();
    }

    /** @param array<string, mixed> $data */
    public function createItem(Menu $menu, array $data, string $locale): MenuItem
    {
        [$type, $objectId] = $this->parseTarget((string) ($data['target'] ?? ''));
        $parentId = (int) ($data['parent_id'] ?? 0);
        $this->assertTarget($type, $objectId, $locale, $data);
        $this->assertParent($menu, $parentId);

        $item = (new MenuItem())
            ->setMenuId($menu->getId())
            ->setMenuParent($parentId)
            ->setPosition($this->nextPosition($menu->getId(), $parentId));
        $this->hydrateItem($item, $type, $objectId, $data, $locale);
        $item->save();
        $this->refreshSubmenuFlags($menu->getId());

        return $item;
    }

    /** @param array<string, mixed> $data */
    public function updateItem(MenuItem $item, array $data, string $locale): void
    {
        [$type, $objectId] = $this->parseTarget((string) ($data['target'] ?? ''));
        $parentId = (int) ($data['parent_id'] ?? 0);
        $this->assertTarget($type, $objectId, $locale, $data);
        $this->assertParent(MenuQuery::create()->findPk($item->getMenuId()), $parentId, $item);

        $oldParent = (int) $item->getMenuParent();
        $item->setMenuParent($parentId);
        if ($oldParent !== $parentId) {
            $item->setPosition($this->nextPosition($item->getMenuId(), $parentId));
        }
        $this->hydrateItem($item, $type, $objectId, $data, $locale);
        $item->save();
        $this->normalizeSiblings($item->getMenuId(), $oldParent);
        $this->normalizeSiblings($item->getMenuId(), $parentId);
        $this->refreshSubmenuFlags($item->getMenuId());
    }

    public function deleteItem(MenuItem $item): void
    {
        $menuId = $item->getMenuId();
        $parentId = (int) $item->getMenuParent();
        $connection = Propel::getWriteConnection('TheliaMain');
        $connection->transaction(function () use ($item, $menuId): void {
            $this->deleteBranch($item->getId());
            $this->refreshSubmenuFlags($menuId);
        });
        $this->normalizeSiblings($menuId, $parentId);
    }

    public function move(MenuItem $item, string $direction): void
    {
        match ($direction) {
            'up' => $this->swapWithSibling($item, true),
            'down' => $this->swapWithSibling($item, false),
            'indent' => $this->indent($item),
            'outdent' => $this->outdent($item),
            default => throw new \InvalidArgumentException('Déplacement inconnu.'),
        };
        $this->refreshSubmenuFlags($item->getMenuId());
    }

    /** @return list<array<string, mixed>> */
    public function tree(int $menuId, string $locale): array
    {
        $items = MenuItemQuery::create()->filterByMenuId($menuId)->orderByPosition()->find();
        $byParent = [];
        foreach ($items as $item) {
            $byParent[(int) $item->getMenuParent()][] = $item;
        }

        $build = function (int $parentId, array $trail = []) use (&$build, $byParent, $locale): array {
            $rows = [];
            foreach ($byParent[$parentId] ?? [] as $item) {
                if (in_array($item->getId(), $trail, true)) {
                    continue;
                }
                $item->setLocale($locale);
                $resolved = $this->targets->resolve($item->getTypobj(), $item->getObjet(), $locale);
                $rows[] = [
                    'id' => $item->getId(),
                    'parent_id' => (int) $item->getMenuParent(),
                    'position' => $item->getPosition(),
                    'type_id' => $item->getTypobj(),
                    'type' => MenuItemType::slug($item->getTypobj()),
                    'type_label' => MenuItemType::labels()[$item->getTypobj()] ?? 'Lien libre',
                    'object_id' => $item->getObjet(),
                    'title' => $item->getTitle() ?: ($resolved['title'] ?? 'Élément indisponible'),
                    'url' => $item->getUrl() ?: ($resolved['url'] ?? ''),
                    'visible' => (bool) $item->getVisible(),
                    'target_blank' => (bool) $item->getTargetblank(),
                    'css_class' => $item->getCssclass(),
                    'icon' => $item->getIcone(),
                    'missing' => MenuItemType::CUSTOM !== $item->getTypobj() && null === $resolved,
                    'children' => $build($item->getId(), [...$trail, $item->getId()]),
                ];
            }

            return $rows;
        };

        return $build(0);
    }

    /** @return list<array{id: int, title: string, depth: int}> */
    public function parentChoices(int $menuId, string $locale, ?MenuItem $excluded = null): array
    {
        $excludedIds = $excluded ? [$excluded->getId(), ...$this->descendantIds($excluded->getId())] : [];
        $rows = [];
        $walk = function (array $nodes, int $depth = 0) use (&$walk, &$rows, $excludedIds): void {
            foreach ($nodes as $node) {
                if (!in_array($node['id'], $excludedIds, true)) {
                    $rows[] = ['id' => $node['id'], 'title' => $node['title'], 'depth' => $depth];
                    $walk($node['children'], $depth + 1);
                }
            }
        };
        $walk($this->tree($menuId, $locale));

        return $rows;
    }

    /** @param array<string, mixed> $data */
    private function hydrateItem(MenuItem $item, int $type, int $objectId, array $data, string $locale): void
    {
        $item
            ->setTypobj($type)
            ->setObjet($objectId)
            ->setVisible((int) (bool) ($data['visible'] ?? false))
            ->setTargetblank((int) (bool) ($data['target_blank'] ?? false))
            ->setCssclass(trim((string) ($data['css_class'] ?? '')))
            ->setIcone(trim((string) ($data['icon'] ?? '')))
            ->setLocale($locale)
            ->setTitle(trim((string) ($data['title'] ?? '')))
            ->setUrl(trim((string) ($data['url'] ?? '')))
            ->setChapo(trim((string) ($data['chapo'] ?? '')));
    }

    /** @return array{int, int} */
    private function parseTarget(string $target): array
    {
        if (!preg_match('/^(\d+):(\d+)$/', $target, $matches)) {
            throw new \InvalidArgumentException('Choisissez une destination valide.');
        }

        $type = (int) $matches[1];
        if (!array_key_exists($type, MenuItemType::labels())) {
            throw new \InvalidArgumentException('Ce type de destination est inconnu.');
        }

        return [$type, (int) $matches[2]];
    }

    /** @param array<string, mixed> $data */
    private function assertTarget(int $type, int $objectId, string $locale, array $data): void
    {
        if (MenuItemType::CUSTOM === $type) {
            if ('' === trim((string) ($data['title'] ?? ''))) {
                throw new \InvalidArgumentException('Le titre est obligatoire pour un lien libre.');
            }
            return;
        }
        if ($objectId < 1 || null === $this->targets->resolve($type, $objectId, $locale)) {
            throw new \InvalidArgumentException('La destination choisie est introuvable ou masquée.');
        }
    }

    private function assertParent(?Menu $menu, int $parentId, ?MenuItem $item = null): void
    {
        if (null === $menu) {
            throw new \InvalidArgumentException('Menu introuvable.');
        }
        if (0 === $parentId) {
            return;
        }
        $parent = MenuItemQuery::create()->findPk($parentId);
        if (null === $parent || $parent->getMenuId() !== $menu->getId()) {
            throw new \InvalidArgumentException('Le parent doit appartenir au même menu.');
        }
        if (null !== $item && ($parentId === $item->getId() || in_array($parentId, $this->descendantIds($item->getId()), true))) {
            throw new \InvalidArgumentException('Un élément ne peut pas être placé sous lui-même ou sous un de ses descendants.');
        }
    }

    private function nextPosition(int $menuId, int $parentId): int
    {
        $last = MenuItemQuery::create()
            ->filterByMenuId($menuId)
            ->filterByMenuParent($parentId)
            ->orderByPosition(Criteria::DESC)
            ->findOne();

        return null === $last ? 1 : $last->getPosition() + 1;
    }

    private function swapWithSibling(MenuItem $item, bool $up): void
    {
        $query = MenuItemQuery::create()
            ->filterByMenuId($item->getMenuId())
            ->filterByMenuParent($item->getMenuParent())
            ->filterByPosition($item->getPosition(), $up ? Criteria::LESS_THAN : Criteria::GREATER_THAN)
            ->orderByPosition($up ? Criteria::DESC : Criteria::ASC);
        $sibling = $query->findOne();
        if (null === $sibling) {
            return;
        }
        $position = $item->getPosition();
        $item->setPosition($sibling->getPosition())->save();
        $sibling->setPosition($position)->save();
    }

    private function indent(MenuItem $item): void
    {
        $previous = MenuItemQuery::create()
            ->filterByMenuId($item->getMenuId())
            ->filterByMenuParent($item->getMenuParent())
            ->filterByPosition($item->getPosition(), Criteria::LESS_THAN)
            ->orderByPosition(Criteria::DESC)
            ->findOne();
        if (null === $previous) {
            return;
        }
        $oldParent = (int) $item->getMenuParent();
        $item->setMenuParent($previous->getId())->setPosition($this->nextPosition($item->getMenuId(), $previous->getId()))->save();
        $this->normalizeSiblings($item->getMenuId(), $oldParent);
    }

    private function outdent(MenuItem $item): void
    {
        if (0 === (int) $item->getMenuParent()) {
            return;
        }
        $parent = MenuItemQuery::create()->findPk($item->getMenuParent());
        if (null === $parent) {
            $item->setMenuParent(0)->setPosition($this->nextPosition($item->getMenuId(), 0))->save();
            return;
        }
        $oldParent = $parent->getId();
        $newParent = (int) $parent->getMenuParent();
        $item->setMenuParent($newParent)->setPosition($this->nextPosition($item->getMenuId(), $newParent))->save();
        $this->normalizeSiblings($item->getMenuId(), $oldParent);
        $this->normalizeSiblings($item->getMenuId(), $newParent);
    }

    private function normalizeMenus(): void
    {
        $position = 0;
        foreach (MenuQuery::create()->orderByPosition()->find() as $menu) {
            $menu->setPosition(++$position)->save();
        }
    }

    private function normalizeSiblings(int $menuId, int $parentId): void
    {
        $position = 0;
        foreach (MenuItemQuery::create()->filterByMenuId($menuId)->filterByMenuParent($parentId)->orderByPosition()->find() as $item) {
            $item->setPosition(++$position)->save();
        }
    }

    private function refreshSubmenuFlags(int $menuId): void
    {
        $items = MenuItemQuery::create()->filterByMenuId($menuId)->find();
        $parents = [];
        foreach ($items as $item) {
            if ($item->getMenuParent() > 0) {
                $parents[$item->getMenuParent()] = true;
            }
        }
        foreach ($items as $item) {
            $hasChildren = isset($parents[$item->getId()]);
            if ((bool) $item->getSousmenu() !== $hasChildren) {
                $item->setSousmenu((int) $hasChildren)->save();
            }
        }
    }

    /** @return list<int> */
    private function descendantIds(int $itemId): array
    {
        $children = MenuItemQuery::create()->filterByMenuParent($itemId)->find();
        $ids = [];
        foreach ($children as $child) {
            $ids[] = $child->getId();
            array_push($ids, ...$this->descendantIds($child->getId()));
        }

        return $ids;
    }

    private function deleteBranch(int $itemId): void
    {
        foreach (MenuItemQuery::create()->filterByMenuParent($itemId)->find() as $child) {
            $this->deleteBranch($child->getId());
        }
        MenuItemQuery::create()->filterById($itemId)->delete();
    }
}

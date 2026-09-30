<?php

declare(strict_types=1);

namespace Menu\Controller\Admin;

use Menu\Form\MenuForm;
use Menu\Form\MenuItemForm;
use Menu\Model\Menu;
use Menu\Model\MenuItem;
use Menu\Model\MenuItemQuery;
use Menu\Model\MenuQuery;
use Menu\Service\DestinationBrowser;
use Menu\Service\MenuManager;
use Menu\Service\MenuTargetResolver;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Thelia\Controller\Admin\BaseAdminController;
use Thelia\Core\Security\AccessManager;
use Thelia\Core\Security\Resource\AdminResources;

#[Route('/admin/module/Menu', name: 'menu_admin_')]
final class MenuController extends BaseAdminController
{
    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request, MenuManager $manager, MenuTargetResolver $targets): Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::VIEW)) {
            return $response;
        }

        $locale = $this->getCurrentEditionLocale() ?? 'fr_FR';
        $menus = MenuQuery::create()->orderByPosition()->find();
        $selected = $this->selectedMenu($request, $menus->getFirst());
        $editingMenu = $this->menuFromId($request->query->getInt('edit_menu'));
        $editingItem = $this->itemFromId($request->query->getInt('edit_item'), $selected);

        $menuForm = $this->createForm(MenuForm::class, FormType::class, $this->menuData($editingMenu, $locale));
        $itemForm = $this->createForm(MenuItemForm::class, FormType::class, $this->itemData($editingItem, $locale));
        $quickTargets = $targets->quickChoices($locale);
        $selectedTarget = null === $editingItem ? '4:0' : $editingItem->getTypobj().':'.$editingItem->getObjet();

        $menuRows = [];
        foreach ($menus as $menu) {
            $menu->setLocale($locale);
            $menuRows[] = [
                'id' => $menu->getId(),
                'title' => $menu->getTitle(),
                'description' => $menu->getDescription(),
                'visible' => (bool) $menu->getVisible(),
                'count' => MenuItemQuery::create()->filterByMenuId($menu->getId())->count(),
            ];
        }

        return $this->render('Menu/index', [
            'menus' => $menuRows,
            'selected_menu' => $selected ? $this->menuDataForView($selected, $locale) : null,
            'menu_tree' => $selected ? $manager->tree($selected->getId(), $locale) : [],
            'parent_choices' => $selected ? $manager->parentChoices($selected->getId(), $locale, $editingItem) : [],
            'quick_targets' => $quickTargets,
            'selected_target' => $selectedTarget,
            'selected_target_label' => $targets->targetLabel($selectedTarget, $locale),
            'editing_menu' => $editingMenu,
            'editing_item' => $editingItem,
            'menu_form' => $menuForm->getForm()->createView(),
            'item_form' => $itemForm->getForm()->createView(),
        ]);
    }

    #[Route('/destinations', name: 'destinations', methods: ['GET'])]
    public function destinations(Request $request, DestinationBrowser $browser): JsonResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::VIEW)) {
            return $response;
        }

        try {
            return new JsonResponse($browser->browse(
                (string) $request->query->get('section', 'catalog'),
                max(0, $request->query->getInt('parent')),
                mb_substr((string) $request->query->get('q', ''), 0, 100),
                $this->getCurrentEditionLocale() ?? 'fr_FR',
            ));
        } catch (\InvalidArgumentException $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(MenuManager $manager): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::CREATE)) {
            return $response;
        }
        $form = $this->createForm(MenuForm::class);
        try {
            $menu = $manager->createMenu($this->validateForm($form)->getData(), $this->getCurrentEditionLocale());
            $this->addFlash('success', 'Le menu a été créé.');

            return $this->redirectToRoute('menu_admin_index', ['menu' => $menu->getId()]);
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->generateErrorRedirect($form);
        }
    }

    #[Route('/{id}/update', name: 'update', methods: ['POST'], requirements: ['id' => '\\d+'])]
    public function update(int $id, MenuManager $manager): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::UPDATE)) {
            return $response;
        }
        $menu = $this->requireMenu($id);
        $form = $this->createForm(MenuForm::class);
        try {
            $manager->updateMenu($menu, $this->validateForm($form)->getData(), $this->getCurrentEditionLocale());
            $this->addFlash('success', 'Le menu a été mis à jour.');

            return $this->generateSuccessRedirect($form);
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->generateErrorRedirect($form);
        }
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'], requirements: ['id' => '\\d+'])]
    public function delete(int $id, Request $request, MenuManager $manager, CsrfTokenManagerInterface $csrf): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::DELETE)) {
            return $response;
        }
        $this->validateToken($csrf, 'delete-menu-'.$id, (string) $request->request->get('_token'));
        $manager->deleteMenu($this->requireMenu($id));
        $this->addFlash('success', 'Le menu et ses éléments ont été supprimés.');

        return $this->redirectToRoute('menu_admin_index');
    }

    #[Route('/{menuId}/items/create', name: 'item_create', methods: ['POST'], requirements: ['menuId' => '\\d+'])]
    public function createItem(int $menuId, MenuManager $manager): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::CREATE)) {
            return $response;
        }
        $form = $this->createForm(MenuItemForm::class);
        try {
            $manager->createItem($this->requireMenu($menuId), $this->validateForm($form)->getData(), $this->getCurrentEditionLocale());
            $this->addFlash('success', 'L’élément a été ajouté.');

            return $this->generateSuccessRedirect($form);
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->generateErrorRedirect($form);
        }
    }

    #[Route('/{menuId}/items/{id}/update', name: 'item_update', methods: ['POST'], requirements: ['menuId' => '\\d+', 'id' => '\\d+'])]
    public function updateItem(int $menuId, int $id, MenuManager $manager): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::UPDATE)) {
            return $response;
        }
        $form = $this->createForm(MenuItemForm::class);
        try {
            $manager->updateItem($this->requireItem($id, $menuId), $this->validateForm($form)->getData(), $this->getCurrentEditionLocale());
            $this->addFlash('success', 'L’élément a été mis à jour.');

            return $this->generateSuccessRedirect($form);
        } catch (\Throwable $exception) {
            $this->addFlash('danger', $exception->getMessage());

            return $this->generateErrorRedirect($form);
        }
    }

    #[Route('/{menuId}/items/{id}/move/{direction}', name: 'item_move', methods: ['POST'], requirements: ['menuId' => '\\d+', 'id' => '\\d+', 'direction' => 'up|down|indent|outdent'])]
    public function moveItem(int $menuId, int $id, string $direction, Request $request, MenuManager $manager, CsrfTokenManagerInterface $csrf): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::UPDATE)) {
            return $response;
        }
        $this->validateToken($csrf, 'move-item-'.$id, (string) $request->request->get('_token'));
        $manager->move($this->requireItem($id, $menuId), $direction);

        return $this->redirectToRoute('menu_admin_index', ['menu' => $menuId]);
    }

    #[Route('/{menuId}/items/{id}/delete', name: 'item_delete', methods: ['POST'], requirements: ['menuId' => '\\d+', 'id' => '\\d+'])]
    public function deleteItem(int $menuId, int $id, Request $request, MenuManager $manager, CsrfTokenManagerInterface $csrf): RedirectResponse|Response
    {
        if (null !== $response = $this->checkAuth([AdminResources::MODULE], ['Menu'], AccessManager::DELETE)) {
            return $response;
        }
        $this->validateToken($csrf, 'delete-item-'.$id, (string) $request->request->get('_token'));
        $manager->deleteItem($this->requireItem($id, $menuId));
        $this->addFlash('success', 'L’élément et ses sous-éléments ont été supprimés.');

        return $this->redirectToRoute('menu_admin_index', ['menu' => $menuId]);
    }

    private function selectedMenu(Request $request, ?Menu $fallback): ?Menu
    {
        $id = $request->query->getInt('menu');

        return $id > 0 ? ($this->menuFromId($id) ?? $fallback) : $fallback;
    }

    private function menuFromId(int $id): ?Menu
    {
        return $id > 0 ? MenuQuery::create()->findPk($id) : null;
    }

    private function itemFromId(int $id, ?Menu $menu): ?MenuItem
    {
        if ($id < 1 || null === $menu) {
            return null;
        }
        $item = MenuItemQuery::create()->findPk($id);

        return null !== $item && $item->getMenuId() === $menu->getId() ? $item : null;
    }

    private function requireMenu(int $id): Menu
    {
        return $this->menuFromId($id) ?? throw $this->createNotFoundException('Menu introuvable.');
    }

    private function requireItem(int $id, int $menuId): MenuItem
    {
        $item = MenuItemQuery::create()->findPk($id);
        if (null === $item || $item->getMenuId() !== $menuId) {
            throw $this->createNotFoundException('Élément de menu introuvable.');
        }

        return $item;
    }

    /** @return array<string, mixed> */
    private function menuData(?Menu $menu, string $locale): array
    {
        if (null === $menu) {
            return ['visible' => true];
        }
        $menu->setLocale($locale);

        return ['title' => $menu->getTitle(), 'description' => $menu->getDescription(), 'visible' => (bool) $menu->getVisible()];
    }

    /** @return array<string, mixed> */
    private function menuDataForView(Menu $menu, string $locale): array
    {
        $menu->setLocale($locale);

        return ['id' => $menu->getId(), 'title' => $menu->getTitle(), 'description' => $menu->getDescription(), 'visible' => (bool) $menu->getVisible()];
    }

    /** @return array<string, mixed> */
    private function itemData(?MenuItem $item, string $locale): array
    {
        if (null === $item) {
            return ['target' => '4:0', 'parent_id' => 0, 'visible' => true];
        }
        $item->setLocale($locale);

        return [
            'target' => $item->getTypobj().':'.$item->getObjet(),
            'parent_id' => $item->getMenuParent(),
            'title' => $item->getTitle(),
            'url' => $item->getUrl(),
            'chapo' => $item->getChapo(),
            'css_class' => $item->getCssclass(),
            'icon' => $item->getIcone(),
            'target_blank' => (bool) $item->getTargetblank(),
            'visible' => (bool) $item->getVisible(),
        ];
    }

    private function validateToken(CsrfTokenManagerInterface $manager, string $id, string $value): void
    {
        if (!$manager->isTokenValid(new CsrfToken($id, $value))) {
            throw $this->createAccessDeniedException('Jeton de sécurité invalide.');
        }
    }
}

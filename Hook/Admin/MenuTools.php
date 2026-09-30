<?php

declare(strict_types=1);

namespace Menu\Hook\Admin;

use Menu\Menu;
use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

final class MenuTools extends BaseHook
{
    public static function getSubscribedHooks(): array
    {
        return [
            'main.top-menu-tools' => [
                ['type' => 'back', 'method' => 'onMainTopMenuTools'],
            ],
        ];
    }

    public function onMainTopMenuTools(HookRenderBlockEvent $event): void
    {
        $event->add([
            'id' => 'tools_menu_manager',
            'class' => '',
            'url' => URL::getInstance()?->absoluteUrl('/admin/module/Menu'),
            'title' => $this->trans('Menus', [], Menu::DOMAIN_NAME),
        ]);
    }
}

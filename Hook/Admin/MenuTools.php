<?php

namespace Menu\Hook\Admin;

use Thelia\Core\Event\Hook\HookRenderBlockEvent;
use Thelia\Core\Hook\BaseHook;
use Thelia\Tools\URL;

class MenuTools extends BaseHook {
    public function onMainTopMenuToolsContents(HookRenderBlockEvent $event)
    {
		$event->add(array(
			"id" => "menuTools",
			"class" => '',
			"url" => URL::getInstance()->absoluteUrl('/admin/modules/menu/gestion'),
			"title" => $this->trans("Menu")
		));		
    }
}
?>
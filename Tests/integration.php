<?php

declare(strict_types=1);

use Menu\Service\MenuManager;
use Menu\Service\MenuTargetResolver;
use Menu\Service\DestinationBrowser;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Propel\Runtime\Connection\ConnectionWrapper;
use Propel\Runtime\Propel;

$root = dirname(__DIR__, 4);
$loader = require $root.'/vendor/autoload.php';
$loader->addPsr4('', $root.'/var/propel/dev/model', true);

$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('TheliaMain', 'mysql');
$connectionManager = new ConnectionManagerSingle('TheliaMain');
$connectionManager->setConfiguration([
    'dsn' => 'mysql:host=database;dbname=thelia;port=3306;charset=utf8mb4',
    'user' => 'thelia',
    'password' => 'thelia-local-only',
    'classname' => ConnectionWrapper::class,
]);
$serviceContainer->setConnectionManager($connectionManager);
require $root.'/generated-conf/loadDatabase.php';

$connection = Propel::getWriteConnection('TheliaMain');
$connection->beginTransaction();

try {
    $manager = new MenuManager(new MenuTargetResolver());
    $menu = $manager->createMenu([
        'title' => 'Test transactionnel Menu',
        'description' => 'Cette donnée sera annulée.',
        'visible' => true,
    ], 'fr_FR');
    echo "menu_ok\n";
    $parent = $manager->createItem($menu, [
        'target' => '4:0',
        'parent_id' => 0,
        'title' => 'Entrée principale',
        'url' => '/test-parent',
        'visible' => true,
    ], 'fr_FR');
    echo "parent_ok\n";
    $manager->createItem($menu, [
        'target' => '4:0',
        'parent_id' => $parent->getId(),
        'title' => 'Sous-élément',
        'url' => '/test-child',
        'visible' => true,
    ], 'fr_FR');
    echo "child_ok\n";

    $tree = $manager->tree($menu->getId(), 'fr_FR');
    if (1 !== count($tree) || 1 !== count($tree[0]['children'])) {
        throw new RuntimeException('La hiérarchie créée ne correspond pas à la hiérarchie relue.');
    }
    if ('Entrée principale' !== $tree[0]['title'] || 'Sous-élément' !== $tree[0]['children'][0]['title']) {
        throw new RuntimeException('Les traductions des éléments ne sont pas correctement relues.');
    }

    $browser = new DestinationBrowser();
    foreach (['catalog', 'folder', 'brand', 'page'] as $section) {
        $result = $browser->browse($section, 0, '', 'fr_FR');
        if ($section !== $result['section'] || !array_key_exists('items', $result)) {
            throw new RuntimeException('L’explorateur de destinations ne répond pas pour la section '.$section.'.');
        }
        $searchResult = $browser->browse($section, 0, 'a', 'fr_FR');
        if ($section !== $searchResult['section'] || !array_key_exists('items', $searchResult)) {
            throw new RuntimeException('La recherche de destinations ne répond pas pour la section '.$section.'.');
        }
    }

    echo "menu_integration_ok\n";
} finally {
    $connection->rollBack();
}

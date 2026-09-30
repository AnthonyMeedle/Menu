<?php

declare(strict_types=1);

namespace Menu;

use Propel\Runtime\Connection\ConnectionInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ServicesConfigurator;
use Thelia\Core\Install\Database;
use Thelia\Module\BaseModule;

final class Menu extends BaseModule
{
    public const DOMAIN_NAME = 'menu';

    public function preActivation(?ConnectionInterface $con = null): bool
    {
        if (!$this->getConfigValue('schema_initialized', false)) {
            (new Database($con))->insertSql(null, [__DIR__.'/Config/TheliaMain.sql']);
            $this->setConfigValue('schema_initialized', true);
        }

        return true;
    }

    public static function configureServices(ServicesConfigurator $services): void
    {
        $services->load(self::getModuleCode().'\\', __DIR__)
            ->exclude([
                __DIR__.'/Config',
                __DIR__.'/I18n',
                __DIR__.'/Model',
                __DIR__.'/Tests',
                __DIR__.'/Menu.php',
            ])
            ->autowire(true)
            ->autoconfigure(true);
    }
}

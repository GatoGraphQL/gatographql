<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\MenuPageAttachers;

use GraphQLAPI\GraphQLAPI\Services\Menus\MenuInterface;
use GraphQLAPI\GraphQLAPI\Services\Menus\PluginMenu;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Admin menu class
 */
abstract class AbstractPluginMenuPageAttacher extends AbstractMenuPageAttacher
{
    private ?PluginMenu $pluginMenu = null;

    public function setPluginMenu(PluginMenu $pluginMenu): void
    {
        $this->pluginMenu = $pluginMenu;
    }
    protected function getPluginMenu(): PluginMenu
    {
        return $this->pluginMenu ??= $this->getInstanceManager()->getInstance(PluginMenu::class);
    }

    public function getMenu(): MenuInterface
    {
        return $this->getPluginMenu();
    }
}

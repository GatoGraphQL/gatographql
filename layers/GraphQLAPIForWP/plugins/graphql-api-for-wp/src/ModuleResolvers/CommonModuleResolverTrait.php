<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ModuleResolvers;

use GraphQLAPI\GraphQLAPI\Constants\HTMLCodes;
use GraphQLAPI\GraphQLAPI\Constants\RequestParams;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphQLVoyagerMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphiQLMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\RecipesMenuPage;
use PoP\Root\Facades\Instances\InstanceManagerFacade;

trait CommonModuleResolverTrait
{
    protected function getDefaultValueLabel(): string
    {
        return \__('Default value for the Schema Configuration', 'graphql-api');
    }

    protected function getDefaultValueDescription(): string
    {
        return \__('This value will be used when option <code>"Default"</code> is selected in the Schema Configuration. (i.e. it concerns only public endpoints: the single endpoint, custom endpoints, and persisted queries.)', 'graphql-api');
    }

    protected function getAdminClientDescription(): string
    {
        return sprintf(
            \__('It will be reflected in the admin\'s <a href="%1$s" target="_blank">GraphiQL%4$s</a> and <a href="%2$s" target="_blank">Interactive Schema%4$s</a> clients. (And also as the default value on <a href="%3$s" target="_blank">custom private endpoints%4$s</a>.)', 'graphql-api'),
            \admin_url(sprintf(
                'admin.php?page=%s',
                $this->getGraphiQLMenuPage()->getScreenID()
            )),
            \admin_url(sprintf(
                'admin.php?page=%s',
                $this->getGraphQLVoyagerMenuPage()->getScreenID()
            )),
            \admin_url(sprintf(
                'admin.php?page=%s&%s=%s',
                $this->getRecipesMenuPage()->getScreenID(),
                RequestParams::TAB,
                'defining-custom-private-endpoints'
            )),
            HTMLCodes::OPEN_IN_NEW_WINDOW
        );
    }

    protected function getGraphiQLMenuPage(): GraphiQLMenuPage
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        /** @var GraphiQLMenuPage */
        return $instanceManager->getInstance(GraphiQLMenuPage::class);
    }

    protected function getGraphQLVoyagerMenuPage(): GraphQLVoyagerMenuPage
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        /** @var GraphQLVoyagerMenuPage */
        return $instanceManager->getInstance(GraphQLVoyagerMenuPage::class);
    }

    protected function getRecipesMenuPage(): RecipesMenuPage
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        /** @var RecipesMenuPage */
        return $instanceManager->getInstance(RecipesMenuPage::class);
    }
}

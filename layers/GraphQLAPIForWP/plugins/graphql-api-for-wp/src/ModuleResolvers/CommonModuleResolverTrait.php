<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\ModuleResolvers;

use GraphQLAPI\GraphQLAPI\Constants\HTMLCodes;
use GraphQLAPI\GraphQLAPI\Constants\RequestParams;
use GraphQLAPI\GraphQLAPI\Services\Helpers\EndpointHelpers;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphQLVoyagerMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\GraphiQLMenuPage;
use GraphQLAPI\GraphQLAPI\Services\MenuPages\RecipesMenuPage;
use PoP\ComponentModel\Misc\GeneralUtils;
use PoP\Root\Facades\Instances\InstanceManagerFacade;

trait CommonModuleResolverTrait
{
    /**
     * @param string[]|null $applicableItems
     */
    protected function getDefaultValueDescription(
        string $blockTitle,
        ?array $applicableItems = null
    ): string {
        $applicableItems ??= $this->getDefaultValueApplicableItems($blockTitle);
        return $this->getSettingsInfoContent(
            sprintf(
                \__('%s %s', 'graphql-api'),
                \__('This is the default value for the schema configuration.', 'graphql-api'),
                $this->getCollapsible(
                    sprintf(
                        '<br/>%s<ul><li>%s</li></ul>',
                        \__('It will be used whenever:', 'graphql-api'),
                        implode(
                            '</li><li>',
                            $applicableItems
                        )
                    ),
                )
            )
        );
    }

    /**
     * @return string[]
     */
    protected function getDefaultValueApplicableItems(string $blockTitle): array
    {
        return [
            \__('The endpoint does not have a Schema Configuration assigned to it', 'graphql-api'),
            \__('The endpoint has Schema Configuration <code>"None"</code> assigned to it', 'graphql-api'),
            sprintf(
                \__('Block <code>%s</code> has not been added to the selected Schema Configuration', 'graphql-api'),
                $blockTitle
            ),
            \__('The block in the Schema Configuration has value <code>"Default"</code>', 'graphql-api')
        ];
    }

    protected function getPressCtrlToSelectMoreThanOneOptionLabel(): string
    {
        return \__('Press <code>ctrl</code> or <code>shift</code> keys to select more than one.', 'graphql-api');
    }

    protected function getCollapsible(
        string $content,
        ?string $showDetailsLabel = null,
    ): string {
        return sprintf(
            '<a href="#" type="button" class="collapsible">%s</a><span class="collapsible-content">%s</span>',
            $showDetailsLabel ?? \__('Show details', 'graphql-api'),
            $content
        );
    }

    // protected function getPrivateEndpointsListDescription(): string
    // {
    //     return sprintf(
    //         \__('<ul><li>Endpoint <code>%1$s</code> (which powers the admin\'s <a href="%2$s" target="_blank">GraphiQL%5$s</a> and <a href="%3$s" target="_blank">Interactive Schema%5$s</a> clients, and can be invoked in the WordPress editor to feed data to blocks)</li><li><a href="%4$s" target="_blank">Custom private endpoints%5$s</a> (also used to feed data to blocks, but allowing to lock its configuration via PHP hooks)</li><li>GraphQL queries executed internally (via class <code>%6$s</code> in PHP)</li></ul>', 'graphql-api'),
    //         ltrim(
    //             GeneralUtils::removeDomain($this->getEndpointHelpers()->getAdminGraphQLEndpoint()),
    //             '/'
    //         ),
    //         \admin_url(sprintf(
    //             'admin.php?page=%s',
    //             $this->getGraphiQLMenuPage()->getScreenID()
    //         )),
    //         \admin_url(sprintf(
    //             'admin.php?page=%s',
    //             $this->getGraphQLVoyagerMenuPage()->getScreenID()
    //         )),
    //         \admin_url(sprintf(
    //             'admin.php?page=%s&%s=%s',
    //             $this->getRecipesMenuPage()->getScreenID(),
    //             RequestParams::TAB,
    //             'defining-custom-private-endpoints'
    //         )),
    //         HTMLCodes::OPEN_IN_NEW_WINDOW,
    //         'GraphQLServer'
    //     );
    // }

    protected function getSettingsInfoContent(string $content): string
    {
        return sprintf(
            '<span class="settings-info">%s</span>',
            $content
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

    // protected function getRecipesMenuPage(): RecipesMenuPage
    // {
    //     $instanceManager = InstanceManagerFacade::getInstance();
    //     /** @var RecipesMenuPage */
    //     return $instanceManager->getInstance(RecipesMenuPage::class);
    // }

    protected function getEndpointHelpers(): EndpointHelpers
    {
        $instanceManager = InstanceManagerFacade::getInstance();
        /** @var EndpointHelpers */
        return $instanceManager->getInstance(EndpointHelpers::class);
    }
}

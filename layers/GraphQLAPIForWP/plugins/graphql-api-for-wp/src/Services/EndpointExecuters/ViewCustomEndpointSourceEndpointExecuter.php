<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\EndpointExecuters;

use GraphQLAPI\GraphQLAPI\ModuleResolvers\EndpointFunctionalityModuleResolver;
use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLCustomEndpointCustomPostType;
use GraphQLAPI\GraphQLAPI\Services\CustomPostTypes\GraphQLEndpointCustomPostTypeInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ViewCustomEndpointSourceEndpointExecuter extends AbstractViewSourceEndpointExecuter implements CustomEndpointExecuterServiceTagInterface
{
    protected GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType;

    #[Required]
    final public function autowireViewCustomEndpointSourceEndpointExecuter(
        GraphQLCustomEndpointCustomPostType $graphQLCustomEndpointCustomPostType,
    ): void {
        $this->graphQLCustomEndpointCustomPostType = $graphQLCustomEndpointCustomPostType;
    }

    public function getEnablingModule(): ?string
    {
        return EndpointFunctionalityModuleResolver::CUSTOM_ENDPOINTS;
    }

    protected function getCustomPostType(): GraphQLEndpointCustomPostTypeInterface
    {
        return $this->graphQLCustomEndpointCustomPostType;
    }
}

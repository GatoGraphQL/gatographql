<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Registries;

use GraphQLAPI\GraphQLAPI\Security\UserAuthorizationSchemes\DefaultUserAuthorizationSchemeTagInterface;
use GraphQLAPI\GraphQLAPI\Security\UserAuthorizationSchemes\UserAuthorizationSchemeInterface;
use InvalidArgumentException;

class UserAuthorizationSchemeRegistry implements UserAuthorizationSchemeRegistryInterface
{
    /**
     * @var array<string,string>
     */
    protected array $schemaEditorAccessCapabilities = [];
    /**
     * @var UserAuthorizationSchemeInterface[]
     */
    protected array $userAuthorizationSchemes = [];
    protected ?UserAuthorizationSchemeInterface $defaultUserAuthorizationScheme = null;

    public function addUserAuthorizationScheme(
        UserAuthorizationSchemeInterface $userAuthorizationScheme
    ): void {
        $this->schemaEditorAccessCapabilities[$userAuthorizationScheme->getName()] = $userAuthorizationScheme->getSchemaEditorAccessCapability();
        if ($userAuthorizationScheme instanceof DefaultUserAuthorizationSchemeTagInterface) {
            $this->defaultUserAuthorizationScheme = $userAuthorizationScheme;
            // Place the default one at the top
            array_unshift($this->userAuthorizationSchemes, $userAuthorizationScheme);
        } else {
            // Place at the end
            $this->userAuthorizationSchemes[] = $userAuthorizationScheme;
        }
    }

    /**
     * @return UserAuthorizationSchemeInterface[]
     */
    public function getUserAuthorizationSchemes(): array
    {
        return $this->userAuthorizationSchemes;
    }
    
    /**
     * @throws InvalidArgumentException When the scheme is not registered
     */
    public function getSchemaEditorAccessCapability(string $userAuthorizationSchemeName): string
    {
        if (!isset($this->schemaEditorAccessCapabilities[$userAuthorizationSchemeName])) {
            throw new InvalidArgumentException(sprintf(
                \__('User authorization scheme \'%s\' does not exist', 'graphql-api'),
                $userAuthorizationSchemeName
            ));
        }
        return $this->schemaEditorAccessCapabilities[$userAuthorizationSchemeName];
    }

    public function getDefaultUserAuthorizationScheme(): UserAuthorizationSchemeInterface
    {
        if ($this->defaultUserAuthorizationScheme === null) {
            throw new InvalidArgumentException(
                \__('No default User Authorization Scheme has been set', 'graphql-api')
            );
        }
        return $this->defaultUserAuthorizationScheme;
    }
}

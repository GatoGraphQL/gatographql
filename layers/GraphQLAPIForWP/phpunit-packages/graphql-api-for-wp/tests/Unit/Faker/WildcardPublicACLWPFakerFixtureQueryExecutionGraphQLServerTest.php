<?php

declare(strict_types=1);

namespace PHPUnitForGraphQLAPI\GraphQLAPI\Unit\Faker;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

class WildcardPublicACLWPFakerFixtureQueryExecutionGraphQLServerTest extends AbstractWildcardACLWPFakerFixtureQueryExecutionGraphQLServerTest
{
    /**
     * @return class-string<CompilerPassInterface>|null
     */
    protected static function getWildcardCompilerPassClass(): ?string
    {
        return \PHPUnitForGraphQLAPI\GraphQLAPI\Unit\Faker\Container\CompilerPasses\WildcardPublicACLConfigureAccessControlCompilerPass::class;
    }
}

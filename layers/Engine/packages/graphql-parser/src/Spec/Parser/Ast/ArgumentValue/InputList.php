<?php

declare(strict_types=1);

namespace PoP\GraphQLParser\Spec\Parser\Ast\ArgumentValue;

use PoP\GraphQLParser\Exception\Parser\InvalidDynamicContextException;
use PoP\GraphQLParser\Spec\Parser\Ast\AbstractAst;
use PoP\GraphQLParser\Spec\Parser\Ast\Argument;
use PoP\GraphQLParser\Spec\Parser\Ast\WithAstValueInterface;
use PoP\GraphQLParser\Spec\Parser\Ast\WithValueInterface;
use PoP\GraphQLParser\Spec\Parser\Location;
use PoP\Root\Environment as RootEnvironment;

class InputList extends AbstractAst implements CoercibleArgumentValueAstInterface, WithAstValueInterface
{
    protected InputList|InputObject|Argument $parent;

    /** @var mixed[] */
    protected ?array $cachedValue = null;

    /**
     * @param mixed[] $list Elements inside can be WithValueInterface or native types (array, int, string, etc)
     */
    public function __construct(
        protected array $list,
        Location $location,
    ) {
        parent::__construct($location);
    }

    protected function doAsQueryString(): string
    {
        return $this->getGraphQLQueryStringFormatter()->getListAsQueryString($this->list);
    }

    public function setParent(InputList|InputObject|Argument $parent): void
    {
        $this->parent = $parent;
    }

    public function getParent(): InputList|InputObject|Argument
    {
        return $this->parent;
    }

    /**
     * Transform from Ast to actual value.
     * Eg: replace VariableReferences with their value,
     * nested InputObjects with stdClass, etc
     *
     * @return mixed[]
     * @throws InvalidDynamicContextException When accessing non-declared Dynamic Variables
     */
    final public function getValue(): mixed
    {
        /**
         * Caching results makes PHPUnit tests fail
         * (those asserting the Document was parsed appropriately)
         */
        if (RootEnvironment::isApplicationEnvironmentDevPHPUnit()) {
            return $this->doGetValue();
        }

        if ($this->cachedValue === null) {
            $this->cachedValue = $this->doGetValue();
        }
        return $this->cachedValue;
    }

    /**
     * @return mixed[]
     * @throws InvalidDynamicContextException When accessing non-declared Dynamic Variables
     */
    public function doGetValue(): array
    {
        $list = [];
        foreach ($this->list as $key => $value) {
            if ($value instanceof WithValueInterface) {
                $list[$key] = $value->getValue();
                continue;
            }
            $list[$key] = $value;
        }
        return $list;
    }

    /**
     * @param array<mixed> $list
     */
    public function setValue(mixed $list): void
    {
        $this->cachedValue = null;
        $this->list = $list;
    }

    /**
     * @return mixed[]
     */
    public function getAstValue(): mixed
    {
        return $this->list;
    }
}

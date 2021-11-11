<?php

declare(strict_types=1);

namespace PoP\ComponentModel\TypeResolvers\InputObjectType;

use PoP\ComponentModel\FilterInputProcessors\FilterInputProcessorInterface;
use PoP\ComponentModel\FilterInputProcessors\FilterInputProcessorManagerInterface;
use stdClass;

abstract class AbstractQueryableInputObjectTypeResolver extends AbstractInputObjectTypeResolver implements QueryableInputObjectTypeResolverInterface
{
    private ?FilterInputProcessorManagerInterface $filterInputProcessorManager = null;

    final public function setFilterInputProcessorManager(FilterInputProcessorManagerInterface $filterInputProcessorManager): void
    {
        $this->filterInputProcessorManager = $filterInputProcessorManager;
    }
    final protected function getFilterInputProcessorManager(): FilterInputProcessorManagerInterface
    {
        return $this->filterInputProcessorManager ??= $this->instanceManager->getInstance(FilterInputProcessorManagerInterface::class);
    }
    
    public function getInputFieldFilterInput(string $inputFieldName): ?array
    {
        return null;
    }
    /**
     * If the input field is an InputObject, then forward the logic.
     * Otherwise, if the input field defines a FilterInput,
     * apply it to obtain the filtering query
     *
     * @param array<string, mixed> $query
     */
    final public function integrateInputValueToFilteringQueryArgs(array &$query, stdClass $inputValue): void
    {
        foreach ((array)$inputValue as $inputFieldName => $inputFieldValue) {
            $this->integrateInputFieldValueToFilteringQueryArgs($inputFieldName, $query, $inputFieldValue);
        }
    }
    /**
     * Integrate an InputObject into the filtering args.
     * 
     * By default, forward the logic to its contained input fields
     */
    protected function integrateInputFieldValueToFilteringQueryArgs(string $inputFieldName, array &$query, mixed $inputFieldValue): void
    {
        /**
         * If the input field defines a FilterInput, apply it to obtain the filtering query
         */
        if ($filterInput = $this->getInputFieldFilterInput($inputFieldName)) {
            /** @var FilterInputProcessorInterface */
            $filterInputProcessor = $this->getFilterInputProcessorManager()->getProcessor($filterInput);
            $filterInputProcessor->filterDataloadQueryArgs($filterInput, $query, $inputFieldValue);
            return;
        }
        
        /**
         * If the input field is an InputObject, recursively apply this function
         */
        $inputFieldNameTypeResolvers = $this->getConsolidatedInputFieldNameTypeResolvers();
        $inputFieldTypeResolver = $inputFieldNameTypeResolvers[$inputFieldName];
        if ($inputFieldTypeResolver instanceof QueryableInputObjectTypeResolverInterface) {
            $inputFieldTypeResolver->integrateInputValueToFilteringQueryArgs($query, $inputFieldValue);
        }
    }
}

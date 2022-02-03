<?php

declare(strict_types=1);

namespace PoP\ComponentModel\Schema;

use PoP\ComponentModel\Feedback\Tokens;
use PoP\FieldQuery\FeedbackMessageStore as UpstreamFeedbackMessageStore;

class FeedbackMessageStore extends UpstreamFeedbackMessageStore implements FeedbackMessageStoreInterface
{
    /**
     * @var array[]
     */
    protected array $schemaWarnings = [];
    /**
     * @var array<string, array>
     */
    protected array $schemaErrors = [];
    /**
     * @var array<string, array>
     */
    protected array $objectWarnings = [];
    /**
     * @var array<string, array>
     */
    protected array $objectDeprecations = [];
    /**
     * @var string[]
     */
    protected array $logEntries = [];

    public function addObjectWarnings(array $objectWarnings): void
    {
        foreach ($objectWarnings as $objectID => $objectWarnings) {
            $this->objectWarnings[$objectID] = array_merge(
                $this->objectWarnings[$objectID] ?? [],
                $objectWarnings
            );
        }
    }
    public function addSchemaWarnings(array $schemaWarnings): void
    {
        $this->schemaWarnings = array_merge(
            $this->schemaWarnings,
            $schemaWarnings
        );
    }
    public function retrieveAndClearObjectWarnings(string | int $objectID): ?array
    {
        $objectWarnings = $this->objectWarnings[$objectID] ?? null;
        unset($this->objectWarnings[$objectID]);
        return $objectWarnings;
    }

    public function addSchemaError(string $dbKey, string $field, string $error): void
    {
        $this->schemaErrors[$dbKey][] = [
            Tokens::PATH => [$field],
            Tokens::MESSAGE => $error,
        ];
    }
    public function retrieveAndClearSchemaErrors(): array
    {
        $schemaErrors = $this->schemaErrors;
        $this->schemaErrors = [];
        return $schemaErrors;
    }
    public function retrieveAndClearSchemaWarnings(): array
    {
        $schemaWarnings = $this->schemaWarnings;
        $this->schemaWarnings = [];
        return $schemaWarnings;
    }
    public function getSchemaErrorsForField(string $dbKey, string $field): ?array
    {
        return $this->schemaErrors[$dbKey][$field] ?? null;
    }

    public function addLogEntry(string $entry): void
    {
        $this->logEntries[] = $entry;
    }

    public function maybeAddLogEntry(string $entry): void
    {
        if (!in_array($entry, $this->logEntries)) {
            $this->addLogEntry($entry);
        }
    }

    public function getLogEntries(): array
    {
        return $this->logEntries;
    }
}

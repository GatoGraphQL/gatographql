<?php

declare(strict_types=1);

namespace PoPCMSSchema\MediaMutations\FeedbackItemProviders;

use PoP\Root\FeedbackItemProviders\AbstractFeedbackItemProvider;
use PoP\ComponentModel\Feedback\FeedbackCategories;

class MutationErrorFeedbackItemProvider extends AbstractFeedbackItemProvider
{
    public final const E1 = 'e1';
    public final const E2 = 'e2';
    public final const E3 = 'e3';
    public final const E4 = 'e4';
    public final const E5 = 'e5';
    public final const E6 = 'e6';

    /**
     * @return string[]
     */
    public function getCodes(): array
    {
        return [
            self::E1,
            self::E2,
            self::E3,
            self::E4,
            self::E5,
            self::E6,
        ];
    }

    public function getMessagePlaceholder(string $code): string
    {
        return match ($code) {
            self::E1 => $this->__('You are not logged in', 'user-state-mutations'),
            self::E2 => $this->__('You don\'t have permission to upload files', 'media-mutations'),
            self::E3 => $this->__('There is no custom post with ID \'%s\'', 'media-mutations'),
            self::E4 => $this->__('The attachment source (URL/contents) is empty', 'media-mutations'),
            self::E5 => $this->__('You don\'t have permission to upload files for other users', 'media-mutations'),
            self::E6 => $this->__('There is no user with ID \'%s\'', 'media-mutations'),
            default => parent::getMessagePlaceholder($code),
        };
    }

    public function getCategory(string $code): string
    {
        return FeedbackCategories::ERROR;
    }
}

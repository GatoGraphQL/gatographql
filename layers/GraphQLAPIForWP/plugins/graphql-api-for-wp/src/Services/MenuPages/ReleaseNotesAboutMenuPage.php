<?php

declare(strict_types=1);

namespace GraphQLAPI\GraphQLAPI\Services\MenuPages;

use GraphQLAPI\GraphQLAPI\ContentProcessors\PluginMarkdownContentRetrieverTrait;
use Symfony\Contracts\Service\Attribute\Required;

/**
 * Release notes menu page
 */
class ReleaseNotesAboutMenuPage extends AbstractDocAboutMenuPage
{
    use PluginMarkdownContentRetrieverTrait;

    private ?AboutMenuPage $aboutMenuPage = null;

    public function setAboutMenuPage(AboutMenuPage $aboutMenuPage): void
    {
        $this->aboutMenuPage = $aboutMenuPage;
    }
    protected function getAboutMenuPage(): AboutMenuPage
    {
        return $this->aboutMenuPage ??= $this->getInstanceManager()->getInstance(AboutMenuPage::class);
    }

    public function getMenuPageSlug(): string
    {
        return $this->getAboutMenuPage()->getMenuPageSlug();
    }

    /**
     * Validate the param also
     */
    protected function isCurrentScreen(): bool
    {
        return $this->getMenuPageHelper()->isDocumentationScreen() && parent::isCurrentScreen();
    }

    protected function getRelativePathDir(): string
    {
        return 'release-notes';
    }
}

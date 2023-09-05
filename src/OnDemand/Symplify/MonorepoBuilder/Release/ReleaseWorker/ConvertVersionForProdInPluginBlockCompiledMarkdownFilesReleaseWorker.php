<?php

declare(strict_types=1);

namespace PoP\PoP\OnDemand\Symplify\MonorepoBuilder\Release\ReleaseWorker;

use PharIo\Version\Version;

/**
 * Point to GitHub's tagged image URLs in the compiled Markdown files
 */
final class ConvertVersionForProdInPluginBlockCompiledMarkdownFilesReleaseWorker extends AbstractConvertVersionInPluginBlockCompiledMarkdownFilesReleaseWorker
{
    public function work(Version $version): void
    {
        $prodVersion = $this->monorepoMetadataVersionUtils->getProdVersion();
        $replacements = [
            // Change the image src (pointing to GitHub) from master to the tag 
            '#' . preg_quote('https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/master/') . '#' => 'https://raw.githubusercontent.com/GatoGraphQL/GatoGraphQL/' . $prodVersion . '/',
        ];
        $this->fileContentReplacerSystem->replaceContentInFiles($this->pluginBlockCompiledMarkdownFiles, $replacements);
    }

    public function getDescription(Version $version): string
    {
        return 'Point to GitHub\'s tagged image URLs in the compiled Markdown files in all blocks';
    }
}

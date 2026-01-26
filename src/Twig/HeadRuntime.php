<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Twig;

use Dvc\ContaoTemplateSupportBundle\Utility\AssetUtility;
use Twig\Extension\RuntimeExtensionInterface;

class HeadRuntime implements RuntimeExtensionInterface
{
    public function addGlobalStylesheet(string $path): void
    {
        $GLOBALS['TL_CSS'][] = AssetUtility::getVersionedPath($path, AssetUtility::VERSION_PATH_DELIMITER_PIPE) . '|static';
    }

    public function addGlobalScript(string $path, array $options = []): void
    {
        $path = AssetUtility::getVersionedPath($path);
        $attributes = !empty($options) ? ' ' . \implode(' ', $options) : '';

        $GLOBALS['TL_HEAD'][] = \sprintf('<script src="%s"%s></script>', $path, $attributes);
    }

    public function addGlobalScriptTag(array $options = []): void
    {
        $attributes = !empty($options) ? ' ' . \implode(' ', $options) : '';

        $GLOBALS['TL_HEAD'][] = \sprintf('<script%s></script>', $attributes);
    }

    public function addGlobalScriptToFooter(string $path, array $options = []): void
    {
        $path = AssetUtility::getVersionedPath($path);
        $attributes = !empty($options) ? ' ' . \implode(' ', $options) : '';

        $GLOBALS['TL_BODY'][] = \sprintf('<script src="%s"%s></script>', $path, $attributes);
    }
}

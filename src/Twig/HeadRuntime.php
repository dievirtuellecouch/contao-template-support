<?php

namespace DVC\TemplateSupport\Twig;

use DVC\TemplateSupport\Utility\AssetUtility;
use Twig\Extension\RuntimeExtensionInterface;

class HeadRuntime implements RuntimeExtensionInterface
{
    public function addGlobalStylesheet(string $path): void
    {
        $GLOBALS['TL_CSS'][] = AssetUtility::getVersionedPath($path, AssetUtility::VERSION_PATH_DELIMITER_PIPE)  . '|static';
    }

    public function addGlobalScript(string $path, $options = []): void
    {
        $path = AssetUtility::getVersionedPath($path);
        $attributes = !empty($options) ? ' ' . \join(' ', $options) : '';

        $GLOBALS['TL_HEAD'][] = \sprintf('<script src="%s"%s></script>', $path, $attributes);
    }

    public function addGlobalScriptTag($options = []): void
    {
        $attributes = !empty($options) ? ' ' . \join(' ', $options) : '';

        $GLOBALS['TL_HEAD'][] = \sprintf('<script%s></script>', $attributes);
    }

    public function addGlobalScriptToFooter(string $path, $options = []): void
    {
        $path = AssetUtility::getVersionedPath($path);
        $attributes = !empty($options) ? ' ' . \join(' ', $options) : '';

        $GLOBALS['TL_BODY'][] = \sprintf('<script src="%s"%s></script>', $path, $attributes);
    }
}

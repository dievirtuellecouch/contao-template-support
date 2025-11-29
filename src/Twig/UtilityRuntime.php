<?php

namespace DVC\TemplateSupport\Twig;

use DVC\TemplateSupport\Utility\AssetUtility;
use Twig\Extension\RuntimeExtensionInterface;

class UtilityRuntime implements RuntimeExtensionInterface
{
    public function getVersionedPath(string $path): string
    {
        return AssetUtility::getVersionedPath($path);
    }

    public function unserialize(string $serializedString): mixed
    {
        return \unserialize($serializedString);
    }
}

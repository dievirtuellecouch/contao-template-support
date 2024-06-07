<?php

namespace DVC\TemplateSupport\Twig;

use Contao\FilesModel;
use DVC\TemplateSupport\Utility\AssetUtility;
use DVC\TemplateSupport\Utility\FilesUtility;
use Twig\Extension\RuntimeExtensionInterface;

class UtilityRuntime implements RuntimeExtensionInterface
{
    public function getFileByUuid(string $uuid): ?FilesModel
    {
        return FilesUtility::getFileByUuid($uuid);
    }

    public function getVersionedPath(string $path): string
    {
        return AssetUtility::getVersionedPath($path);
    }

    public function unserialize(string $serializedString): mixed
    {
        return \unserialize($serializedString);
    }
}

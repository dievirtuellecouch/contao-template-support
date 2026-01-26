<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Twig;

use Contao\FilesModel;
use Dvc\ContaoTemplateSupportBundle\Utility\AssetUtility;
use Dvc\ContaoTemplateSupportBundle\Utility\FilesUtility;
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

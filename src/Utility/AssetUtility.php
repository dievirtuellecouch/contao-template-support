<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Utility;

use Contao\System;

class AssetUtility
{
    public const VERSION_PATH_DELIMITER_QUERY = 'query';
    public const VERSION_PATH_DELIMITER_PIPE = 'pipe';

    /**
     * Returns the timestamp for the asset at given path.
     * @param string $src The path to the file.
     * @return int|null The timestamp or null if the file does not exist.
     */
    public static function getTimestampForAsset(string $src): ?int
    {
        $projectDir = self::getProjectDir();

        $mtime = null;

        if (file_exists($projectDir . '/' . $src)) {
            $mtime = filemtime($projectDir . '/' . $src);
        } else {
            $publicDir = self::getPublicDir();

            // Handle public bundle resources in public/
            if (file_exists($projectDir . '/' . $publicDir . '/' . $src)) {
                $mtime = filemtime($projectDir . '/' . $publicDir . '/' . $src);
            }
        }

        return $mtime;
    }

    /**
     * Returns the versioned path for given asset path.
     * @param string $src The path to the resource
     * @param string|null $delimiter The delimiter type
     * @return string The path with version parameter
     */
    public static function getVersionedPath(string $src, ?string $delimiter = self::VERSION_PATH_DELIMITER_QUERY): string
    {
        $timestamp = self::getTimestampForAsset($src);

        if ($timestamp === null) {
            return $src;
        }

        switch ($delimiter) {
            case self::VERSION_PATH_DELIMITER_QUERY:
                return \sprintf(
                    '%s?v=%s',
                    $src,
                    substr(md5((string) $timestamp), 0, 8)
                );

            case self::VERSION_PATH_DELIMITER_PIPE:
                return \sprintf(
                    '%s|%s',
                    $src,
                    $timestamp
                );

            default:
                return $src;
        }
    }

    private static function getPublicDir(): string
    {
        $container = System::getContainer();

        // Contao 5.3: use kernel.public_dir instead of contao.web_dir
        if ($container->hasParameter('kernel.public_dir')) {
            return basename($container->getParameter('kernel.public_dir'));
        }

        // Fallback for compatibility
        if ($container->hasParameter('contao.web_dir')) {
            return basename($container->getParameter('contao.web_dir'));
        }

        return 'public';
    }

    private static function getProjectDir(): string
    {
        return System::getContainer()->getParameter('kernel.project_dir');
    }
}

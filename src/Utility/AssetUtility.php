<?php

namespace DVC\TemplateSupport\Utility;

use Contao\StringUtil;
use Contao\System;

class AssetUtility
{
    const VERSION_PATH_DELIMITER_QUERY = 'query';
    const VERSION_PATH_DELIMITER_PIPE = 'pipe';

    /**
     * Returns the timestamp for the asset at given path.
     * @param string The path to the file.
     * @return string|null The timestamp or null if the file does not exist.
     */
    public static function getTimestampForAsset(string $src): ?string
    {
        $projectDir = self::getProjectDir();

        $mtime = null;

        if (file_exists($projectDir . '/' . $src)) {
            $mtime = filemtime($projectDir . '/' . $src);
        }
        else {
            $webDir = StringUtil::stripRootDir(self::getWebDir());

            // Handle public bundle resources in web/
            if (file_exists($projectDir . '/' . $webDir . '/' . $src)) {
                $mtime = filemtime($projectDir . '/' . $webDir . '/' . $src);
            }
        }

        return $mtime;
    }

    /**
     * Returns the versioned path for given asset path.
     * @param string The path to the resource
     * @return string The path with version parameter
     */
    public static function getVersionedPath(string $src, ?string $delimiter = self::VERSION_PATH_DELIMITER_QUERY): string {
        $timestamp = self::getTimestampForAsset($src);

        if ($timestamp === null) {
            return $src;
        }

        switch ($delimiter) {
            case self::VERSION_PATH_DELIMITER_QUERY:
                return \sprintf(
                    '%s?v=%s',
                    $src,
                    substr(md5($timestamp), 0, 8)
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

    private static function getWebDir(): string
    {
        return System::getContainer()->getParameter('contao.web_dir');
    }

    private static function getProjectDir(): string
    {
        return System::getContainer()->getParameter('kernel.project_dir');
    }
}

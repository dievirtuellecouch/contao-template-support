<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Utility;

use Contao\FilesModel;

class FilesUtility
{
    /**
     * Returns the language of the current page as locale string.
     * @return string|null The current locale string.
     */
    private static function getPageLanguage(): ?string
    {
        global $objPage;

        if (empty($objPage)) {
            return null;
        }

        return $objPage->language;
    }

    /**
     * Returns the metadata for given file and current language.
     * @param FilesModel|null $file The FileModel object.
     * @return array|null The metadata as array.
     */
    public static function getMetadataForFile(?FilesModel $file): ?array
    {
        if (empty($file)) {
            return null;
        }

        if (empty($file->meta)) {
            return null;
        }

        if (empty(self::getPageLanguage())) {
            return null;
        }

        $metadata = \deserialize($file->meta);

        if (empty($metadata)) {
            return null;
        }

        if (!\array_key_exists(self::getPageLanguage(), $metadata)) {
            return null;
        }

        return $metadata[self::getPageLanguage()];
    }

    /**
     * Returns the FilesModel of a variant of given video file, e. g. the
     * mobile version or thumbnail image. The variant's filename has to
     * follow the naming scheme explained below.
     *
     * @param FilesModel|null $file The default video file
     * @param string $variantName Possible options: "desktop", "mobile", "thumbnail"
     * @return FilesModel|null The FilesModel or null if variant could not be found
     */
    public static function getVideoFileVariant(?FilesModel $file, string $variantName): ?FilesModel
    {
        /**
         * Try to guess the placeholder filepath based on the video's filename,
         * when no explicit placeholder has been set.
         * The video filename is required to be space-separated; the last part
         * of the name should be the type identifier ("desktop", "mobile", …).
         * The placeholder image should have the type identifier "thumbnail"
         * and should be of file type "JPEG".
         */

        if (empty($file)) {
            return null;
        }

        if (!\in_array($variantName, ['mobil', 'mobile', 'desktop', 'thumbnail'])) {
            return null;
        }

        $pattern = '/(.*)_(.*)\.(.*)/';
        $replacementSuffix = ($variantName == 'thumbnail') ? 'jpg' : 'mp4';
        $replacementMask = \sprintf('${1}_%s.%s', $variantName, $replacementSuffix);

        $searchFilename = preg_replace($pattern, $replacementMask, $file->path);

        return FilesModel::findByPath($searchFilename);
    }

    /**
     * Returns a FileModel with given UUID.
     *
     * @param string $uuid The id of the file to find
     * @return FilesModel|null The FilesModel or null if the file could not be found
     */
    public static function getFileByUuid(string $uuid): ?FilesModel
    {
        return FilesModel::findByUuid($uuid);
    }
}

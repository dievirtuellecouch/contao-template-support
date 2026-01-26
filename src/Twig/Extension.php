<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('addGlobalStylesheet', [HeadRuntime::class, 'addGlobalStylesheet']),
            new TwigFunction('addGlobalScript', [HeadRuntime::class, 'addGlobalScript']),
            new TwigFunction('addGlobalScriptTag', [HeadRuntime::class, 'addGlobalScriptTag']),
            new TwigFunction('addGlobalScriptToFooter', [HeadRuntime::class, 'addGlobalScriptToFooter']),
            new TwigFunction('getFileByUuid', [UtilityRuntime::class, 'getFileByUuid']),
            new TwigFunction('makeCssClassVariations', [TextRuntime::class, 'makeCssClassVariations']),
            new TwigFunction('kebabCase', [TextRuntime::class, 'kebabCase']),
            new TwigFunction('versionedPath', [UtilityRuntime::class, 'getVersionedPath']),
            new TwigFunction('groupJobsByEmploymentType', [JobRuntime::class, 'groupJobsByEmploymentType']),
            new TwigFunction('getJobColorClass', [JobRuntime::class, 'getJobColorClass']),
        ];
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('leftPad', [TextRuntime::class, 'leftPad']),
            new TwigFilter('rightPad', [TextRuntime::class, 'rightPad']),
            new TwigFilter('unserialize', [UtilityRuntime::class, 'unserialize']),
            new TwigFilter('urlDecode', [TextRuntime::class, 'urlDecode']),
        ];
    }
}

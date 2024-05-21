<?php

namespace DVC\TemplateSupport\Twig;

use DVC\TemplateSupport\Twig\HeadRuntime;
use DVC\TemplateSupport\Twig\TextRuntime;
use DVC\TemplateSupport\Twig\UtilityRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class Extension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('addGlobalStylesheet', [HeadRuntime::class, 'addGlobalStylesheet']),
            new TwigFunction('addGlobalScript', [HeadRuntime::class, 'addGlobalScript']),
            new TwigFunction('addGlobalScriptTag', [HeadRuntime::class, 'addGlobalScriptTag']),
            new TwigFunction('addGlobalScriptToFooter', [HeadRuntime::class, 'addGlobalScriptToFooter']),
            new TwigFunction('makeCssClassVariations', [TextRuntime::class, 'makeCssClassVariations']),
            new TwigFunction('kebabCase', [TextRuntime::class, 'kebabCase']),
            new TwigFunction('versionedPath', [UtilityRuntime::class, 'getVersionedPath']),
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('leftPad', [TextRuntime::class, 'leftPad']),
            new TwigFilter('rightPad', [TextRuntime::class, 'rightPad']),
            new TwigFilter('unserialize', [UtilityRuntime::class, 'unserialize']),
            new TwigFilter('urlDecode', [TextRuntime::class, 'urlDecode']),
        ];
    }
}

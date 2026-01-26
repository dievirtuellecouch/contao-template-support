<?php

declare(strict_types=1);

namespace Dvc\ContaoTemplateSupportBundle;

use Dvc\ContaoTemplateSupportBundle\DependencyInjection\DvcContaoTemplateSupportExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class DvcContaoTemplateSupportBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DvcContaoTemplateSupportExtension();
    }
}

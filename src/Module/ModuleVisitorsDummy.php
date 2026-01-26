<?php

namespace Dvc\ContaoTemplateSupportBundle\Module;

use Contao\Module;

class ModuleVisitorsDummy extends Module
{
    protected function compile(): void
    {
        // intentionally empty: dummy module to prevent runtime errors
    }
}


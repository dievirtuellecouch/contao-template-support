<?php

// Dummy mapping for legacy visitors module to prevent runtime errors in Contao 5
// Use correct namespace for the dummy module class.
$GLOBALS['FE_MOD']['miscellaneous']['visitors'] = \Dvc\ContaoTemplateSupportBundle\Module\ModuleVisitorsDummy::class;

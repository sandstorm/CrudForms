<?php

namespace Sandstorm\CrudForms\View;


use TYPO3\Fluid\View\TemplateView;

class ExtendedTemplateView extends TemplateView
{
    protected function getPartialRootPaths()
    {
        $partialRootPaths = parent::getPartialRootPaths();
        $partialRootPaths[] = 'resource://Sandstorm.CrudForms/Private/Partials/';

        return $partialRootPaths;
    }
}

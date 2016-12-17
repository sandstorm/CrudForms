<?php

namespace Sandstorm\CrudForms\View;


use Neos\FluidAdaptor\View\TemplateView;

class ExtendedTemplateView extends TemplateView
{
    protected function getPartialRootPaths()
    {
        $partialRootPaths = parent::getPartialRootPaths();
        $partialRootPaths[] = 'resource://Sandstorm.CrudForms/Private/Partials/';

        return $partialRootPaths;
    }
}
